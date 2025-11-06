<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();

            // Kolom untuk item DARI MENU
            $table->foreignId('product_id')->nullable()->constrained('products');
            $table->foreignId('variant_id')->nullable()->constrained('variants');

            // Snapshot nama & harga (bisa dari varian atau custom)
            $table->string('item_name'); // cth: "Indomie (Goreng)" atau "Piring Pecah"
            $table->decimal('base_price', 10, 2); // Harga varian / Harga custom

            $table->integer('quantity');
            $table->text('notes')->nullable();

            // Snapshot Tipe Pesanan & Diskon
            $table->foreignId('order_type_id')->nullable()->constrained('order_types');
            $table->decimal('order_type_fee', 10, 2)->default(0); // Biaya markup/tambahan

            $table->foreignId('discount_id')->nullable()->constrained('discounts');
            $table->decimal('discount_amount', 10, 2)->default(0); // Jumlah potongan
            
            // Harga final per unit (SETELAH markup & diskon)
            $table->decimal('unit_price_final', 10, 2); 
            // Total (unit_price_final * quantity)
            $table->decimal('subtotal', 10, 2); 

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};