<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder-seeder yang telah kita buat
        // Urutan ini penting!
        $this->call([
            AdminUserSeeder::class,
            DiscountSeeder::class,
            OrderTypeSeeder::class,
            ProductDataSeeder::class, // Jalankan seeder produk/kategori/dll terakhir
        ]);
    }
}