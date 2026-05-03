<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class ProfileController extends Controller
{
    /**
     * Afficher le formulaire d'édition du profil
     */
    public function edit(Request $request)
    {
        return Inertia::render('Profile/Edit', [
            'user' => $request->user(),
            'success' => session('success'),
        ]);
    }

    /**
     * Mettre à jour le profil
     */
    public function update(Request $request)
    {
        $user = $request->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'university' => 'nullable|string|max:255',
            'study_year' => 'nullable|string|max:50',
            'domain' => 'nullable|string|max:255',
        ]);
        
        $user->update($validated);
        
        return redirect()->route('profile.edit')->with('success', '✅ Profil mis à jour avec succès !');
    }
    
    /**
     * Mettre à jour le mot de passe
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);
        
        return redirect()->route('profile.edit')->with('success', '🔒 Mot de passe mis à jour avec succès !');
    }
    
    /**
     * Supprimer le compte
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);
        
        $user = $request->user();
        
        Auth::logout();
        $user->delete();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Votre compte a été supprimé avec succès.');
    }
}