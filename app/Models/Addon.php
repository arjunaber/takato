<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // <-- Tambahkan ini

class Addon extends Model
{
    use HasFactory;
    protected $guarded = []; // Izinkan mass assignment

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
