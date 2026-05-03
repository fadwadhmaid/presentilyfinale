<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use App\Services\ChunkingService;
use App\Services\ChunkAnalysisService;
use App\Services\FinalPresentationService;
class AppServiceProvider extends ServiceProvider
{
   
    public function register(): void
    {
        $this->app->singleton(ChunkingService::class);
        $this->app->singleton(ChunkAnalysisService::class);
        $this->app->singleton(FinalPresentationService::class);
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
