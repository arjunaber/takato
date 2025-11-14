<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GrossProfitReportExport;
use Illuminate\Database\Query\Builder as QueryBuilder;


class ReportController extends Controller
{
    /**
     * Menampilkan formulir filter dan data Laporan Analisis Laba Kotor.
     */
    public function grossProfitIndex(Request $request)
    {
        // 1. Ambil input filter dari user
        $shiftId = $request->input('shift_id');
        $productId = $request->input('product_id');

        // KOREKSI: Pastikan selalu Carbon object dari input/default
        $startDate = Carbon::parse($request->input('start_date', Carbon::today()->toDateString()))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date', Carbon::today()->toDateString()))->endOfDay();

        // 2. Query Kompleks untuk Analisis Laba Kotor (Gross Profit)
        $reportData = $this->runGrossProfitQuery($startDate, $endDate, $shiftId, $productId);

        // 3. Ambil data untuk dropdown filter (shift dan produk)
        $shifts = DB::table('cashier_shifts')->select('id', 'start_time', 'end_time')->get();
        $products = DB::table('products')->select('id', 'name')->get();

        return view('admin.reports.gross_profit_index', compact('reportData', 'startDate', 'endDate', 'shiftId', 'productId', 'shifts', 'products'));
    }


    public function exportGrossProfit(Request $request)
    {
        $type = $request->get('type');

        // KOREKSI: Pastikan selalu Carbon object dari input/default
        $startDate = Carbon::parse($request->input('start_date', Carbon::today()->toDateString()))->startOfDay();
        $endDate = Carbon::parse($request->input('end_date', Carbon::today()->toDateString()))->endOfDay();

        $shiftId = $request->input('shift_id');
        $productId = $request->input('product_id');

        $dataToExport = $this->runGrossProfitQuery($startDate, $endDate, $shiftId, $productId);

        if ($type === 'excel') {
            return Excel::download(new GrossProfitReportExport($dataToExport), 'laporan-laba-kotor-' . time() . '.xlsx');
        } elseif ($type === 'pdf') {
            return $this->exportGrossProfitPdf($dataToExport, $startDate, $endDate);
        }

        return redirect()->back()->with('error', 'Tipe export tidak valid.');
    }

    /**
     * Menjalankan query kompleks untuk menghitung Gross Profit.
     * Menggunakan unit_price_final (Revenue) dan COGS berbasis Resep/Ingredient.
     */
    private function runGrossProfitQuery($startDate, $endDate, $shiftId, $productId)
    {
        // Sub-query COGS:
        // Menghitung Biaya Bahan Baku per Varian (menggunakan resep dan harga bahan baku)
        $cogsSubQuery = DB::table('recipe_items')
            // Ambil harga dari tabel ingredients
            ->join('ingredients', 'recipe_items.ingredient_id', '=', 'ingredients.id')
            ->select(
                'recipe_items.variant_id',
                // PHP Logic: quantity_used * unit_price
                DB::raw('SUM(recipe_items.quantity_used * ingredients.unit_price) as item_cogs_base')
            )
            ->groupBy('recipe_items.variant_id');

        return DB::table('orders')
            // JOIN UTAMA
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('cashier_shifts', 'orders.cashier_shift_id', '=', 'cashier_shifts.id')

            // JOIN COGS: Menghubungkan COGS basis resep ke order item melalui variant_id
            ->leftJoin(DB::raw('(' . $cogsSubQuery->toSql() . ') as cogs'), 'cogs.variant_id', '=', 'order_items.variant_id')
            ->mergeBindings($cogsSubQuery)

            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', 'completed')

            // Filter Opsional
            ->when($shiftId, fn(QueryBuilder $q) => $q->where('orders.cashier_shift_id', $shiftId))
            ->when($productId, fn(QueryBuilder $q) => $q->where('order_items.product_id', $productId))

            ->select(
                'orders.cashier_shift_id as shift_id',
                'products.name as product_name',
                DB::raw('SUM(order_items.quantity) as total_quantity'),

                // Revenue: Quantity * Harga Jual Final
                DB::raw('SUM(order_items.quantity * order_items.unit_price_final) as total_revenue'),

                // COGS: Quantity * COGS Base per item (Menggunakan IFNULL karena ada item tanpa resep)
                DB::raw('SUM(order_items.quantity * IFNULL(cogs.item_cogs_base, 0)) as total_cogs'),

                // Gross Profit: Revenue - COGS
                DB::raw('SUM(order_items.quantity * order_items.unit_price_final) - SUM(order_items.quantity * IFNULL(cogs.item_cogs_base, 0)) as gross_profit')
            )
            // Group By berdasarkan shift dan nama produk (SKU dihapus)
            ->groupBy('orders.cashier_shift_id', 'products.name')
            ->orderBy('orders.cashier_shift_id')
            ->orderByDesc('gross_profit')
            ->get();
    }

    private function exportGrossProfitPdf($dataToExport, $startDate, $endDate)
    {
        // Hitung Grand Total di Controller
        $grandTotal = $dataToExport->sum('gross_profit');
        $grandRevenue = $dataToExport->sum('total_revenue');
        $grandCogs = $dataToExport->sum('total_cogs');

        // Menggunakan app() binding
        $pdf = app('dompdf.wrapper');

        // Render view PDF dengan data lengkap
        $pdf->loadView('admin.reports.gross_profit_pdf', [
            'reportData' => $dataToExport,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'grandTotal' => $grandTotal,
            'grandRevenue' => $grandRevenue,
            'grandCogs' => $grandCogs,
        ]);

        // Mengatur agar PDF menggunakan format Landscape
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('laporan-laba-kotor-' . time() . '.pdf');
    }
}
