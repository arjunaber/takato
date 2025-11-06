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
        // ... (Semua logika validasi dan penyimpanan order Anda tetap di sini) ...
        // 1. Validasi data JSON yang dikirim
        $data = $request->validate([
            'cartItems' => 'required|array|min:1',
            'cartItems.*.id' => 'required',
            'cartItems.*.name' => 'required|string',
            'cartItems.*.quantity' => 'required|integer|min:1',
            'cartItems.*.finalPrice' => 'required|numeric',
            'cartItems.*.isCustom' => 'required|boolean',
            'cartItems.*.selectedVariant' => 'required_if:cartItems.*.isCustom,false|array',
            'cartItems.*.selectedAddons' => 'required_if:cartItems.*.isCustom,false|array',
            'cartItems.*.selectedOrderType' => 'required_if:cartItems.*.isCustom,false|array',
            'cartItems.*.discount' => 'required_if:cartItems.*.isCustom,false|array',
            'cartItems.*.note' => 'nullable|string',
            'total' => 'required|numeric',
            'tax' => 'required|numeric',
            'subtotal' => 'required|numeric',
            'paymentMethod' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => auth()->id(),
                'invoice_number' => 'INV-' . date('Ymd') . '-' . Str::random(6),
                'status' => 'completed',
                'subtotal' => $data['subtotal'],
                'tax_amount' => $data['tax'],
                'total' => $data['total'],
                'payment_method' => $data['paymentMethod'],
                'payment_status' => 'paid',
            ]);

            foreach ($data['cartItems'] as $item) {

                $orderItem = $order->orderItems()->create([
                    'product_id' => $item['isCustom'] ? null : $item['id'],
                    'variant_id' => $item['isCustom'] ? null : $item['selectedVariant']['id'],
                    'item_name' => $item['isCustom'] ? $item['name'] : $item['name'] . ' (' . $item['selectedVariant']['name'] . ')',
                    'base_price' => $item['isCustom'] ? $item['finalPrice'] : $item['selectedVariant']['price'],
                    'quantity' => $item['quantity'],
                    'notes' => $item['note'] ?? null,
                    'order_type_id' => $item['isCustom'] ? null : $item['selectedOrderType']['id'],
                    'discount_id' => $item['isCustom'] ? null : $item['discount']['id'],
                    'unit_price_final' => $item['finalPrice'],
                    'subtotal' => $item['finalPrice'] * $item['quantity'],
                    'order_type_fee' => 0,
                    'discount_amount' => 0,
                ]);

                if (!$item['isCustom']) {

                    if (!empty($item['selectedAddons'])) {
                        foreach ($item['selectedAddons'] as $addon) {
                            $orderItem->addons()->create([
                                'addon_id' => $addon['id'],
                                'addon_name' => $addon['name'],
                                'addon_price' => $addon['price'],
                            ]);
                        }
                    }

                    $recipeItems = RecipeItem::where('variant_id', $item['selectedVariant']['id'])->get();

                    foreach ($recipeItems as $recipe) {
                        $ingredient = Ingredient::find($recipe->ingredient_id);
                        if ($ingredient) {
                            $stockToReduce = $recipe->quantity_used * $item['quantity'];
                            if ($ingredient->stock < $stockToReduce) {
                                throw new \Exception("Stok tidak cukup untuk: " . $ingredient->name);
                            }
                            $ingredient->decrement('stock', $stockToReduce);
                        }
                    }
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Pesanan berhasil disimpan!',
                'order_id' => $order->id,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan pesanan: ' . $e->getMessage());
            return response()->json([
                'message' => 'Gagal menyimpan pesanan.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
