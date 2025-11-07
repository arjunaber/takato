<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;
use App\Models\Discount;
use App\Models\OrderType;
use App\Models\Ingredient;
use App\Models\RecipeItem;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\Variant;

class PosController extends Controller
{
    public function index()
    {
        // 1. Ambil data untuk Tab Kategori & Library
        $categories = Category::orderBy('name')->get();

        $libraryProducts = Product::with(['variants', 'addons'])
            ->orderBy('name')
            ->get();

        $favoriteProducts = Product::with(['variants', 'addons'])
            ->where('is_favorite', true)
            ->orderBy('name')
            ->get();

        // 2. Ambil data untuk Modal
        $discounts = Discount::orderBy('name')->get();
        $orderTypes = OrderType::orderBy('id')->get();

        // 3. Kirim semua 5 variabel ke view
        return view('admin.cafe.index', [
            'categories' => $categories,
            'libraryProducts' => $libraryProducts,
            'favoriteProducts' => $favoriteProducts,
            'discounts' => $discounts,
            'orderTypes' => $orderTypes,
        ]);
    }

    /**
     * FUNGSI BARU: Endpoint API ini dipanggil oleh JavaScript
     * untuk mendapatkan semua data yang dibutuhkan POS.
     */
    public function getDataForPos()
    {
        try {
            $categories = Category::orderBy('name')->get();

            $libraryProducts = Product::with(['variants', 'addons'])
                ->orderBy('name')
                ->get();

            $favoriteProducts = Product::with(['variants', 'addons'])
                ->where('is_favorite', true)
                ->orderBy('name')
                ->get();

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
     * Method store() tetap sama, tidak perlu diubah.
     * (Saya potong kodenya agar ringkas, JANGAN HAPUS method store() Anda)
     */
    public function store(Request $request)
    {
        // 1. Validasi data JSON yang dikirim (Sesuai JS baru kita)
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

        try {
            DB::beginTransaction();

            $paymentMethod = $data['paymentMethod'];
            $isCash = ($paymentMethod === 'cash');

            // 2. Buat Order (Sesuai migrasi baru Anda + data JS)
            $order = Order::create([
                'user_id' => Auth::id(), // ID kasir
                'invoice_number' => 'INV-' . date('YmdHi') . '-' . Str::random(4),

                'status' => $isCash ? 'completed' : 'pending',
                'payment_status' => $isCash ? 'paid' : 'unpaid',

                'subtotal' => $data['subtotal'],
                'tax_amount' => $data['tax'], // Nama kolom di migrasi baru Anda
                'total' => $data['total'],

                'payment_method' => $paymentMethod,
                'cash_received' => $data['cashReceived'], // Data dari modal
                'cash_change' => $data['cashChange'],     // Data dari modal
            ]);

            // 3. Loop dan simpan OrderItems
            foreach ($data['cartItems'] as $item) {

                // Siapkan data snapshot
                $basePrice = 0;
                $orderTypeFee = 0;
                $discountAmount = 0;
                $unitPriceFinal = $item['finalPrice'];

                if (!$item['isCustom']) {
                    // Hitung ulang biaya snapshot (Lebih aman di backend)
                    $basePrice = (float) $item['selectedVariant']['price'];

                    // Harga Addon (dihitung terpisah, tidak ditambahkan ke base_price)
                    $addonPrice = array_sum(array_column($item['selectedAddons'], 'price'));
                    $priceAfterAddons = $basePrice + $addonPrice; // Harga dasar + addon

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
                    // Untuk item kustom
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

                // ===============================================
                // ==         INI BAGIAN PERBAIKANNYA           ==
                // ===============================================
                if (!$item['isCustom'] && !empty($item['selectedAddons'])) {

                    $addonsToSync = [];
                    foreach ($item['selectedAddons'] as $addon) {
                        // Buat array asosiatif
                        // [ addon_id => [ 'kolom_pivot_1' => 'nilai', 'kolom_pivot_2' => 'nilai' ] ]
                        $addonsToSync[$addon['id']] = [
                            'addon_name' => $addon['name'],
                            'addon_price' => $addon['price']
                        ];
                    }

                    // sync() sekarang akan mengisi kolom ekstra
                    $orderItem->addons()->sync($addonsToSync);
                }
                // ===============================================
                // ==         AKHIR PERBAIKAN                   ==
                // ===============================================


                // 5. Kurangi Stok (Logika Anda sudah benar, tapi kita optimalkan)
                if (!$item['isCustom']) {
                    // Kita pakai 'find' karena $variant belum tentu ada
                    $variant = Variant::with('ingredients')->find($item['selectedVariant']['id']);
                    if ($variant) {
                        foreach ($variant->ingredients as $ingredient) {
                            $stockToReduce = $ingredient->pivot->quantity_used * $item['quantity'];

                            // Cek stok dulu sebelum mengurangi
                            if ($ingredient->stock < $stockToReduce) {
                                // Batalkan transaksi dan kirim pesan error
                                throw new \Exception("Stok tidak cukup untuk: " . $ingredient->name);
                            }
                            // decrement() lebih aman untuk stock
                            $ingredient->decrement('stock', $stockToReduce);
                        }
                    }
                }
            } // Akhir loop cartItems

            DB::commit();

            return response()->json([
                'message' => 'Pesanan berhasil disimpan!',
                'order_id' => $order->id,
                'status' => $order->status,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Data tidak valid.', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan pesanan: ' . $e->getMessage());
            return response()->json([
                'message' => 'Gagal menyimpan pesanan.',
                'error' => $e->getMessage(), // Kirim pesan error (cth: "Stok tidak cukup")
            ], 500);
        }
    }
}
