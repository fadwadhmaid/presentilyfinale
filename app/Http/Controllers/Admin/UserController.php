<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(20);
        
        return Inertia::render('Admin/Users/Index', [
            'users' => $users
        ]);
    }
    // app/Http/Controllers/Admin/UserController.php
public function toggleAdmin(User $user)
{
    // Empêcher de se retirer les droits admin à soi-même
    if ($user->id === auth()->id()) {
        return back()->with('error', 'Vous ne pouvez pas modifier vos propres droits admin');
    }
    
    $user->is_admin = !$user->is_admin;
    $user->save();
    
    return back()->with('success', "Statut admin modifié pour {$user->name}");
}

    public function show(User $user)
    {
        $orders = $user->orders()->latest()->get();
        
        return Inertia::render('Admin/Users/Show', [
            'user' => $user,
            'orders' => $orders,
            'credits' => [
                'presentations' => $user->presentation_credits,
                'simulations' => $user->jury_credits,
                'reformulations' => $user->reformulation_credits,
            ]
        ]);
    }
    
    public function addCredits(User $user)
    {
        $amount = request('amount');
        $type = request('type'); // presentations, simulations, reformulations
        
        $method = 'add' . ucfirst($type) . 'Credits';
        $user->$method($amount);
        
        return back()->with('success', 'Crédits ajoutés avec succès');
    }
}