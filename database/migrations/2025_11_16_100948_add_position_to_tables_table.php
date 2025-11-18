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
        Schema::table('tables', function (Blueprint $table) {
            // Tambahkan kolom area jika belum ada
            if (!Schema::hasColumn('tables', 'area')) {
                $table->string('area')->default('indoor')->after('name');
            }

            // Tambahkan kolom shape jika belum ada
            if (!Schema::hasColumn('tables', 'shape')) {
                $table->string('shape')->default('square')->after('status');
            }

            // Tambahkan position columns jika belum ada
            if (!Schema::hasColumn('tables', 'position_x')) {
                $table->integer('position_x')->default(50)->after('shape');
            }

            if (!Schema::hasColumn('tables', 'position_y')) {
                $table->integer('position_y')->default(50)->after('position_x');
            }

            // Add index untuk area untuk query lebih cepat
            $table->index('area');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->dropIndex(['area']);
            $table->dropColumn(['area', 'shape', 'position_x', 'position_y']);
        });
    }
};