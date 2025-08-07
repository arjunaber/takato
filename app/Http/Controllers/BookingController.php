<?php

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = env('SB-Mid-server-BUFitd_XGexfM0lesU_yJAge');
        // Config::$isProduction = env('MIDTRANS_IS_PRODUCTION') === 'true';
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Data transaksi
        $orderId = uniqid('BOOK-');
        $grossAmount = $request->total_price;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'email' => $request->email ?? 'guest@example.com',
                'first_name' => 'Guest',
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal membuat Snap Token'], 500);
        }
    }
}
