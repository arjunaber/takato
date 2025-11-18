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

            // STATISTIK: Hitung ulang berdasarkan logika "Real" (Order ada = Occupied)
            $stats = [
                'total' => $tables->count(),

                // Available = Status meja available DAN tidak ada order nempel
                'available' => $tables->filter(function ($t) {
                    return $t->status === 'available' && !$t->activeOrder;
                })->count(),

                // Occupied = Status meja occupied ATAU ada order aktif (meskipun status 'completed'/'paid')
                'occupied' => $tables->filter(function ($t) {
                    return $t->status === 'occupied' || $t->activeOrder;
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

                    // --- LOGIKA SEDERHANA ---

                    // 1. Cek apakah ada order yang MENEMPEL?
                    // Karena saat 'Free Table' kita sudah set table_id = NULL,
                    // maka variabel $order ini otomatis NULL jika meja sudah dibersihkan.
                    $order = $table->activeOrder;

                    // 2. Tentukan Status Tampilan
                    if ($order) {
                        // Jika masih ada relasi order -> PASTI OCCUPIED
                        // Tidak peduli paid/unpaid, kalau masih nempel berarti meja dipake.
                        $displayStatus = 'occupied';
                    } else {
                        // Jika tidak ada order (atau sudah di-NULL-kan) -> Ikuti status meja (available)
                        $displayStatus = $table->status;
                    }

                    return [
                        'id' => $table->id,
                        'name' => $table->name,
                        'capacity' => $table->capacity,
                        'status' => $displayStatus,
                        'payment_status' => $order ? $order->payment_status : null,
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
     */
    public function getTableDetails(Table $table)
    {
        try {
            // Ambil order terakhir (termasuk yang completed/paid)
            $order = $table->activeOrder()->with('orderItems')->first();

            // Jika tidak ada order, kembalikan info meja saja
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

            // Jika ada order, status pasti occupied
            return response()->json([
                'status' => 'occupied',
                'table' => $table,
                'order' => [
                    'id' => $order->id,
                    'invoice_number' => $order->invoice_number,
                    'total_price' => (float) $order->total, // Pastikan kolom di DB 'total' atau 'total_price'
                    'payment_status' => $order->payment_status, // Frontend akan cek ini untuk warna badge
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
            // 1. Ambil order aktif yang masih menempel pada meja ini
            // (Pastikan menggunakan activeOrder() yang sudah ada di model Table)
            $order = $table->activeOrder;

            if ($order) {
                // 2. PUTUS RELASI: Set table_id menjadi NULL
                // Ini inti permintaanmu: History meja di order ini akan hilang.
                $order->update([
                    'table_id' => null
                ]);
            }

            // 3. Ubah status meja fisik menjadi Available
            $table->update(['status' => 'available']);

            return response()->json([
                'success' => true,
                'message' => "Meja {$table->name} berhasil dikosongkan."
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // --- CRUD FUNCTIONS (SAMA SEPERTI SEBELUMNYA) ---

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
