<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Booking;
use App\Models\AvailableDate;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function availableDates()
    {
        return $this->hasMany(AvailableDate::class);
    }
}