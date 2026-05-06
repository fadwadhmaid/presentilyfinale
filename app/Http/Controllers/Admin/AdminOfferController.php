<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminOfferController extends Controller
{
    public function index()
    {
        $offers = Offer::latest()->paginate(10);
        
        return Inertia::render('Admin/Offers/Index', [
            'offers' => $offers
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Offers/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'valid_until' => 'nullable|date',
            'status' => 'boolean'
        ]);

        Offer::create($validated);

        return redirect()->route('admin.offers.index')
            ->with('success', 'Offre créée avec succès');
    }

    public function edit(Offer $offer)
    {
        return Inertia::render('Admin/Offers/Edit', [
            'offer' => $offer
        ]);
    }

    public function update(Request $request, Offer $offer)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'valid_until' => 'nullable|date',
            'status' => 'boolean'
        ]);

        $offer->update($validated);

        return redirect()->route('admin.offers.index')
            ->with('success', 'Offre mise à jour avec succès');
    }

    public function destroy(Offer $offer)
    {
        $offer->delete();

        return redirect()->route('admin.offers.index')
            ->with('success', 'Offre supprimée avec succès');
    }

    public function toggleStatus(Offer $offer)
    {
        $offer->update([
            'status' => !$offer->status
        ]);

        return redirect()->back()
            ->with('success', 'Statut modifié avec succès');
    }
}