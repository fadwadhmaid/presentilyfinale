<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si l'utilisateur est connecté
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        // Vérifier si l'utilisateur est admin
        if (!auth()->user()->is_admin) {
            abort(403, '⛔ Accès non autorisé. Zone administrateur uniquement.');
        }
        
        return $next($request);
    }
}