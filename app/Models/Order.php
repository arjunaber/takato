<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- Tambahkan ini
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- Tambahkan ini

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'invoice_number',
        'status',
        'subtotal',
        'tax_amount',     
        'total',
        'payment_method',
        'payment_status',   
        'payment_gateway_ref', 
        'cash_received',
        'cash_change',
    ];
    protected $guarded = []; // Izinkan mass assignment

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}