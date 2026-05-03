<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return inertia('Admin/Orders/Index', [
            'orders' => $orders
        ]);
    }
    
    public function activate(Order $order)
    {
        if ($order->status !== 'pending') {
            return back()->with('error', 'Cette commande ne peut pas être activée');
        }
        
        DB::transaction(function () use ($order) {
            // Mettre à jour la commande
            $order->update([
                'status' => 'activated',
                'paid_at' => now(),
                'activated_at' => now()
            ]);
            
            // Ajouter les crédits à l'utilisateur
            $user = $order->user;
            $offerDetails = $order->offer_details;
            
            if ($offerDetails['features']['presentations'] > 0) {
                $user->addPresentationCredits($offerDetails['features']['presentations']);
            }
            
            if ($offerDetails['features']['simulations'] > 0) {
                $user->addJuryCredits($offerDetails['features']['simulations']);
            }
            
            if ($offerDetails['features']['reformulations'] > 0) {
                $user->addReformulationCredits($offerDetails['features']['reformulations']);
            }
        });
        
        return back()->with('success', 'Commande activée et crédits ajoutés !');
    }
}