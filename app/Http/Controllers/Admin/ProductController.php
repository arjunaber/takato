<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Addon;
use Illuminate\Support\Facades\Storage; // <<< IMPORT STORAGE

class ProductController extends Controller
{
    /**
     * Menampilkan daftar semua produk.
     */
    public function index(Request $request)
    {
        $query = Product::with('category')->latest(); 

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

        $products = $query->paginate(10);

        // Ambil semua kategori untuk dropdown filter
        $categories = Category::orderBy('name')->get();

        // Kirim data ke view
        return view('admin.products.index', [
            'products' => $products,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category_id']) 
        ]);
    }

    /**
     * Menampilkan form untuk membuat produk baru.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $addons = Addon::orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'addons')); 
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            // VALIDASI FILE GAMBAR
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            'variants' => 'required|array|min:1',
            'variants.*.name' => 'required|string|max:255',
            'variants.*.price' => 'required|numeric|min:0',
            'addons' => 'nullable|array', 
            'addons.*' => 'exists:addons,id'
        ]);

        $imagePath = null;
        
        // 1. UPLOAD GAMBAR
        if ($request->hasFile('image')) {
            // Simpan gambar ke storage/app/public/images/products
            $imagePath = $request->file('image')->store('images/products', 'public');
        }

        $product = Product::create([
            'name' => $validatedData['name'],
            'category_id' => $validatedData['category_id'],
            // 2. SIMPAN PATH GAMBAR
            'image_url' => $imagePath,
        ]);

        foreach ($validatedData['variants'] as $variantData) {
            $product->variants()->create($variantData);
        }

        // 3. SINKRONKAN ADDONS
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
        $addons = Addon::orderBy('name')->get(); 

        $product->load('variants', 'addons'); 

        return view('admin.products.edit', compact('product', 'categories', 'addons')); 
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            // VALIDASI FILE GAMBAR (boleh kosong)
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            'variants' => 'required|array|min:1',
            'variants.*.id' => 'nullable|exists:variants,id',
            'variants.*.name' => 'required|string|max:255',
            'variants.*.price' => 'required|numeric|min:0',
            'addons' => 'nullable|array', 
            'addons.*' => 'exists:addons,id'
        ]);

        $updateData = [
            'name' => $validatedData['name'],
            'category_id' => $validatedData['category_id'],
        ];

        // 4. UPLOAD DAN GANTI GAMBAR LAMA (JIKA ADA FILE BARU)
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image_url) {
                Storage::disk('public')->delete($product->image_url);
            }
            // Simpan gambar baru
            $updateData['image_url'] = $request->file('image')->store('images/products', 'public');
        }

        $product->update($updateData);

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

        // 5. SINKRONKAN ADDONS
        $product->addons()->sync($request->addons ?? []); 

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Menghapus produk.
     */
    public function destroy(Product $product)
    {
        try {
            // Hapus gambar dari storage sebelum menghapus record
            if ($product->image_url) {
                Storage::disk('public')->delete($product->image_url);
            }
            
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