<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
        $paymentMethodBreakdown = collect();
        $employeeSalesPerformance = collect();
        $peakHourSales = collect();
        $chartPeriodType = 'day'; // Default

        // === 1. TENTUKAN RENTANG TANGGAL ===
        $startDate = Carbon::parse($request->input('start_date', Carbon::today()))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date', Carbon::today()))->endOfDay();
        $dateDiff = $startDate->diffInDays($endDate);


        // === Tentukan Period Type untuk Chart Tren ===
        if ($dateDiff <= 1) {
            $chartPeriodType = 'hour';
            $groupByFormat = '%H:00'; // Group by Hour
            $periodStep = '1 hour';
        } elseif ($dateDiff <= 14) {
            $chartPeriodType = 'day';
            $groupByFormat = '%Y-%m-%d'; // Group by Day
            $periodStep = '1 day';
        } elseif ($dateDiff <= 90) {
            $chartPeriodType = 'week';
            $groupByFormat = '%Y-%u'; // Group by Year-WeekNumber
            $periodStep = '1 week';
        } else {
            $chartPeriodType = 'month';
            $groupByFormat = '%Y-%m'; // Group by Year-Month
            $periodStep = '1 month';
        }


        // === HANYA JALANKAN QUERY SENSITIF JIKA USER ADALAH OWNER ===
        if ($isOwner) {
            // FIX: Kualifikasi Kolom di Base Query untuk menghindari Ambiguity pada JOIN selanjutnya
            $baseQuery = Order::where('orders.status', 'completed')
                ->whereBetween('orders.created_at', [$startDate, $endDate]);

            // === 2. DATA UNTUK KARTU KPI ===
            $totalSales = (clone $baseQuery)->sum('total');
            $totalOrders = (clone $baseQuery)->count();
            $avgOrderValue = ($totalOrders > 0) ? $totalSales / $totalOrders : 0;

            $totalDiscountsGiven = OrderItem::whereHas('order', function ($query) use ($startDate, $endDate) {
                // Kualifikasi di sini juga untuk jaga-jaga
                $query->where('orders.status', 'completed')->whereBetween('orders.created_at', [$startDate, $endDate]);
            })->sum('discount_amount');


            // === 3. DATA GRAFIK PENJUALAN (LINE CHART) - DYNAMIC PERIOD ===
            $salesData = (clone $baseQuery)
                ->select(
                    DB::raw("DATE_FORMAT(orders.created_at, '{$groupByFormat}') as period"),
                    DB::raw('SUM(orders.total) as daily_sales')
                )
                ->groupBy('period')
                ->orderBy('period', 'ASC')
                ->get();

            $salesDataMap = $salesData->pluck('daily_sales', 'period');
            $periodGenerator = CarbonPeriod::create($startDate, $periodStep, $endDate);

            foreach ($periodGenerator as $date) {
                $periodKey = $this->getPeriodKey($date, $chartPeriodType);
                $label = $this->getLabelFormat($date, $chartPeriodType);

                if ($chartPeriodType === 'hour') {
                    break;
                }

                $chartLabels[] = $label;
                $chartData[] = $salesDataMap->get($periodKey, 0);
            }

            // Logika khusus untuk tren per jam (00:00 - 23:00)
            if ($chartPeriodType === 'hour') {
                $chartLabels = [];
                $chartData = [];
                for ($h = 0; $h < 24; $h++) {
                    $hour = str_pad($h, 2, '0', STR_PAD_LEFT);
                    $key = $hour . ':00';
                    $chartLabels[] = $key;
                    $chartData[] = $salesDataMap->get($key, 0);
                }
            }


            // === 4. DATA GRAFIK KATEGORI (PIE CHART) ===
            $categorySales = OrderItem::whereHas('order', function ($query) use ($startDate, $endDate) {
                $query->where('orders.status', 'completed')->whereBetween('orders.created_at', [$startDate, $endDate]);
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
                $query->where('orders.status', 'completed')->whereBetween('orders.created_at', [$startDate, $endDate]);
            })
                ->select('item_name', DB::raw('SUM(quantity) as total_sold'))
                ->groupBy('item_name')
                ->orderBy('total_sold', 'DESC')
                ->limit(5)
                ->get();

            // === 6. DATA METODE PEMBAYARAN ===
            $paymentMethodBreakdown = (clone $baseQuery)
                ->select('payment_method', DB::raw('SUM(orders.total) as total_sales'))
                ->groupBy('payment_method')
                ->orderBy('total_sales', 'DESC')
                ->get();

            // === 7. DATA KINERJA KASIR/KARYAWAN (FIX SHIFT ID) ===
            $employeeSalesPerformance = (clone $baseQuery)
                ->join('users', 'orders.user_id', '=', 'users.id')
                // 1. Lakukan JOIN ke tabel cashier_shifts
                ->leftJoin('cashier_shifts', 'orders.cashier_shift_id', '=', 'cashier_shifts.id')
                ->select(
                    'users.name as employee_name',
                    DB::raw('orders.cashier_shift_id as shift_id'),
                    DB::raw('SUM(orders.total) as total_sales'),
                    DB::raw('COUNT(orders.id) as total_transactions'),
                    // 2. Ambil start_time dan end_time dari tabel shift
                    'cashier_shifts.start_time',
                    'cashier_shifts.end_time'
                )
                // 3. Tambahkan kolom waktu ke GROUP BY
                ->groupBy('users.name', 'orders.cashier_shift_id', 'cashier_shifts.start_time', 'cashier_shifts.end_time')
                ->orderBy('users.name', 'ASC')
                ->orderBy('shift_id', 'ASC')
                ->limit(5)
                ->get();

            // === 8. DATA PENJUALAN PUNCAK (PEAK HOUR) ===
            $hourlySalesData = (clone $baseQuery)
                ->select(DB::raw('HOUR(orders.created_at) as hour'), DB::raw('SUM(orders.total) as hourly_sales'))
                ->groupBy('hour')
                ->orderBy('hour', 'ASC')
                ->get()
                ->pluck('hourly_sales', 'hour');

            $peakHourSales = collect();
            for ($h = 0; $h < 24; $h++) {
                $key = str_pad($h, 2, '0', STR_PAD_LEFT) . ':00';
                $peakHourSales->put($key, $hourlySalesData->get($h, 0));
            }
        }

        // === 9. DATA BAHAN BAKU (Untuk Permintaan Stok) ===
        $allIngredients = Ingredient::select('id', 'name', 'unit', 'stock', 'unit_price')->orderBy('name')->get();

        // === 10. KIRIM SEMUA DATA KE VIEW ===
        return view('admin.dashboard', [
            'totalSales' => $totalSales,
            'totalOrders' => $totalOrders,
            'avgOrderValue' => $avgOrderValue,
            'totalDiscountsGiven' => $totalDiscountsGiven,

            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'chartPeriodType' => $chartPeriodType,
            'categoryChartLabels' => $categoryChartLabels,
            'categoryChartData' => $categoryChartData,

            'topProducts' => $topProducts,
            'paymentMethodBreakdown' => $paymentMethodBreakdown,
            'employeeSalesPerformance' => $employeeSalesPerformance,
            'peakHourSales' => $peakHourSales,

            'allIngredients' => $allIngredients,

            'startDate' => $startDate->toDateString(),
            'endDate' => $endDate->toDateString(),
            'isOwner' => $isOwner,
            'isAdmin' => $isAdmin,
        ]);
    }

    // Fungsi Pembantu untuk mendapatkan Key periode untuk salesDataMap
    private function getPeriodKey(Carbon $date, string $periodType): string
    {
        switch ($periodType) {
            case 'hour':
                return $date->format('H:00');
            case 'day':
                return $date->format('Y-m-d');
            case 'week':
                return $date->format('Y') . '-' . $date->weekOfYear;
            case 'month':
                return $date->format('Y-m');
            default:
                return $date->toDateString();
        }
    }

    // Fungsi Pembantu untuk mendapatkan Label periode untuk chart
    private function getLabelFormat(Carbon $date, string $periodType): string
    {
        switch ($periodType) {
            case 'hour':
                return $date->format('H:i');
            case 'day':
                return $date->format('d M');
            case 'week':
                return $date->startOfWeek()->format('d M');
            case 'month':
                return $date->format('M Y');
            default:
                return $date->toDateString();
        }
    }
}
