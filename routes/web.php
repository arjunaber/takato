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

// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/landing', function () {
    return view('auth.landing.index');
});

Route::get('/grandschedule', function () {
    return view('auth.grandschedule.index');
});
Route::post('/grand-schedules/book', [GrandScheduleController::class, 'book'])->name('grand-schedules.book');

Route::get('/grand-schedules/calendar-data', [GrandScheduleController::class, 'getCalendarData']);
// Authentication Routes
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
});

// Admin routes group
Route::prefix('admin')->name('admin.')->middleware(['auth', AdminMiddleware::class])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Grand Schedule Management
    Route::prefix('grand-schedules')->name('grand-schedules.')->controller(GrandScheduleController::class)->group(function () {
        // List View
        Route::get('/', 'index')->name('index'); // Full route name: admin.grand-schedules.index

        // Calendar View
        Route::get('/calendar', 'calendar')->name('calendar');

        // Create Schedule
        Route::post('/', 'store')->name('store');

        // Update Schedule
        Route::put('/{grandSchedule}', 'update')->name('update');

        // Bulk Update Status
        Route::post('/bulk-update', 'bulkUpdate')->name('bulk-update');

        // Bulk Store (Create multiple schedules) - TAMBAHKAN INI
        Route::post('/bulk-store', 'bulkStore')->name('bulk-store');

        // Get Calendar Data (JSON)
        Route::get('/calendar-data', 'getCalendarData')->name('calendar-data');
    });


    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/store', [PosController::class, 'store'])->name('pos.store');
    Route::get('/pos/data', [PosController::class, 'getDataForPos'])->name('pos.data');
    Route::get('/variants/{variant}/recipe', [RecipeController::class, 'show'])->name('variants.recipe.show');
    Route::post('/variants/{variant}/recipe', [RecipeController::class, 'update'])->name('variants.recipe.update');
    Route::get('/orders/{order}/receipt', [OrderController::class, 'printReceipt'])->name('orders.receipt');

    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('ingredients', IngredientController::class);
    Route::resource('addons', AddonController::class);
    Route::resource('discounts', DiscountController::class);
    Route::resource('order-types', OrderTypeController::class);
    Route::resource('orders', OrderController::class);
});

// Route::post('/midtrans-webhook', [WebhookController::class, 'webhook']);