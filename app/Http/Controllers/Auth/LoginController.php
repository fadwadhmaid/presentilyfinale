<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class LoginController extends Controller
{
    /**
     * Afficher le formulaire de connexion
     */
    public function showLoginForm()
    {
        return Inertia::render('Auth/Login', [
            'verificationRequired' => session('verification_required', false),
            'status' => session('status'),
            'success' => session('success'),
            'error' => session('error'),
            'info' => session('info'),
            'unverified_email' => session('unverified_email'),
        ]);
    }

    /**
     * Tentative de connexion
     */
    public function login(Request $request)
    {
        // Validation des champs
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tentative de connexion
        if (Auth::attempt($credentials, $request->remember)) {
            $user = Auth::user();
            
            // Vérifier si l'email est vérifié
            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Veuillez vérifier votre adresse email avant de vous connecter.',
                ])->with('verification_required', true)
                  ->with('unverified_email', $credentials['email']);
            }
            
            // Connexion réussie
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        // Échec de la connexion
        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}