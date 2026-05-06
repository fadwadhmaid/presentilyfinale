<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\OpenAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Presentation;
use App\Models\JurySimulation;
use Inertia\Inertia;
use Illuminate\Support\Facades\Cache; 
use App\Jobs\GenerateQuestionsJob; 

class JurySimulationController extends Controller
{
    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    /**
     * Page Inertia pour la simulation
     */
    public function simulatePage()
    {
        $user = Auth::user();
        
        if ($user->jury_credits <= 0) {
            return redirect()->route('dashboard')
                ->with('error', 'Vous n\'avez plus de crédits pour la simulation jury.');
        }
        
        $presentations = Presentation::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get(['id', 'title', 'created_at']);
        
        return Inertia::render('Jury/Simulate', [
            'credits' => $user->jury_credits,
            'presentations' => $presentations
        ]);
    }
    





    /***presnetation comrend  */


/**
 * API: Générer des questions avec l'IA
 */
public function generateQuestions(Request $request)
{
    $request->validate([
        'presentation_id' => 'required|exists:presentations,id',
        'jury_type' => 'required|integer|in:1,2,3'
    ]);
    
    $presentation = Presentation::where('id', $request->presentation_id)
        ->where('user_id', Auth::id())
        ->firstOrFail();
    
    // Utiliser Cache avec le bon namespace
    $cacheKey = "jury_questions_{$presentation->id}_{$request->jury_type}_" . Auth::id();
    
    // Vérifier si déjà en cache
    $cached = Cache::get($cacheKey);
    
    if ($cached && $cached['status'] === 'completed') {
        return response()->json([
            'success' => true,
            'questions' => $cached['questions'],
            'from_cache' => true
        ]);
    }
    
    // Dispatch le job
    GenerateQuestionsJob::dispatch(
        $presentation->id,
        $request->jury_type,
        Auth::id()
    );
    
    return response()->json([
        'success' => true,
        'status' => 'processing',
        'message' => 'Génération des questions en cours...',
        'cache_key' => $cacheKey
    ]);
}

/**
 * Vérifier le statut de génération des questions
 */
public function getQuestionsStatus(Request $request)
{
    $request->validate([
        'cache_key' => 'required|string'
    ]);
    
    $cached = Cache::get($request->cache_key);
    
    if (!$cached) {
        return response()->json([
            'status' => 'pending'
        ]);
    }
    
    return response()->json($cached);
}
/**
 * Construction du prompt en utilisant le champ content existant
 */
private function buildPromptWithExistingContent($presentation, $juryType)
{
    // Titre (si c'est un tableau, on le convertit)
    $title = is_array($presentation->title) ? implode(' ', $presentation->title) : $presentation->title;
    
    // Contenu (c'est là que sont vos slides)
    $content = $presentation->content;
    
    // Formater le contenu pour qu'il soit lisible par l'IA
    $formattedContent = $this->formatContentForPrompt($content);
    
    $juryNames = [
        1 => 'Jury Technique (architecture, sécurité, performances, scalabilité)',
        2 => 'Jury Business (valeur ajoutée, marché, modèle économique, ROI)',
        3 => 'Jury Pédagogique (méthodologie, innovation, rigueur académique)'
    ];
    
    return <<<PROMPT
Tu es un expert en évaluation de projets PFE.

**PRÉSENTATION À ANALYSER :**

Titre: {$title}

Contenu complet de la présentation:
{$formattedContent}

**RÔLE DU JURY:** {$juryNames[$juryType]}

**TÂCHE:** Génère 5 TRÈS BONNES QUESTIONS que ce jury poserait.

**RÈGLES CRITIQUES:**
1. Chaque question doit être basée sur un élément SPÉCIFIQUE du contenu ci-dessus
2. Ne pose PAS de questions génériques comme "Parlez-moi de votre projet"
3. Pose des questions qui montrent que vous avez LU la présentation
4. Exemple de BONNE question: "Vous mentionnez [technologie X], pourquoi ce choix plutôt que [alternative Y] ?"
5. Exemple de MAUVAISE question: "Quelles technologies avez-vous utilisées ?"

**FORMAT JSON EXIGÉ:**
{
    "questions": [
        {
            "question": "Question spécifique basée sur le contenu",
            "category": "Technique|Business|Innovation|Méthodologie|Critique",
            "difficulty": "Facile|Moyen|Difficile"
        }
    ]
}

Retourne UNIQUEMENT le JSON, pas de texte avant ou après.
PROMPT;
}

/**
 * Formate le contenu (qui peut être string, JSON, ou tableau)
 */
private function formatContentForPrompt($content)
{
    // Si c'est déjà une string
    if (is_string($content)) {
        // Essayer de décoder si c'est du JSON
        $decoded = json_decode($content, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $this->formatArrayContent($decoded);
        }
        return $content;
    }
    
    // Si c'est un tableau
    if (is_array($content)) {
        return $this->formatArrayContent($content);
    }
    
    return "Contenu non disponible";
}

/**
 * Formate un tableau (slides, sections, etc.) de manière lisible
 */
private function formatArrayContent($array)
{
    if (empty($array)) {
        return "Pas de contenu détaillé";
    }
    
    $formatted = [];
    
    // Vérifie si c'est un tableau de slides (avec title, content)
    if (isset($array[0]) && is_array($array[0])) {
        foreach ($array as $index => $slide) {
            $slideNum = $index + 1;
            $title = $slide['title'] ?? "Slide {$slideNum}";
            $slideContent = $slide['content'] ?? $slide['description'] ?? '';
            
            if (is_array($slideContent)) {
                $slideContent = implode(' ', $slideContent);
            }
            
            $formatted[] = "--- SLIDE {$slideNum}: {$title} ---";
            $formatted[] = $slideContent;
            $formatted[] = "";
        }
    } 
    // Sinon, formatage générique
    else {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $formatted[] = "{$key}: " . json_encode($value, JSON_UNESCAPED_UNICODE);
            } else {
                $formatted[] = "{$key}: {$value}";
            }
        }
    }
    
    return implode("\n", $formatted);
}

/**
 * Extraction du contenu des slides
 */
private function extractSlidesContent($slides)
{
    if (!$slides || $slides->isEmpty()) {
        return "Aucun slide détaillé disponible.";
    }
    
    $formatted = [];
    foreach ($slides as $index => $slide) {
        $slideNumber = $index + 1;
        $title = $slide->title ?? "Slide {$slideNumber}";
        $content = $slide->content ?? $slide->description ?? '';
        
        // Si content est un tableau, le convertir en texte
        if (is_array($content)) {
            $content = implode(' ', $content);
        }
        
        $formatted[] = "📄 SLIDE {$slideNumber}: {$title}";
        $formatted[] = "   Contenu: " . substr($content, 0, 500);
        $formatted[] = "";
    }
    
    return implode("\n", $formatted);
}

/**
 * Extraction intelligente du contexte du projet
 */
private function extractProjectContext($presentation, $slidesContent)
{
    $fullContent = $slidesContent . " " . ($presentation->description ?? '');
    
    // Extraction avec regex ou mots-clés
    $patterns = [
        'problem' => '/(problème|problématique|contexte|besoin|cahier des charges|objectif principal)/i',
        'solution' => '/(solution|proposition|notre solution|nous proposons|approche)/i',
        'technologies' => '/(technologies|stack technique|outils|framework|langages|PHP|Laravel|React|Vue|Node|Python|Java|MySQL|PostgreSQL|MongoDB|Redis|Docker|AWS|Firebase)/i',
        'architecture' => '/(architecture|design pattern|structure|composants|modules|API|microservices|MVC)/i',
        'results' => '/(résultats|livrables|fonctionnalités|ce qu(on|\'|’)a réalisé|implémentation)/i'
    ];
    
    $context = [];
    foreach ($patterns as $key => $pattern) {
        if (preg_match($pattern, $fullContent, $matches)) {
            // Récupérer le paragraphe contenant le mot-clé
            $context[$key] = $this->extractParagraph($fullContent, $matches[0]) ?? "Information {$key} disponible dans la présentation.";
        } else {
            $context[$key] = "À identifier dans la présentation (section {$key})";
        }
    }
    
    return $context;
}

/**
 * Extraction du paragraphe contenant un mot-clé
 */
private function extractParagraph($text, $keyword)
{
    $sentences = preg_split('/(?<=[.!?])\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
    
    foreach ($sentences as $sentence) {
        if (stripos($sentence, $keyword) !== false) {
            return trim($sentence);
        }
    }
    
    return null;
}





    /**
     * API: Récupérer l'historique (retourne JSON)
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $simulations = JurySimulation::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return response()->json([
            'success' => true,
            'simulations' => $simulations
        ]);
    }
    
   



/**
 * Formater le contenu de la présentation (array) en string lisible
 */
private function formatPresentationContent($content)
{
    if (is_string($content)) {
        return $content;
    }
    
    if (is_array($content)) {
        // Si c'est un tableau de slides avec structure
        if (isset($content[0]) && is_array($content[0])) {
            $formatted = [];
            foreach ($content as $index => $slide) {
                $slideNumber = $index + 1;
                $slideTitle = $slide['title'] ?? "Slide {$slideNumber}";
                $slideContent = $slide['content'] ?? $slide['description'] ?? '';
                
                // Extraire le texte du contenu si c'est un tableau
                if (is_array($slideContent)) {
                    $slideContent = implode(' ', $slideContent);
                }
                
                $formatted[] = "Slide {$slideNumber} - {$slideTitle}: {$slideContent}";
            }
            return implode("\n", $formatted);
        }
        
        // Si c'est un tableau associatif simple
        return json_encode($content, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
    
    return (string) $content;
}
 
    /**
     * Normaliser le feedback pour garantir tous les champs
     */
    private function normalizeFeedback($feedback)
    {
        // Si le feedback est un tableau avec une clé 'content'
        if (isset($feedback['content']) && is_array($feedback['content'])) {
            $feedback = $feedback['content'];
        }
        
        // Si le feedback est un tableau JSON string
        if (is_string($feedback)) {
            $decoded = json_decode($feedback, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $feedback = $decoded;
            }
        }
        
        return [
            'score' => min(20, max(0, $feedback['score'] ?? 12)),
            'level' => $feedback['level'] ?? $this->getLevelFromScore($feedback['score'] ?? 12),
            'confidence' => min(5, max(1, $feedback['confidence'] ?? 3)),
            'communication' => min(20, max(0, $feedback['communication'] ?? 12)),
            'technique' => min(20, max(0, $feedback['technique'] ?? 12)),
            'confiance' => min(20, max(0, $feedback['confiance'] ?? 12)),
            'strengths' => array_slice($feedback['strengths'] ?? ['Structure claire', 'Pertinence de la réponse'], 0, 3),
            'errors' => array_slice($feedback['errors'] ?? ['Pourrait être plus détaillé'], 0, 3),
            'suggestions' => array_slice($feedback['suggestions'] ?? ['Ajouter des exemples concrets', 'Développer les arguments'], 0, 3)
        ];
    }

    /**
     * Obtenir le niveau à partir du score
     */
    private function getLevelFromScore($score)
    {
        if ($score >= 18) return 'Excellent';
        if ($score >= 15) return 'Très bien';
        if ($score >= 12) return 'Bien';
        if ($score >= 10) return 'Passable';
        return 'À améliorer';
    }

    /**
     * Fallback quand l'API échoue
     */
    private function generateFallbackFeedback($answer)
    {
        $length = strlen($answer);
        $hasKeywords = preg_match('/(architecture|technologie|sécurité|base de donnée|API|méthodologie|innovation|marché)/i', $answer);
        $hasStructure = preg_match('/(premièrement|deuxièmement|en premier lieu|d\'une part|d\'autre part)/i', $answer);
        
        // Calculer le score basé sur des heuristiques simples
        $score = 10; // score de base
        
        if ($length < 30) {
            $score = 5;
            $level = 'Insuffisant';
            $strengths = ['A fourni une réponse'];
            $errors = ['Réponse beaucoup trop courte'];
            $suggestions = ['Développez votre réponse en 3-4 phrases minimum', 'Donnez des exemples concrets'];
        } else {
            if ($length > 100) $score += 3;
            if ($hasKeywords) $score += 3;
            if ($hasStructure) $score += 2;
            
            $score = min(20, $score);
            $level = $this->getLevelFromScore($score);
            
            $strengths = [];
            if ($hasKeywords) $strengths[] = 'Utilisation de vocabulaire technique';
            if ($length > 100) $strengths[] = 'Réponse détaillée';
            if ($hasStructure) $strengths[] = 'Structure claire';
            if (empty($strengths)) $strengths = ['Réponse correcte'];
            
            $errors = [];
            if (!$hasKeywords) $errors[] = 'Manque de vocabulaire technique spécifique';
            if (!$hasStructure && $length > 100) $errors[] = 'Structure peu claire';
            if (empty($errors)) $errors = ['Pourrait être plus approfondi'];
            
            $suggestions = [];
            if (!$hasKeywords) $suggestions[] = 'Utilisez des termes comme "architecture", "scalabilité", "robustesse"';
            if (!$hasStructure) $suggestions[] = 'Structurez votre réponse (d\'abord... ensuite... enfin...)';
            if ($length < 100 && $length >= 30) $suggestions[] = 'Ajoutez 2-3 phrases d\'exemples ou d\'arguments';
            if (empty($suggestions)) $suggestions = ['Ajoutez des métriques ou des résultats chiffrés'];
        }
        
        return [
            'score' => $score,
            'level' => $level,
            'confidence' => $score >= 15 ? 4 : ($score >= 10 ? 3 : 2),
            'communication' => min(20, $score + ($hasStructure ? 2 : 0)),
            'technique' => min(20, $score + ($hasKeywords ? 3 : -2)),
            'confiance' => min(20, $score + ($length > 80 ? 2 : -1)),
            'strengths' => array_slice($strengths, 0, 3),
            'errors' => array_slice($errors, 0, 3),
            'suggestions' => array_slice($suggestions, 0, 3)
        ];
    }

    /**
     * Questions par défaut pour fallback
     */
    private function getDefaultQuestions($juryType)
    {
        $questions = [
            1 => [ // Technique
                ['question' => 'Pourquoi avez-vous choisi cette architecture technique ?', 'category' => 'Architecture', 'difficulty' => 'Moyen'],
                ['question' => 'Comment gérez-vous la sécurité des données ?', 'category' => 'Sécurité', 'difficulty' => 'Difficile'],
                ['question' => 'Quels sont les choix technologiques clés et pourquoi ?', 'category' => 'Technologie', 'difficulty' => 'Moyen'],
                ['question' => 'Comment assurez-vous la scalabilité de votre solution ?', 'category' => 'Performance', 'difficulty' => 'Difficile'],
                ['question' => 'Quels tests avez-vous mis en place ?', 'category' => 'Qualité', 'difficulty' => 'Moyen']
            ],
            2 => [ // Business
                ['question' => 'Quelle est la valeur ajoutée de votre solution ?', 'category' => 'Valeur', 'difficulty' => 'Facile'],
                ['question' => 'Quel est votre modèle économique ?', 'category' => 'Business Model', 'difficulty' => 'Moyen'],
                ['question' => 'Comment vous différenciez-vous de la concurrence ?', 'category' => 'Concurrence', 'difficulty' => 'Moyen'],
                ['question' => 'Quel est le ROI estimé pour l\'entreprise ?', 'category' => 'ROI', 'difficulty' => 'Difficile'],
                ['question' => 'Quel est votre marché cible ?', 'category' => 'Marché', 'difficulty' => 'Facile']
            ],
            3 => [ // Pédagogique
                ['question' => 'Quelle est votre méthodologie de travail ?', 'category' => 'Méthodologie', 'difficulty' => 'Facile'],
                ['question' => 'Quelles sont vos sources et références ?', 'category' => 'Recherche', 'difficulty' => 'Moyen'],
                ['question' => 'Quel est l\'apport innovant de votre projet ?', 'category' => 'Innovation', 'difficulty' => 'Moyen'],
                ['question' => 'Quelles sont les limites de votre étude ?', 'category' => 'Critique', 'difficulty' => 'Difficile'],
                ['question' => 'Quelles perspectives pour la suite ?', 'category' => 'Perspectives', 'difficulty' => 'Facile']
            ]
        ];
        
        return $questions[$juryType] ?? $questions[1];
    }
    
    /**
     * API: Sauvegarder une simulation
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'jury_type' => 'required|integer',
            'presentation_id' => 'nullable|exists:presentations,id',
            'total_questions' => 'required|integer',
            'final_score' => 'required|integer|between:0,20',
            'answers' => 'required|array',
            'feedbacks' => 'required|array',
            'category_scores' => 'required|array',
        ]);
        
        // Décrémenter les crédits
        $creditsUsed = 0;
        if ($user->jury_credits > 0) {
            $user->decrement('jury_credits');
            $user->increment('total_jury_simulations');
            $creditsUsed = 1;
        }
        
        // Calculer la durée si non fournie
        $durationSeconds = $request->duration_seconds ?? null;
        
        $simulation = JurySimulation::create([
            'user_id' => $user->id,
            'presentation_id' => $request->presentation_id,
            'jury_type' => $request->jury_type,
            'jury_name' => $this->getJuryName($request->jury_type),
            'total_questions' => $request->total_questions,
            'final_score' => $request->final_score,
            'answers' => $request->answers,
            'feedbacks' => $request->feedbacks,
            'category_scores' => $request->category_scores,
            'credits_used' => $creditsUsed,
            'status' => 'completed',
            'duration_seconds' => $durationSeconds
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Simulation sauvegardée avec succès',
            'simulation' => $simulation,
            'credits_remaining' => $user->fresh()->jury_credits
        ]);
    }
    
    /**
     * API: Récupérer les statistiques
     */
    public function stats()
    {
        $user = Auth::user();
        
        $simulations = JurySimulation::where('user_id', $user->id);
        
        return response()->json([
            'success' => true,
            'stats' => [
                'total' => $simulations->count(),
                'average' => round($simulations->avg('final_score'), 2),
                'best' => $simulations->max('final_score') ?? 0,
                'last_score' => $simulations->latest()->first()?->final_score,
                'last_simulation_date' => $simulations->latest()->first()?->created_at,
                'total_credits_used' => $simulations->sum('credits_used')
            ]
        ]);
    }
    
    /**
     * API: Détails d'une simulation
     */
    public function show($id)
    {
        $simulation = JurySimulation::where('user_id', Auth::id())
            ->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'simulation' => $simulation
        ]);
    }
    
    /**
     * Obtenir le nom du jury
     */
    private function getJuryName($type)
    {
        $names = [
            1 => 'Jury Technique',
            2 => 'Jury Business',
            3 => 'Jury Pédagogique',
            4 => 'Jury Mixte'
        ];
        
        return $names[$type] ?? 'Jury';
    }




/**
 * API: Analyser une réponse avec l'IA
 * POST /api/jury/analyze-answer
 */
// Dans JurySimulationController.php

/**
 * API: Analyser une réponse avec l'IA
 * POST /jury/analyze-answer
 */
public function analyzeAnswer(Request $request)
{
    $request->validate([
        'question' => 'required|string',
        'answer' => 'required|string',
        'jury_type' => 'required|integer',
        'presentation_id' => 'required|exists:presentations,id',
        'question_category' => 'nullable|string',
        'question_difficulty' => 'nullable|string',
        // Ces champs deviennent optionnels
        'simulation_id' => 'nullable|exists:jury_simulations,id',
        'question_index' => 'nullable|integer'
    ]);

    try {
        $presentation = Presentation::findOrFail($request->presentation_id);
        
        $prompt = $this->buildAnalysisPrompt(
            $presentation,
            $request->question,
            $request->answer,
            $request->jury_type,
            $request->question_category ?? 'Général'
        );
        
        $response = $this->openAIService->analyzePresentation($prompt);
        
        if (isset($response['score'])) {
            $feedback = $this->normalizeFeedback($response);
            
            // Si simulation_id est fourni, sauvegarder le résultat
            if ($request->has('simulation_id') && $request->simulation_id) {
                $simulation = JurySimulation::find($request->simulation_id);
                if ($simulation) {
                    $answers = $simulation->answers ?? [];
                    $feedbacks = $simulation->feedbacks ?? [];
                    $index = $request->question_index ?? count($answers);
                    
                    $answers[$index] = [
                        'question' => $request->question,
                        'answer' => $request->answer,
                        'feedback' => $feedback,
                        'analyzed_at' => now()->toISOString()
                    ];
                    
                    $feedbacks[$index] = $feedback;
                    
                    $simulation->update([
                        'answers' => $answers,
                        'feedbacks' => $feedbacks
                    ]);
                }
            }
            
            return response()->json([
                'success' => true,
                'feedback' => $feedback
            ]);
        }
        
        throw new \Exception('Réponse IA invalide');
        
    } catch (\Exception $e) {
        \Log::error('Erreur analyse: ' . $e->getMessage());
        
        return response()->json([
            'success' => true,
            'feedback' => $this->generateFallbackFeedback($request->answer),
            'fallback' => true
        ]);
    }
}

// Nouvelle route pour récupérer le résultat
public function getAnalysisResult($simulationId, $questionIndex)
{
    $simulation = JurySimulation::where('user_id', Auth::id())
        ->findOrFail($simulationId);
    
    $answers = $simulation->answers ?? [];
    $result = $answers[$questionIndex] ?? null;
    
    if ($result && isset($result['analyzed_at'])) {
        return response()->json([
            'success' => true,
            'feedback' => $result['feedback'],
            'completed' => true
        ]);
    }
    
    return response()->json([
        'success' => true,
        'completed' => false
    ]);
}

/**
 * Build the analysis prompt
 */
private function buildAnalysisPrompt($presentation, $question, $answer, $juryType, $category)
{
    $title = is_array($presentation->title) ? implode(' ', $presentation->title) : $presentation->title;
    $content = $this->formatContentForPrompt($presentation->content);
    
    $juryNames = [
        1 => 'Jury Technique (expert en architecture, sécurité, performances)',
        2 => 'Jury Business (expert en valeur ajoutée, marché, ROI)',
        3 => 'Jury Pédagogique (enseignant-chercheur, méthodologie, innovation)'
    ];
    
    return <<<PROMPT
Tu es un examinateur dans un jury de soutenance PFE.

**CONTEXTE DE LA PRÉSENTATION :**
Titre: {$title}
Contenu: {$content}

**RÔLE DU JURY :** {$juryNames[$juryType]}

**QUESTION POSÉE :** {$question}
**RÉPONSE DE L'ÉTUDIANT :** {$answer}

**TÂCHE :** Analyse cette réponse et retourne UNIQUEMENT un JSON avec cette structure :

{
    "score": (int 0-20),
    "level": "Excellent|Très bien|Bien|Passable|À améliorer",
    "confidence": (int 1-5),
    "communication": (int 0-20),
    "technique": (int 0-20),
    "confiance": (int 0-20),
    "strengths": ["point fort 1", "point fort 2"],
    "errors": ["point faible 1", "point faible 2"],
    "suggestions": ["RÉPONSE IDÉALE: [détail complet de la réponse attendue]", "suggestion d'amélioration 2", "suggestion 3"]
}

Retourne UNIQUEMENT le JSON, sans texte supplémentaire.
PROMPT;
}
}