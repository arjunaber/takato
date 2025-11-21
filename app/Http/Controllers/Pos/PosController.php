<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;
use App\Models\Discount;
use App\Models\OrderType;
use App\Models\Ingredient;
use App\Models\Variant;
use App\Models\Order;
use App\Models\CashierShift;

class PosController extends Controller
{
    public function __construct()
    {
        // Set konfigurasi Midtrans saat controller ini diinisialisasi
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
    }

    public function index()
    {
        $categories = Category::orderBy('name')->get();

        // KRUSIAL FIX: Tambahkan 'variants.ingredients' untuk memuat data resep
        $libraryProducts = Product::with(['variants.ingredients', 'addons'])->orderBy('name')->get();
        $favoriteProducts = Product::with(['variants.ingredients', 'addons'])->where('is_favorite', true)->orderBy('name')->get();

        // Panggil fungsi pembantu untuk menghitung stok pembatas
        $libraryProducts = $this->calculateLimitingStock($libraryProducts);
        $favoriteProducts = $this->calculateLimitingStock($favoriteProducts);

        $discounts = Discount::orderBy('name')->get();
        $orderTypes = OrderType::orderBy('id')->get();

        return view('admin.cafe.index', [
            'categories' => $categories,
            'libraryProducts' => $libraryProducts,
            'favoriteProducts' => $favoriteProducts,
            'discounts' => $discounts,
            'orderTypes' => $orderTypes,
        ]);
    }

    /**
     * Fungsi private untuk menghitung stok maksimum yang dapat diproduksi (Limiting Stock).
     */
    private function calculateLimitingStock($products)
    {
        // Ambil semua stok bahan baku ke dalam map (id => stock) untuk lookup cepat
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

                    $ingredientId = $ingredient->id;
                    $quantityUsed = (float)$ingredient->pivot->quantity_used;
                    $currentStock = $ingredientStocks->get($ingredientId, 0.0);

                    if ($quantityUsed > 0) {
                        $possibleProduction = floor($currentStock / $quantityUsed);
                        if ($possibleProduction < $minVariantStock) {
                            $minVariantStock = $possibleProduction;
                        }
                    }
                }

                if ($variantHasRecipe) {
                    $variant->max_production = ($minVariantStock === INF) ? 0 : (int)$minVariantStock;
                } else {
                    $variant->max_production = INF;
                }

                if ($variant->max_production < $minProductStock) {
                    $minProductStock = $variant->max_production;
                }
            }

            // Set limiting_stock produk
            // Jika tidak ada resep sama sekali, set ke 9999 (Stok OK)
            $product->limiting_stock = ($minProductStock === INF || !$productHasAnyRecipe) ? 9999 : (int)$minProductStock;

            // Batasi tampilan ke 9999 jika stok terlalu tinggi (untuk menghindari angka INF di JSON)
            if ($product->limiting_stock > 9999) {
                $product->limiting_stock = 9999;
            }

            return $product;
        });
    }


    public function getDataForPos()
    {
        try {
            $categories = Category::orderBy('name')->get();
            // PERBAIKAN: Tambahkan variants.ingredients di sini juga
            $libraryProducts = Product::with(['variants.ingredients', 'addons'])->orderBy('name')->get();
            $favoriteProducts = Product::with(['variants.ingredients', 'addons'])->where('is_favorite', true)->orderBy('name')->get();

            // Hitung stok sebelum dikirim ke API
            $libraryProducts = $this->calculateLimitingStock($libraryProducts);
            $favoriteProducts = $this->calculateLimitingStock($favoriteProducts);

            $discounts = Discount::orderBy('name')->get();
            $orderTypes = OrderType::orderBy('id')->get();

            return response()->json([
                'categories' => $categories,
                'libraryProducts' => $libraryProducts,
                'favoriteProducts' => $favoriteProducts,
                'discounts' => $discounts,
                'orderTypes' => $orderTypes,
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal mengambil data POS: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memuat data server.'], 500);
        }
    }


    public function completeOpenBill(Request $request, Order $order)
    {
        $request->validate([
            'paymentMethod' => 'required|string|in:cash,gateway',
            'cashReceived' => 'nullable|numeric',
            'cashChange' => 'nullable|numeric',
        ]);

        $paymentMethod = $request->input('paymentMethod');
        $cashReceived = $request->input('cashReceived') ?? null;
        $cashChange = $request->input('cashChange') ?? null;

        try {
            DB::beginTransaction();

            // === LOGIKA BARU: JIKA GATEWAY (NON CASH) ===
            if ($paymentMethod === 'gateway') {
                // 1. Konfigurasi Midtrans
                \Midtrans\Config::$serverKey = config('midtrans.server_key');
                \Midtrans\Config::$isProduction = config('midtrans.is_production');
                \Midtrans\Config::$isSanitized = true;
                \Midtrans\Config::$is3ds = true;

                // 2. Buat Parameter Snap
                // Kita tambahkan suffix unik agar Midtrans tidak menolak jika ID order pernah dipakai
                $transactionId = $order->invoice_number . '-' . time();

                $params = [
                    'transaction_details' => [
                        'order_id' => $transactionId, // Gunakan ID unik
                        'gross_amount' => (int) $order->total,
                    ],
                    'customer_details' => [
                        'first_name' => Auth::user()->name ?? 'Pelanggan',
                        'email' => Auth::user()->email ?? 'customer@tokomu.com',
                    ],
                ];

                // 3. Dapatkan Token
                $snapToken = \Midtrans\Snap::getSnapToken($params);

                // 4. Update Order ke Pending (bukan Paid)
                $order->status = 'pending'; // Masih menunggu bayar
                $order->payment_status = 'unpaid';
                $order->payment_method = 'gateway';
                $order->save();

                DB::commit();

                // 5. Kembalikan Response Pending + Token
                return response()->json([
                    'message' => 'Silakan selesaikan pembayaran.',
                    'order_id' => $order->id,
                    'status' => 'pending', // Status pending memicu popup di JS
                    'snap_token' => $snapToken
                ], 200);
            }

            // === LOGIKA LAMA: JIKA CASH ===
            $order->status = 'completed';
            $order->payment_status = 'paid';
            $order->payment_method = 'cash';
            $order->cash_received = $cashReceived;
            $order->cash_change = $cashChange;
            $order->save();

            // Kurangi Stok
            $order->load('orderItems.variant');
            foreach ($order->orderItems as $item) {
                if (!is_null($item->product_id) && $item->variant_id) {
                    $this->reduceStock($item->variant_id, $item->quantity);
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Tagihan berhasil diselesaikan!',
                'order_id' => $order->id,
                'status' => 'completed',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyelesaikan Open Bill: ' . $e->getMessage());
            return response()->json([
                'message' => 'Gagal menyelesaikan tagihan.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function updateBillAfterPayment(Request $request, Order $order)
    {
        $request->validate([
            'isSplit' => 'required|boolean',
            'paidItemIds' => 'nullable|array', // Digunakan untuk Split Bill
            'new_order_id' => 'required|numeric',
        ]);

        $isSplit = $request->input('isSplit');

        try {
            DB::beginTransaction();

            if ($isSplit) {
                // LOGIKA SPLIT BILL
                $paidItemIds = $request->input('paidItemIds');

                // 1. Hapus OrderItems yang sudah dibayar dari Order lama
                $order->orderItems()->whereIn('id', $paidItemIds)->delete();

                // 2. Hitung ulang total Order lama
                $newSubtotal = $order->orderItems()->sum('subtotal');
                $newTax = $newSubtotal * 0.10; // Asumsi Tax 10%
                $newTotal = $newSubtotal + $newTax;

                $order->subtotal = $newSubtotal;
                $order->tax_amount = $newTax;
                $order->total = $newTotal;

                // 3. Cek apakah order lama sudah kosong
                if ($order->orderItems()->count() === 0) {
                    $order->status = 'completed'; // Order lama Selesai
                    $order->payment_status = 'paid';
                }

                $order->save();

                $message = $order->status === 'completed' ? 'Tagihan lama selesai.' : 'Order lama berhasil diperbarui.';
            } else {
                // Logika Bayar Penuh tidak dieksekusi di sini lagi
                $message = 'Order lama berhasil diselesaikan.';
            }

            DB::commit();

            // Kembalikan status baru order lama
            return response()->json([
                'message' => $message,
                'old_order_status' => $order->status,
                'new_total' => $order->total // Kirim total baru untuk pembaruan UI
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui order lama: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memperbarui order lama.'], 500);
        }
    }

    /**
     * Endpoint BARU untuk memuat Open Bills (status 'openbill')
     */
    public function getOpenBills()
    {
        $openBills = Order::where('status', 'openbill')
            ->select('id', 'invoice_number', 'total', 'created_at')
            ->orderByDesc('created_at')
            ->get();

        return response()->json($openBills);
    }

    /**
     * Endpoint untuk memuat detail Open Bill tertentu.
     */
    public function loadBill(Order $order)
    {
        Log::info('Accessing loadBill for Order ID: ' . $order->id);

        $order->load(['orderItems.addons', 'orderItems.variant', 'orderItems.orderType', 'orderItems.discount']);

        $cartItems = [];
        foreach ($order->orderItems as $item) {
            $isCustom = is_null($item->product_id);

            // KRUSIAL: Ambil ID Order Item yang Lama
            $orderItemId = $item->id;

            $productName = $item->item_name;

            // Hanya coba cari Product jika BUKAN Custom dan punya product_id
            if (!$isCustom && $item->product_id) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $productName = $product->name;
                } else {
                    $productName = $item->item_name . ' (Produk Dihapus)';
                }
            }

            // Bersihkan nama produk dari varian/custom untuk tampilan di cart
            if (!$isCustom) {
                $productName = str_replace(' (Custom)', '', $productName);
                if ($item->variant) {
                    $productName = str_replace(' (' . $item->variant->name . ')', '', $productName);
                }
            } else {
                $productName = str_replace(' (Custom)', '', $item->item_name);
            }

            // Re-format data agar sesuai dengan struktur cartItems di JS
            $cartItems[] = [
                // KRUSIAL: Gunakan ID OrderItem ($orderItemId) di field 'id' untuk pelacakan
                'id' => $isCustom ? $item->id : $orderItemId,
                'product_id' => $item->product_id, // KRUSIAL: Simpan ID produk asli di sini
                'name' => $productName,
                'quantity' => $item->quantity,
                'note' => $item->notes,
                'finalPrice' => (float)$item->unit_price_final,
                'isCustom' => $isCustom,
                'selectedVariant' => $isCustom ? null : [
                    'id' => $item->variant->id ?? null,
                    'name' => $item->variant->name ?? 'N/A',
                    'price' => (float)$item->base_price,
                ],
                'selectedAddons' => $item->addons->map(fn($addon) => ['id' => $addon->id, 'name' => $addon->pivot->addon_name, 'price' => (float)$addon->pivot->addon_price])->all(),
                'selectedOrderType' => [
                    'id' => $item->orderType->id ?? 1,
                    'name' => $item->orderType->name ?? 'Dine In',
                    'type' => $item->orderType->type ?? 'fixed',
                    'value' => $item->orderType->value ?? 0,
                ],
                'discount' => [
                    'id' => $item->discount->id ?? 1,
                    'name' => $item->discount->name ?? 'Tanpa Diskon',
                    'type' => $item->discount->type ?? 'fixed',
                    'value' => $item->discount->value ?? 0,
                ]
            ];
        }

        return response()->json([
            'order_id' => $order->id,
            'invoice_number' => $order->invoice_number,
            'cartItems' => $cartItems,
            'subtotal' => (float)$order->subtotal,
            'tax' => (float)$order->tax_amount,
            'total' => (float)$order->total,
        ]);
    }


    /**
     * Menyimpan pesanan dari POS (Hanya untuk Order Baru atau Order Split)
     */
    public function store(Request $request)
    {

        $activeShift = CashierShift::where('user_id', Auth::id())
            ->where('is_closed', false)
            ->first();

        if (!$activeShift && $request->input('paymentMethod') !== 'openbill') {
            return response()->json(['error' => 'Harap buka shift kasir terlebih dahulu.'], 403);
        }
        $data = $request->validate([
            'cartItems' => 'required|array|min:1',
            'cartItems.*' => 'required|array',
            'total' => 'required|numeric',
            'tax' => 'required|numeric',
            'subtotal' => 'required|numeric',
            'paymentMethod' => 'required|string|in:cash,gateway,openbill',
            'cashReceived' => 'nullable|numeric',
            'cashChange' => 'nullable|numeric',
            'isSplit' => 'nullable|boolean',
        ]);

        $snapToken = null;
        $order = null;
        $paymentMethod = $data['paymentMethod'];
        $isCash = ($paymentMethod === 'cash');
        $isOpenBill = ($paymentMethod === 'openbill');
        $isSplit = $data['isSplit'] ?? false;

        $cashReceived = $data['cashReceived'] ?? null;
        $cashChange = $data['cashChange'] ?? null;

        try {
            DB::beginTransaction();

            // == LOGIKA STATUS (KEY) ==
            if ($isOpenBill) {
                $orderStatus = 'openbill';
                $paymentStatus = 'unpaid';
            } elseif ($paymentMethod === 'gateway') { // PRIORITASKAN CEK GATEWAY DULU
                // Jika Gateway (baik Split maupun Normal), status harus Pending
                $orderStatus = 'pending';
                $paymentStatus = 'unpaid';
            } elseif ($isCash || $isSplit) {
                // Jika Cash (Normal/Split), status Completed
                // Catatan: isSplit di sini hanya relevan jika BUKAN Gateway
                $orderStatus = 'completed';
                $paymentStatus = 'paid';
            } else {
                // Fallback (seharusnya tidak terpanggil jika validasi benar)
                $orderStatus = 'pending';
                $paymentStatus = 'unpaid';
            }
            // =========================

            $order = Order::create([
                'user_id' => Auth::id(),
                'cashier_shift_id' => $activeShift->id ?? null,
                'invoice_number' => 'INV-' . date('YmdHi') . '-' . strtoupper(Str::random(4)),
                'status' => $orderStatus,
                'payment_status' => $paymentStatus,
                'subtotal' => $data['subtotal'],
                'tax_amount' => $data['tax'],
                'total' => $data['total'],
                'payment_method' => $paymentMethod,
                'cash_received' => $cashReceived,
                'cash_change' => $cashChange,
            ]);

            foreach ($data['cartItems'] as $item) {

                $basePrice = 0;
                $orderTypeFee = 0;
                $discountAmount = 0;
                $unitPriceFinal = $item['finalPrice'];

                if (!$item['isCustom']) {
                    $basePrice = (float) $item['selectedVariant']['price'];
                    $addonPrice = array_sum(array_column($item['selectedAddons'], 'price'));
                    $priceAfterAddons = $basePrice + $addonPrice;
                    if ($item['selectedOrderType']['type'] == 'percentage') {
                        $orderTypeFee = $priceAfterAddons * (float) $item['selectedOrderType']['value'];
                    } else {
                        $orderTypeFee = (float) $item['selectedOrderType']['value'];
                    }
                    $priceAfterMarkup = $priceAfterAddons + $orderTypeFee;
                    if ($item['discount']['type'] == 'percentage') {
                        $discountAmount = $priceAfterMarkup * (float) $item['discount']['value'];
                    } else {
                        $discountAmount = (float) $item['discount']['value'];
                    }
                    $unitPriceFinal = $priceAfterMarkup - $discountAmount;
                    if ($unitPriceFinal < 0) $unitPriceFinal = 0;
                } else {
                    $basePrice = $item['finalPrice'];
                }

                $orderItem = $order->orderItems()->create([
                    // KRUSIAL FIX: Gunakan 'product_id' yang dikirim dari frontend, BUKAN 'id' item.
                    'product_id' => $item['isCustom'] ? null : ($item['product_id'] ?? $item['id']),
                    'variant_id' => $item['isCustom'] ? null : $item['selectedVariant']['id'],
                    'item_name' => $item['isCustom'] ? $item['name'] . ' (Custom)' : $item['name'] . ' (' . $item['selectedVariant']['name'] . ')',
                    'base_price' => $basePrice,
                    'quantity' => $item['quantity'],
                    'notes' => $item['note'] ?? null,
                    'order_type_id' => $item['isCustom'] ? null : $item['selectedOrderType']['id'],
                    'discount_id' => $item['isCustom'] ? null : $item['discount']['id'],
                    'order_type_fee' => $orderTypeFee,
                    'discount_amount' => $discountAmount,
                    'unit_price_final' => $unitPriceFinal,
                    'subtotal' => $unitPriceFinal * $item['quantity'],
                ]);

                if (!$item['isCustom'] && !empty($item['selectedAddons'])) {
                    $addonsToSync = [];
                    foreach ($item['selectedAddons'] as $addon) {
                        $addonsToSync[$addon['id']] = ['addon_name' => $addon['name'], 'addon_price' => (float)$addon['price']];
                    }
                    $orderItem->addons()->sync($addonsToSync);
                }

                // Kurangi Stok HANYA JIKA COMPLETED (Cash atau Split)
                if (!$item['isCustom'] && ($isCash || $isSplit)) {
                    $this->reduceStock($item['selectedVariant']['id'], $item['quantity']);
                }
            }

            // Buat Snap Token HANYA JIKA GATEWAY (dan bukan Open Bill)
            if (!$isCash && !$isOpenBill) {

                \Midtrans\Config::$serverKey = config('midtrans.server_key');
                \Midtrans\Config::$isProduction = config('midtrans.is_production');
                \Midtrans\Config::$isSanitized = true;
                \Midtrans\Config::$is3ds = true;
                $params = [
                    'transaction_details' => [
                        'order_id' => $order->invoice_number,
                        'gross_amount' => (int) $order->total,
                    ],
                    'customer_details' => [
                        'first_name' => Auth::user()->name ?? 'Pelanggan',
                        'email' => Auth::user()->email ?? 'customer@tokomu.com',
                    ],
                ];
                $snapToken = \Midtrans\Snap::getSnapToken($params);
            }

            DB::commit();

            return response()->json([
                'message' => 'Pesanan berhasil disimpan!',
                'order_id' => $order->id,
                'status' => $order->status,
                'snap_token' => $snapToken
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Data tidak valid.', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan pesanan: ' . $e->getMessage());
            return response()->json([
                'message' => 'Gagal menyimpan pesanan.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    /**
     * Method BARU: Konfirmasi pembayaran Gateway dari Frontend (JS)
     * Dipanggil saat onsuccess Midtrans Snap.
     */
    public function confirmPayment(Request $request, Order $order)
    {
        // 1. Cek Idempotency (Cek apakah sudah lunas duluan)
        if ($order->status === 'completed' || $order->payment_status === 'paid') {
            return response()->json([
                'message' => 'Order sudah lunas sebelumnya.',
                'status' => 'completed'
            ], 200);
        }

        try {
            DB::beginTransaction();

            // 2. Update Status Order
            $order->status = 'completed';
            $order->payment_status = 'paid';
            $order->save();

            // 3. KURANGI STOK
            // Kita load item beserta varian-nya untuk looping pengurangan stok
            $order->load('orderItems.variant');

            foreach ($order->orderItems as $item) {
                // Pastikan item tersebut memiliki variant (bukan custom item murni tanpa resep)
                if (!is_null($item->product_id) && $item->variant_id) {
                    // Panggil fungsi private reduceStock yang sudah ada di bawah
                    $this->reduceStock($item->variant_id, $item->quantity);
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Pembayaran berhasil dikonfirmasi dan stok diperbarui.',
                'status' => 'completed',
                'order_id' => $order->id
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal konfirmasi pembayaran gateway POS: ' . $e->getMessage());
            return response()->json([
                'message' => 'Gagal memproses konfirmasi di server.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Fungsi private untuk mengurangi stok
     */
    private function reduceStock($variantId, $quantity)
    {
        try {
            $variant = Variant::with('ingredients')->find($variantId);
            if (!$variant) return;

            foreach ($variant->ingredients as $ingredient) {
                $stockToReduce = $ingredient->pivot->quantity_used * $quantity;
                if ($ingredient->stock < $stockToReduce) {
                    throw new \Exception("Stok tidak cukup untuk: " . $ingredient->name);
                }
                $ingredient->decrement('stock', $stockToReduce);
            }
        } catch (\Exception $e) {
            throw $e; // Lemparkan error agar DB::rollBack() menangkapnya
        }
    }
}
