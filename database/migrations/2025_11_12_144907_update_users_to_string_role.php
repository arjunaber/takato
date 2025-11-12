<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tugas migrasi ini adalah memastikan kolom 'role' memiliki panjang yang cukup, 
     * lalu menghapus 'is_admin'.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // LANGKAH 1: Tambahkan/Ubah kolom 'role' menjadi VARCHAR(50) jika belum.
            // Jika kolom sudah ada, 'string('role', 50)->change()' akan mengubah tipenya.
            // Jika kolom belum ada (karena migrate:fresh), ini akan menambahkannya dengan tipe yang benar.
            if (Schema::hasColumn('users', 'role')) {
                $table->string('role', 50)->default('customer')->change();
            } else {
                $table->string('role', 50)->default('customer')->after('email')->nullable();
            }
        });

        // LANGKAH 2 (Opsional): Mengkonversi data lama is_admin ke role string 
        // Ini hanya diperlukan jika Anda tidak menggunakan migrate:fresh
        if (Schema::hasColumn('users', 'is_admin')) {
            DB::statement("
                 UPDATE users
                 SET role = CASE 
                     WHEN is_admin = 1 THEN 'owner' 
                     ELSE 'customer' 
                 END
             ");
        }


        // LANGKAH 3: Hapus kolom 'is_admin' yang lama 
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_admin')) {
                $table->dropColumn('is_admin');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Rollback: Tambahkan kembali is_admin
            $table->boolean('is_admin')->default(false)->nullable();

            // Rollback: Hapus kolom role
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
