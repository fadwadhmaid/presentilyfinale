<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends BaseVerifyEmail
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        
        return (new MailMessage)
            ->subject('Bienvenue sur presento ! Vérifiez votre adresse email')
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Merci de vous être inscrit sur presento. Nous sommes ravis de vous compter parmi notre communauté d\'étudiants !')
            ->line('Pour commencer à utiliser notre plateforme et profiter de votre offre découverte, veuillez vérifier votre adresse email en cliquant sur le bouton ci-dessous :')
            ->action('Vérifier mon adresse email', $verificationUrl)
            ->line('Une fois votre email vérifié, vous pourrez :')
            ->line('• Générer votre première présentation avec l\'IA')
            ->line('• Simuler un jury d\'examen')
            ->line('• Recevoir des feedbacks personnalisés')
            ->line('• Accéder à votre offre découverte gratuite')
            ->line('Si vous n\'avez pas créé de compte sur presento, ignorez simplement cet email.')
            ->salutation('Cordialement,')
            ->salutation("L'équipe presento");
    }
    
    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(config('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}