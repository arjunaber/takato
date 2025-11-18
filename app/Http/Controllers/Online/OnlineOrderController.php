<?php

namespace App\Http\Controllers\Online;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Discount;
use App\Models\OrderType;
use App\Models\Order;
use App\Models\Variant;
use App\Models\Ingredient;
use App\Models\CashierShift;
use App\Models\Table;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Query\Builder as QueryBuilder;

class OnlineOrderController extends Controller
{
    public function __construct()
    {
        // Pastikan konfigurasi Midtrans sudah dimuat sebelum digunakan
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
    }

    /**
     * Menampilkan halaman menu online (Dipanggil via scan QR Code).
     * @param string $tableNumber Nomor meja yang diambil dari URL.
     */
    public function index(Request $request, $tableNumber = null)
    {
        // 1. Validasi Awal: tableNumber harus ada
        if (!$tableNumber) {
            Log::warning('OnlineOrderController: Akses index tanpa tableNumber.');
            return redirect('/')->with('error', 'Nomor meja tidak valid. Silakan scan QR Code lagi.');
        }

        // 2. Validasi Database (Dihapus Validasi Ganda)
        $table = Table::where('name', $tableNumber)->first();
        if (!$table) {
            Log::error('OnlineOrderController: Nomor meja tidak terdaftar: ' . $tableNumber);
            return redirect('/')->with('error', 'Nomor meja (' . $tableNumber . ') tidak terdaftar di sistem.');
        }

        // Memuat data menu
        $categories = Category::orderBy('name')->get();

        // KRUSIAL: Muat variants.ingredients untuk menghitung stok
        $products = Product::with(['variants.ingredients', 'addons'])
            ->orderBy('name')
            ->get();

        $products = $this->calculateLimitingStock($products);

        // Gunakan values() agar indexing array di JS konsisten
        $favoriteProducts = $products->filter(fn($p) => $p->is_favorite)->values();

        $discounts = Discount::orderBy('name')->get();

        // Filter Order Types: Hanya Dine In dan Takeaway
        $allowedOrderTypes = ['Dine In', 'Takeaway'];
        $orderTypes = OrderType::whereIn('name', $allowedOrderTypes)->orderBy('id')->get();

        return view('online.menu_order', [
            'tableNumber' => $tableNumber,
            'tableId' => $table->id, // Kirim table ID ke view
            'categories' => $categories,
            'products' => $products,
            'favoriteProducts' => $favoriteProducts,
            'discounts' => $discounts,
            'orderTypes' => $orderTypes,
        ]);
    }

    /**
     * Menyimpan pesanan dari user online (Payment Gateway).
     */
    public function store(Request $request)
    {
        // Pengecekan Shift AKTIF hanya untuk mencatat KASIR mana yang MENANGANI order ini.
        // Catatan: Biasanya order online tidak terikat ke shift kasir, kecuali ada integrasi khusus.
        $activeShift = CashierShift::where('user_id', \Auth::id())
            ->where('is_closed', false)
            ->first();

        $data = $request->validate([
            'tableNumber' => 'required|string|max:50', // Tetap terima string nama meja dari FE
            'cartItems' => 'required|array|min:1',
            'cartItems.*.product_id' => 'nullable|exists:products,id',
            'cartItems.*.selectedVariant.id' => 'required_without:cartItems.*.isCustom|exists:variants,id',
            'cartItems.*.quantity' => 'required|integer|min:1',
            'cartItems.*.finalPrice' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
        ]);

        // 💡 INTEGRASI TABLE: Cari objek Table berdasarkan nama/nomor meja
        $table = Table::where('name', $data['tableNumber'])->first();

        if (!$table) {
            Log::error('OnlineOrderController: Gagal membuat order, meja tidak ditemukan: ' . $data['tableNumber']);
            return response()->json(['success' => false, 'message' => 'Meja tidak terdaftar di sistem.'], 400);
        }

        Log::info('OnlineOrderController: Memproses order untuk Meja ID: ' . $table->id . ' (' . $table->name . ')');

        $snapToken = null;

        try {
            DB::beginTransaction();

            // 1. Validasi stok sebelum menyimpan
            $this->validateStock($data['cartItems']);

            // 2. Buat Order
            $order = Order::create([
                'user_id' => null, // Order online tidak memiliki user ID login
                'cashier_shift_id' => $activeShift->id ?? null,
                'table_id' => $table->id, // Menggunakan ID meja yang ditemukan
                'invoice_number' => 'WEB-' . date('YmdHis') . '-' . strtoupper(Str::random(4)),
                'is_online_order' => true,
                'status' => 'pending', // Order pending menunggu pembayaran
                'payment_status' => 'unpaid',
                'subtotal' => $data['subtotal'],
                'tax_amount' => $data['tax'],
                'total' => $data['total'],
                'payment_method' => 'gateway',
            ]);

            Log::info("Order ID: {$order->id} berhasil dibuat dengan table_id: {$order->table_id}.");

            // 3. Simpan Order Items
            foreach ($data['cartItems'] as $item) {
                $this->createOrderItem($order, $item);
            }

            // 4. Buat Snap Token Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $order->invoice_number,
                    'gross_amount' => (int) $order->total,
                ],
                'customer_details' => [
                    // Gunakan nama meja di Midtrans
                    'first_name' => 'Meja ' . $table->name,
                    // Buat email unik berdasarkan nama meja untuk Midtrans
                    'email' => strtolower(Str::slug($table->name)) . '@online-order.com',
                ],
            ];
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // 💡 INTEGRASI TABLE: Update status meja menjadi terisi
            $table->update(['status' => 'occupied']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat! Menunggu pembayaran.',
                'order_id' => $order->id,
                'invoice_number' => $order->invoice_number,
                'snap_token' => $snapToken
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan pesanan online: ' . $e->getMessage() . ' | Line: ' . $e->getLine());

            $errorMessage = Str::contains($e->getMessage(), 'Stok tidak cukup') ?
                $e->getMessage() : 'Gagal menyimpan pesanan. Silakan coba lagi.';

            return response()->json(['success' => false, 'message' => $errorMessage], 500);
        }
    }

    /**
     * Callback dari Midtrans untuk update status pembayaran (di luar scope store)
     */
    public function paymentCallback(Request $request)
    {
        try {
            // ... (Kode verifikasi signature_key) ...
            $serverKey = config('midtrans.server_key');
            $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

            if ($hashed !== $request->signature_key) {
                Log::warning('Midtrans Callback: Invalid signature for Order ID: ' . $request->order_id);
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            $order = Order::where('invoice_number', $request->order_id)->firstOrFail();
            $transactionStatus = $request->transaction_status;

            Log::info("Midtrans Callback: Order {$order->invoice_number} received status: {$transactionStatus}");

            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                if ($order->payment_status != 'paid') {
                    DB::beginTransaction();
                    try {
                        $order->payment_status = 'paid';
                        $order->status = 'on_progress'; // Order siap diproses dapur
                        $order->save();

                        // **KRUSIAL: POTONG STOK SAAT PEMBAYARAN BERHASIL**
                        $this->reduceStockForOrder($order);

                        DB::commit();
                        Log::info("Midtrans Callback: Order {$order->invoice_number} sukses (Paid), stok dipotong.");
                        // [Tambahkan event notifikasi real-time di sini]
                    } catch (\Exception $e) {
                        DB::rollBack();
                        Log::error('Gagal memotong stok atau update order di callback: ' . $e->getMessage());
                        return response()->json(['message' => 'Callback failed due to stock/db error.'], 500);
                    }
                }
            } elseif ($transactionStatus == 'pending') {
                $order->payment_status = 'unpaid';
                $order->status = 'pending';
                $order->save();
            } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                $order->payment_status = 'failed';
                $order->status = 'cancelled';
                $order->save();

                // 💡 INTEGRASI TABLE: Jika gagal/expire, kembalikan status meja ke available (jika Order memiliki table_id)
                if ($order->table_id) {
                    // Gunakan relasi, pastikan relasi 'table' ada di model Order
                    if ($order->table) {
                        $order->table->update(['status' => 'available']);
                        Log::info("Midtrans Callback: Meja {$order->table->name} dikembalikan ke status 'available' karena pembayaran gagal.");
                    }
                }
            }

            return response()->json(['message' => 'Callback processed']);
        } catch (\Exception $e) {
            Log::error('Payment callback error: ' . $e->getMessage());
            return response()->json(['message' => 'Callback failed'], 500);
        }
    }

    // ====== PRIVATE HELPER METHODS (Tidak Berubah Signifikan) ======

    private function calculateLimitingStock($products)
    {
        $ingredientStocks = Ingredient::pluck('stock', 'id')->map(fn($stock) => (float)$stock);

        return $products->map(function ($product) use ($ingredientStocks) {
            $minProductStock = INF;
            $productHasAnyRecipe = false;

            if ($product->variants->isEmpty()) {
                $product->limiting_stock = 9999;
                return $product;
            }

            foreach ($product->variants as $variant) {
                $minVariantStock = INF;
                $variantHasRecipe = false;

                foreach ($variant->ingredients as $ingredient) {
                    $variantHasRecipe = true;
                    $productHasAnyRecipe = true;

                    $quantityUsed = (float)$ingredient->pivot->quantity_used;
                    $currentStock = $ingredientStocks->get($ingredient->id, 0.0);

                    if ($quantityUsed > 0) {
                        $possibleProduction = floor($currentStock / $quantityUsed);
                        if ($possibleProduction < $minVariantStock) {
                            $minVariantStock = $possibleProduction;
                        }
                    }
                }

                $variant->max_production = $variantHasRecipe ?
                    ($minVariantStock === INF ? 0 : (int)$minVariantStock) : INF;

                if ($variant->max_production < $minProductStock) {
                    $minProductStock = $variant->max_production;
                }
            }

            $product->limiting_stock = ($minProductStock === INF || !$productHasAnyRecipe) ?
                9999 : min((int)$minProductStock, 9999);

            return $product;
        });
    }

    private function validateStock($cartItems)
    {
        foreach ($cartItems as $item) {
            $isCustom = $item['isCustom'] ?? false;

            if ($isCustom) {
                continue;
            }

            $variantId = $item['selectedVariant']['id'] ?? null;
            if (!$variantId) {
                throw new \Exception('Varian tidak valid untuk produk: ' . ($item['name'] ?? 'Unknown') . '. Pilih varian.');
            }

            $variant = Variant::with('ingredients')->find($variantId);
            if (!$variant) {
                throw new \Exception('Varian tidak ditemukan.');
            }

            foreach ($variant->ingredients as $ingredient) {
                $stockNeeded = $ingredient->pivot->quantity_used * $item['quantity'];
                if ($ingredient->stock < $stockNeeded) {
                    throw new \Exception('Stok tidak cukup untuk: ' . $ingredient->name . ' (' . $variant->product->name . ')');
                }
            }
        }
    }

    private function createOrderItem($order, $item)
    {
        $isCustom = $item['isCustom'] ?? false;

        // --- Ambil data dengan null coalescing yang aman ---
        $basePrice = (float) ($item['selectedVariant']['price'] ?? $item['finalPrice']);
        $addonPrice = 0;
        $orderTypeFee = 0;
        $discountAmount = 0.00;
        $discountId = 1;

        // Handle selectedAddons
        $selectedAddons = $item['selectedAddons'] ?? [];
        if (!empty($selectedAddons) && is_array($selectedAddons)) {
            $addonPrice = array_sum(array_column($selectedAddons, 'price'));
        }

        $priceAfterAddons = $basePrice + $addonPrice;

        // Handle selectedOrderType
        $selectedOrderType = $item['selectedOrderType'] ?? null;
        if ($selectedOrderType) {
            $orderTypeValue = (float) ($selectedOrderType['value'] ?? 0);
            if (($selectedOrderType['type'] ?? 'fixed') == 'percentage') {
                $orderTypeFee = $priceAfterAddons * $orderTypeValue;
            } else {
                $orderTypeFee = $orderTypeValue;
            }
        }

        $priceAfterMarkup = $priceAfterAddons + $orderTypeFee;

        // Diskon diabaikan di mode online
        $unitPriceFinal = max(0, $priceAfterMarkup - $discountAmount);

        // --- Buat nama item yang aman ---
        $variantName = $item['selectedVariant']['name'] ?? 'Standard';
        $itemName = $isCustom ?
            ($item['name'] ?? 'Custom Item') . ' (Custom)' : ($item['name'] ?? 'Unknown Product') . ' (' . $variantName . ')';

        // --- Buat Order Item ---
        $orderItem = $order->orderItems()->create([
            'product_id' => $isCustom ? null : ($item['product_id'] ?? null),
            'variant_id' => $isCustom ? null : ($item['selectedVariant']['id'] ?? null),
            'item_name' => $itemName,
            'base_price' => $basePrice,
            'quantity' => $item['quantity'],
            'notes' => $item['note'] ?? null,
            'order_type_id' => $selectedOrderType['id'] ?? null,
            'discount_id' => $discountId,
            'order_type_fee' => $orderTypeFee,
            'discount_amount' => $discountAmount,
            'unit_price_final' => $unitPriceFinal,
            'subtotal' => $unitPriceFinal * $item['quantity'],
        ]);

        // Sync addons jika ada
        if (!empty($selectedAddons) && is_array($selectedAddons)) {
            $addonsToSync = [];
            foreach ($selectedAddons as $addon) {
                if (isset($addon['id']) && isset($addon['name'])) {
                    $addonsToSync[$addon['id']] = [
                        'addon_name' => $addon['name'],
                        'addon_price' => (float)($addon['price'] ?? 0)
                    ];
                }
            }
            if (!empty($addonsToSync)) {
                $orderItem->addons()->sync($addonsToSync);
            }
        }

        return $orderItem;
    }

    private function reduceStockForOrder(Order $order)
    {
        // Muat order items dengan relasi variant dan ingredients
        $order->load(['orderItems.variant.ingredients']);

        foreach ($order->orderItems as $orderItem) {
            // Abaikan item yang tidak terkait dengan variant (misal: custom item tanpa resep)
            if (!$orderItem->variant_id || !$orderItem->variant) {
                continue;
            }

            $variant = $orderItem->variant;

            foreach ($variant->ingredients as $ingredient) {
                $stockToReduce = $ingredient->pivot->quantity_used * $orderItem->quantity;

                // Pemeriksaan stok terakhir sebelum pemotongan
                if ($ingredient->stock < $stockToReduce) {
                    Log::critical("Stok kritis! Order {$order->invoice_number} gagal potong stok untuk {$ingredient->name}. Stok: {$ingredient->stock}, Dibutuhkan: {$stockToReduce}");
                    throw new \Exception("Stok tidak cukup saat callback untuk: " . $ingredient->name);
                }

                // Lakukan pemotongan stok
                $ingredient->decrement('stock', $stockToReduce);
            }
        }
    }

    private function buildItemDetails(Order $order)
    {
        $items = [];

        foreach ($order->orderItems as $item) {
            $items[] = [
                'id' => $item->id,
                'price' => (int) $item->unit_price_final,
                'quantity' => $item->quantity,
                'name' => substr($item->item_name, 0, 50)
            ];
        }

        return $items;
    }
}
