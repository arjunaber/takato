<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Variant;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * Mengambil data resep (Method show() TIDAK BERUBAH)
     */
    public function show(Variant $variant)
    {
        $all_ingredients = Ingredient::orderBy('name')->get();
        $current_recipe = $variant->ingredients;

        return response()->json([
            'all_ingredients' => $all_ingredients,
            'current_recipe' => $current_recipe
        ]);
    }

    /**
     * Menyimpan/Update resep (Method update() DISESUAIKAN)
     */
    public function update(Request $request, Variant $variant)
    {
        $request->validate([
            'recipes' => 'nullable|array',
            'recipes.*.ingredient_id' => 'required|exists:ingredients,id',
            'recipes.*.quantity_used' => 'required|numeric|min:0.01', // <-- PERUBAHAN DI SINI
        ]);

        $recipesToSync = [];
        if ($request->has('recipes')) {
            foreach ($request->recipes as $recipe) {
                $recipesToSync[$recipe['ingredient_id']] = [
                    'quantity_used' => $recipe['quantity_used'] // <-- PERUBAHAN DI SINI
                ];
            }
        }

        $variant->ingredients()->sync($recipesToSync);

        return response()->json([
            'success' => true,
            'message' => 'Resep berhasil diperbarui!'
        ]);
    }
}
