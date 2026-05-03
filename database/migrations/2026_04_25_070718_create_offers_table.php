<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_create_offers_table.php
public function up()
{
    Schema::create('offers', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Basic, Pro, Premium
        $table->string('slug')->unique(); // basic, pro, premium
        $table->text('description');
        $table->decimal('price', 10, 2); // 10.00, 25.00, 50.00
        $table->enum('period', ['one_time', 'monthly', 'yearly'])->default('one_time');
        $table->json('features'); // {"presentations": 5, "simulations": 5}
        $table->boolean('is_active')->default(true);
        $table->integer('sort_order')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
