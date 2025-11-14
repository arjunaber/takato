<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

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

        $ingredients = $query->paginate(10);

        // === PERBAIKAN: Tambahkan 'unit_price' untuk modal ===
        $allIngredients = Ingredient::orderBy('name')->get(['id', 'name', 'unit', 'stock', 'unit_price']);

        return view('admin.ingredients.index', [
            'ingredients' => $ingredients, // Untuk tabel
            'allIngredients' => $allIngredients, // Untuk modal
            'filters' => $request->only(['search']) // <-- $filters ada di sini
        ]);
    }

    /**
     * Menampilkan form untuk membuat bahan baku baru.
     */
    public function create()
    {
        return view('admin.ingredients.create', [
            'filters' => []
        ]);
    }

    /**
     * Menyimpan bahan baku baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            // === BARU: Validasi unit_price ===
            'unit_price' => 'required|numeric|min:0',
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
        return view('admin.ingredients.edit', [
            'ingredient' => $ingredient,
            'filters' => []
        ]);
    }

    /**
     * Update bahan baku di database.
     */
    public function update(Request $request, Ingredient $ingredient)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            // === BARU: Validasi unit_price ===
            'unit_price' => 'required|numeric|min:0',
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
            // Asumsi model Ingredient memiliki relasi variants()
            if (method_exists($ingredient, 'variants') && $ingredient->variants()->count() > 0) {
                return back()->with('error', 'Gagal! Bahan ini masih dipakai di resep produk.');
            }

            $ingredient->delete();
            return redirect()->route('admin.ingredients.index')
                ->with('success', 'Bahan baku berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.ingredients.index')
                ->with('error', 'Gagal menghapus bahan baku.');
        }
    }

    /**
     * Menyesuaikan (menambah/mengurangi) stok dari modal.
     */
    public function adjustStock(Request $request)
    {
        $validated = $request->validate([
            'ingredient_id' => 'required|exists:ingredients,id',
            'quantity' => 'required|numeric|min:0.01',
            'action' => 'required|in:add,subtract',
            'notes' => 'nullable|string|max:255',
            // unit_price tidak di adjust di sini, hanya stok
        ]);

        try {
            DB::beginTransaction();

            $ingredient = Ingredient::find($validated['ingredient_id']);
            $quantity = (float) $validated['quantity'];

            if ($validated['action'] === 'add') {
                $ingredient->increment('stock', $quantity);
            } else {
                if ($ingredient->stock < $quantity) {
                    throw ValidationException::withMessages([
                        'quantity' => "Stok saat ini ({$ingredient->stock} {$ingredient->unit}) tidak cukup untuk dikurangi {$quantity} {$ingredient->unit}."
                    ]);
                }
                $ingredient->decrement('stock', $quantity);
            }

            DB::commit();

            return redirect()->route('admin.ingredients.index')
                ->with('success', "Stok {$ingredient->name} berhasil disesuaikan.");
        } catch (ValidationException $e) {
            DB::rollBack();
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal sesuaikan stok: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Gagal menyimpan: Terjadi kesalahan server.'])->withInput();
        }
    }
}
