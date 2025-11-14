<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit',
        'stock',
        'unit_price',
    ];

    public function variants()
    {
        return $this->belongsToMany(Variant::class, 'ingredient_variant')
            ->withPivot('quantity_used');
    }
}