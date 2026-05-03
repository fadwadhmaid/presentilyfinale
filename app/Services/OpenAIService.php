<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    protected string $apiKey;
    protected string $apiUrl = 'https://api.openai.com/v1/responses';

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
    }

 public function generateContent(string $prompt, array $options = []): array
{
    if (empty($this->apiKey)) {
        throw new \Exception("Configuration API OpenAI manquante.");
    }

    $model = 'gpt-5-mini';

    try {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->timeout(120)
        ->post($this->apiUrl, [
            'model' => $model,
            'input' => [
                [
                    'role' => 'system',
                    'content' => [
                        ['type' => 'input_text', 'text' => "Tu es un expert en présentations PFE tunisien. Tu réponds UNIQUEMENT en JSON valide."]
                    ]
                ],
                [
                    'role' => 'user',
                    'content' => [
                        ['type' => 'input_text', 'text' => $prompt]
                    ]
                ]
            ],
            'max_output_tokens' => 8000,
        ]);

        if (!$response->successful()) {
            Log::error('OpenAI HTTP Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            throw new \Exception("Erreur API OpenAI");
        }

        $data = $response->json();

        // 🔥 extraction propre
        $content = null;

        foreach ($data['output'] as $item) {
            if ($item['type'] === 'message') {
                foreach ($item['content'] as $c) {
                    if ($c['type'] === 'output_text') {
                        $content = $c['text'];
                        break 2;
                    }
                }
            }
        }

        if (empty($content)) {
            Log::error('Réponse OpenAI invalide', $data);
            throw new \Exception("La réponse de l'API est vide");
        }

        $decoded = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('JSON Error: ' . json_last_error_msg(), ['content' => $content]);
            throw new \Exception("JSON invalide: " . json_last_error_msg());
        }

        return ['success' => true, 'content' => $decoded];

    } catch (\Exception $e) {
        Log::error('OpenAI Error: ' . $e->getMessage());
        throw $e;
    }
}



// Dans app/Services/OpenAIService.php

public function analyzePresentation(string $prompt): array
{
    if (empty($this->apiKey)) {
        throw new \Exception("API key manquante");
    }

    try {
        // Déterminer la structure du contenu à envoyer
        $inputContent = [
            [
                'role' => 'system',
                'content' => [
                    [
                        'type' => 'input_text',
                        'text' => "Tu es un expert en évaluation de projets PFE. Tu génères des questions SPÉCIFIQUES et PERTINENTES basées sur le contenu fourni. Tu ne donnes JAMAIS de réponses génériques."
                    ]
                ]
            ],
            [
                'role' => 'user',
                'content' => [
                    [
                        'type' => 'input_text',
                        'text' => $prompt
                    ]
                ]
            ]
        ];

        // Construction des paramètres compatibles Responses API
        $payload = [
            'model' => 'gpt-4.1-mini',
            'input' => $inputContent,
            'max_output_tokens' => 2500,
            'temperature' => 0.7,
            // ✅ SOLUTION : Utiliser text.format au lieu de response_format
            'text' => [
                'format' => [
                    'type' => 'json_object'
                ]
            ]
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->timeout(120)
        ->post($this->apiUrl, $payload);

        if (!$response->successful()) {
            \Log::error('OpenAI API error: ' . $response->body());
            throw new \Exception("Erreur API OpenAI: " . $response->status());
        }

        $data = $response->json();

        // Nouveau format de réponse pour Responses API
        $content = $data['output'][0]['content'][0]['text'] ?? null;
        
        if (!$content) {
            throw new \Exception("Réponse vide de l'API");
        }
        
        // Nettoyage du JSON
        $content = preg_replace('/```json\s*|\s*```/', '', $content);
        
        $decoded = json_decode($content, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            \Log::error('JSON decode error: ' . json_last_error_msg());
            throw new \Exception("Réponse JSON invalide");
        }
        
        return $decoded;

    } catch (\Exception $e) {
        \Log::error('OpenAI analyze error: ' . $e->getMessage());
        throw $e;
    }
}
}