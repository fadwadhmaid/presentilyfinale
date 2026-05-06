<?php

namespace App\Jobs;

use App\Models\Presentation;
use App\Models\User;
use App\Services\OpenAIService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class GeneratePresentationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 300;
    public int $backoff = 10;
    
    // ⚠️ SUPPRIMEZ cette ligne si vous l'avez :
    // public $queue = 'default';
    
    // Gardez uniquement ces propriétés
    protected int $presentationId;
    protected string $prompt;
    protected int $userId;

    public function __construct(int $presentationId, string $prompt, int $userId)
    {
        $this->presentationId = $presentationId;
        $this->prompt = $prompt;
        $this->userId = $userId;
    }

    public function handle(OpenAIService $openAIService): void
    {
        $presentation = Presentation::find($this->presentationId);
        
        if (!$presentation) {
            Log::error("Présentation non trouvée", ['id' => $this->presentationId]);
            return;
        }

        try {
            Log::info("🚀 Job commence: Génération pour présentation #{$this->presentationId}");
            
            $presentation->update(['status' => 'processing']);

            // Appel à l'IA
            $result = $openAIService->generateContent($this->prompt);
            
            Log::info("📝 Réponse OpenAI reçue", [
                'type' => gettype($result),
                'presentation_id' => $this->presentationId
            ]);

            // Nettoyage et parsing de la réponse
            $slides = $this->parseOpenAIResponse($result);
            
            if (empty($slides)) {
                throw new \Exception("Aucune slide valide générée par l'IA");
            }

            // Normaliser les slides
            $normalizedSlides = $this->normalizeSlides($slides);
            
            // Mise à jour de la présentation
            $presentation->update([
                'content' => $normalizedSlides,
                'status' => 'completed',
                'error_message' => null,
                'metadata' => array_merge(
                    json_decode($presentation->metadata ?? '{}', true),
                    [
                        'completed_at' => now()->toISOString(),
                        'total_slides' => count($normalizedSlides)
                    ]
                )
            ]);
            
            Log::info("✅ Job terminé avec succès", [
                'presentation_id' => $this->presentationId,
                'slides_count' => count($normalizedSlides)
            ]);

        } catch (\Exception $e) {
            Log::error("❌ Job échoué", [
                'presentation_id' => $this->presentationId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Remettre le crédit à l'utilisateur si échec
            DB::transaction(function () use ($presentation) {
                $user = User::find($this->userId);
                if ($user) {
                    $user->increment('presentation_credits');
                    Log::info("💰 Crédit remboursé à l'utilisateur", [
                        'user_id' => $this->userId,
                        'credits' => $user->presentation_credits
                    ]);
                }
            });
            
            $presentation->update([
                'status' => 'failed',
                'error_message' => $e->getMessage()
            ]);
            
            // Relancer le job si nécessaire
            if ($this->attempts() < 3) {
                $this->release(60); // Réessayer dans 60 secondes
            }
        }
    }

    /**
     * Parse et nettoie la réponse OpenAI
     */
    private function parseOpenAIResponse($result): array
    {
        // Si c'est déjà un tableau
        if (is_array($result) && isset($result['slides'])) {
            return $result['slides'];
        }
        
        // Si c'est une chaîne JSON
        if (is_string($result)) {
            // Nettoyer les marqueurs markdown
            $cleaned = preg_replace('/```json\s*|\s*```/', '', $result);
            $cleaned = preg_replace('/^```|```$/', '', $cleaned);
            $decoded = json_decode($cleaned, true);
            
            if (json_last_error() === JSON_ERROR_NONE) {
                return $decoded['slides'] ?? [];
            }
            
            Log::warning("Échec du parsing JSON", ['error' => json_last_error_msg()]);
        }
        
        return [];
    }

    /**
     * Normalise les slides au format attendu par l'application
     */
    private function normalizeSlides(array $slides): array
    {
        $normalized = [];
        
        foreach ($slides as $index => $slide) {
            // S'assurer que le contenu est un tableau
            $content = $slide['contenu'] ?? $slide['content'] ?? [];
            if (is_string($content)) {
                $content = explode("\n", $content);
            }
            
            // Nettoyer chaque point
            $cleanedContent = [];
            foreach ($content as $point) {
                $point = trim($point);
                $point = ltrim($point, '•-* ');
                if (!empty($point) && strlen($point) > 2) {
                    $cleanedContent[] = $point;
                }
            }
            
            // Si moins de 3 points, ajouter des points génériques
            while (count($cleanedContent) < 3) {
                $cleanedContent[] = "Point à développer lors de la présentation";
            }
            
            $normalized[] = [
                'slide_number' => $slide['numero'] ?? ($index + 1),
                'title' => $slide['titre'] ?? $slide['title'] ?? "Slide " . ($index + 1),
                'content' => $cleanedContent,
                'speaker_notes' => $slide['notes_presentateur'] ?? $slide['speaker_notes'] ?? "Développez ce point de manière claire et structurée.",
                'subtitle' => $slide['sous_titre'] ?? ''
            ];
        }
        
        return $normalized;
    }
}