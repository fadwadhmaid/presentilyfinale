<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Inertia\Inertia;
use App\Models\User;

class EmailVerificationController extends Controller
{
    /**
     * Afficher la page de notification de vérification
     */
    public function notice(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(route('dashboard'))
            : Inertia::render('Auth/VerifyEmail', [
                'status' => session('status'),
            ]);
    }

    /**
     * Vérifier l'email de l'utilisateur
     */
    public function verify(Request $request, $id, $hash)
    {
        // Récupérer l'utilisateur par son ID
        $user = User::findOrFail($id);

        // Vérifier si l'email est déjà vérifié
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')
                ->with('success', 'Votre email est déjà vérifié. Vous pouvez vous connecter.');
        }

        // Vérifier le hash
        if (!hash_equals(sha1($user->getEmailForVerification()), $hash)) {
            return redirect()->route('login')
                ->with('error', 'Lien de vérification invalide.');
        }

        // Marquer l'email comme vérifié
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        // Rediriger vers la page de connexion avec un message de succès
        return redirect()->route('login')
            ->with('success', '✅ Félicitations ! Votre email a été vérifié avec succès. Vous pouvez maintenant vous connecter et profiter de votre offre découverte !');
    }

    /**
     * Renvoyer l'email de vérification
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard'));
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'Un nouveau lien de vérification a été envoyé à votre adresse email.');
    }
}