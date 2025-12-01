<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class GrandSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'day_type',
        'price',
        'status',
        'notes',
        'booked_email', // Gunakan kolom yang sudah ada
        'booked_phone', // Gunakan kolom yang sudah ada
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public static function dayTypes()
    {
        return [
            'weekday' => 'Weekday',
            'weekend' => 'Weekend',
            'special' => 'Special Event'
        ];
    }

    public static function statuses()
    {
        return [
            'available' => 'Available',
            'booked' => 'Booked',
            'event' => 'Event / Blocked'
        ];
    }

    public static function getPriceForDate($date)
    {
        $carbonDate = Carbon::parse($date);
        return $carbonDate->isWeekend() ? 5000000 : 3000000;
    }
}
