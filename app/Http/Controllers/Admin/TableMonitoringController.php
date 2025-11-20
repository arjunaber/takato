<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Table;
use Illuminate\Support\Facades\Log;

class TableMonitoringController extends Controller
{
    /**
     * Menampilkan daftar semua meja (Monitoring View).
     * LOGIKA: Hanya tampilkan order yang PAID sebagai occupied
     */
    public function index()
    {
        try {
            // LOAD DATA: Eager load activeOrder tanpa filter aneh-aneh
            $tables = Table::with(['activeOrder.orderItems'])
                ->orderBy('area')
                ->orderBy('name')
                ->get();

            // Grouping untuk tampilan per area (jika perlu)
            $tablesByArea = $tables->groupBy('area');

            // STATISTIK: Hitung ulang berdasarkan logika "Real" (Hanya Order PAID = Occupied)
            $stats = [
                'total' => $tables->count(),

                // Available = Status meja available DAN tidak ada order PAID yang nempel
                'available' => $tables->filter(function ($t) {
                    $paidOrder = $t->activeOrder && $t->activeOrder->payment_status === 'paid';
                    return $t->status === 'available' && !$paidOrder;
                })->count(),

                // Occupied = Status meja occupied ATAU ada order PAID (BUKAN unpaid)
                'occupied' => $tables->filter(function ($t) {
                    $paidOrder = $t->activeOrder && $t->activeOrder->payment_status === 'paid';
                    return $t->status === 'occupied' || $paidOrder;
                })->count(),

                'cleaning' => $tables->where('status', 'cleaning')->count(),
            ];

            $areas = $tables->pluck('area')->unique()->sort();

            return view('admin.tables.monitor', compact('tables', 'tablesByArea', 'stats', 'areas'));
        } catch (\Exception $e) {
            Log::error('TableMonitoringController Index Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat data meja.');
        }
    }

    /**
     * Get tables filtered by area (AJAX).
     * Endpoint ini dipanggil oleh Javascript untuk refresh data real-time.
     * HANYA menampilkan order dengan status PAID
     */
    public function getByArea(Request $request)
    {
        try {
            $area = $request->get('area');

            $query = Table::with(['activeOrder.orderItems']);

            if ($area && $area !== 'all') {
                $query->where('area', $area);
            }

            $tables = $query->orderBy('name')->get();

            return response()->json([
                'success' => true,
                'tables' => $tables->map(function ($table) {

                    // --- LOGIKA SEDERHANA: HANYA PAID ---

                    // 1. Cek apakah ada order yang MENEMPEL DAN berstatus PAID?
                    $order = $table->activeOrder;
                    $hasPaidOrder = $order && $order->payment_status === 'paid';

                    // 2. Tentukan Status Tampilan
                    if ($hasPaidOrder) {
                        // Jika ada order PAID -> PASTI OCCUPIED
                        $displayStatus = 'occupied';
                    } else {
                        // Jika tidak ada order PAID -> Ikuti status meja (available/cleaning)
                        $displayStatus = $table->status;
                    }

                    return [
                        'id' => $table->id,
                        'name' => $table->name,
                        'capacity' => $table->capacity,
                        'status' => $displayStatus,
                        'payment_status' => $hasPaidOrder ? $order->payment_status : null,
                        'area' => $table->area,
                        'position_x' => $table->position_x,
                        'position_y' => $table->position_y,
                        'shape' => $table->shape,
                    ];
                })
            ], 200);
        } catch (\Exception $e) {
            Log::error('TableMonitoringController getByArea Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error loading data'], 500);
        }
    }

    /**
     * Mengambil detail pesanan (via AJAX) untuk ditampilkan di Side Panel.
     * HANYA menampilkan order yang berstatus PAID
     */
    public function getTableDetails(Table $table)
    {
        try {
            // Ambil order terakhir yang PAID saja
            $order = $table->activeOrder;

            // ✅ PERUBAHAN: Jika order ada tapi UNPAID, anggap sebagai tidak ada order
            if ($order && $order->payment_status !== 'paid') {
                $order = null;
            }

            // Jika tidak ada order PAID, kembalikan info meja saja sebagai available
            if (!$order) {
                return response()->json([
                    'status' => $table->status, // available / cleaning
                    'message' => 'Meja ' . $table->name . ' kosong.',
                    'table' => $table
                ], 200);
            }

            // Format item pesanan
            $orderItems = $order->orderItems->map(function ($item) {
                return [
                    'item_name' => $item->item_name,
                    'quantity' => $item->quantity,
                    'subtotal' => (float) $item->subtotal,
                ];
            });

            // Jika ada order PAID, status pasti occupied
            return response()->json([
                'status' => 'occupied',
                'table' => $table,
                'order' => [
                    'id' => $order->id,
                    'invoice_number' => $order->invoice_number,
                    'total_price' => (float) $order->total,
                    'payment_status' => $order->payment_status, // PAID
                    'created_at' => $order->created_at->format('d M Y H:i'),
                ],
                'order_items' => $orderItems,
                'total_items' => $order->orderItems->sum('quantity'),
            ], 200);
        } catch (\Exception $e) {
            Log::error("TableMonitoringController Detail Error: " . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Server Error'], 500);
        }
    }

    /**
     * Mengosongkan meja (Finish/Clear).
     * Ini akan melepas link antara meja dan order (dengan mengubah status meja jadi available).
     */
    public function clearTable(Table $table)
    {
        try {
            $order = $table->activeOrder;

            if ($order) {
                // PUTUS RELASI: Set table_id menjadi NULL
                $order->update([
                    'table_id' => null
                ]);
            }

            // Ubah status meja fisik menjadi Available
            $table->update(['status' => 'available']);

            return response()->json([
                'success' => true,
                'message' => "Meja {$table->name} berhasil dikosongkan."
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // --- CRUD FUNCTIONS ---

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:tables,name',
            'capacity' => 'required|integer|min:1',
            'area' => 'required|string',
            'shape' => 'required|string|in:square,round,rectangle',
            'status' => 'required|string|in:available,occupied,cleaning',
        ]);

        Table::create(array_merge($request->all(), ['position_x' => 50, 'position_y' => 50]));
        return redirect()->route('admin.tables.index')->with('success', 'Meja berhasil ditambahkan');
    }

    public function update(Request $request, Table $table)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:tables,name,' . $table->id,
            'capacity' => 'required|integer|min:1',
            'area' => 'required|string',
            'shape' => 'required|string|in:square,round,rectangle',
            'status' => 'required|string|in:available,occupied,cleaning',
        ]);

        $table->update($request->all());
        return redirect()->route('admin.tables.index')->with('success', 'Meja berhasil diperbarui');
    }

    public function destroy(Table $table)
    {
        if ($table->activeOrder()->exists()) {
            return back()->with('error', 'Meja memiliki pesanan aktif.');
        }
        $table->delete();
        return redirect()->route('admin.tables.index')->with('success', 'Meja dihapus.');
    }

    public function saveLayout(Request $request)
    {
        $tablesData = $request->input('tables');
        if (empty($tablesData)) return response()->json(['success' => false], 400);

        foreach ($tablesData as $data) {
            Table::where('id', $data['id'])->update([
                'position_x' => $data['position_x'],
                'position_y' => $data['position_y']
            ]);
        }
        return response()->json(['success' => true]);
    }

    public function resetLayout()
    {
        Table::query()->update(['position_x' => 50, 'position_y' => 50]);
        return response()->json(['success' => true]);
    }
}
