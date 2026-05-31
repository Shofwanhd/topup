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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('id_transaksi')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('product');
            $table->string('variation');
            $table->integer('amount');
            $table->enum('status', [
                'pending',
                'processing',
                'success',
                'failed'
            ])->default('pending');
            $table->enum('status_payment', [
                'unpaid',
                'paid',
                'expired',
                'cancelled'
            ])->default('unpaid');
            $table->string('payment_method')->nullable();
            $table->string('snap_token')->nullable();
            $table->string('midtrans_order_id')->nullable();
            $table->string('midtrans_transaction_id')->nullable();
            $table->string('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
