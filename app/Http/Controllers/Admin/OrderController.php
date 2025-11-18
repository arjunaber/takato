<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; // <-- Import Model
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\StrukConfig;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar histori pesanan
     */
    public function index(Request $request)
    {
        $query = Order::with('user')->latest(); // 'user' adalah kasir/admin

        // == TAMBAHAN: Search query ==
        if ($request->filled('search')) {
            $searchTerm = $request->search;

            // Grup query agar tidak bentrok dengan filter lain
            $query->where(function ($q) use ($searchTerm) {
                // Cari berdasarkan ID Pesanan (harus sama persis)
                $q->where('id', $searchTerm)
                    // ATAU cari berdasarkan nama kasir
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('name', 'LIKE', '%' . $searchTerm . '%');
                    });
                // Catatan: Jika Anda punya kolom 'customer_name' di tabel Order,
                // tambahkan juga: ->orWhere('customer_name', 'LIKE', '%' . $searchTerm . '%')
            });
        }

        // Filter Tanggal
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10);

        // Kirim juga data filter untuk ditampilkan kembali di form
        return view('admin.orders.index', [
            'orders' => $orders,
            'filters' => $request->only(['search', 'date', 'status']) // Kirim filter ke view
        ]);
    }

    public function index2(Request $request)
    {
        // === KRUSIAL: Filter HANYA pesanan online ===
        $query = Order::with('user')
            ->where('is_online_order', true)
            ->latest();

        // == Filter dan Pencarian tetap berlaku (jika diperlukan) ==
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('id', $searchTerm)
                    ->orWhere('invoice_number', 'LIKE', '%' . $searchTerm . '%') // Online order pakai invoice number
                    ->orWhere('table_number', 'LIKE', '%' . $searchTerm . '%'); // Biasanya online order punya table number
            });
        }

        // Filter Tanggal
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Ambil data. Mungkin perlu limit yang lebih kecil untuk monitor real-time
        $orders = $query->paginate(10);

        // Tampilkan di view yang sama atau view baru (disarankan view baru: admin.orders.online_index)
        return view('admin.orders.online_index', [
            'orders' => $orders,
            'filters' => $request->only(['search', 'date', 'status']), // Kirim filter ke view
            'is_online_mode' => true // Flag untuk membedakan tampilan
        ]);
    }
    /**
     * Admin tidak membuat pesanan dari sini, jadi method ini bisa kosong
     */
    public function create()
    {
        return redirect()->route('admin.pos.index'); // Arahkan ke POS
    }

    /**
     * Admin tidak membuat pesanan dari sini
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Menampilkan detail satu pesanan (struk)
     * PERBAIKAN: Menggunakan Route Model Binding (Order $order)
     */
    public function show(Order $order)
    {
        // Data order sudah otomatis diambil oleh Laravel (findOrFail)

        // Load relasi yang dibutuhkan untuk halaman detail
        $order->load(['user', 'orderItems.product', 'orderItems.variant', 'orderItems.addons']);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Admin tidak meng-edit pesanan yang sudah selesai
     * PERBAIKAN: Menggunakan Route Model Binding (Order $order)
     */
    public function edit(Order $order)
    {
        abort(404);
    }

    /**
     * Admin mungkin bisa update status (cth: dari pending ke cancelled)
     * PERBAIKAN: Menggunakan Route Model Binding (Order $order)
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
            'cashier_shift_id' => 'required|exists:cashier_shifts,id',
        ]);

        $redirectRoute = $order->is_online_order ? 'admin.orders.online' : 'admin.orders.index';
        $oldStatus = $order->status;

        try {
            DB::beginTransaction();

            $dataToUpdate = [
                'status' => $request->status,
                'cashier_shift_id' => $request->cashier_shift_id,
            ];

            // Logika Khusus Pembatalan
            if ($request->status === 'cancelled') {
                $dataToUpdate['payment_status'] = 'failed';

                // 1. Kembalikan stok jika sebelumnya sudah completed
                if ($oldStatus === 'completed') {
                    $order->returnStock();
                }
            }

            // Logika Khusus Penyelesaian (Completed)
            if ($request->status === 'completed' && $oldStatus !== 'completed') {
                // 2. Lakukan pengurangan stok jika ini adalah aksi "Selesaikan"
                // Asumsi: Logika pengurangan stok ada di sini
                // $order->reduceStock();
            }

            $order->update($dataToUpdate);
            DB::commit();

            return redirect()->route($redirectRoute)->with('success', 'Status pesanan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Gagal update status Order ID {$order->id}: " . $e->getMessage());
            return redirect()->route($redirectRoute)->with('error', 'Gagal memproses aksi. Terjadi error.');
        }
    }

    /**
     * Menghapus data pesanan
     * PERBAIKAN: Menggunakan Route Model Binding (Order $order)
     */
    public function destroy(Request $request, Order $order)
    {
        // 1. Validasi Shift
        $request->validate([
            'cashier_shift_id' => 'required|exists:cashier_shifts,id',
        ]);

        // Tentukan rute redirect yang benar (berdasarkan is_online_order)
        $redirectRoute = $order->is_online_order ? 'admin.orders.online' : 'admin.orders.index';

        // 2. Cek Redundansi Status (Digabungkan)
        if ($order->status == 'cancelled') {
            return redirect()->route($redirectRoute)->with('error', 'Pesanan sudah dibatalkan sebelumnya.');
        }

        $wasCompleted = ($order->status == 'completed');

        try {
            DB::beginTransaction();

            // 3. Kembalikan stok HANYA JIKA order sebelumnya completed
            if ($wasCompleted) {
                // Asumsi: $order->returnStock() sudah didefinisikan di Model Order
                $order->returnStock();
            }

            // 4. Ubah status order & Simpan ID Shift yang melakukan pembatalan
            $order->update([
                'status' => 'cancelled', // WAJIB DIUBAH ke CANCELLED
                'payment_status' => 'unpaid', // WAJIB DIUBAH ke FAILED/UNPAID
                'cashier_shift_id' => $request->cashier_shift_id, // KRUSIAL: Menyimpan ID Shift
            ]);

            DB::commit();

            return redirect()->route($redirectRoute)
                ->with('success', 'Pesanan berhasil dibatalkan. Stok telah dikembalikan' . ($wasCompleted ? '.' : ' (Tidak ada stok yang dikembalikan karena belum selesai).'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Gagal membatalkan Order ID {$order->id}: " . $e->getMessage());

            return redirect()->route($redirectRoute)
                ->with('error', 'Gagal membatalkan pesanan. Terjadi error: ' . $e->getMessage());
        }
    }

    public function printReceipt(Order $order)
    {
        // Muat semua setting yang relevan
        $settings = [
            'wifi_ssid' => StrukConfig::getValue('wifi_ssid', 'TAKATO-Guest'),
            'wifi_password' => StrukConfig::getValue('wifi_password', 'takato123'),
            'footer_message' => StrukConfig::getValue('footer_message', 'Terima kasih atas kunjungan Anda!'),
        ];

        $order->load('orderItems.addons');
        return view('admin.receipts.print', compact('order', 'settings'));
    }
}
