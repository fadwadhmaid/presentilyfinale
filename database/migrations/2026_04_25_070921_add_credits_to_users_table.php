<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_add_credits_to_users_table.php
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->integer('free_presentations_used')->default(0);
        $table->integer('free_simulations_used')->default(0);
        $table->integer('free_reformulations_used')->default(0);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
