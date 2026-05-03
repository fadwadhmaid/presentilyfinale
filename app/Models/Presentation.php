<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Presentation extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'generation_method',
        'status',
        'content',
        'options',
        'script_oral',
        'questions_jury',
        'original_file_path',
        'error_message',
        'generated_at'
    ];

    protected $casts = [
        'content' => 'array',
        'options' => 'array',
        'script_oral' => 'array',
        'questions_jury' => 'array',
        'generated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function markAsProcessing(): void
    {
        $this->update(['status' => 'processing']);
    }

    public function markAsCompleted(array $content, ?array $script = null, ?array $questions = null): void
    {
        $this->update([
            'status' => 'completed',
            'content' => $content,
            'script_oral' => $script,
            'questions_jury' => $questions,
            'generated_at' => now(),
        ]);
    }

    public function markAsFailed(string $error): void
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $error,
        ]);
    }
}