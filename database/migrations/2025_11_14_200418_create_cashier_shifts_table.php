<?php

// database/migrations/YYYY_MM_DD_HHMMSS_create_cashier_shifts_table.php

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
        Schema::create('cashier_shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Kasir yang membuka shift
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();

            $table->decimal('initial_cash', 10, 2)->default(0.00)->comment('Uang tunai awal (modal)');
            $table->decimal('closing_cash', 10, 2)->nullable()->comment('Uang tunai akhir (fisik)');

            $table->decimal('system_cash_sales', 10, 2)->default(0.00)->comment('Total penjualan CASH tercatat sistem');
            $table->decimal('system_noncash_sales', 10, 2)->default(0.00)->comment('Total penjualan NON-CASH tercatat sistem');

            $table->decimal('cash_difference', 10, 2)->nullable()->comment('Selisih kas (closing - expected)');

            $table->text('notes')->nullable();
            $table->boolean('is_closed')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashier_shifts');
    }
};
