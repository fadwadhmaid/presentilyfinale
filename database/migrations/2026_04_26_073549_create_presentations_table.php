<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presentations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('generation_method', ['pdf', 'form'])->default('form');
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->json('content')->nullable(); // Stocke les slides générées
            $table->json('options')->nullable(); // Style, slide_count, etc.
            $table->json('script_oral')->nullable(); // Script associé
            $table->json('questions_jury')->nullable(); // Questions probables
            $table->string('original_file_path')->nullable(); // Chemin du PDF uploadé
            $table->text('error_message')->nullable();
            $table->timestamp('generated_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presentations');
    }
};