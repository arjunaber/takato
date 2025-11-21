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
use App\Http\Controllers\Admin\ShiftController;
use App\Http\Controllers\Admin\StrukConfigController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\TableMonitoringController;
use App\Http\Controllers\Online\OnlineOrderController;
use App\Models\Table;


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

    // ========================================
    // DASHBOARD / HOME
    // ========================================
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    // ATAU jika ingin langsung ke monitoring meja:
    // Route::get('/', [TableMonitoringController::class, 'index'])->name('dashboard');


    // ========================================
    // TABLE MONITORING (Floor Plan)
    // ========================================
    Route::prefix('tables')->name('tables.')->group(function () {
        Route::get('/', [TableMonitoringController::class, 'index'])->name('index');
        Route::post('/', [TableMonitoringController::class, 'store'])->name('store');
        Route::put('/{table}', [TableMonitoringController::class, 'update'])->name('update');
        Route::delete('/{table}', [TableMonitoringController::class, 'destroy'])->name('destroy');

        Route::get('/by-area', [TableMonitoringController::class, 'getByArea'])->name('by-area');
        Route::get('/statistics', [TableMonitoringController::class, 'getStatistics'])->name('statistics');
        Route::get('/{table}/details', [TableMonitoringController::class, 'getTableDetails'])->name('details');
        Route::post('/{table}/position', [TableMonitoringController::class, 'savePosition'])->name('save-position');
        Route::post('/reset-layout', [TableMonitoringController::class, 'resetLayout'])->name('reset-layout');
        Route::post('/save-layout', [TableMonitoringController::class, 'saveLayout'])->name('admin.tables.save-layout');
        Route::post('/{table}/clear-table', [TableMonitoringController::class, 'clearTable'])->name('admin.tables.clear-table');
        Route::get('/table}/details', [TableMonitoringController::class, 'getTableDetails'])->name('admin.tables.details');
    });


    // ========================================
    // POS (Point of Sale)
    // ========================================
    Route::prefix('pos')->name('pos.')->group(function () {
        // Main POS view
        Route::get('/', [PosController::class, 'index'])->name('index');
        Route::post('/store', [PosController::class, 'store'])->name('store');
        Route::get('/data', [PosController::class, 'getDataForPos'])->name('data');

        // Open Bills Management
        Route::get('/open-bills', [PosController::class, 'getOpenBills'])->name('open_bills');
        Route::get('/load-bill/{order}', [PosController::class, 'loadBill'])->name('load_bill');
        Route::post('/complete-old-bill/{order}', [PosController::class, 'updateBillAfterPayment'])->name('update_bill_status');
        Route::post('/complete-open-bill/{order}', [PosController::class, 'completeOpenBill'])->name('complete_open_bill');
        Route::post('/confirm-payment/{order}', [PosController::class, 'confirmPayment'])->name('confirm_payment');
    });


    // ========================================
    // ORDERS
    // ========================================
    Route::prefix('orders')->name('orders.')->group(function () {
        // Online orders
        Route::get('/online', [OrderController::class, 'index2'])->name('online');

        // Receipt printing
        Route::get('/{order}/receipt', [OrderController::class, 'printReceipt'])->name('receipt');
    });

    // Resource routes untuk orders (index, create, store, show, edit, update, destroy)
    Route::resource('orders', OrderController::class)->names([
        'index' => 'orders.index',
        'create' => 'orders.create',
        'store' => 'orders.store',
        'show' => 'orders.show',
        'edit' => 'orders.edit',
        'update' => 'orders.update',
        'destroy' => 'orders.destroy',
    ]);


    // ========================================
    // SHIFT MANAGEMENT
    // ========================================
    Route::prefix('shift')->name('shift.')->group(function () {
        // Main shift view
        Route::get('/', [ShiftController::class, 'index'])->name('index');

        // Shift operations (API endpoints)
        Route::post('/open', [ShiftController::class, 'openShift'])->name('open');
        Route::post('/close', [ShiftController::class, 'closeShift'])->name('close');
        Route::get('/active', [ShiftController::class, 'getActiveShift'])->name('active');
        Route::get('/history', [ShiftController::class, 'getShiftHistory'])->name('history');
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

    Route::prefix('config/struk')->name('config.struk.')->group(function () {
        Route::get('/', [StrukConfigController::class, 'edit'])->name('edit');
        Route::post('/', [StrukConfigController::class, 'update'])->name('update');
    });

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('gross-profit', [ReportController::class, 'grossProfitIndex'])->name('gross_profit.index');
        Route::get('gross-profit/export', [ReportController::class, 'exportGrossProfit'])->name('gross_profit.export'); // Untuk export
    });
});

Route::prefix('online/order')->name('online.order.')->group(function () {
    Route::get('/{table}', [OnlineOrderController::class, 'index'])->name('menu');
    Route::post('/store', [OnlineOrderController::class, 'store'])->name('store');
});
// Route::post('/midtrans-webhook', [WebhookController::class, 'webhook']);