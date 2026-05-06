<?php
// app/Jobs/AnalyzeAnswerJob.php

namespace App\Jobs;

use App\Models\JurySimulation;
use App\Models\Presentation;
use App\Services\OpenAIService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AnalyzeAnswerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public $timeout = 120;
    public $tries = 3;
    public $queue = 'jury-analyze';
    
    protected $simulationId;
    protected $questionIndex;
    protected $question;
    protected $answer;
    protected $juryType;
    protected $presentationId;
    protected $userId;

    public function __construct(
        int $simulationId,
        int $questionIndex,
        string $question,
        string $answer,
        int $juryType,
        int $presentationId,
        int $userId
    ) {
        $this->simulationId = $simulationId;
        $this->questionIndex = $questionIndex;
        $this->question = $question;
        $this->answer = $answer;
        $this->juryType = $juryType;
        $this->presentationId = $presentationId;
        $this->userId = $userId;
    }

    public function handle(OpenAIService $openAIService): void
    {
        try {
            Log::info('🎬 Job analyze-answer started', [
                'simulation_id' => $this->simulationId,
                'question_index' => $this->questionIndex
            ]);

            // Récupérer la présentation
            $presentation = Presentation::findOrFail($this->presentationId);
            
            // Construire le prompt
            $prompt = $this->buildAnalysisPrompt(
                $presentation,
                $this->question,
                $this->answer,
                $this->juryType
            );
            
            // Appel API OpenAI
            $response = $openAIService->analyzePresentation($prompt);
            
            // Normaliser le feedback
            $feedback = $this->normalizeFeedback($response);
            
            // Sauvegarder le résultat
            $simulation = JurySimulation::find($this->simulationId);
            if ($simulation) {
                $answers = $simulation->answers ?? [];
                $feedbacks = $simulation->feedbacks ?? [];
                
                $answers[$this->questionIndex] = [
                    'question' => $this->question,
                    'answer' => $this->answer,
                    'feedback' => $feedback,
                    'analyzed_at' => now()->toISOString()
                ];
                
                $feedbacks[$this->questionIndex] = $feedback;
                
                $simulation->update([
                    'answers' => $answers,
                    'feedbacks' => $feedbacks,
                    'status' => $this->isLastQuestion($simulation) ? 'completed' : 'processing'
                ]);
            }
            
            Log::info('✅ Job analyze-answer completed', [
                'simulation_id' => $this->simulationId,
                'score' => $feedback['score']
            ]);
            
        } catch (\Exception $e) {
            Log::error('❌ Job analyze-answer failed', [
                'simulation_id' => $this->simulationId,
                'error' => $e->getMessage()
            ]);
            
            // En cas d'échec, utiliser le fallback
            $fallbackFeedback = $this->generateFallbackFeedback($this->answer);
            
            $simulation = JurySimulation::find($this->simulationId);
            if ($simulation) {
                $answers = $simulation->answers ?? [];
                $feedbacks = $simulation->feedbacks ?? [];
                
                $answers[$this->questionIndex] = [
                    'question' => $this->question,
                    'answer' => $this->answer,
                    'feedback' => $fallbackFeedback,
                    'analyzed_at' => now()->toISOString(),
                    'is_fallback' => true
                ];
                
                $feedbacks[$this->questionIndex] = $fallbackFeedback;
                
                $simulation->update([
                    'answers' => $answers,
                    'feedbacks' => $feedbacks
                ]);
            }
            
            if ($this->attempts() < $this->tries) {
                $this->release(10);
            }
        }
    }
    
    private function buildAnalysisPrompt($presentation, $question, $answer, $juryType)
    {
        $title = is_array($presentation->title) ? implode(' ', $presentation->title) : $presentation->title;
        $content = $this->formatContentForPrompt($presentation->content);
        
        $juryNames = [
            1 => 'Jury Technique',
            2 => 'Jury Business', 
            3 => 'Jury Pédagogique'
        ];
        
        return <<<PROMPT
Tu es un examinateur dans un jury de soutenance PFE.

**PRÉSENTATION:**
Titre: {$title}
Contenu: {$content}

**JURY:** {$juryNames[$juryType]}

**QUESTION:** {$question}
**RÉPONSE:** {$answer}

**TÂCHE:** Analyse cette réponse et retourne UNIQUEMENT ce JSON:
{
    "score": (int 0-20),
    "level": "Excellent|Très bien|Bien|Passable|À améliorer",
    "confidence": (int 1-5),
    "communication": (int 0-20),
    "technique": (int 0-20),
    "confiance": (int 0-20),
    "strengths": ["point fort 1", "point fort 2"],
    "errors": ["point faible 1", "point faible 2"],
    "suggestions": ["suggestion 1", "suggestion 2", "suggestion 3"]
}
PROMPT;
    }
    
    private function formatContentForPrompt($content)
    {
        if (is_string($content)) {
            $decoded = json_decode($content, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $this->formatArrayContent($decoded);
            }
            return substr($content, 0, 2000);
        }
        
        if (is_array($content)) {
            return $this->formatArrayContent($content);
        }
        
        return "Contenu non disponible";
    }
    
    private function formatArrayContent($array)
    {
        if (empty($array)) return "Pas de contenu";
        
        $formatted = [];
        foreach ($array as $slide) {
            if (is_array($slide)) {
                $title = $slide['title'] ?? 'Slide';
                $content = $slide['content'] ?? '';
                if (is_array($content)) {
                    $content = implode(' ', $content);
                }
                $formatted[] = "{$title}: " . substr($content, 0, 300);
            }
        }
        return implode("\n", $formatted);
    }
    
    private function normalizeFeedback($feedback)
    {
        return [
            'score' => min(20, max(0, $feedback['score'] ?? 12)),
            'level' => $feedback['level'] ?? $this->getLevelFromScore($feedback['score'] ?? 12),
            'confidence' => min(5, max(1, $feedback['confidence'] ?? 3)),
            'communication' => min(20, max(0, $feedback['communication'] ?? 12)),
            'technique' => min(20, max(0, $feedback['technique'] ?? 12)),
            'confiance' => min(20, max(0, $feedback['confiance'] ?? 12)),
            'strengths' => array_slice($feedback['strengths'] ?? ['Structure claire'], 0, 3),
            'errors' => array_slice($feedback['errors'] ?? ['Peut être amélioré'], 0, 3),
            'suggestions' => array_slice($feedback['suggestions'] ?? ['Ajouter des exemples'], 0, 3)
        ];
    }
    
    private function getLevelFromScore($score)
    {
        if ($score >= 18) return 'Excellent';
        if ($score >= 15) return 'Très bien';
        if ($score >= 12) return 'Bien';
        if ($score >= 10) return 'Passable';
        return 'À améliorer';
    }
    
    private function generateFallbackFeedback($answer)
    {
        $score = min(20, max(5, intval(strlen($answer) / 10)));
        return [
            'score' => $score,
            'level' => $this->getLevelFromScore($score),
            'confidence' => 3,
            'communication' => $score,
            'technique' => $score - 2,
            'confiance' => $score,
            'strengths' => ['Réponse fournie'],
            'errors' => ['À améliorer avec l\'IA'],
            'suggestions' => ['Rafraîchissez la page pour une meilleure analyse']
        ];
    }
    
    private function isLastQuestion($simulation)
    {
        $totalQuestions = $simulation->total_questions ?? 5;
        return ($this->questionIndex + 1) >= $totalQuestions;
    }
}