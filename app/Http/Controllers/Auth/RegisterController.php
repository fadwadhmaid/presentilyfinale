<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class RegisterController extends Controller
{
    /**
     * Afficher le formulaire d'inscription
     */
    public function showRegistrationForm()
    {
        return Inertia::render('Auth/Register');
    }

   public function register(Request $request)
{
    // 1. Validation des données
    $validator = $this->validator($request->all());

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    // 2. Création de l'utilisateur
    $user = $this->create($request->all());

    // 3. Déclencher l'événement d'enregistrement (envoie l'email de vérification)
    event(new Registered($user));

    // 4. Rediriger avec message personnalisé (supprimer le double return)
    return redirect()->route('verification.notice')
        ->with('success', '🎉 Félicitations ! Votre compte a été créé avec succès.')
        ->with('info', '📧 Un email de vérification vient d\'être envoyé à ' . $user->email . '. Cliquez sur le lien pour activer votre compte et profiter de votre offre découverte !');
}

    /**
     * Validation des données
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'university' => ['nullable', 'string', 'max:255'],
            'study_year' => ['nullable', 'string', 'max:50'],
            'domain' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required' => 'Le nom est obligatoire',
            'username.required' => "Le nom d'utilisateur est obligatoire",
            'username.unique' => "Ce nom d'utilisateur est déjà pris",
            'email.required' => "L'email est obligatoire",
            'email.email' => "Format d'email invalide",
            'email.unique' => "Cet email est déjà utilisé",
            'password.required' => 'Le mot de passe est obligatoire',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'password.confirmed' => 'Les mots de passe ne correspondent pas',
        ]);
    }

    /**
     * Création de l'utilisateur
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'university' => $data['university'] ?? null,
            'study_year' => $data['study_year'] ?? null,
            'domain' => $data['domain'] ?? null,
            // Crédits gratuits à l'inscription
            'presentation_credits' => 1,
            'jury_credits' => 1,
            'reformulation_credits' => 1,
            'total_presentations_generated' => 0,
            'total_jury_simulations' => 0,
            'total_reformulations' => 0,
        ]);
    }
}