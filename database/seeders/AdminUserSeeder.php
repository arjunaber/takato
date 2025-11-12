<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // PENTING: IMPORT DB

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Owner Takato',
                'email' => 'owner@takato.com',
                'password' => Hash::make('0wn3rP@ssw0rd'),
                'role' => 'owner',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin Kasir',
                'email' => 'admin@takato.com',
                'password' => Hash::make('P@ssw0rdAdm1n'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pengguna Customer',
                'email' => 'customer@takato.com',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kasir Satu',
                'email' => 'kasir1@takato.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Menggunakan metode insert() langsung ke DB untuk menghindari masalah event model.
        DB::table('users')->insert($users);
    }
}
