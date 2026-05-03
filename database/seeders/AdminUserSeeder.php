<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Vérifier si l'admin n'existe pas déjà
        if (!User::where('email', 'dhmaidfadwa@gmail.com')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'dhmaidfadwa@gmail.com',
                'password' => Hash::make('adminpresentor6cJ2qmmE%'),
                'username' => 'superadmin',
                'university' => 'Administration',
                'study_year' => 'Admin',
                'domain' => 'Administration',
                'presentation_credits' => 999,
                'jury_credits' => 999,
                'reformulation_credits' => 999,
                'total_presentations_generated' => 0,
                'total_jury_simulations' => 0,
                'total_reformulations' => 0,
                'is_admin' => true,
                'email_verified_at' => now(),
            ]);
            
            $this->command->info('Admin user created successfully!');
        } else {
            $this->command->warn('Admin user already exists!');
        }
    }
}