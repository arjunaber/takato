<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderType;

class OrderTypeSeeder extends Seeder
{
    public function run(): void
    {
        OrderType::firstOrCreate(
            ['name' => 'Dine In'],
            ['type' => 'fixed', 'value' => 0]
        );

        OrderType::firstOrCreate(
            ['name' => 'Takeaway'],
            ['type' => 'fixed', 'value' => 2000]
        );

        OrderType::firstOrCreate(
            ['name' => 'Gojek'],
            ['type' => 'percentage', 'value' => 0.20] // 20% Markup
        );

        OrderType::firstOrCreate(
            ['name' => 'GrabFood'],
            ['type' => 'percentage', 'value' => 0.20] // 20% Markup
        );
    }
}
