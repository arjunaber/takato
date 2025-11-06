<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ingredient; // <-- Import Model

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::latest()->paginate(10);
        return view('admin.ingredients.index', compact('ingredients'));
    }

    public function create()
    {
        return view('admin.ingredients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ingredients',
            'unit' => 'required|string|max:50',
            'stock' => 'required|numeric|min:0',
        ]);

        Ingredient::create($request->all());
        return redirect()->route('admin.ingredients.index')->with('success', 'Bahan baku berhasil dibuat.');
    }

    public function edit(string $id)
    {
        $ingredient = Ingredient::findOrFail($id);
        return view('admin.ingredients.edit', compact('ingredient'));
    }

    public function update(Request $request, string $id)
    {
        $ingredient = Ingredient::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:ingredients,name,' . $ingredient->id,
            'unit' => 'required|string|max:50',
            'stock' => 'required|numeric|min:0',
        ]);

        $ingredient->update($request->all());
        return redirect()->route('admin.ingredients.index')->with('success', 'Bahan baku berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $ingredient = Ingredient::findOrFail($id);
        // Tambahkan validasi: Cek jika bahan baku masih terpakai di resep
        if ($ingredient->recipeItems()->count() > 0) {
            return back()->with('error', 'Bahan baku tidak bisa dihapus karena masih terdaftar di resep.');
        }

        $ingredient->delete();
        return redirect()->route('admin.ingredients.index')->with('success', 'Bahan baku berhasil dihapus.');
    }
}
