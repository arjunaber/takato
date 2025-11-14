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
        // Data order sudah otomatis diambil

        // Contoh update status
        $request->validate(['status' => 'required|in:pending,completed,cancelled']);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diupdate.');
    }

    /**
     * Menghapus data pesanan
     * PERBAIKAN: Menggunakan Route Model Binding (Order $order)
     */
    public function destroy(Order $order)
    {
        // Jika order sudah 'cancelled', tidak perlu lakukan apa-apa
        if ($order->status == 'cancelled') {
            return redirect()->route('admin.orders.index')->with('success', 'Pesanan sudah dibatalkan.');
        }

        // Cek apakah order ini sudah lunas (completed)
        $wasCompleted = ($order->status == 'completed');

        try {
            DB::beginTransaction();

            // 1. Kembalikan stok HANYA JIKA order sebelumnya completed
            if ($wasCompleted) {
                $order->returnStock(); // Panggil fungsi yang baru kita buat
            }

            // 2. Ubah status order
            $order->update([
                'status' => 'cancelled',
                'payment_status' => 'unpaid' // Set juga status bayar (jika perlu)
            ]);

            DB::commit();

            return redirect()->route('admin.orders.index')
                ->with('success', 'Pesanan berhasil dibatalkan. Stok telah dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Gagal membatalkan Order ID {$order->id}: " . $e->getMessage());
            return redirect()->route('admin.orders.index')
                ->with('error', 'Gagal membatalkan pesanan. Terjadi error.');
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