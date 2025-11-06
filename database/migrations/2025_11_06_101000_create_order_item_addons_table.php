<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_item_addons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_item_id')->constrained('order_items')->cascadeOnDelete();
            $table->foreignId('addon_id')->constrained('addons');

            // Snapshot harga add-on saat transaksi
            $table->string('addon_name');
            $table->decimal('addon_price', 10, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_item_addons');
    }
};
