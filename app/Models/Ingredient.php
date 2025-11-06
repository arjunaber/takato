<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- Tambahkan ini

class Ingredient extends Model
{
    use HasFactory;
    protected $guarded = []; // Izinkan mass assignment

    public function recipeItems(): HasMany
    {
        return $this->hasMany(RecipeItem::class);
    }
}
