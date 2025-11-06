<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Discount;

class DiscountSeeder extends Seeder
{
    public function run(): void
    {
        Discount::firstOrCreate(
            ['name' => 'Tanpa Diskon'],
            ['type' => 'fixed', 'value' => 0]
        );

        Discount::firstOrCreate(
            ['name' => 'Karyawan 20%'],
            ['type' => 'percentage', 'value' => 0.20]
        );

        Discount::firstOrCreate(
            ['name' => 'Diskon 50%'],
            ['type' => 'percentage', 'value' => 0.50]
        );

        Discount::firstOrCreate(
            ['name' => 'Potongan 10K'],
            ['type' => 'fixed', 'value' => 10000]
        );
    }
}
