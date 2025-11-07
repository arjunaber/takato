<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    /**
     * Menampilkan daftar semua bahan baku.
     */
    public function index(Request $request)
    {
        $query = Ingredient::latest();

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $ingredients = $query->paginate(20);

        return view('admin.ingredients.index', [
            'ingredients' => $ingredients,
            'filters' => $request->only(['search'])
        ]);
    }

    /**
     * Menampilkan form untuk membuat bahan baku baru.
     */
    public function create()
    {
        return view('admin.ingredients.create');
    }

    /**
     * Menyimpan bahan baku baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255', // Dihilangkan 'unique' sesuai migrasi
            'stock' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
        ]);

        Ingredient::create($validatedData);

        return redirect()->route('admin.ingredients.index')
            ->with('success', 'Bahan baku berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit.
     */
    public function show(Ingredient $ingredient)
    {
        return redirect()->route('admin.ingredients.edit', $ingredient);
    }

    /**
     * Menampilkan form untuk mengedit bahan baku.
     */
    public function edit(Ingredient $ingredient)
    {
        return view('admin.ingredients.edit', compact('ingredient'));
    }

    /**
     * Update bahan baku di database.
     */
    public function update(Request $request, Ingredient $ingredient)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255', // Dihilangkan 'unique'
            'stock' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
        ]);

        $ingredient->update($validatedData);

        return redirect()->route('admin.ingredients.index')
            ->with('success', 'Bahan baku berhasil diperbarui.');
    }

    /**
     * Menghapus bahan baku.
     */
    public function destroy(Ingredient $ingredient)
    {
        try {
            // Nanti kita cek relasi ke resep
            // if ($ingredient->variants()->count() > 0) {
            //    return back()->with('error', 'Gagal! Bahan ini masih dipakai di resep produk.');
            // }

            $ingredient->delete();
            return redirect()->route('admin.ingredients.index')
                ->with('success', 'Bahan baku berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.ingredients.index')
                ->with('error', 'Gagal menghapus bahan baku.');
        }
    }
}
