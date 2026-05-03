<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenRouterService
{
    protected string $apiKey;
    protected string $apiUrl;
    protected string $siteUrl;
    protected string $siteName;

    public function __construct()
    {
        $this->apiUrl = 'https://openrouter.ai/api/v1/chat/completions';
        $this->siteUrl = config('app.url');
        $this->siteName = config('app.name');
    }

    /**
     * Appelle l'API OpenRouter pour générer du contenu
     * 
     * @throws \Exception
     */
    public function generateContent(string $prompt, array $options = []): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'HTTP-Referer' => $this->siteUrl,
                'X-Title' => $this->siteName,
            ])->timeout(120) // Timeout de 2 minutes pour l'IA
              ->post($this->apiUrl, [
                'model' => $options['model'] ?? 'nvidia/nemotron-nano-12b-v2-vl:free',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $options['system_prompt'] ?? "Vous êtes un expert en création de présentations de soutenance PFE. Vous générez des présentations structurées, professionnelles et percutantes. Répondez toujours en JSON valide."
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => $options['temperature'] ?? 0.7,
                'max_tokens' => $options['max_tokens'] ?? 4000,
                'response_format' => ['type' => 'json_object'] // Force la réponse JSON
            ]);

            if (!$response->successful()) {
                $errorMessage = $response->json('error.message') ?? 'Erreur inconnue de l\'API';
                Log::error('OpenRouter API Error', [
                    'status' => $response->status(),
                    'error' => $errorMessage,
                    'response' => $response->body()
                ]);
                
                throw new \Exception("Erreur API OpenRouter: " . $errorMessage);
            }

            $data = $response->json();
            
            if (!isset($data['choices'][0]['message']['content'])) {
                throw new \Exception("Format de réponse API invalide");
            }

            $content = $data['choices'][0]['message']['content'];
            
            // Tenter de décoder le JSON
            $decoded = json_decode($content, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                // Si ce n'est pas du JSON valide, essayer d'extraire le JSON
                if (preg_match('/\{[\s\S]*\}/', $content, $matches)) {
                    $decoded = json_decode($matches[0], true);
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        throw new \Exception("La réponse n'est pas au format JSON valide");
                    }
                } else {
                    throw new \Exception("La réponse n'est pas au format JSON valide");
                }
            }

            return [
                'success' => true,
                'content' => $decoded,
                'raw' => $content,
                'usage' => $data['usage'] ?? null
            ];

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('OpenRouter Connection Error', ['error' => $e->getMessage()]);
            throw new \Exception("Problème de connexion avec le service IA. Veuillez réessayer plus tard.");
        } catch (\Exception $e) {
            Log::error('OpenRouter Service Error', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Génère la structure de la présentation
     */
    public function generatePresentation(array $data, array $options): array
    {
        $prompt = $this->buildPresentationPrompt($data, $options);
        
        try {
            $result = $this->generateContent($prompt, [
                'temperature' => 0.7,
                'max_tokens' => 4000,
                'system_prompt' => $this->getSystemPrompt()
            ]);
            
            if ($result['success']) {
                return $result['content'];
            }
            
            throw new \Exception($result['error'] ?? "Échec de la génération");
            
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la génération de la présentation: " . $e->getMessage());
        }
    }

    /**
     * Génère le script oral
     */
    public function generateOralScript(array $slides, array $options): array
    {
        $prompt = $this->buildScriptPrompt($slides, $options);
        
        try {
            $result = $this->generateContent($prompt, [
                'temperature' => 0.8,
                'max_tokens' => 3000,
                'system_prompt' => "Vous êtes un expert en prise de parole. Générez un script oral naturel, professionnel et chronométré pour une soutenance PFE."
            ]);
            
            if ($result['success']) {
                return $result['content'];
            }
            
            throw new \Exception($result['error'] ?? "Échec de la génération du script");
            
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la génération du script oral: " . $e->getMessage());
        }
    }

    /**
     * Génère les questions probables du jury
     */
    public function generateJuryQuestions(array $presentationData, array $options): array
    {
        $prompt = $this->buildQuestionsPrompt($presentationData, $options);
        
        try {
            $result = $this->generateContent($prompt, [
                'temperature' => 0.9,
                'max_tokens' => 2000,
                'system_prompt' => "Vous êtes un membre de jury d'école d'ingénieurs. Générez des questions pertinentes, techniques et stratégiques pour une soutenance PFE."
            ]);
            
            if ($result['success']) {
                return $result['content'];
            }
            
            throw new \Exception($result['error'] ?? "Échec de la génération des questions");
            
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la génération des questions jury: " . $e->getMessage());
        }
    }

    protected function buildPresentationPrompt(array $data, array $options): string
    {
        $slideCount = (int)($options['slideCount'] ?? 15);
        $style = $options['style'] ?? 'modern';
        
        return json_encode([
            'instruction' => "Génère une présentation de soutenance PFE complète et professionnelle.",
            'contexte' => $data,
            'options' => [
                'nombre_slides' => $slideCount,
                'style_visuel' => $style,
                'type' => 'pfe_soutenance'
            ],
            'format_attendu' => [
                'slides' => [
                    [
                        'numero' => 1,
                        'titre' => "Titre de la slide",
                        'contenu' => ["Point 1", "Point 2"],
                        'notes_presentateur' => "Notes pour le présentateur",
                        'transition' => "Transition vers la slide suivante"
                    ]
                ],
                'structure' => [
                    'introduction' => 'Présentation du contexte et de la problématique',
                    'problematique' => 'Définition claire de la problématique',
                    'solution' => 'Description de la solution technique',
                    'implementation' => 'Détails de l\'implémentation',
                    'resultats' => 'Présentation des résultats',
                    'conclusion' => 'Conclusion et perspectives'
                ]
            ],
            'contraintes' => [
                'contenu_percutant',
                'langage_professionnel',
                'clarte_et_synthese',
                'adaptation_soutenance_20_minutes'
            ]
        ]);
    }

    protected function buildScriptPrompt(array $slides, array $options): string
    {
        return json_encode([
            'instruction' => "Génère un script oral détaillé pour chaque slide de la présentation",
            'slides' => $slides,
            'duree_totale' => "20 minutes",
            'format_attendu' => [
                'script_par_slide' => [
                    'slide_numero' => 1,
                    'duree_estimee' => "en secondes",
                    'discours' => "Texte à dire mot pour mot",
                    'tips_orateurs' => "Conseils de présentation"
                ],
                'introduction_globale' => "Introduction de 30 secondes",
                'conclusion_globale' => "Conclusion de 1 minute"
            ]
        ]);
    }

    protected function buildQuestionsPrompt(array $presentationData, array $options): string
    {
        return json_encode([
            'instruction' => "Génère une liste de questions probables que le jury pourrait poser",
            'presentation' => $presentationData,
            'format_attendu' => [
                'questions_techniques' => [
                    'question' => "La question",
                    'niveau' => "débutant/intermédiaire/avancé",
                    'reponse_suggeree' => "Éléments de réponse"
                ],
                'questions_methodologie' => [],
                'questions_perspectives' => [],
                'red_flags' => "Points faibles potentiels à anticiper"
            ],
            'contexte' => "Jury d'école d'ingénieurs, soutenance PFE de 20 minutes"
        ]);
    }

    protected function getSystemPrompt(): string
{
    return "Tu es un EXPERT TUNISIEN en création de présentations de soutenance PFE.
    
    RÈGLES STRICTES À SUIVRE:
    1. Structure standardisée selon les normes des universités tunisiennes
    2. Présentation 100% professionnelle adaptée aux jurys d'école d'ingénieurs
    3. Contenu pertinent, synthétique mais complet (pas de bla-bla)
    4. Langage technique mais accessible
    5. Temps de présentation: 20 minutes maximum
    6. Ton confiant et convaincant
    
    POUR CHAQUE SLIDE:
    - Titre accrocheur avec émoji pertinent
    - 3-5 points clés maximum
    - Format 'point bullet' avec • ou ✓
    - Notes présentateur pour l'oral
    - Transition vers la slide suivante
    
    CONTEXTE TUNISIEN SPÉCIFIQUE:
    - Valoriser l'innovation et l'adaptation au marché tunisien
    - Mettre en avant l'aspect pratique et professionnel
    - Souligner la méthodologie rigoureuse
    - Inclure des exemples concrets si possible
    
    RÉPONDS TOUJOURS EN JSON VALIDE avec cette structure EXACTE:
    {
        \"slides\": [
            {
                \"numero\": 1,
                \"titre\": \"Titre accrocheur\",
                \"contenu\": [\"Point 1\", \"Point 2\", \"Point 3\"],
                \"notes_presentateur\": \"Ce qu'il faut dire et comment le dire\",
                \"duree_suggested\": 60
            }
        ]
    }";
}
}