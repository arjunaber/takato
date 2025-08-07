<?php

namespace App\Http\Controllers;

use App\Models\GrandSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GrandScheduleController extends Controller
{
    public function index()
    {
        $schedules = GrandSchedule::orderBy('date', 'asc')->paginate(30);
        $dayTypes = GrandSchedule::dayTypes();
        $statuses = GrandSchedule::statuses();

        return view('admin.grand-schedules.index', compact('schedules', 'dayTypes', 'statuses'));
    }

    public function calendar()
    {
        return view('admin.grand-schedules.calendar');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date|unique:grand_schedules,date',
            'day_type' => 'required|in:weekday,weekend,holiday,special_event',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,booked,maintenance',
            'notes' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        GrandSchedule::create($validator->validated());

        return redirect()->route('admin.grand-schedules.index')
            ->with('success', 'Schedule created successfully.');
    }

    public function update(Request $request, GrandSchedule $grandSchedule)
    {
        $validator = Validator::make($request->all(), [
            'day_type' => 'required|in:weekday,weekend,holiday,special_event',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,booked,maintenance',
            'notes' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $grandSchedule->update($validator->validated());

        return redirect()->route('admin.grand-schedules.index')
            ->with('success', 'Schedule updated successfully.');
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'dates' => 'required|array',
            'dates.*' => 'date',
            'status' => 'required|in:available,booked,maintenance'
        ]);

        GrandSchedule::whereIn('date', $request->dates)
            ->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }

    public function getCalendarData(Request $request)
    {
        $start = $request->start;
        $end = $request->end;

        // Ambil semua schedule yang ada di database
        $existingSchedules = GrandSchedule::whereBetween('date', [$start, $end])
            ->get()
            ->keyBy(function ($item) {
                return $item->date->format('Y-m-d');
            });

        // Generate semua tanggal dalam range
        $allDates = [];
        $current = Carbon::parse($start);
        $endDate = Carbon::parse($end);

        while ($current <= $endDate) {
            $dateStr = $current->format('Y-m-d');
            $allDates[$dateStr] = true;
            $current->addDay();
        }

        // Gabungkan dengan data dari database
        $result = [];
        foreach ($allDates as $dateStr => $_) {
            if (isset($existingSchedules[$dateStr])) {
                // Jika ada di database, gunakan data tersebut
                $schedule = $existingSchedules[$dateStr];
                $result[] = $this->formatCalendarEvent($schedule);
            } else {
                // Jika tidak ada, buat default available
                $result[] = [
                    'title' => 'Rp 5.000.000', // Default price
                    'start' => $dateStr,
                    'color' => $this->getStatusColor('available'),
                    'extendedProps' => [
                        'day_type' => $this->getDefaultDayType($dateStr),
                        'status' => 'available',
                        'notes' => 'Auto-generated'
                    ]
                ];
            }
        }

        return response()->json($result);
    }

    private function formatCalendarEvent($schedule)
    {
        return [
            'title' => 'Rp ' . number_format($schedule->price),
            'start' => $schedule->date->format('Y-m-d'),
            'color' => $this->getStatusColor($schedule->status),
            'extendedProps' => [
                'day_type' => $schedule->day_type,
                'status' => $schedule->status,
                'notes' => $schedule->notes
            ]
        ];
    }

    private function getDefaultDayType($dateStr)
    {
        $date = Carbon::parse($dateStr);
        if ($date->isWeekend()) {
            return 'weekend';
        }
        return 'weekday';
    }

    private function getStatusColor($status)
    {
        switch ($status) {
            case 'booked':
                return '#EA5455'; // Red
            case 'maintenance':
                return '#FF9F43'; // Orange
            default:
                return '#28C76F'; // Green
        }
    }

    public function bulkStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dates' => 'required|array',
            'dates.*' => 'date',
            'day_type' => 'required|in:weekday_weekend,special_event',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,booked',
            'notes' => 'nullable|string|max:255',
            'booked_email' => 'nullable|email|required_if:status,booked',
            'booked_phone' => 'nullable|string|required_if:status,booked'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        $createdCount = 0;

        DB::beginTransaction();
        try {
            foreach ($validated['dates'] as $date) {
                $exists = GrandSchedule::where('date', $date)->exists();

                if (!$exists) {
                    $scheduleData = [
                        'date' => $date,
                        'day_type' => $validated['day_type'],
                        'price' => $validated['price'],
                        'status' => $validated['status'],
                        'notes' => $validated['notes'] ?? null
                    ];

                    // Jika status booked, tambahkan informasi booking
                    if ($validated['status'] === 'booked') {
                        $scheduleData['booked_at'] = now();
                        $scheduleData['booked_email'] = $validated['booked_email'] ?? null;
                        $scheduleData['booked_phone'] = $validated['booked_phone'] ?? null;
                    }

                    GrandSchedule::create($scheduleData);
                    $createdCount++;
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Successfully created {$createdCount} new schedules",
                'created_count' => $createdCount
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error creating schedules: ' . $e->getMessage()
            ], 500);
        }
    }

    public function book(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'checkin_date' => 'required|date|after_or_equal:today',
            'checkout_date' => 'required|date|after:checkin_date',
            'email' => 'required|email',
            'phone' => 'required|string|min:10',
            'guests' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $dates = [];
            $current = Carbon::parse($request->checkin_date);
            $end = Carbon::parse($request->checkout_date);
            $totalPrice = 0;

            while ($current < $end) {
                $dateStr = $current->format('Y-m-d');
                $schedule = GrandSchedule::where('date', $dateStr)->first();

                if (!$schedule) {
                    // Determine day type and price for new dates
                    $dayType = 'weekday_weekend'; // Default value
                    $price = 5000000; // Default weekday price

                    // Check if this is a special event date (you might have other logic here)
                    $isSpecialEvent = false; // Add your special event detection logic

                    if ($isSpecialEvent) {
                        $dayType = 'special_event';
                        $price = 7000000; // Special event price
                    } elseif ($current->isWeekend()) {
                        $price = 6000000; // Weekend price
                    }

                    $schedule = GrandSchedule::create([
                        'date' => $dateStr,
                        'day_type' => $dayType,
                        'price' => $price,
                        'status' => 'available'
                    ]);
                }

                if ($schedule->status === 'booked') {
                    throw new \Exception("Date {$dateStr} is already booked");
                }

                $totalPrice += $schedule->price;
                $dates[] = $dateStr;
                $current->addDay();
            }

            // Update booking information
            GrandSchedule::whereIn('date', $dates)
                ->update([
                    'status' => 'booked',
                    'booked_at' => now(),
                    'booked_email' => $request->email,
                    'booked_phone' => $request->phone,
                    'notes' => "Booking for {$request->guests} guests"
                ]);

            $bookingId = 'BK-' . strtoupper(uniqid());

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Booking successful',
                'booking_id' => $bookingId,
                'total_price' => $totalPrice,
                'payment_options' => $this->preparePaymentOptions($totalPrice, $bookingId)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    private function preparePaymentOptions($amount, $bookingId)
    {
        // This would be replaced with actual Midtrans integration
        return [
            'midtrans' => [
                'client_key' => config('services.midtrans.client_key'),
                'token' => 'MOCK_SNAP_TOKEN_' . $bookingId,
                'amount' => $amount
            ]
        ];
    }
}