<?php

use App\Http\Controllers\GrandScheduleController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Pos\PosController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\IngredientController;
use App\Http\Controllers\Admin\AddonController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\OrderTypeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\RecipeController;
use App\Http\Controllers\WebhookController;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\Admin\StockRequestController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/events/wedding', function () {
    return view('wedding');
});

Route::get('/events/retreat', function () {
    return view('retreat');
});

Route::get('/events/gathering', function () {
    return view('gathering');
});


// Authentication Routes
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
});


Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin_or_owner'])->group(function () {
    // POS (Akses: Owner & Admin)
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/store', [PosController::class, 'store'])->name('pos.store');
    Route::get('/pos/data', [PosController::class, 'getDataForPos'])->name('pos.data');
    Route::resource('orders', OrderController::class);
    Route::get('/orders/{order}/receipt', [OrderController::class, 'printReceipt'])->name('orders.receipt');

    Route::prefix('/pos')->name('pos.')->middleware(['auth'])->group(function () {
        Route::get('/open-bills', [PosController::class, 'getOpenBills'])->name('open_bills');
        Route::get('/load-bill/{order}', [PosController::class, 'loadBill'])->name('load_bill');
        Route::post('/complete-old-bill/{order}', [PosController::class, 'updateBillAfterPayment'])->name('update_bill_status');
        Route::post('/complete-open-bill/{order}', [PosController::class, 'completeOpenBill'])->name('complete_open_bill');
    });
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'owner'])->group(function () {

    // Dashboard & Laporan (Akses: Owner Saja)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/ingredients/adjust-stock', [IngredientController::class, 'adjustStock'])->name('ingredients.adjust-stock');
    Route::get('/stock/request/print', [StockRequestController::class, 'printRequest'])->name('stock.request.print');
    Route::get('/variants/{variant}/recipe', [RecipeController::class, 'show'])->name('variants.recipe.show');
    Route::post('/variants/{variant}/recipe', [RecipeController::class, 'update'])->name('variants.recipe.update');


    // Resource Routes (Akses: Owner Saja)
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('ingredients', IngredientController::class);
    Route::resource('addons', AddonController::class);
    Route::resource('discounts', DiscountController::class);
    Route::resource('order-types', OrderTypeController::class);
});

// Route::post('/midtrans-webhook', [WebhookController::class, 'webhook']);