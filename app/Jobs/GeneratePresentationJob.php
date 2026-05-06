<?php
// app/Jobs/GeneratePresentationJob.php

namespace App\Jobs;

use App\Models\Presentation;
use App\Models\User;
use App\Services\OpenAIService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GeneratePresentationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public $timeout = 300;
    public $tries = 3;
    public $queue = 'presentations';
    
    protected $presentationId;
    protected $prompt;
    protected $userId;

    public function __construct(int $presentationId, string $prompt, int $userId)
    {
        $this->presentationId = $presentationId;
        $this->prompt = $prompt;
        $this->userId = $userId;
        
        // Log dans le constructeur
        Log::info('🔧 Job instancié', [
            'presentation_id' => $presentationId,
            'user_id' => $userId,
            'prompt_length' => strlen($prompt)
        ]);
    }

    public function handle(OpenAIService $openAIService): void
    {
        Log::info('🎬 Job handle() début', [
            'presentation_id' => $this->presentationId,
            'attempt' => $this->attempts()
        ]);

        try {
            // Récupérer la présentation
            Log::info('📝 Recherche de la présentation...');
            $presentation = Presentation::find($this->presentationId);
            
            if (!$presentation) {
                throw new \Exception("Présentation {$this->presentationId} non trouvée");
            }
            Log::info('✅ Présentation trouvée', ['status' => $presentation->status]);
            
            // Récupérer l'utilisateur
            Log::info('👤 Recherche de l\'utilisateur...');
            $user = User::find($this->userId);
            
            if (!$user) {
                throw new \Exception("Utilisateur {$this->userId} non trouvé");
            }
            Log::info('✅ Utilisateur trouvé', ['credits' => $user->presentation_credits]);
            
            // Vérifier les crédits
            if ($user->presentation_credits <= 0) {
                throw new \Exception("Crédits insuffisants: {$user->presentation_credits}");
            }
            
            // Mettre à jour le statut
            Log::info('🟡 Mise à jour du statut vers processing...');
            $presentation->update(['status' => 'processing']);
            Log::info('✅ Statut mis à jour');
            
            // Appel API (ça peut prendre du temps)
            Log::info('🤖 Appel API OpenAI...', [
                'prompt_preview' => substr($this->prompt, 0, 200) . '...'
            ]);
            
            $result = $openAIService->generateContent($this->prompt, [
                'max_output_tokens' => 8000,
            ]);
            
            Log::info('📦 Réponse API reçue', [
                'success' => $result['success'] ?? false,
                'has_content' => isset($result['content']),
                'has_slides' => isset($result['content']['slides'])
            ]);
            
            if (empty($result['content']['slides'])) {
                throw new \Exception("L'API n'a pas retourné de slides valides");
            }
            
            // Normaliser
            Log::info('🎨 Normalisation des slides...');
            $normalizedSlides = $this->normalizeSlides($result['content']);
            Log::info('✅ Slides normalisées', ['count' => count($normalizedSlides)]);
            
            // Débiter le crédit
            Log::info('💰 Débit du crédit...');
            DB::transaction(function () use ($user, $presentation, $normalizedSlides) {
                $freshUser = User::where('id', $user->id)->lockForUpdate()->first();
                
                if ($freshUser->presentation_credits <= 0) {
                    throw new \Exception("Plus de crédits disponibles");
                }
                
                $freshUser->decrement('presentation_credits');
                
                $presentation->update([
                    'status' => 'completed',
                    'content' => $normalizedSlides,
                    'metadata' => array_merge(
                        json_decode($presentation->metadata ?? '{}', true),
                        [
                            'total_slides' => count($normalizedSlides),
                            'completed_at' => now()->toISOString(),
                            'credits_used' => 1,
                            'credits_deducted_at' => now()->toISOString()
                        ]
                    )
                ]);
            });
            
            Log::info('✅ Job terminé avec succès!', [
                'presentation_id' => $this->presentationId,
                'slides_count' => count($normalizedSlides)
            ]);
            
        } catch (\Exception $e) {
            Log::error('❌ ERREUR DANS LE JOB', [
                'presentation_id' => $this->presentationId,
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Mettre à jour la présentation en échec
            try {
                $presentation = Presentation::find($this->presentationId);
                if ($presentation) {
                    $presentation->update([
                        'status' => 'failed',
                        'error_message' => $e->getMessage()
                    ]);
                    Log::info('📝 Statut mis à jour vers failed');
                }
            } catch (\Exception $updateError) {
                Log::error('❌ Erreur lors de la mise à jour du statut', [
                    'error' => $updateError->getMessage()
                ]);
            }
            
            // Relancer si possible
            if ($this->attempts() < $this->tries) {
                Log::info('🔄 Relance du job', ['next_attempt' => $this->attempts() + 1]);
                $this->release(30);
            } else {
                Log::error('💀 Job abandonné après 3 tentatives');
            }
        }
    }
    
    protected function normalizeSlides(array $content): array
    {
        $normalized = [];
        $slides = $content['slides'] ?? [];
        
        if (empty($slides)) {
            Log::warning('Aucune slide dans la réponse', ['content' => array_keys($content)]);
            throw new \Exception("Aucune slide générée");
        }
        
        foreach ($slides as $index => $slide) {
            $normalized[] = [
                'slide_number' => $slide['numero'] ?? ($index + 1),
                'title' => $slide['titre'] ?? "Slide " . ($index + 1),
                'subtitle' => $slide['sous_titre'] ?? '',
                'content' => is_array($slide['contenu'] ?? []) ? $slide['contenu'] : [$slide['contenu'] ?? ''],
                'speaker_notes' => $slide['notes_presentateur'] ?? "Développez ce point."
            ];
        }
        
        return $normalized;
    }
}