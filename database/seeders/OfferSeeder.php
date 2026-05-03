<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;

class OfferSeeder extends Seeder
{
    public function run()
    {
        $offers = [
            [
                'name' => 'Découverte',
                'slug' => 'free',
                'description' => 'Pour démarrer gratuitement',
                'price' => 0,
                'period' => 'one_time',
                'features' => [
                    'presentations' => 1,
                    'simulations' => 1,
                    'reformulations' => 1,
                    'support' => 'standard'
                ],
                'sort_order' => 1
            ],
            [
                'name' => 'Basic',
                'slug' => 'basic',
                'description' => 'Idéal pour commencer',
                'price' => 15,
                'period' => 'one_time',
                'features' => [
                    'presentations' => 5,
                    'simulations' => 5,
                    'reformulations' => 5,
                    'support' => 'prioritaire'
                ],
                'sort_order' => 2
            ],
            [
                'name' => 'Pro',
                'slug' => 'pro',
                'description' => 'Pour les utilisateurs actifs',
                'price' => 35,
                'period' => 'one_time',
                'features' => [
                    'presentations' => 15,
                    'simulations' => 15,
                    'reformulations' => 15,
                    'support' => 'vip'
                ],
                'sort_order' => 3
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium',
                'description' => 'Usage illimité',
                'price' => 60,
                'period' => 'monthly',
                'features' => [
                    'presentations' => -1, // -1 = illimité
                    'simulations' => -1,
                    'reformulations' => -1,
                    'support' => 'dedie'
                ],
                'sort_order' => 4
            ]
        ];
        
        foreach ($offers as $offer) {
            Offer::create($offer);
        }
    }
}