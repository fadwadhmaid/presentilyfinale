<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_create_orders_table.php
public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('offer_id')->constrained()->onDelete('cascade');
        $table->string('order_number')->unique(); // PRES-20241225-001
        $table->enum('status', ['pending', 'paid', 'activated', 'cancelled'])->default('pending');
        $table->decimal('amount', 10, 2);
        $table->json('offer_details'); // Sauvegarde des détails de l'offre
        $table->timestamp('paid_at')->nullable();
        $table->timestamp('activated_at')->nullable();
        $table->text('admin_notes')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
