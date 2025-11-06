<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Panggil semua model yang dibutuhkan
use App\Models\Product;
use App\Models\Category;
use App\Models\Addon;
use App\Models\Ingredient;
use App\Models\Variant;

class ProductController extends Controller
{
    // Menampilkan daftar semua produk
    public function index()
    {
        $products = Product::with('category', 'variants')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    // Menampilkan form untuk membuat produk baru
    public function create()
    {
        // Kita butuh data ini untuk mengisi <select> di form
        $categories = Category::orderBy('name')->get();
        $addons = Addon::orderBy('name')->get();
        $ingredients = Ingredient::orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'addons', 'ingredients'));
    }

    // Menyimpan produk baru
    public function store(Request $request)
    {
        // (Di sini Anda perlu validasi data)
        // $request->validate([...]);

        // 1. Buat Produk Utama
        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'is_favorite' => $request->has('is_favorite'),
        ]);

        // 2. Hubungkan Addons (dari checkbox)
        if ($request->has('addons')) {
            $product->addons()->sync($request->addons); // sync() akan otomatis attach/detach
        }

        // 3. Buat Varian-varian (dari form repeater)
        if ($request->has('variants')) {
            foreach ($request->variants as $variantData) {
                $variant = $product->variants()->create([
                    'name' => $variantData['name'],
                    'price' => $variantData['price'],
                ]);

                // 4. Buat Resep untuk varian tsb
                if (isset($variantData['recipe'])) {
                    foreach ($variantData['recipe'] as $recipeData) {
                        $variant->recipeItems()->create([
                            'ingredient_id' => $recipeData['ingredient_id'],
                            'quantity_used' => $recipeData['quantity_used'],
                        ]);
                    }
                }
            }
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil dibuat.');
    }

    // Menampilkan detail 1 produk (biasanya tidak dipakai di admin, tapi ada)
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    // Menampilkan form untuk edit produk
    public function edit(Product $product)
    {
        // Load relasi agar bisa ditampilkan di form
        $product->load('variants.recipeItems', 'addons');

        $categories = Category::orderBy('name')->get();
        $addons = Addon::orderBy('name')->get();
        $ingredients = Ingredient::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'addons', 'ingredients'));
    }

    // Mengupdate produk yang ada
    public function update(Request $request, Product $product)
    {
        // (Mirip dengan store, tapi Anda perlu logika update/delete varian lama)
        // 1. Update data produk utama
        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'is_favorite' => $request->has('is_favorite'),
        ]);

        // 2. Update relasi addon
        $product->addons()->sync($request->addons);

        // 3. Update Varian & Resep (Logika ini bisa jadi kompleks)
        // ... (Logika untuk menghapus varian lama, update yg ada, dan menambah yg baru) ...

        return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate.');
    }

    // Menghapus produk
    public function destroy(Product $product)
    {
        // Karena kita setting cascadeOnDelete di migrasi,
        // saat produk dihapus, semua varian & resepnya akan ikut terhapus.
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
