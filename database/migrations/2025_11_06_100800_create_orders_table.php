<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // ID Admin/Kasir yang login dan memproses
            $table->foreignId('user_id')->nullable()->constrained('users');

            $table->string('invoice_number')->unique();
            $table->enum('status', ['pending', 'completed', 'cancelled', 'openbill'])->default('pending');

            // Total Kalkulasi
            $table->decimal('subtotal', 10, 2); // Total harga item
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('total', 10, 2); // Total yang harus dibayar

            // Info Pembayaran
            $table->string('payment_method')->nullable(); // cth: "cash", "qris"
            $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid');
            $table->string('payment_gateway_ref')->nullable(); // Ref dari Midtrans, dll.

            $table->decimal('cash_received', 15, 2)->nullable(); // Uang dari customer
            $table->decimal('cash_change', 15, 2)->nullable();   // Kembalian

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};