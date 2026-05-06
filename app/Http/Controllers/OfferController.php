<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Order;
use App\Models\UserCredit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia; // Ajoutez cette ligne

class OfferController extends Controller
{
    // ========== MÉTHODES EXISTANTES (Côté utilisateur) ==========
    
    public function index()
    {
        $offers = Offer::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        
        $userCredits = $this->getUserCredits();
        
        return inertia('Offers', [
            'offers' => $offers,
            'userCredits' => $userCredits
        ]);
    }
    
    public function createOrder(Request $request)
    {
        $request->validate([
            'offer_slug' => 'required|exists:offers,slug'
        ]);
        
        $offer = Offer::where('slug', $request->offer_slug)->first();
        $user = auth()->user();
        
        // Vérifier si l'offre est gratuite
        if ($offer->price == 0) {
            return $this->activateFreeOffer($offer, $user);
        }
        
        // Créer la commande pour les offres payantes
        $order = DB::transaction(function () use ($offer, $user) {
            return Order::create([
                'user_id' => $user->id,
                'offer_id' => $offer->id,
                'order_number' => $this->generateOrderNumber(),
                'status' => 'pending',
                'amount' => $offer->price,
                'offer_details' => $offer->toArray()
            ]);
        });
        
        $whatsappMessage = $this->generateWhatsAppMessage($order, $user);
        
        return response()->json([
            'success' => true,
            'order' => $order,
            'whatsapp_message' => $whatsappMessage,
            'whatsapp_link' => $this->generateWhatsAppLink($whatsappMessage)
        ]);
    }
    
    private function activateFreeOffer($offer, $user)
    {
        $features = $offer->features;
        
        // Vérifier si l'utilisateur a déjà des crédits (donc a déjà utilisé l'offre gratuite)
        if ($user->presentation_credits > 0 || $user->jury_credits > 0 || $user->reformulation_credits > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Vous avez déjà utilisé l\'offre découverte'
            ], 400);
        }
        
        DB::transaction(function () use ($user, $features) {
            // Ajouter les crédits en utilisant les méthodes existantes
            $user->addPresentationCredits($features['presentations'] ?? 1);
            $user->addJuryCredits($features['simulations'] ?? 1);
            $user->addReformulationCredits($features['reformulations'] ?? 1);
            
            // Optionnel: Créer un enregistrement dans user_credits pour le suivi
            UserCredit::create([
                'user_id' => $user->id,
                'order_id' => null,
                'presentations_remaining' => $features['presentations'] ?? 1,
                'simulations_remaining' => $features['simulations'] ?? 1,
                'reformulations_remaining' => $features['reformulations'] ?? 1
            ]);
        });
        
        return response()->json([
            'success' => true,
            'message' => 'Offre découverte activée ! Vous avez reçu vos crédits.',
            'credits' => [
                'presentations' => $user->presentation_credits,
                'simulations' => $user->jury_credits,
                'reformulations' => $user->reformulation_credits,
            ]
        ]);
    }
    
    private function generateOrderNumber()
    {
        $prefix = 'PRES';
        $date = now()->format('Ymd');
        $lastOrder = Order::whereDate('created_at', today())->count();
        $number = str_pad($lastOrder + 1, 3, '0', STR_PAD_LEFT);
        
        return "{$prefix}-{$date}-{$number}";
    }
    
    private function generateWhatsAppMessage($order, $user)
    {
        $offerDetails = $order->offer_details;
        
        return " NOUVELLE COMMANDE PRESENTO \n\n" .
               " Commande N°: {$order->order_number}\n" .
               " Client: {$user->name}\n" .
               " Email: {$user->email}\n" .
               "Offre: {$offerDetails['name']}\n" .
               "Montant: {$offerDetails['price']}€\n" .
               "Date: {$order->created_at->format('d/m/Y H:i')}\n\n" .
               "Détails de l'offre:\n" .
               "- Présentations: " . ($offerDetails['features']['presentations'] ?? 0) . "\n" .
               "- Simulations: " . ($offerDetails['features']['simulations'] ?? 0) . "\n" .
               "- Reformulations: " . ($offerDetails['features']['reformulations'] ?? 0) . "\n\n" .
               "Paiement effectué par [Orange Money/Wave]\n" .
               "Numéro de transaction: [à remplir]\n\n" .
               "Merci d'activer mon compte.";
    }
    
    private function generateWhatsAppLink($message)
    {
        $phoneNumber = '21693462295'; // Remplace par ton numéro WhatsApp
        $encodedMessage = urlencode($message);
        return "https://wa.me/{$phoneNumber}?text={$encodedMessage}";
    }
    
    private function getUserCredits()
    {
        $user = auth()->user();
        
        if (!$user) {
            return [
                'free' => ['presentations' => 0, 'simulations' => 0, 'reformulations' => 0],
                'paid' => []
            ];
        }
        
        $paidCredits = UserCredit::where('user_id', $user->id)
            ->whereHas('order', function ($query) {
                $query->where('status', 'activated');
            })
            ->get();
        
        // Vérifier si l'utilisateur a déjà des crédits
        $hasFreeCredits = ($user->presentation_credits == 0 && 
                          $user->jury_credits == 0 && 
                          $user->reformulation_credits == 0);
        
        $freeCredits = [
            'presentations' => $hasFreeCredits ? 1 : 0,
            'simulations' => $hasFreeCredits ? 1 : 0,
            'reformulations' => $hasFreeCredits ? 1 : 0
        ];
        
        return [
            'free' => $freeCredits,
            'paid' => $paidCredits
        ];
    }

    // ========== NOUVELLES MÉTHODES ADMIN ==========
    
    /**
     * Afficher la liste des offres (admin)
     */
    public function adminIndex()
    {
        $offers = Offer::orderBy('sort_order')->paginate(10);
        
        return Inertia::render('Admin/Offers/Index', [
            'offers' => $offers
        ]);
    }
    
    /**
     * Afficher le formulaire de création (admin)
     */
    public function adminCreate()
    {
        return Inertia::render('Admin/Offers/Create');
    }
    
    /**
     * Enregistrer une nouvelle offre (admin)
     */
    public function adminStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:offers,slug',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'features' => 'required|array',
            'features.presentations' => 'integer|min:0',
            'features.simulations' => 'integer|min:0',
            'features.reformulations' => 'integer|min:0',
            'is_active' => 'boolean',
            'sort_order' => 'integer'
        ]);
        
        // Convertir features en JSON si nécessaire
        if (isset($validated['features'])) {
            $validated['features'] = json_encode($validated['features']);
        }
        
        Offer::create($validated);
        
        return redirect()->route('admin.offers.index')
            ->with('success', 'Offre créée avec succès');
    }
    
    /**
     * Afficher le formulaire d'édition (admin)
     */
    public function adminEdit(Offer $offer)
    {
        // Décoder features si c'est du JSON
        if (is_string($offer->features)) {
            $offer->features = json_decode($offer->features, true);
        }
        
        return Inertia::render('Admin/Offers/Edit', [
            'offer' => $offer
        ]);
    }
    
    /**
     * Mettre à jour une offre (admin)
     */
    public function adminUpdate(Request $request, Offer $offer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:offers,slug,' . $offer->id,
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'features' => 'required|array',
            'features.presentations' => 'integer|min:0',
            'features.simulations' => 'integer|min:0',
            'features.reformulations' => 'integer|min:0',
            'is_active' => 'boolean',
            'sort_order' => 'integer'
        ]);
        
        // Convertir features en JSON si nécessaire
        if (isset($validated['features'])) {
            $validated['features'] = json_encode($validated['features']);
        }
        
        $offer->update($validated);
        
        return redirect()->route('admin.offers.index')
            ->with('success', 'Offre mise à jour avec succès');
    }
    
    /**
     * Supprimer une offre (admin)
     */
    public function adminDestroy(Offer $offer)
    {
        // Vérifier si l'offre a des commandes associées
        if ($offer->orders()->exists()) {
            return redirect()->route('admin.offers.index')
                ->with('error', 'Impossible de supprimer cette offre car elle a des commandes associées');
        }
        
        $offer->delete();
        
        return redirect()->route('admin.offers.index')
            ->with('success', 'Offre supprimée avec succès');
    }
    
    /**
     * Activer/désactiver une offre (admin)
     */
    public function adminToggleStatus(Offer $offer)
    {
        $offer->update([
            'is_active' => !$offer->is_active
        ]);
        
        return redirect()->back()
            ->with('success', 'Statut de l\'offre modifié avec succès');
    }
}