<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jury_simulations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('presentation_id')->nullable()->constrained()->onDelete('set null');
            $table->string('jury_type'); // technique, business, pedagogique, mixte
            $table->string('jury_name');
            $table->integer('total_questions');
            $table->integer('final_score');
            $table->json('answers')->nullable(); // Stocke toutes les réponses
            $table->json('feedbacks')->nullable(); // Stocke tous les feedbacks
            $table->json('category_scores')->nullable(); // Scores par catégorie
            $table->integer('credits_used')->default(1);
            $table->enum('status', ['completed', 'abandoned', 'in_progress'])->default('completed');
            $table->integer('duration_seconds')->nullable(); // Durée totale
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jury_simulations');
    }
};