<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // cth: "Karyawan 20%"
            $table->enum('type', ['percentage', 'fixed']);
            $table->decimal('value', 10, 2); // 0.20 untuk 20%, 10000 untuk 10K
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};