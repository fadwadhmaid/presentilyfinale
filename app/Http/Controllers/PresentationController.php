<?php

namespace App\Http\Controllers;

use App\Models\Presentation;
use App\Services\OpenAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Jobs\GeneratePresentationJob;
class PresentationController extends Controller
{
    protected OpenAIService $aiService;

    public function __construct(OpenAIService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Affiche le formulaire de génération
     */
    public function create()
    {
        return inertia('PresentationGenerator');
    }
public function index()
{
    $user = auth()->user();
    
    $presentations = Presentation::where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    
    return Inertia::render('Presentations/Index', [
        'presentations' => $presentations,
        'user' => $user
    ]);
}
    /**
     * Génère une présentation à partir du formulaire
     */
public function store(Request $request)
{
    set_time_limit(120);
    ini_set('max_execution_time', 120);

    try {
        $user = Auth::user();

        Log::info('🎬 Début génération présentation (QUEUE)', [
            'user_id' => $user->id,
            'credits_avant' => $user->presentation_credits,
        ]);

        // ❌ Vérification crédits
        if ($user->presentation_credits <= 0) {
            return response()->json([
                'success' => false,
                'error' => 'Vous n\'avez plus de crédits présentation.'
            ], 403);
        }

        // ✅ Validation
        $validated = $request->validate([
            'formData.title' => 'required|string|max:255',
            'formData.projectType' => 'required|string',
            'formData.problem' => 'required|string|min:20',
            'formData.solution' => 'required|string|min:20',
            'formData.technologies' => 'nullable|string',
            'formData.results' => 'nullable|string',
            'formData.difficulties' => 'nullable|string',
            'formData.perspectives' => 'nullable|string',

            'options.style' => 'required|string|in:modern,corporate,colorful',
            'options.slideCount' => 'required|string',
            'options.includeScript' => 'boolean',
            'options.includeQuestions' => 'boolean',
        ]);

        $formData = $validated['formData'];
        $options = $validated['options'];

        // 🧠 1. Créer la présentation en mode pending
        $presentation = Presentation::create([
            'user_id' => $user->id,
            'title' => $formData['title'],
            'slug' => \Illuminate\Support\Str::slug($formData['title']) . '-' . \Illuminate\Support\Str::random(8),
            'generation_method' => 'form',
            'status' => 'processing',
            'options' => $options,
        ]);

        Log::info('📦 Présentation créée (QUEUE)', [
            'presentation_id' => $presentation->id
        ]);

 $prompt = $this->buildPresentationPrompt($formData, $options);

GeneratePresentationJob::dispatch(
    $presentation->id,
    $prompt,
    $user->id
);

        // ⚡ 3. Réponse immédiate (PAS DE TIMEOUT)
        return response()->json([
            'success' => true,
            'status' => 'processing',
            'presentation_id' => $presentation->id,
            'message' => 'Génération en cours...'
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {

        return response()->json([
            'success' => false,
            'error' => 'Erreur de validation',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {

        Log::error('❌ Erreur store presentation', [
            'message' => $e->getMessage()
        ]);

        return response()->json([
            'success' => false,
            'error' => 'Erreur serveur'
        ], 500);
    }
}

    /**
     * Génère les slides avec l'IA
     */
   protected function generateSlides(Presentation $presentation, array $formData, array $options): array
{
    Log::info('Génération des slides', ['presentation_id' => $presentation->id]);
    
    try {
        // Construction du prompt
        $prompt = $this->buildPresentationPrompt($formData, $options);
        
        // Appel API
        $result = $this->aiService->generateContent($prompt, [
            'max_completion_tokens' => 8000, // Réduit
        ]);
        
        if (empty($result['content']) || empty($result['content']['slides'])) {
            throw new \Exception("L'IA n'a pas généré de slides valides");
        }
        
        // Normalisation des slides
        $normalizedSlides = $this->normalizeSlides($result['content']);
        
        if (empty($normalizedSlides) || count($normalizedSlides) < 3) {
            throw new \Exception("Normalisation échouée");
        }
        
        // Nettoyage UTF-8
        $normalizedSlides = $this->cleanUtf8Array($normalizedSlides);
        
        // Sauvegarde
        $presentation->update([
            'status' => 'completed',
            'content' => $normalizedSlides,
            'metadata' => [
                'total_slides' => count($normalizedSlides),
                'style' => $options['style'] ?? 'modern',
                'slide_count_preference' => $options['slideCount'] ?? '15',
                'include_script' => $options['includeScript'] ?? true,
                'include_questions' => $options['includeQuestions'] ?? true,
                'generated_at' => now()->toISOString()
            ]
        ]);
        
        Log::info(' Présentation générée avec succès', [
            'presentation_id' => $presentation->id,
            'slides_count' => count($normalizedSlides)
        ]);
        
        return [
            'success' => true,
            'presentation_id' => $presentation->id,
            'status' => 'completed',
            'content' => $normalizedSlides,
            'slides_count' => count($normalizedSlides)
        ];
        
    } catch (\Exception $e) {
        Log::error(' Échec génération', [
            'presentation_id' => $presentation->id,
            'error' => $e->getMessage()
        ]);
        
        // Marquer la présentation comme échouée
        $presentation->update([
            'status' => 'failed',
            'error_message' => $e->getMessage()
        ]);
        
        //  NE PAS incrémenter le crédit ici car il n'a pas encore été déduit
        // Le crédit sera conservé car on ne l'a pas encore déduit
        
        throw $e; // Propager l'exception pour que store() la capture
    }
}

    /**
     * Construction du prompt optimisé pour formulaire
     */
protected function buildPresentationPrompt(array $data, array $options): string
{
    $title = $data['title'] ?? 'Projet de Fin d\'Études';
    $problem = $data['problem'] ?? '';
    $solution = $data['solution'] ?? '';
    $technologies = $data['technologies'] ?? '';
    $results = $data['results'] ?? '';
    $difficulties = $data['difficulties'] ?? '';
    $perspectives = $data['perspectives'] ?? '';

    $slideCount = $options['slideCount'] ?? 15;

    return <<<PROMPT
You are a SENIOR academic expert specialized in Tunisian PFE defenses.

OBJECTIVE:
Generate a HIGH-QUALITY, professional, and convincing PFE presentation adapted for a Tunisian jury.

The presentation must follow a strong storytelling:
Context → Problem → Solution → Implementation → Results → Value

INPUT:
Title: {$title}
Problem: {$problem}
Solution: {$solution}
Technologies: {$technologies}
Results: {$results}
Difficulties: {$difficulties}
Perspectives: {$perspectives}

ACADEMIC EXPECTATIONS:

- Content must reflect a REAL academic project
- Highlight VALUE and INNOVATION
- Avoid generic or vague sentences
- Use professional academic tone
- Add realistic details if missing

STRUCTURE (if the project for a developer student keep this flow else adapt and keep logical flow):

1. Page de garde
2. Plan
3. Introduction
4. Contexte général
5. Analyse de l'existant (avec limites)
6. Problématique
7. Objectifs
8. Solution proposée
9. Architecture technique (frontend / backend / API)
10. Technologies utilisées (justifiées)
11. Implémentation (fonctionnalités principales)
12. Résultats & démonstration
13. Difficultés rencontrées
14. Conclusion
15. Perspectives
16. Questions

OUTPUT RULES:

- Return ONLY valid JSON
- No text before or after JSON
- Language: French
- Slides count: {$slideCount}

CRITICAL RULES FOR SLIDES:

EACH SLIDE MUST STRICTLY:

- Contain BETWEEN 3 and 5 bullet points
- NEVER less than 3 bullets
- If content is insufficient → GENERATE additional relevant points
- Be clear, concise, and professional
- Avoid generic bullets like "Introduction du projet"

VALIDATION STEP (MANDATORY):

Before returning the JSON:
- Check ALL slides
- If any slide has less than 3 bullet points → REGENERATE that slide
- Ensure no empty or weak content

SPEAKER NOTES RULES:

- Natural spoken French (oral defense style)
-  3 to 4 phrases per slide
- Explain the slide, do NOT repeat bullets
- Add a smooth transition to the next slide

STRICT JSON FORMAT:

{
  "slides": [
    {
      "numero": 1,
      "titre": "string",
      "contenu": [
        "string",
        "string",
        "string"
      ],
      "notes_presentateur": "string"
    }
  ]
}

GLOBAL CONSTRAINTS:

- Reformulate all user inputs professionally
- No duplication between slides
- Ensure strong logical flow
- Maintain consistency across slides
- Make the presentation convincing for a jury

Generate the full presentation now.
PROMPT;
}
    /**
     * Nettoie une chaîne pour le prompt
     */
    protected function cleanString(?string $str): string
    {
        if (empty($str)) return '';
        $str = trim($str);
        $str = str_replace(["\n", "\r"], ' ', $str);
        $str = preg_replace('/\s+/', ' ', $str);
        return $str;
    }

    /**
     * Normalise les slides générées
     */
  protected function normalizeSlides(array $content): array
{
    $normalized = [];
    
    $slides = $content['slides'] ?? [];
    
    if (empty($slides)) {
        throw new \Exception("Aucune slide générée");
    }
    
    foreach ($slides as $index => $slide) {
        $normalized[] = [
            'slide_number' => $slide['numero'] ?? ($index + 1),
            'title' => $slide['titre'] ?? "Slide " . ($index + 1),
            'subtitle' => $slide['sous_titre'] ?? '',
            'content' => $slide['contenu'] ?? [],
            'speaker_notes' => $slide['notes_presentateur'] ?? "Développez ce point de manière claire et structurée."
        ];
    }
    
    return $normalized;
}
    /**
     * Normalise le contenu (string > array)
     */
    protected function normalizeContent($content): array
    {
        if (is_string($content)) {
            $content = explode("\n", $content);
        }
        
        if (!is_array($content)) {
            return ["Information à présenter"];
        }
        
        // Nettoyer chaque point
        $cleaned = [];
        foreach ($content as $point) {
            if (is_string($point)) {
                $point = trim($point);
                $point = ltrim($point, '•-* ');
                if (!empty($point) && strlen($point) > 2) {
                    $cleaned[] = $point;
                }
            }
        }
        
        return !empty($cleaned) ? $cleaned : ["Point à développer"];
    }

    /**
     * Nettoie un tableau UTF-8
     */
    protected function cleanUtf8Array(array $array): array
    {
        $cleaned = [];
        foreach ($array as $key => $value) {
            $cleanKey = is_string($key) ? $this->cleanUtf8String($key) : $key;
            if (is_array($value)) {
                $cleaned[$cleanKey] = $this->cleanUtf8Array($value);
            } elseif (is_string($value)) {
                $cleaned[$cleanKey] = $this->cleanUtf8String($value);
            } else {
                $cleaned[$cleanKey] = $value;
            }
        }
        return $cleaned;
    }

    /**
     * Nettoie une chaîne UTF-8
     */
    protected function cleanUtf8String(string $string): string
    {
        $string = mb_convert_encoding($string, 'UTF-8', 'UTF-8');
        $string = preg_replace('/[\x00-\x1F\x7F-\x9F]/u', '', $string);
        return trim($string);
    }

    /**
     * Affiche une présentation
     */
    public function show($id)
    {
        $presentation = Presentation::where('user_id', Auth::id())
            ->with('user')
            ->findOrFail($id);
        
        return inertia('PresentationViewer', [
            'presentation' => $presentation
        ]);
    }

    /**
     * Récupère le statut
     */
    public function status($id)
    {
        $presentation = Presentation::where('user_id', Auth::id())
            ->findOrFail($id);
            
        return response()->json([
            'status' => $presentation->status,
            'error_message' => $presentation->error_message,
            'progress' => $presentation->status === 'completed' ? 100 : 50,
        ]);
    }
// Dans PresentationController.php
public function update(Request $request, $id)
{
    $presentation = Presentation::findOrFail($id);
    
    $validated = $request->validate([
        'custom_slides' => 'nullable|array',
        'metadata' => 'nullable|array',
        'title' => 'nullable|string'
    ]);
    
    // Mettre à jour les slides personnalisées
    if (isset($validated['custom_slides'])) {
        $presentation->custom_slides = json_encode($validated['custom_slides']);
    }
    
    if (isset($validated['metadata'])) {
        $metadata = json_decode($presentation->metadata, true) ?? [];
        $metadata = array_merge($metadata, $validated['metadata']);
        $presentation->metadata = json_encode($metadata);
    }
    
    if (isset($validated['title'])) {
        $presentation->title = $validated['title'];
    }
    
    $presentation->save();
    
    return response()->json(['success' => true, 'presentation' => $presentation]);
}

 public function addSlide(Request $request, Presentation $presentation)
    {
        $request->validate([
            'type' => 'required|string',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'speaker_notes' => 'nullable|string',
            'visual_type' => 'required|string|in:auto,upload,none',
            'position' => 'required|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $imageUrl = null;
        
        if ($request->visual_type === 'upload' && $request->hasFile('image')) {
            try {
                // Stocker l'image dans storage/app/public/slides
                $imagePath = $request->file('image')->store('slides', 'public');
                $imageUrl = Storage::url($imagePath); // Génère /storage/slides/nomfichier.jpg
            } catch (\Exception $e) {
                \Log::error('Erreur upload image: ' . $e->getMessage());
            }
        } elseif ($request->visual_type === 'auto') {
            $imageUrl = 'https://picsum.photos/800/400?random=' . rand(1, 1000);
        }

        // Le reste de votre code...
        $generatedContent = $this->generateSlideContent(
            $request->type,
            $request->title,
            $request->description ?: $request->title
        );

        $newSlide = [
            'slide_number' => 0,
            'title' => $request->title,
            'subtitle' => $request->type,
            'content' => $generatedContent['points'],
            'image_url' => $imageUrl,
            'speaker_notes' => $request->speaker_notes ?: $generatedContent['speaker_notes'],
        ];

        // Insertion du slide...
        $content = $presentation->content;
        
        if ($request->position === 'end') {
            $content[] = $newSlide;
        } elseif ($request->position === 'start') {
            array_unshift($content, $newSlide);
        } else {
            $position = intval($request->position);
            array_splice($content, $position, 0, [$newSlide]);
        }
        
        foreach ($content as $index => &$slide) {
            $slide['slide_number'] = $index + 1;
        }
        
        $presentation->content = $content;
        $presentation->save();

        return redirect()->back()->with('success', 'Slide ajoutée avec succès');
    }
 public function updateSlide(Request $request, Presentation $presentation, $slideNumber)
    {
        try {
            $request->validate([
                'title' => 'required|string',
                'content' => 'required|array',
                'speaker_notes' => 'nullable|string'
            ]);

            // Trouver l'index de la slide
            $content = $presentation->content;
            $slideIndex = null;
            
            foreach ($content as $index => $slide) {
                if ($slide['slide_number'] == $slideNumber) {
                    $slideIndex = $index;
                    break;
                }
            }
            
            if ($slideIndex === null) {
                return response()->json(['error' => 'Slide non trouvée'], 404);
            }
            
            // Mettre à jour la slide
            $content[$slideIndex]['title'] = $request->title;
            $content[$slideIndex]['content'] = $request->content;
            $content[$slideIndex]['speaker_notes'] = $request->speaker_notes;
            
            $presentation->content = $content;
            $presentation->save();
            
            return redirect()->back()->with('success', 'Slide mise à jour avec succès');
            
        } catch (\Exception $e) {
            Log::error('Erreur updateSlide: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour');
        }
    }
/**
 * Supprimer une slide
 */
public function deleteSlide(Presentation $presentation, $slideNumber)
{
    try {
        $content = $presentation->content;
        $slideIndex = null;
        
        // Trouver l'index de la slide à supprimer
        foreach ($content as $index => $slide) {
            if ($slide['slide_number'] == $slideNumber) {
                $slideIndex = $index;
                break;
            }
        }
        
        if ($slideIndex === null) {
            return redirect()->back()->with('error', 'Slide non trouvée');
        }
        
        // Supprimer la slide
        array_splice($content, $slideIndex, 1);
        
        // Renuméroter les slides restantes
        foreach ($content as $index => &$slide) {
            $slide['slide_number'] = $index + 1;
        }
        
        $presentation->content = $content;
        $presentation->save();
        
        return redirect()->back()->with('success', 'Slide supprimée avec succès');
        
    } catch (\Exception $e) {
        \Log::error('Erreur deleteSlide: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Erreur lors de la suppression');
    }
}
private function generateSlideContent($type, $title, $description)
{
    // Logique de génération IA existante
    return [
        'points' => [
            "Introduction à $type : $title",
            "Point clé 1 : $description",
            "Point clé 2 : Développement du concept",
            "Point clé 3 : Applications pratiques",
            "Conclusion sur $type"
        ],
        'speaker_notes' => "Présentez les points clés de $title en 1-2 minutes"
    ];
}


    /**
     * Exporte la présentation
     */
    public function export($id)
    {
        $presentation = Presentation::where('user_id', Auth::id())
            ->findOrFail($id);
            
        if ($presentation->status !== 'completed') {
            return response()->json(['error' => 'Présentation non disponible'], 400);
        }
        
        return response()->json([
            'presentation' => $presentation->content,
            'metadata' => $presentation->metadata,
            'exported_at' => now()->toISOString()
        ]);
    }
}