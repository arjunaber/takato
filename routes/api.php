<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebhookController; // Pastikan namespace ini benar

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Di sinilah Anda mendaftarkan rute API. Rute-rute ini
| dimuat oleh RouteServiceProvider dan secara otomatis
| diberi awalan (prefix) '/api/'.
|
*/

// Rute ini akan menjadi: https://.../api/midtrans-webhook
Route::post('/midtrans-webhook', [WebhookController::class, 'webhook']);
