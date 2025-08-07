<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('grand_schedules', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique();
            $table->enum('day_type', ['weekday_weekend', 'special_event']);
            $table->decimal('price', 12, 2);
            $table->enum('status', ['available', 'booked'])->default('available');
            $table->timestamp('booked_at')->nullable(); // waktu dibooking
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('grand_schedules');
    }
};