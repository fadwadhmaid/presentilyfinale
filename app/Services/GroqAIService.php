<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqAIService
{
    protected string $apiKey;
    protected string $apiUrl;
    protected string $model;

    public function __construct()
    {
        $this->apiKey = env('GROQ_API_KEY');
        $this->apiUrl = 'https://api.groq.com/openai/v1/chat/completions';
        $this->model = 'llama-3.3-70b-versatile'; // Modèle gratuit le plus performant
        // Alternatives gratuites: 'llama3-8b-8192', 'gemma2-9b-it', 'llama3-70b-8192'
    }

    public function generatePresentation(array $content, array $options): array
    {
        $prompt = $this->buildPresentationPrompt($content, $options);
        $response = $this->callGroq($prompt);
        return $this->parsePresentationResponse($response, $options);
    }

    public function generateOralScript(array $slides, array $content): array
    {
        $prompt = $this->buildScriptPrompt($slides, $content);
        $response = $this->callGroq($prompt);
        return $this->parseScriptResponse($response);
    }

    public function generateJuryQuestions(array $slides, array $content): array
    {
        $prompt = $this->buildQuestionsPrompt($slides, $content);
        $response = $this->callGroq($prompt);
        return $this->parseQuestionsResponse($response);
    }

    protected function buildPresentationPrompt(array $content, array $options): string
    {
        $slideCount = $options['slideCount'] ?? 15;
        $style = $options['style'] ?? 'modern';
        
        $title = $content['title'] ?? 'Projet PFE';
        $problem = $content['problem'] ?? 'Non spécifié';
        $solution = $content['solution'] ?? 'Non spécifié';
        $technologies = $content['technologies'] ?? 'Non spécifié';
        $results = $content['results'] ?? 'Non spécifié';
        $difficulties = $content['difficulties'] ?? 'Non spécifié';
        $perspectives = $content['perspectives'] ?? 'Non spécifié';
        
        return "Tu es un expert en création de présentations de soutenance PFE (Projet de Fin d'Études) en Tunisie.

Voici les informations du projet :
- Titre : {$title}
- Problématique : {$problem}
- Solution technique : {$solution}
- Technologies : {$technologies}
- Résultats : {$results}
- Difficultés : {$difficulties}
- Perspectives : {$perspectives}

Génère une présentation de soutenance de {$slideCount} slides environ avec le style '{$style}'.

Structure obligatoire des slides pour un PFE tunisien :
1. Page de garde (titre, étudiant, encadrants, logo université, année)
2. Plan de la présentation (sommaire)
3. Introduction et contexte (pourquoi ce projet)
4. Problématique et objectifs (question de recherche)
5. État de l'art / Solutions existantes
6. Cahier des charges et contraintes
7. Solution proposée (architecture technique)
8. Technologies utilisées (justification des choix)
9. Développement et implémentation
10. Démonstration et résultats obtenus
11. Tests et validation
12. Difficultés rencontrées et solutions
13. Planning et méthodologie
14. Perspectives et améliorations futures
15. Conclusion générale
16. Questions / Remerciements

Pour chaque slide, fournis AU FORMAT JSON UNIQUEMENT avec cette structure exacte :
{
    \"slides\": [
        {
            \"slide_number\": 1,
            \"title\": \"titre de la slide\",
            \"subtitle\": \"sous-titre optionnel\",
            \"content\": [\"point 1\", \"point 2\", \"point 3\", \"point 4\"],
            \"design_note\": \"icône suggérée: ..., mise en page: ...\",
            \"speaker_notes\": \"notes pour l'oral (30-45 secondes)\"
        }
    ],
    \"metadata\": {
        \"total_slides\": {$slideCount},
        \"estimated_duration\": " . ($slideCount * 1.5) . ",
        \"style\": \"{$style}\"
    }
}

IMPORTANT: Retourne UNIQUEMENT du JSON valide, rien d'autre.";
    }

    protected function buildScriptPrompt(array $slides, array $content): string
    {
        $slidesSummary = [];
        foreach ($slides as $slide) {
            $slidesSummary[] = "Slide {$slide['slide_number']}: {$slide['title']}";
        }

        return "Génère un script oral détaillé pour une soutenance PFE.

Slides à présenter: " . implode(", ", $slidesSummary) . "

Pour chaque slide, génère un script de 30-45 secondes, naturel et professionnel, comme si l'étudiant parlait au jury.

Format JSON attendu :
{
    \"script\": {
        \"1\": \"Bonjour, je vais vous présenter...\",
        \"2\": \"Passons maintenant au plan...\"
    },
    \"total_duration_minutes\": 15,
    \"tips\": \"Conseils pour l'oral: parlez lentement, regardez le jury...\"
}

Retourne UNIQUEMENT du JSON valide.";
    }

    protected function buildQuestionsPrompt(array $slides, array $content): string
    {
        return "Génère 10 questions probables que le jury d'une soutenance PFE tunisienne pourrait poser.

Basé sur ce projet :
- Titre: " . ($content['title'] ?? 'Projet PFE') . "
- Solution: " . ($content['solution'] ?? 'Non spécifié') . "

Catégorise les questions :
- Questions techniques (sur l'architecture, les choix technologiques)
- Questions méthodologiques (sur l'approche, la gestion de projet)
- Questions de perspective (sur l'évolution du projet)

Format JSON :
{
    \"questions\": [
        {
            \"category\": \"technique\",
            \"question\": \"Pourquoi avez-vous choisi cette technologie?\",
            \"tips\": \"Mettez en avant les avantages par rapport aux alternatives\",
            \"difficulty\": \"medium\"
        }
    ],
    \"advice\": \"Conseils généraux pour répondre aux questions\"
}

Retourne UNIQUEMENT du JSON valide.";
    }

    // app/Services/GroqAIService.php
// Modifiez la méthode callGroq :

protected function callGroq(string $prompt): array
{
    try {
        if (empty($this->apiKey)) {
            throw new \Exception('GROQ_API_KEY non configurée');
        }

        // Log de la requête
        \Log::info('Appel API Groq', [
            'model' => $this->model,
            'api_key_prefix' => substr($this->apiKey, 0, 15) . '...',
            'prompt_length' => strlen($prompt)
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->timeout(120)
          ->post($this->apiUrl, [
            'model' => $this->model,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Tu es un expert en présentations académiques PFE. Tu réponds toujours au format JSON valide.'
                ],
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ],
            'temperature' => 0.7,
            'max_tokens' => 4096,
        ]);

        // Log détaillé de la réponse
        \Log::info('Réponse Groq brute', [
            'status' => $response->status(),
            'successful' => $response->successful(),
            'body' => $response->body()
        ]);

        if (!$response->successful()) {
            $errorBody = $response->json();
            $errorMessage = $errorBody['error']['message'] ?? 'Erreur inconnue';
            \Log::error('Erreur Groq détaillée', [
                'status' => $response->status(),
                'error' => $errorMessage,
                'full_response' => $response->body()
            ]);
            throw new \Exception('Erreur API Groq: ' . $response->status() . ' - ' . $errorMessage);
        }

        $result = $response->json();
        $content = $result['choices'][0]['message']['content'] ?? '';
        
        // Nettoyer le contenu
        $content = $this->extractJson($content);
        $decoded = json_decode($content, true);
        
        if (!$decoded) {
            \Log::error('JSON invalide reçu', ['content' => $content]);
            throw new \Exception('La réponse n\'est pas du JSON valide');
        }
        
        return $decoded;

    } catch (\Exception $e) {
        \Log::error('Exception Groq API', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        throw $e;
    }
}

    protected function extractJson(string $content): string
    {
        // Extraire le JSON des backticks ou du texte
        if (preg_match('/```json\s*(\{.*?\})\s*```/s', $content, $matches)) {
            return $matches[1];
        }
        if (preg_match('/```\s*(\{.*?\})\s*```/s', $content, $matches)) {
            return $matches[1];
        }
        if (preg_match('/\{.*\}/s', $content, $matches)) {
            return $matches[0];
        }
        return $content;
    }

    protected function parsePresentationResponse(array $response, array $options): array
    {
        if (isset($response['slides']) && !empty($response['slides'])) {
            return $response;
        }
        
        // Fallback en cas d'erreur
        return $this->getFallbackPresentation($options);
    }

    protected function parseScriptResponse(array $response): array
    {
        return $response['script'] ?? [];
    }

    protected function parseQuestionsResponse(array $response): array
    {
        return $response['questions'] ?? [];
    }

    protected function getFallbackPresentation(array $options): array
    {
        $slideCount = (int)($options['slideCount'] ?? 15);
        $slides = [];
        
        for ($i = 1; $i <= $slideCount; $i++) {
            $slides[] = [
                'slide_number' => $i,
                'title' => "Slide {$i}",
                'subtitle' => "Contenu à générer",
                'content' => ["Point important 1", "Point important 2", "Point important 3"],
                'design_note' => "Style moderne",
                'speaker_notes' => "Présentez clairement ce point"
            ];
        }
        
        return [
            'slides' => $slides,
            'metadata' => [
                'total_slides' => $slideCount,
                'estimated_duration' => $slideCount * 1.5,
                'style' => $options['style'] ?? 'modern',
                'generated_at' => now()->toISOString()
            ]
        ];
    }

    // Pour vérifier si l'API fonctionne
    public function testConnection(): bool
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->get('https://api.groq.com/openai/v1/models');
            
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }
}