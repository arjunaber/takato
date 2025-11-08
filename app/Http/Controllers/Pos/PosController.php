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

class PosController extends Controller
{
    /**
     * Inisialisasi konfigurasi Midtrans
     */
    public function __construct()
    {
        // Set konfigurasi Midtrans saat controller ini diinisialisasi
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Menampilkan halaman POS dan memuat semua data awal.
     */
    public function index()
    {
        $categories = Category::orderBy('name')->get();
        $libraryProducts = Product::with(['variants', 'addons'])->orderBy('name')->get();
        $favoriteProducts = Product::with(['variants', 'addons'])->where('is_favorite', true)->orderBy('name')->get();
        $discounts = Discount::orderBy('name')->get();
        $orderTypes = OrderType::orderBy('id')->get();

        // Pastikan path view Anda benar (admin.pos.index atau admin.cafe.index)
        return view('admin.cafe.index', [
            'categories' => $categories,
            'libraryProducts' => $libraryProducts,
            'favoriteProducts' => $favoriteProducts,
            'discounts' => $discounts,
            'orderTypes' => $orderTypes,
        ]);
    }

    /**
     * Endpoint API (jika Anda membutuhkannya)
     */
    public function getDataForPos()
    {
        try {
            $categories = Category::orderBy('name')->get();
            $libraryProducts = Product::with(['variants', 'addons'])->orderBy('name')->get();
            $favoriteProducts = Product::with(['variants', 'addons'])->where('is_favorite', true)->orderBy('name')->get();
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


    /**
     * Menyimpan pesanan dari POS (Versi Final dengan Logika Midtrans)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'cartItems' => 'required|array|min:1',
            'cartItems.*' => 'required|array',
            'total' => 'required|numeric',
            'tax' => 'required|numeric',
            'subtotal' => 'required|numeric',
            'paymentMethod' => 'required|string|in:cash,gateway',
            'cashReceived' => 'nullable|numeric',
            'cashChange' => 'nullable|numeric',
        ]);

        $snapToken = null;
        $order = null;
        $paymentMethod = $data['paymentMethod'];
        $isCash = ($paymentMethod === 'cash');

        try {
            DB::beginTransaction();

            // == INI LOGIKA KUNCINYA ==
            $orderStatus = $isCash ? 'completed' : 'pending';
            $paymentStatus = $isCash ? 'paid' : 'unpaid';
            // =========================

            $order = Order::create([
                'user_id' => Auth::id(),
                'invoice_number' => 'INV-' . date('YmdHi') . '-' . strtoupper(Str::random(4)),
                'status' => $orderStatus, // <-- Menggunakan status yang benar
                'payment_status' => $paymentStatus, // <-- Menggunakan status yang benar
                'subtotal' => $data['subtotal'],
                'tax_amount' => $data['tax'],
                'total' => $data['total'],
                'payment_method' => $paymentMethod,
                'cash_received' => $data['cashReceived'],
                'cash_change' => $data['cashChange'],
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
                    'product_id' => $item['isCustom'] ? null : $item['id'],
                    'variant_id' => $item['isCustom'] ? null : $item['selectedVariant']['id'],
                    'item_name' => $item['isCustom'] ? $item['name'] : $item['name'] . ' (' . $item['selectedVariant']['name'] . ')',
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
                        $addonsToSync[$addon['id']] = ['addon_name' => $addon['name'], 'addon_price' => $addon['price']];
                    }
                    $orderItem->addons()->sync($addonsToSync);
                }

                // Kurangi Stok HANYA JIKA CASH
                if (!$item['isCustom'] && $isCash) {
                    $this->reduceStock($item['selectedVariant']['id'], $item['quantity']);
                }
            }

            // == INI LOGIKA KUNCINYA ==
            // Buat Snap Token HANYA JIKA BUKAN CASH
            if (!$isCash) {
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
            // =========================

            DB::commit();

            return response()->json([
                'message' => 'Pesanan berhasil disimpan!',
                'order_id' => $order->id,
                'status' => $order->status, // Ini akan mengirim 'pending'
                'snap_token' => $snapToken  // Ini akan mengirim token
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