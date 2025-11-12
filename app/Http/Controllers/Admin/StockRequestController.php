<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StockRequestController extends Controller
{
    /**
     * Menampilkan view terpisah untuk mencetak Surat Permintaan Stok.
     * Data item dikirim melalui query parameter yang di-encode dari JavaScript.
     */
    public function printRequest(Request $request)
    {
        // 1. Ambil dan decode data item permintaan stok dari URL
        $encodedItems = $request->query('items', '[]');

        try {
            // Data dikirim dalam format Base64 encoded JSON
            $items = json_decode(base64_decode($encodedItems), true);
        } catch (\Exception $e) {
            // Fallback jika decoding gagal
            $items = [];
        }

        // 2. Persiapkan data lain untuk view
        $user = Auth::user();
        $date = Carbon::now();

        // 3. Muat view cetak
        return view('admin.receipts.print_stock_request', compact('items', 'user', 'date'));
    }
}
