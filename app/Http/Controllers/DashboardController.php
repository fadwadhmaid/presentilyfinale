<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Models\JurySimulation;
use App\Models\Presentation;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Rediriger vers admin dashboard si admin
        if ($user && $user->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        
        // Récupérer toutes les simulations de l'utilisateur
        $allSimulations = JurySimulation::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Récupérer toutes les présentations de l'utilisateur
        $allPresentations = Presentation::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Récupérer les 3 dernières simulations pour l'aperçu
        $recentSimulations = JurySimulation::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        // Récupérer les 3 dernières présentations pour l'aperçu
        $recentPresentations = Presentation::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        // Pour le dashboard user normal
        return Inertia::render('Dashboard', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'username' => $user->username,
                'university' => $user->university,
                'study_year' => $user->study_year,
                'domain' => $user->domain,
                'is_admin' => $user->is_admin,
                'presentation_credits' => $user->presentation_credits ?? 0,
                'jury_credits' => $user->jury_credits ?? 0,
                'reformulation_credits' => $user->reformulation_credits ?? 0,
                'total_presentations_generated' => $user->total_presentations_generated ?? 0,
                'total_jury_simulations' => $user->total_jury_simulations ?? 0,
                'total_reformulations' => $user->total_reformulations ?? 0,
                'subscription_expires_at' => $user->subscription_expires_at,
                'created_at' => $user->created_at,
            ],
            'recentActivities' => $this->getRecentActivities($user),
            'allSimulations' => $allSimulations,
            'recentSimulations' => $recentSimulations,
            'allPresentations' => $allPresentations,
            'recentPresentations' => $recentPresentations,
        ]);
    }
    
    private function getRecentActivities($user)
    {
        $activities = [];
        
        try {
            // Récupérer les dernières présentations avec l'ID
            $presentations = $user->presentations()->latest()->take(5)->get();
            foreach ($presentations as $presentation) {
                $activities[] = [
                    'id' => $presentation->id,
                    'presentation_id' => $presentation->id,
                    'type' => 'presentation',
                    'title' => $presentation->title ?? 'Présentation sans titre',
                    'description' => 'Présentation générée',
                    'time' => $presentation->title ?? 'Sans titre',
                    'date' => $presentation->created_at->diffForHumans(),
                    'created_at' => $presentation->created_at->toDateTimeString(),
                    'iconClass' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-600',
                    'iconPath' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'
                ];
            }
        } catch (\Exception $e) {
            \Log::error('Erreur récupération présentations: ' . $e->getMessage());
        }
        
        try {
            // Récupérer les dernières simulations jury
            $simulations = JurySimulation::where('user_id', $user->id)->latest()->take(5)->get();
            foreach ($simulations as $simulation) {
                $activities[] = [
                    'id' => 'sim_' . $simulation->id,
                    'type' => 'jury_simulation',
                    'title' => $simulation->jury_name . ' - Score: ' . $simulation->final_score . '/20',
                    'description' => 'Score: ' . $simulation->final_score . '/20',
                    'time' => $simulation->jury_name,
                    'date' => $simulation->created_at->diffForHumans(),
                    'created_at' => $simulation->created_at->toDateTimeString(),
                    'iconClass' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-600',
                    'iconPath' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'
                ];
            }
        } catch (\Exception $e) {
            \Log::error('Erreur récupération simulations: ' . $e->getMessage());
        }
        
        try {
            // Récupérer les dernières reformulations
            $reformulations = $user->reformulations()->latest()->take(3)->get();
            foreach ($reformulations as $reformulation) {
                $activities[] = [
                    'id' => 'ref_' . $reformulation->id,
                    'type' => 'reformulation',
                    'title' => 'Texte reformulé',
                    'description' => 'Longueur: ' . strlen($reformulation->original_text ?? '') . ' caractères',
                    'time' => 'Longueur: ' . strlen($reformulation->original_text ?? '') . ' caractères',
                    'date' => $reformulation->created_at->diffForHumans(),
                    'created_at' => $reformulation->created_at->toDateTimeString(),
                    'iconClass' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600',
                    'iconPath' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'
                ];
            }
        } catch (\Exception $e) {
            \Log::error('Erreur récupération reformulations: ' . $e->getMessage());
        }
        
        // Trier par date (plus récent en premier)
        usort($activities, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        
        // Limiter à 10 activités maximum
        return array_slice($activities, 0, 10);
    }
}