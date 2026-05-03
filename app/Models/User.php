<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Order; 
use App\Notifications\VerifyEmail;
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'university',
        'study_year',
        'domain',
        'presentation_credits',
        'jury_credits',
        'reformulation_credits',
        'total_presentations_generated',
        'total_jury_simulations',
        'total_reformulations',
        'subscription_expires_at',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
 /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'subscription_expires_at' => 'datetime',
            'presentation_credits' => 'integer',
            'jury_credits' => 'integer',
            'reformulation_credits' => 'integer',
            'total_presentations_generated' => 'integer',
            'total_jury_simulations' => 'integer',
            'total_reformulations' => 'integer',
            'is_admin' => 'boolean',
        ];
    }
public function sendPasswordResetNotification($token)
{
    $this->notify(new \App\Notifications\CustomResetPassword($token));
}
    /**
     * Relations
     */
    public function presentations()
    {
        return $this->hasMany(Presentation::class);
    }

    public function jurySimulations()
    {
        return $this->hasMany(JurySimulation::class);
    }

    public function reformulations()
    {
        return $this->hasMany(Reformulation::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
/**
     * Vérifier si l'utilisateur est admin
     */
    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }
 /**
     * Ajouter des crédits depuis une commande
     */
    public function addCreditsFromOrder($offerDetails)
    {
        $features = $offerDetails['features'];
        
        // Gérer les crédits illimités (-1 signifie illimité)
        if ($features['presentations'] > 0) {
            $this->addPresentationCredits($features['presentations']);
        }
        
        if ($features['simulations'] > 0) {
            $this->addJuryCredits($features['simulations']);
        }
        
        if ($features['reformulations'] > 0) {
            $this->addReformulationCredits($features['reformulations']);
        }
        
        // Pour l'offre premium (illimité), on met une grande valeur ou on utilise un système différent
        if ($features['presentations'] === -1) {
            $this->update(['subscription_expires_at' => now()->addMonth()]);
            // Ou mets 999 crédits pour simuler l'illimité
            $this->addPresentationCredits(999);
            $this->addJuryCredits(999);
            $this->addReformulationCredits(999);
        }
    }
    /**
     * Check if user has enough credits
     */
    public function hasEnoughPresentationCredits(): bool
    {
        return $this->presentation_credits > 0;
    }

    public function hasEnoughJuryCredits(): bool
    {
        return $this->jury_credits > 0;
    }

    public function hasEnoughReformulationCredits(): bool
    {
        return $this->reformulation_credits > 0;
    }

    /**
     * Use a credit
     */
    public function usePresentationCredit(): void
    {
        $this->decrement('presentation_credits');
        $this->increment('total_presentations_generated');
    }

    public function useJuryCredit(): void
    {
        $this->decrement('jury_credits');
        $this->increment('total_jury_simulations');
    }

    public function useReformulationCredit(): void
    {
        $this->decrement('reformulation_credits');
        $this->increment('total_reformulations');
    }

    /**
     * Add credits (when buying an offer)
     */
    public function addPresentationCredits(int $amount): void
    {
        $this->increment('presentation_credits', $amount);
    }

    public function addJuryCredits(int $amount): void
    {
        $this->increment('jury_credits', $amount);
    }

    public function addReformulationCredits(int $amount): void
    {
        $this->increment('reformulation_credits', $amount);
    }
}