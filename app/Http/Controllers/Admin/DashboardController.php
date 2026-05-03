<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Offer;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques globales
        $stats = [
            'total_users' => User::count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_revenue' => Order::where('status', 'activated')->sum('amount'),
            'revenue_today' => Order::whereDate('paid_at', today())->sum('amount'),
            'revenue_month' => Order::whereMonth('paid_at', now()->month)->sum('amount'),
            'active_offers' => Offer::where('is_active', true)->count(),
        ];
        
        // Dernières commandes
        $recent_orders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();
        
        // Derniers utilisateurs
        $recent_users = User::latest()
            ->take(5)
            ->get();
        
        // Graphique des ventes (7 derniers jours)
        $sales_chart = $this->getSalesChart();
        
        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'recent_orders' => $recent_orders,
            'recent_users' => $recent_users,
            'sales_chart' => $sales_chart,
        ]);
    }
    
    private function getSalesChart()
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $data[] = [
                'date' => $date->format('d/m'),
                'amount' => Order::whereDate('paid_at', $date)->sum('amount'),
            ];
        }
        return $data;
    }
}