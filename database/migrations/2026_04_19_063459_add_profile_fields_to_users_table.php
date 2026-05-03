<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Profile information
            $table->string('username')->unique()->after('name');
            $table->string('university')->nullable()->after('email');
            $table->string('study_year')->nullable()->after('university');
            $table->string('domain')->nullable()->after('study_year');
            
            // Credits (with default values: 1 each at inscription)
            $table->integer('presentation_credits')->default(1)->after('domain');
            $table->integer('jury_credits')->default(1)->after('presentation_credits');
            $table->integer('reformulation_credits')->default(1)->after('jury_credits');
            
            // Statistics
            $table->integer('total_presentations_generated')->default(0)->after('reformulation_credits');
            $table->integer('total_jury_simulations')->default(0)->after('total_presentations_generated');
            $table->integer('total_reformulations')->default(0)->after('total_jury_simulations');
            
            // Subscription
            $table->timestamp('subscription_expires_at')->nullable()->after('total_reformulations');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'university',
                'study_year',
                'domain',
                'presentation_credits',
                'jury_credits',
                'reformulation_credits',
                'total_presentations_generated',
                'total_jury_simulations',
                'total_reformulations',
                'subscription_expires_at',
            ]);
        });
    }
};