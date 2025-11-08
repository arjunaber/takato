<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // <-- 1. TAMBAHKAN INI
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // === 1. TENTUKAN RENTANG TANGGAL ===
        // Ambil dari request, atau set default ke "Hari Ini"
        $startDate = Carbon::parse($request->input('start_date', Carbon::today()))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date', Carbon::today()))->endOfDay();

        // === 2. DATA UNTUK KARTU KPI (Key Performance Indicators) ===
        $kpiQuery = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate]);

        $totalSales = (clone $kpiQuery)->sum('total');
        $totalOrders = (clone $kpiQuery)->count();
        $avgOrderValue = ($totalOrders > 0) ? $totalSales / $totalOrders : 0;


        // === 3. DATA UNTUK GRAFIK PENJUALAN ===
        $chartLabels = [];
        $chartData = [];
        $dateDiff = $startDate->diffInDays($endDate);

        if ($dateDiff <= 31) {
            // JIKA RENTANG < 31 HARI: Tampilkan harian
            $salesData = Order::where('status', 'completed')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as sales'))
                ->groupBy('date')->orderBy('date', 'ASC')->get()->pluck('sales', 'date');

            $period = CarbonPeriod::create($startDate, '1 day', $endDate);
            foreach ($period as $date) {
                $chartLabels[] = $date->format('d M'); // Cth: "09 Nov"
                $chartData[] = $salesData->get($date->format('Y-m-d'), 0); // Ambil data, jika tidak ada = 0
            }
        } else {
            // JIKA RENTANG > 31 HARI: Tampilkan bulanan
            $salesData = Order::where('status', 'completed')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"), DB::raw('SUM(total) as sales'))
                ->groupBy('month')->orderBy('month', 'ASC')->get()->pluck('sales', 'month');

            $period = CarbonPeriod::create($startDate->startOfMonth(), '1 month', $endDate->endOfMonth());
            foreach ($period as $date) {
                $chartLabels[] = $date->format('M Y'); // Cth: "Nov 2025"
                $chartData[] = $salesData->get($date->format('Y-m'), 0);
            }
        }

        // === 4. DATA UNTUK DAFTAR "TOP SELLING" ===
        $topProducts = OrderItem::whereHas('order', function ($query) use ($startDate, $endDate) {
            $query->where('status', 'completed')
                ->whereBetween('created_at', [$startDate, $endDate]);
        })
            ->select('item_name', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('item_name')
            ->orderBy('total_sold', 'DESC')
            ->limit(5)
            ->get();

        // === 5. DATA UNTUK DAFTAR "STOK MENIPIS" ===
        // (Stok tidak terpengaruh filter tanggal)
        $lowStockItems = Ingredient::where('stock', '<=', 20)
            ->orderBy('stock', 'ASC')
            ->limit(5)
            ->get();

        // === 6. KIRIM SEMUA DATA KE VIEW ===
        return view('admin.dashboard', [
            'totalSales' => $totalSales, // <-- Nama diubah
            'totalOrders' => $totalOrders, // <-- Nama diubah
            'avgOrderValue' => $avgOrderValue, // <-- Nama diubah

            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'topProducts' => $topProducts,
            'lowStockItems' => $lowStockItems,

            // Kirim tanggal kembali ke view untuk mengisi form filter
            'startDate' => $startDate->toDateString(), // cth: "2025-11-09"
            'endDate' => $endDate->toDateString(),
        ]);
    }
}
