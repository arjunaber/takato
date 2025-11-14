<?php

// app/Http/Controllers/Admin/ShiftController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CashierShift;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User; // Pastikan model User diimpor

class ShiftController extends Controller
{
    /**
     * Menampilkan halaman Open/Close Shift.
     */
    public function index()
    {
        // Mendapatkan shift yang sedang aktif
        $activeShift = CashierShift::with('user')
            ->where('user_id', Auth::id())
            ->where('is_closed', false)
            ->first();

        // Mendapatkan riwayat shift yang sudah ditutup untuk tampilan
        $history = CashierShift::with('user')
            ->where('is_closed', true)
            ->orderByDesc('end_time')
            ->limit(10) // Tampilkan 10 shift terakhir
            ->get();

        // Catatan: Pastikan Anda memiliki view 'admin.shift.index'
        return view('admin.shift.index', compact('history', 'activeShift'));
    }

    /**
     * Membuka shift baru.
     */
    public function openShift(Request $request)
    {
        $request->validate([
            'initial_cash' => 'required|numeric|min:0',
        ]);

        // Cek apakah kasir sudah memiliki shift yang terbuka
        $existingShift = CashierShift::where('user_id', Auth::id())
            ->where('is_closed', false)
            ->first();

        if ($existingShift) {
            return response()->json(['error' => 'Anda sudah memiliki shift yang terbuka.'], 409);
        }

        $shift = CashierShift::create([
            'user_id' => Auth::id(),
            'start_time' => now(),
            'initial_cash' => $request->initial_cash,
            'is_closed' => false,
        ]);

        return response()->json(['message' => 'Shift berhasil dibuka.', 'shift' => $shift], 201);
    }

    /**
     * Menutup shift yang sedang berjalan.
     */
    public function closeShift(Request $request)
    {
        // Validasi input
        $request->validate([
            'shift_id' => 'required|exists:cashier_shifts,id',
            'closing_cash' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $shift = CashierShift::find($request->shift_id);

        if ($shift->is_closed) {
            return response()->json(['error' => 'Shift ini sudah ditutup.'], 400);
        }

        // 1. Ambil data transaksi yang terjadi selama shift ini
        // Kita hanya hitung Order yang berstatus 'completed' atau Order yang pembayarannya tunai dan split
        $transactions = Order::where('cashier_shift_id', $shift->id)
            ->where(function ($query) {
                // Selesaikan/hitung semua Order yang Completed (CASH/SPLIT)
                $query->where('status', 'completed')
                    // ATAU Order yang Pending tapi sudah dibayar (Paid Gateway/Midtrans Webhook)
                    ->orWhere('payment_status', 'paid');
            })
            ->get();

        // 2. Hitung total penjualan tunai dan non-tunai
        $systemCashSales = $transactions->where('payment_method', 'cash')->sum('total');
        $systemNonCashSales = $transactions->whereIn('payment_method', ['gateway', 'transfer', 'card'])->sum('total');

        $expectedCash = $shift->initial_cash + $systemCashSales;
        $cashDifference = $request->closing_cash - $expectedCash;

        // 3. Update dan tutup shift
        $shift->update([
            'end_time' => now(),
            'closing_cash' => $request->closing_cash,
            'system_cash_sales' => $systemCashSales,
            'system_noncash_sales' => $systemNonCashSales,
            'cash_difference' => $cashDifference,
            'notes' => $request->notes,
            'is_closed' => true,
        ]);

        return response()->json([
            'message' => 'Shift berhasil ditutup dan direkonsiliasi.',
            'report' => $shift
        ], 200);
    }

    /**
     * Mendapatkan shift yang sedang aktif
     */
    public function getActiveShift()
    {
        $shift = CashierShift::where('user_id', Auth::id())
            ->where('is_closed', false)
            ->first();

        return response()->json(['shift' => $shift]);
    }
}
