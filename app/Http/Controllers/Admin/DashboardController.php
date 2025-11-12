<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // <<< TAMBAHKAN INI
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // === 0. CEK PERAN ===
        $user = Auth::user();
        $isOwner = $user->isOwner(); // TRUE jika role = 'owner'
        $isAdmin = $user->isAdmin(); // TRUE jika role = 'admin'

        // Inisialisasi variabel sensitif
        $totalSales = 0;
        $totalOrders = 0;
        $avgOrderValue = 0;
        $totalDiscountsGiven = 0;
        $chartLabels = [];
        $chartData = [];
        $categoryChartLabels = [];
        $categoryChartData = [];
        $topProducts = collect();

        // === 1. TENTUKAN RENTANG TANGGAL (Selalu diperlukan untuk filter) ===
        $startDate = Carbon::parse($request->input('start_date', Carbon::today()))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date', Carbon::today()))->endOfDay();


        // === HANYA JALANKAN QUERY SENSITIF JIKA USER ADALAH OWNER ===
        if ($isOwner) {
            // === 2. DATA UNTUK KARTU KPI ===
            $kpiQuery = Order::where('status', 'completed')
                ->whereBetween('created_at', [$startDate, $endDate]);

            $totalSales = (clone $kpiQuery)->sum('total');
            $totalOrders = (clone $kpiQuery)->count();
            $avgOrderValue = ($totalOrders > 0) ? $totalSales / $totalOrders : 0;

            $totalDiscountsGiven = OrderItem::whereHas('order', function ($query) use ($startDate, $endDate) {
                $query->where('status', 'completed')
                    ->whereBetween('created_at', [$startDate, $endDate]);
            })->sum('discount_amount');


            // === 3. DATA GRAFIK PENJUALAN (LINE CHART) ===
            $salesData = Order::where('status', 'completed')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as daily_sales'))
                ->groupBy('date')->orderBy('date', 'ASC')->get()->pluck('daily_sales', 'date');

            $period = CarbonPeriod::create($startDate, '1 day', $endDate);
            $dateDiff = $startDate->diffInDays($endDate);
            $step = $dateDiff > 14 ? 3 : 1;

            foreach ($period as $date) {
                $dateString = $date->format('Y-m-d');
                if ($date->day % $step == 0 || $dateDiff <= 14) {
                    $chartLabels[] = $date->format('d M');
                    $chartData[] = $salesData->get($dateString, 0);
                }
            }

            // === 4. DATA GRAFIK KATEGORI (PIE CHART) ===
            $categorySales = OrderItem::whereHas('order', function ($query) use ($startDate, $endDate) {
                $query->where('status', 'completed')
                    ->whereBetween('created_at', [$startDate, $endDate]);
            })
                ->whereNotNull('product_id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->select('categories.name as category_name', DB::raw('SUM(order_items.subtotal) as category_sales'))
                ->groupBy('categories.name')
                ->orderBy('category_sales', 'DESC')
                ->limit(5)
                ->get();

            $categoryChartLabels = $categorySales->pluck('category_name');
            $categoryChartData = $categorySales->pluck('category_sales');

            // === 5. DATA PRODUK TERLARIS ===
            $topProducts = OrderItem::whereHas('order', function ($query) use ($startDate, $endDate) {
                $query->where('status', 'completed')
                    ->whereBetween('created_at', [$startDate, $endDate]);
            })
                ->select('item_name', DB::raw('SUM(quantity) as total_sold'))
                ->groupBy('item_name')
                ->orderBy('total_sold', 'DESC')
                ->limit(5)
                ->get();
        }

        // === 6. DATA BAHAN BAKU (Dibagi ke semua admin/kasir untuk permintaan stok) ===
        $allIngredients = Ingredient::orderBy('name')->get();

        // === 7. KIRIM SEMUA DATA KE VIEW ===
        return view('admin.dashboard', [
            'totalSales' => $totalSales,
            'totalOrders' => $totalOrders,
            'avgOrderValue' => $avgOrderValue,
            'totalDiscountsGiven' => $totalDiscountsGiven,

            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'categoryChartLabels' => $categoryChartLabels,
            'categoryChartData' => $categoryChartData,

            'topProducts' => $topProducts,
            'allIngredients' => $allIngredients,

            'startDate' => $startDate->toDateString(),
            'endDate' => $endDate->toDateString(),
            'isOwner' => $isOwner, // <<< Status Owner dikirim
            'isAdmin' => $isAdmin, // <<< Status Admin dikirim
        ]);
    }
}
