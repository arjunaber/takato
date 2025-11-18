<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'area',
        'capacity',
        'status',
        'shape',
        'position_x',
        'position_y',
    ];

    protected $casts = [
        'capacity' => 'integer',
        'position_x' => 'integer',
        'position_y' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ============================
    // RELATIONSHIPS
    // ============================

    /**
     * Satu meja dapat memiliki banyak pesanan.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get active order (order yang belum selesai/belum dibayar).
     * Helper untuk mendapatkan Order AKTIF terbaru dengan status order.
     */
    public function activeOrder()
    {
        return $this->hasOne(Order::class)
            ->where('status', '!=', 'cancelled')
            ->whereDate('created_at', now())
            ->latestOfMany();
    }

    // ============================
    // SCOPES
    // ============================

    /**
     * Filter table by area.
     */
    public function scopeByArea($query, $area)
    {
        if ($area && $area !== 'all') {
            return $query->where('area', $area);
        }
        return $query;
    }

    /**
     * Filter table by status.
     */
    public function scopeByStatus($query, $status)
    {
        if ($status && $status !== 'all') {
            return $query->where('status', $status);
        }
        return $query;
    }

    /**
     * Get available tables only.
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Get occupied tables.
     */
    public function scopeOccupied($query)
    {
        return $query->where('status', 'occupied');
    }

    /**
     * Get cleaning tables.
     */
    public function scopeCleaning($query)
    {
        return $query->where('status', 'cleaning');
    }

    /**
     * Order by area and name.
     */
    public function scopeOrderByAreaAndName($query)
    {
        return $query->orderBy('area')->orderBy('name');
    }

    // ============================
    // HELPER METHODS
    // ============================

    /**
     * Get the actual status considering active orders.
     */
    public function getActualStatusAttribute()
    {
        if ($this->activeOrder()->exists()) {
            return 'occupied';
        }
        return $this->status;
    }

    /**
     * Get formatted position as array.
     */
    public function getPositionAttribute()
    {
        return [
            'x' => $this->position_x,
            'y' => $this->position_y,
        ];
    }
}
