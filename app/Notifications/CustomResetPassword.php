<?php
// app/Notifications/CustomResetPassword.php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends ResetPassword
{
    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Réinitialisation de votre mot de passe - presento')
            ->greeting('Bonjour !')
            ->line('Vous recevez cet email car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.')
            ->action('Réinitialiser le mot de passe', $url)
            ->line('Ce lien expirera dans :count minutes.', ['count' => config('auth.passwords.users.expire')])
            ->line('Si vous n\'avez pas demandé de réinitialisation, ignorez cet email.')
            ->salutation('Cordialement, L\'équipe presento');
    }
}