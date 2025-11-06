<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; // <-- Import Model Order
use Carbon\Carbon; // <-- Import Carbon untuk mengelola tanggal

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard dengan data penjualan yang difilter.
     */
    public function index(Request $request)
    {
        // Tentukan tanggal. Default-nya adalah hari ini.
        $filterDate = $request->input('date', now()->format('Y-m-d'));

        // Ubah tanggal string menjadi objek Carbon
        $date = Carbon::parse($filterDate);

        // Ambil data order HANYA untuk tanggal yang dipilih
        $query = Order::whereDate('created_at', $date)
                      ->where('status', 'completed'); // Hanya hitung yang selesai

        // 1. Hitung Total Penjualan
        $totalSales = $query->sum('total');

        // 2. Hitung Jumlah Transaksi
        $totalTransactions = $query->count();
        
        // 3. Ambil daftar 10 transaksi terakhir di hari itu
        $latestOrders = $query->latest()->take(10)->get();

        // 4. Kirim semua data ke view dashboard
        return view('admin.dashboard', [
            'totalSales' => $totalSales,
            'totalTransactions' => $totalTransactions,
            'latestOrders' => $latestOrders,
            'filterDate' => $date, // Kirim tanggal untuk ditampilkan di kalender filter
        ]);
    }
}