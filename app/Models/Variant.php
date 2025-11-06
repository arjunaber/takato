<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- Tambahkan ini
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- Tambahkan ini

class Variant extends Model
{
    use HasFactory;
    protected $guarded = []; // Izinkan mass assignment

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function recipeItems(): HasMany
    {
        return $this->hasMany(RecipeItem::class);
    }
}