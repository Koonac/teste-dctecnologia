<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments_orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('order_id')->constrained('orders');
            $table->foreignId('client_id')->constrained('clients');
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->decimal('value', 10, 2);
            $table->date('due_date');
            $table->date('payment_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments_orders');
    }
};
