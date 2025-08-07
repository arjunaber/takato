<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'grand_schedule_id',
        'amount',
        'status',
        'payment_gateway',
        'payment_reference',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    /**
     * Relasi ke GrandSchedule
     */
    public function grandSchedule()
    {
        return $this->belongsTo(GrandSchedule::class);
    }

    /**
     * Status pembayaran yang tersedia
     */
    public static function statuses()
    {
        return [
            'pending' => 'Belum Dibayar',
            'paid' => 'Sudah Dibayar',
            'failed' => 'Gagal',
        ];
    }

    /**
     * Gateway yang tersedia (opsional)
     */
    public static function gateways()
    {
        return [
            'midtrans' => 'Midtrans',
            'xendit' => 'Xendit',
            'manual' => 'Transfer Manual',
        ];
    }
}
