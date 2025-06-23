<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Unit;
use App\Models\Booking;

class GrandScheduleController extends Controller
{
    public function index(Request $request)
    {
        $units = Unit::all();
        $month = $request->input('month', date('Y-m'));
        $unitId = $request->input('unit');

        // Generate calendar
        $startDate = Carbon::parse($month)->startOfMonth()->startOfWeek();
        $endDate = Carbon::parse($month)->endOfMonth()->endOfWeek();

        $calendar = [];
        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            $bookings = Booking::query()->when($unitId, fn($q) => $q->where('unit_id', $unitId))
                ->whereDate('check_in', '<=', $currentDate)->whereDate('check_out', '>=', $currentDate)
                ->with('unit')
                ->get();

            $calendar[] = [
                'date' => $currentDate->toDateString(),
                'day' => $currentDate->day,
                'is_current_month' => $currentDate->format('Y-m') === $month,
                'is_today' => $currentDate->isToday(),
                'status' => $bookings->isEmpty() ? 'available' : 'booked',
                'bookings' => $bookings
            ];

            $currentDate->addDay();
        }

        return view('auth.grandschedule.index', compact('units', 'month', 'calendar'));
    }
}