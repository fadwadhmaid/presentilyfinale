<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIPresentationService
{
    protected string $apiKey;
    protected string $apiUrl;

    public function __construct()
    {
        // Configurer pour utiliser OpenAI ou simuler pour le développement
        $this->apiKey = config('services.openai.api_key', '');
        $this->apiUrl = 'https://api.openai.com/v1/chat/completions';
    }

    public function generatePresentation(array $content, array $options): array
    {
        // Version simplifiée pour tester sans API
        // En production, décommentez l'appel API
        
        // Pour tester sans API (mode développement)
        return $this->getMockPresentation($content, $options);
        
        /* Version avec API réelle
        $prompt = $this->buildPresentationPrompt($content, $options);
        $response = $this->callOpenAI($prompt);
        return $this->parsePresentationResponse($response, $options);
        */
    }

    public function generateOralScript(array $slides, array $content): array
    {
        // Version mockée pour tester
        $script = [];
        foreach ($slides as $slide) {
            $script[$slide['slide_number']] = "Présentez la slide {$slide['slide_number']} : {$slide['title']}. Expliquez clairement les points clés.";
        }
        return $script;
    }

    public function generateJuryQuestions(array $slides, array $content): array
    {
        // Version mockée pour tester
        return [
            ['category' => 'technique', 'question' => 'Pourquoi avez-vous choisi cette architecture technique ?', 'tips' => 'Mettez en avant les avantages'],
            ['category' => 'technique', 'question' => 'Quelles alternatives avez-vous considérées ?', 'tips' => 'Comparez objectivement'],
            ['category' => 'methodologique', 'question' => 'Comment avez-vous validé vos résultats ?', 'tips' => 'Décrivez votre processus de test'],
            ['category' => 'perspective', 'question' => 'Quelles améliorations envisagez-vous ?', 'tips' => 'Soyez ambitieux mais réaliste'],
        ];
    }

    protected function getMockPresentation(array $content, array $options): array
    {
        $slideCount = (int)($options['slideCount'] ?? 15);
        $style = $options['style'] ?? 'modern';
        
        $slides = [];
        
        // Structure de base des slides PFE
        $templates = [
            ['title' => 'Présentation du Projet PFE', 'subtitle' => $content['title'] ?? 'Mon Projet PFE', 'points' => [
                'Bienvenue et introduction',
                'Présentation de l\'étudiant',
                'Contexte du projet'
            ]],
            ['title' => 'Plan de la Présentation', 'subtitle' => 'Déroulement de la soutenance', 'points' => [
                'Contexte et problématique',
                'Solution technique',
                'Résultats et démonstration',
                'Conclusion et perspectives'
            ]],
            ['title' => 'Contexte du Projet', 'subtitle' => 'Pourquoi ce projet ?', 'points' => [
                $content['problem'] ?? 'Problématique identifiée dans le secteur',
                'Objectifs à atteindre',
                'Public cible et bénéficiaires'
            ]],
            ['title' => 'Problématique', 'subtitle' => 'Question de recherche', 'points' => [
                $content['problem'] ?? 'Comment résoudre le problème identifié ?',
                'Contraintes et défis',
                'Cahier des charges'
            ]],
            ['title' => 'État de l\'art', 'subtitle' => 'Solutions existantes', 'points' => [
                'Analyse des concurrents',
                'Forces et faiblesses des solutions actuelles',
                'Notre positionnement'
            ]],
            ['title' => 'Solution Proposée', 'subtitle' => 'Approche technique', 'points' => [
                $content['solution'] ?? 'Architecture modulaire et scalable',
                'Fonctionnalités principales',
                'Innovations apportées'
            ]],
            ['title' => 'Architecture Technique', 'subtitle' => 'Choix technologiques', 'points' => [
                $content['technologies'] ?? 'Laravel, React, PostgreSQL',
                'API et services',
                'Sécurité et performances'
            ]],
            ['title' => 'Développement', 'subtitle' => 'Implémentation', 'points' => [
                'Méthodologie Agile',
                'Itérations et versions',
                'Tests unitaires et d\'intégration'
            ]],
            ['title' => 'Résultats', 'subtitle' => 'Ce qui a été accompli', 'points' => [
                $content['results'] ?? 'MVP fonctionnel',
                'Démonstration en direct',
                'Métriques et indicateurs'
            ]],
            ['title' => 'Tests et Validation', 'subtitle' => 'Qualité et fiabilité', 'points' => [
                'Tests utilisateurs',
                'Correction des bugs',
                'Performance et scalabilité'
            ]],
            ['title' => 'Difficultés Rencontrées', 'subtitle' => 'Leçons apprises', 'points' => [
                $content['difficulties'] ?? 'Défis techniques surmontés',
                'Solutions trouvées',
                'Compétences développées'
            ]],
            ['title' => 'Planning', 'subtitle' => 'Gestion de projet', 'points' => [
                'Diagramme de Gantt',
                'Respect des délais',
                'Répartition des tâches'
            ]],
            ['title' => 'Perspectives', 'subtitle' => 'Améliorations futures', 'points' => [
                $content['perspectives'] ?? 'Fonctionnalités à ajouter',
                'Évolutions possibles',
                'Opportunités de déploiement'
            ]],
            ['title' => 'Conclusion', 'subtitle' => 'Bilan du projet', 'points' => [
                'Objectifs atteints',
                'Valeur ajoutée',
                'Compétences acquises'
            ]],
            ['title' => 'Merci pour votre Attention', 'subtitle' => 'Questions / Réponses', 'points' => [
                'Questions du jury',
                'Démonstration complémentaire',
                'Remerciements'
            ]]
        ];
        
        // Générer le nombre demandé de slides
        for ($i = 0; $i < min($slideCount, count($templates)); $i++) {
            $template = $templates[$i];
            $slides[] = [
                'slide_number' => $i + 1,
                'title' => $template['title'],
                'subtitle' => $template['subtitle'],
                'content' => $template['points'],
                'design_note' => "Style: {$style}, icône suggérée: image_{$i}",
                'speaker_notes' => "Durée approximative: 1 minute. Insistez sur les points clés de cette slide."
            ];
        }
        
        return [
            'slides' => $slides,
            'metadata' => [
                'total_slides' => count($slides),
                'estimated_duration' => count($slides),
                'style' => $style,
                'generated_at' => now()->toISOString()
            ]
        ];
    }

    protected function buildPresentationPrompt(array $content, array $options): string
    {
        // Prompt pour l'API OpenAI
        return "Génère une présentation de soutenance PFE...";
    }

    protected function callOpenAI(string $prompt): array
    {
        if (empty($this->apiKey)) {
            throw new \Exception('OpenAI API key not configured');
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl, [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'Tu es un expert en présentations PFE.'],
                ['role' => 'user', 'content' => $prompt]
            ],
            'temperature' => 0.7,
        ]);

        if (!$response->successful()) {
            throw new \Exception('OpenAI API error: ' . $response->status());
        }

        return $response->json();
    }

    protected function parsePresentationResponse(array $response, array $options): array
    {
        // Parser la réponse de l'API
        $content = json_decode($response['choices'][0]['message']['content'], true);
        return $content ?? $this->getMockPresentation([], $options);
    }
}