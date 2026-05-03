<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JurySimulation extends Model
{
    protected $fillable = [
        'user_id',
        'presentation_id',
        'jury_type',
        'jury_name',
        'total_questions',
        'final_score',
        'answers',
        'feedbacks',
        'category_scores',
        'credits_used',
        'status',
        'duration_seconds'
    ];

    protected $casts = [
        'answers' => 'array',
        'feedbacks' => 'array',
        'category_scores' => 'array',
        'final_score' => 'integer',
        'total_questions' => 'integer',
        'credits_used' => 'integer',
        'duration_seconds' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function presentation(): BelongsTo
    {
        return $this->belongsTo(Presentation::class);
    }

    // Scope pour les simulations terminées
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Scope pour les simulations d'un utilisateur
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}