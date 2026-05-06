<?php
// app/Jobs/GenerateQuestionsJob.php

namespace App\Jobs;

use App\Models\Presentation;
use App\Services\OpenAIService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GenerateQuestionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public $timeout = 120;
    public $tries = 3;
    public $queue = 'jury-questions';
    
    protected $presentationId;
    protected $juryType;
    protected $userId;
    protected $cacheKey;

    public function __construct(int $presentationId, int $juryType, int $userId)
    {
        $this->presentationId = $presentationId;
        $this->juryType = $juryType;
        $this->userId = $userId;
        $this->cacheKey = "jury_questions_{$presentationId}_{$juryType}_{$userId}";
    }

    public function handle(OpenAIService $openAIService): void
    {
        try {
            Log::info('🎬 Job generate-questions started', [
                'presentation_id' => $this->presentationId,
                'jury_type' => $this->juryType
            ]);

            // Mettre à jour le cache : en cours
            Cache::put($this->cacheKey, ['status' => 'processing'], 600);

            // Récupérer la présentation
            $presentation = Presentation::where('id', $this->presentationId)
                ->where('user_id', $this->userId)
                ->firstOrFail();
            
            // Construire le prompt
            $prompt = $this->buildPrompt($presentation, $this->juryType);
            
            // Appel API OpenAI
            $response = $openAIService->analyzePresentation($prompt);
            
            // Normaliser les questions
            $questions = $this->normalizeQuestions($response, $this->juryType);
            
            // Mettre en cache le résultat
            Cache::put($this->cacheKey, [
                'status' => 'completed',
                'questions' => $questions,
                'generated_at' => now()->toISOString()
            ], 3600);
            
            Log::info('✅ Questions générées avec succès', [
                'presentation_id' => $this->presentationId,
                'questions_count' => count($questions)
            ]);
            
        } catch (\Exception $e) {
            Log::error('❌ Job generate-questions failed', [
                'presentation_id' => $this->presentationId,
                'error' => $e->getMessage()
            ]);
            
            // En cas d'échec, mettre les questions par défaut en cache
            Cache::put($this->cacheKey, [
                'status' => 'failed',
                'questions' => $this->getDefaultQuestions($this->juryType),
                'error' => $e->getMessage(),
                'is_fallback' => true
            ], 3600);
            
            if ($this->attempts() < $this->tries) {
                $this->release(5);
            }
        }
    }
    
    private function buildPrompt($presentation, $juryType)
    {
        $title = is_array($presentation->title) ? implode(' ', $presentation->title) : $presentation->title;
        $content = $this->formatContentForPrompt($presentation->content);
        
        $juryNames = [
            1 => 'Jury Technique (architecture, sécurité, performances)',
            2 => 'Jury Business (valeur ajoutée, marché, ROI)',
            3 => 'Jury Pédagogique (méthodologie, innovation)'
        ];
        
        return <<<PROMPT
Tu es un expert en évaluation PFE.

**PRÉSENTATION:**
Titre: {$title}
Contenu: {$content}

**RÔLE:** {$juryNames[$juryType]}

Génère 5 questions SPÉCIFIQUES basées sur le contenu.

Format JSON:
{
    "questions": [
        {
            "question": "question spécifique",
            "category": "Technique|Business|Innovation",
            "difficulty": "Facile|Moyen|Difficile"
        }
    ]
}
PROMPT;
    }
    
    private function formatContentForPrompt($content)
    {
        if (is_array($content)) {
            $text = [];
            foreach ($content as $slide) {
                if (isset($slide['title'])) $text[] = $slide['title'];
                if (isset($slide['content'])) {
                    $slideContent = is_array($slide['content']) ? implode(' ', $slide['content']) : $slide['content'];
                    $text[] = substr($slideContent, 0, 300);
                }
            }
            return implode("\n", $text);
        }
        return substr($content, 0, 2000);
    }
    
    private function normalizeQuestions($response, $juryType)
    {
        if (isset($response['questions']) && is_array($response['questions'])) {
            return array_slice($response['questions'], 0, 5);
        }
        return $this->getDefaultQuestions($juryType);
    }
    
    private function getDefaultQuestions($juryType)
    {
        $defaults = [
            1 => [
                ['question' => 'Quelle est l\'architecture technique de votre solution ?', 'category' => 'Architecture', 'difficulty' => 'Moyen'],
                ['question' => 'Comment gérez-vous la sécurité des données ?', 'category' => 'Sécurité', 'difficulty' => 'Difficile'],
                ['question' => 'Quels tests avez-vous mis en place ?', 'category' => 'Qualité', 'difficulty' => 'Moyen'],
                ['question' => 'Comment assurez-vous la scalabilité ?', 'category' => 'Performance', 'difficulty' => 'Difficile'],
                ['question' => 'Quels choix technologiques et pourquoi ?', 'category' => 'Technologie', 'difficulty' => 'Moyen']
            ],
            2 => [
                ['question' => 'Quelle est votre proposition de valeur ?', 'category' => 'Valeur', 'difficulty' => 'Facile'],
                ['question' => 'Quel est votre marché cible ?', 'category' => 'Marché', 'difficulty' => 'Moyen'],
                ['question' => 'Comment monétisez-vous votre solution ?', 'category' => 'Business', 'difficulty' => 'Difficile'],
                ['question' => 'Quel est votre avantage concurrentiel ?', 'category' => 'Concurrence', 'difficulty' => 'Moyen'],
                ['question' => 'Quel ROI pour l\'entreprise ?', 'category' => 'ROI', 'difficulty' => 'Difficile']
            ],
            3 => [
                ['question' => 'Quelle méthodologie avez-vous suivie ?', 'category' => 'Méthodologie', 'difficulty' => 'Facile'],
                ['question' => 'Quel est votre apport innovant ?', 'category' => 'Innovation', 'difficulty' => 'Moyen'],
                ['question' => 'Quelles sont les limites de votre étude ?', 'category' => 'Critique', 'difficulty' => 'Difficile'],
                ['question' => 'Quelles perspectives d\'évolution ?', 'category' => 'Perspectives', 'difficulty' => 'Moyen'],
                ['question' => 'Comment validez-vous vos résultats ?', 'category' => 'Validation', 'difficulty' => 'Moyen']
            ]
        ];
        
        return $defaults[$juryType] ?? $defaults[1];
    }
}