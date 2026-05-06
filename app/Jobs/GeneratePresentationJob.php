<?php

namespace App\Jobs;

use App\Models\Presentation;
use App\Services\OpenAIService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GeneratePresentationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 300;

    protected int $presentationId;
    protected string $prompt;
    protected int $userId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $presentationId, string $prompt, int $userId)
    {
        $this->presentationId = $presentationId;
        $this->prompt = $prompt;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(OpenAIService $openAIService): void
    {
        try {

            // 🔹 1. récupérer présentation
            $presentation = Presentation::find($this->presentationId);

            if (!$presentation) {
                Log::error("Presentation not found: {$this->presentationId}");
                return;
            }

            // 🔹 2. update status processing
            $presentation->update([
                'status' => 'processing'
            ]);

            // 🔹 3. appeler OpenAI
            $result = $openAIService->generateContent($this->prompt);

            // 🔹 4. sauvegarder résultat
            $presentation->update([
                'content' => json_encode($result),
                'status' => 'done'
            ]);

        } catch (\Exception $e) {

            Log::error('GeneratePresentationJob failed', [
                'error' => $e->getMessage()
            ]);

            // 🔴 statut failed
            if (isset($presentation)) {
                $presentation->update([
                    'status' => 'failed'
                ]);
            }

            throw $e;
        }
    }
}