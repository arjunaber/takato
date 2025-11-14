<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('struk_configs', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->text('value')->nullable();
        });
        // KRUSIAL: Tambahkan nilai default
        DB::table('struk_configs')->insert([
            ['key' => 'wifi_ssid', 'value' => 'TAKATO-Guest'],
            ['key' => 'wifi_password', 'value' => 'takato123'],
            ['key' => 'footer_message', 'value' => 'Terima kasih atas kunjungan Anda!'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('struk_configs');
    }
};