<?php

namespace App\Http\Controllers;

use App\Models\GrandSchedule;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GrandScheduleController extends Controller
{
    // --- ADMIN SECTION ---

    public function index()
    {
        // Ambil data jadwal
        $schedules = GrandSchedule::orderBy('date', 'desc')->paginate(30);

        // AMBIL DATA REFERENSI DARI MODEL
        $dayTypes = GrandSchedule::dayTypes();
        $statuses = GrandSchedule::statuses();

        // Kirim ke view menggunakan compact
        return view('admin.grand-schedules.index', compact('schedules', 'dayTypes', 'statuses'));
    }

    public function calendar()
    {
        // Tampilan kalender admin
        return view('admin.grand-schedules.calendar');
    }

    // Fungsi create single schedule (dari tombol Add di index)
    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date|unique:grand_schedules,date',
            'day_type' => 'required',
            'price' => 'required|numeric',
            'status' => 'required',
            'notes' => 'nullable|string',
            'booked_email' => 'nullable|required_if:status,booked|email',
            'booked_phone' => 'nullable|required_if:status,booked|string',
        ]);

        GrandSchedule::create($data);

        return redirect()->route('admin.grand-schedules.index')
            ->with('success', 'Schedule created successfully.');
    }

    // Fungsi update single schedule (dari tombol Edit di index)
    public function update(Request $request, GrandSchedule $grandSchedule)
    {
        $data = $request->validate([
            'day_type' => 'required',
            'price' => 'required|numeric',
            'status' => 'required',
            'notes' => 'nullable|string',
            'booked_email' => 'nullable|required_if:status,booked|email',
            'booked_phone' => 'nullable|required_if:status,booked|string',
        ]);

        $grandSchedule->update($data);

        return redirect()->route('admin.grand-schedules.index')
            ->with('success', 'Schedule updated successfully.');
    }

    // Fungsi untuk menyimpan booking manual BANYAK TANGGAL SEKALIGUS (Bulk Store)
    public function bulkStore(Request $request)
    {
        $request->validate([
            'dates' => 'required|array',
            'status' => 'required|in:available,booked,event', // Update status sesuai model
            'price' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'booked_email' => 'nullable|required_if:status,booked|email',
            'booked_phone' => 'nullable|required_if:status,booked|string',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->dates as $dateStr) {
                // Hapus data lama jika ada, lalu buat baru (upsert logic)
                GrandSchedule::where('date', $dateStr)->delete();

                $dayType = Carbon::parse($dateStr)->isWeekend() ? 'weekend' : 'weekday';
                $price = $request->price ?? GrandSchedule::getPriceForDate($dateStr);

                GrandSchedule::create([
                    'date' => $dateStr,
                    'day_type' => $request->day_type ?? $dayType, // Gunakan input day_type jika ada
                    'price' => $price,
                    'status' => $request->status,
                    'notes' => $request->notes,
                    'booked_email' => $request->booked_email, // Gunakan Email
                    'booked_phone' => $request->booked_phone, // Gunakan Phone
                ]);
            }
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // --- PUBLIC/USER SECTION ---

    public function userView()
    {
        // Halaman booking untuk user dengan tema retreat.blade.php
        return view('booking');
    }

    public function getCalendarData(Request $request)
    {
        $start = $request->start;
        $end = $request->end;

        $schedules = GrandSchedule::whereBetween('date', [$start, $end])->get();

        $events = [];

        foreach ($schedules as $sched) {
            // --- LOGIKA WARNA DIPERBAIKI DISINI ---

            // 1. Jika Status BOOKED -> Merah
            if ($sched->status === 'booked') {
                $color = '#ef4444';
                $title = 'Booked';
                $className = 'bg-booked';

                // 2. Jika Status EVENT atau Day Type SPECIAL EVENT -> KUNING (EAB308)
            } elseif ($sched->status === 'event' || $sched->day_type === 'special_event') {
                $color = '#EAB308'; // <--- Warna Gold sesuai request
                $title = 'Event / Special';
                $className = 'bg-event';

                // 3. Sisanya (Available) -> Hijau
            } else {
                $color = '#28a745';
                $title = 'Available';
                $className = 'bg-available';
            }

            // Logic privasi admin
            if ($request->is_admin && $sched->status == 'booked') {
                $contactInfo = $sched->booked_email ?? $sched->booked_phone ?? 'No Contact';
                $title .= " ($contactInfo)";
            } elseif ($request->is_admin && ($sched->status == 'event' || $sched->day_type == 'special_event')) {
                $title .= " (" . ($sched->notes ?? 'Special Event') . ")";
            }

            $events[] = [
                'title' => $title,
                'start' => $sched->date->format('Y-m-d'),
                'display' => 'background',
                'backgroundColor' => $color, // Ini akan mengirim #EAB308 ke frontend
                'classNames' => [$className],
                'extendedProps' => [
                    'status' => $sched->status,
                    'price' => $sched->price,
                    'day_type' => $sched->day_type,
                    // Kita kirim flag khusus is_event untuk validasi frontend
                    'is_event' => ($sched->status === 'event' || $sched->day_type === 'special_event')
                ]
            ];
        }

        return response()->json($events);
    }

    // API Kalkulator Harga Otomatis
    public function calculatePrice(Request $request)
    {
        $dates = $request->dates;
        if (empty($dates)) return response()->json(['total' => 0]);

        $total = 0;
        $details = [];

        foreach ($dates as $dateStr) {
            // Cek validasi booking/event (sudah ada sebelumnya)
            $existing = GrandSchedule::where('date', $dateStr)
                ->whereIn('status', ['booked']) // Event boleh dihitung harganya, Booked tidak
                ->first();

            if ($existing) {
                return response()->json(['error' => "Tanggal $dateStr sudah terbooking!"], 422);
            }

            // Ambil data schedule
            $schedule = GrandSchedule::where('date', $dateStr)->first();

            // Logika Harga
            $price = $schedule ? $schedule->price : GrandSchedule::getPriceForDate($dateStr);

            // --- LOGIKA LABEL UNTUK FRONTEND ---
            $carbonDate = Carbon::parse($dateStr);
            $label = 'Weekday';
            $labelColor = 'green'; // Default

            // Prioritas 1: Special Event / Event Status
            if ($schedule && ($schedule->status === 'event' || $schedule->day_type === 'special_event')) {
                $label = 'Special Event';
                $labelColor = 'gold'; // Untuk CSS di frontend
            }
            // Prioritas 2: Weekend
            elseif ($carbonDate->isWeekend()) {
                $label = 'Weekend';
                $labelColor = 'orange';
            }

            $total += $price;

            $details[] = [
                'date' => $carbonDate->translatedFormat('D, d M Y'), // Format cantik: Senin, 12 Des 2025
                'raw_date' => $dateStr,
                'price' => $price,
                'formatted' => number_format($price, 0, ',', '.'),
                'label' => $label,       // Kirim Label
                'color' => $labelColor   // Kirim Kode Warna
            ];
        }

        return response()->json([
            'total' => $total,
            'total_formatted' => number_format($total, 0, ',', '.'),
            'details' => $details // Array ini yang akan kita loop di frontend
        ]);
    }
}
