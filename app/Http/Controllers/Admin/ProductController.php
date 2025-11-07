<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product; // <-- Import
use App\Models\Category; // <-- Import
use Illuminate\Http\Request;
use App\Models\Addon; // <-- 1. IMPORT MODEL ADDON

class ProductController extends Controller
{
    /**
     * Menampilkan daftar semua produk.
     */
    public function index(Request $request)
    {
        $query = Product::with('category')->latest(); // Muat relasi kategori

        // Filter: Search
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhereHas('category', function ($catQuery) use ($searchTerm) {
                        $catQuery->where('name', 'LIKE', '%' . $searchTerm . '%');
                    });
            });
        }

        // Filter: Kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->paginate(20);

        // Ambil semua kategori untuk dropdown filter
        $categories = Category::orderBy('name')->get();

        // Kirim data ke view
        return view('admin.products.index', [
            'products' => $products,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category_id']) // Kirim filter ke view
        ]);
    }

    /**
     * Menampilkan form untuk membuat produk baru.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $addons = Addon::orderBy('name')->get(); // <-- 2. AMBIL SEMUA ADDON

        return view('admin.products.create', compact('categories', 'addons')); // <-- 3. KIRIM KE VIEW
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'variants' => 'required|array|min:1',
            'variants.*.name' => 'required|string|max:255',
            'variants.*.price' => 'required|numeric|min:0',
            'addons' => 'nullable|array', // <-- 4. TAMBAHKAN VALIDASI ADDONS
            'addons.*' => 'exists:addons,id'
        ]);

        $product = Product::create([
            'name' => $validatedData['name'],
            'category_id' => $validatedData['category_id'],
        ]);

        foreach ($validatedData['variants'] as $variantData) {
            $product->variants()->create($variantData);
        }

        // 5. SINKRONKAN ADDONS (Simpan ke tabel jembatan)
        if ($request->has('addons')) {
            $product->addons()->sync($validatedData['addons']);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail produk (biasanya langsung ke edit).
     */
    public function show(Product $product)
    {
        return redirect()->route('admin.products.edit', $product);
    }

    /**
     * Menampilkan form untuk mengedit produk.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $addons = Addon::orderBy('name')->get(); // <-- 6. AMBIL SEMUA ADDON

        $product->load('variants', 'addons'); // <-- 7. LOAD RELASI VARIANTS & ADDONS

        return view('admin.products.edit', compact('product', 'categories', 'addons')); // <-- 8. KIRIM KE VIEW
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'variants' => 'required|array|min:1',
            'variants.*.id' => 'nullable|exists:variants,id',
            'variants.*.name' => 'required|string|max:255',
            'variants.*.price' => 'required|numeric|min:0',
            'addons' => 'nullable|array', // <-- 9. TAMBAHKAN VALIDASI ADDONS
            'addons.*' => 'exists:addons,id'
        ]);

        $product->update([
            'name' => $validatedData['name'],
            'category_id' => $validatedData['category_id'],
        ]);

        // ... (Logika update varian Anda sudah benar) ...
        $existingVariantIds = [];
        foreach ($validatedData['variants'] as $variantData) {
            $variantId = $variantData['id'] ?? null;
            $variant = $product->variants()->updateOrCreate(
                ['id' => $variantId],
                ['name' => $variantData['name'], 'price' => $variantData['price']]
            );
            $existingVariantIds[] = $variant->id;
        }
        $product->variants()->whereNotIn('id', $existingVariantIds)->delete();

        // 10. SINKRONKAN ADDONS
        // sync() akan otomatis menambah/menghapus relasi di tabel jembatan
        $product->addons()->sync($request->addons ?? []); // '?? []' untuk menghapus semua jika tidak ada yg dipilih

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Menghapus produk.
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil dihapus.');
        } catch (\Exception $e) {
            // Tangani jika produk tidak bisa dihapus (misal: terkait data order)
            return redirect()->route('admin.products.index')
                ->with('error', 'Gagal menghapus produk. Mungkin terkait data pesanan.');
        }
    }
}