<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // cth: "Dine In", "Gojek"
            $table->enum('type', ['percentage', 'fixed']); // Tipe markup/biaya
            $table->decimal('value', 10, 2)->default(0); // 0.20 (20%) atau 2000 (Rp)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_types');
    }
};