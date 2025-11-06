<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipe_items', function (Blueprint $table) {
            $table->id();
            // Resep ini untuk Varian mana?
            $table->foreignId('variant_id')->constrained('variants')->cascadeOnDelete();
            
            // Bahan baku apa yang dipakai?
            $table->foreignId('ingredient_id')->constrained('ingredients');
            
            // Berapa banyak?
            $table->decimal('quantity_used', 10, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipe_items');
    }
};