<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- Tambahkan ini
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- Tambahkan ini
use Illuminate\Support\Facades\Log;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'invoice_number',
        'cashier_shift_id',
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
    public function reduceStock()
    {
        // Pastikan relasi yang dibutuhkan sudah ter-load
        $this->loadMissing('orderItems.variant.ingredients');

        foreach ($this->orderItems as $item) {
            // Lewati item kustom atau item yang tidak punya varian
            if ($item->isCustom || !$item->variant) {
                continue;
            }

            $variant = $item->variant;
            $quantity = $item->quantity;

            foreach ($variant->ingredients as $ingredient) {
                $stockToReduce = $ingredient->pivot->quantity_used * $quantity;

                Log::info("Mengurangi stok {$ingredient->name}: {$ingredient->stock} - {$stockToReduce}");

                if ($ingredient->stock < $stockToReduce) {
                    // Lemparkan error. Ini akan ditangkap oleh DB::rollBack()
                    throw new \Exception("Stok tidak cukup untuk: " . $ingredient->name);
                }

                // Kurangi stok
                $ingredient->decrement('stock', $stockToReduce);
            }
        }
    }

    public function returnStock()
    {
        $this->loadMissing('orderItems.variant.ingredients');

        foreach ($this->orderItems as $item) {
            // Lewati item kustom atau item yang tidak punya varian
            if ($item->isCustom || !$item->variant) {
                continue;
            }

            $variant = $item->variant;
            $quantity = $item->quantity;

            foreach ($variant->ingredients as $ingredient) {
                $amountToReturn = $ingredient->pivot->quantity_used * $quantity;

                Log::info("Mengembalikan stok {$ingredient->name}: {$ingredient->stock} + {$amountToReturn}");

                // Kembalikan stok
                $ingredient->increment('stock', $amountToReturn);
            }
        }
    }
}
