<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class GrandSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'day_type',
        'price',
        'status',
        'notes',
        'booked_email',
        'booked_phone',
        'booked_at',
    ];


    protected $casts = [
        'date' => 'date',
        'booked_at' => 'datetime',
    ];


    // Relasi ke pembayaran
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Daftar tipe hari
    public static function dayTypes()
    {
        return [
            'weekday_weekend' => 'Weekday & Weekend',
            'special_event' => 'Special Event',
        ];
    }

    // Daftar status
    public static function statuses()
    {
        return [
            'available' => 'Available',
            'booked' => 'Booked'
        ];
    }

    public static function bookDate($date, $userId = null)
    {
        $carbonDate = Carbon::parse($date);
        $dayType = $carbonDate->isWeekend() ? 'weekday_weekend' : 'weekday_weekend';

        return self::updateOrCreate(
            ['date' => $date],
            [
                'status' => 'booked',
                'booked_by' => $userId,
                'booked_at' => now(),
                'day_type' => $dayType,
                'price' => self::getDefaultPrice($date),
                'notes' => 'Booked by user ID ' . $userId,
            ]
        );
    }

    // Penentuan harga default
    private static function getDefaultPrice($date)
    {
        $carbonDate = Carbon::parse($date);
        return $carbonDate->isWeekend() ? 500000 : 300000;
    }
}