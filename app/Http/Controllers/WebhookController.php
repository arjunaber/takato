<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class WebhookController extends Controller
{
    public function webhook(Request $request)
    {
        $payload = $request->all();
        $serverKey = config('midtrans.server_key');

        // Validasi Signature
        $hashed = hash("sha512", $payload['order_id'] . $payload['status_code'] . $payload['gross_amount'] . $serverKey);
        if (($payload['signature_key'] ?? '') !== $hashed) {
            Log::warning('Webhook Midtrans: Signature tidak valid.', $payload);
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        // === FIX LOGIKA PENCARIAN ORDER ===
        $midtransOrderId = $payload['order_id'];

        // 1. Coba cari exact match (untuk pembayaran normal)
        $order = Order::where('invoice_number', $midtransOrderId)->first();

        // 2. Jika tidak ketemu, coba hapus suffix timestamp (untuk Open Bill/Split Bill/Retry)
        // Asumsi format: INV-XXXX-TIMESTAMP. Kita buang bagian setelah tanda '-' terakhir.
        if (!$order) {
            $lastDashPosition = strrpos($midtransOrderId, '-');
            if ($lastDashPosition !== false) {
                $realInvoiceNumber = substr($midtransOrderId, 0, $lastDashPosition);
                $order = Order::where('invoice_number', $realInvoiceNumber)->first();

                Log::info("Webhook: Mencoba mencari dengan ID asli: $realInvoiceNumber (Original: $midtransOrderId)");
            }
        }

        if (!$order) {
            Log::error('Webhook Midtrans: Order tetap tidak ditemukan.', ['received_id' => $midtransOrderId]);
            return response()->json(['error' => 'Order not found'], 404);
        }
        // ==================================

        $status = $payload['transaction_status'];
        Log::info("MIDTRANS CALLBACK STATUS: {$status} untuk order {$order->invoice_number}");

        try {
            DB::beginTransaction();

            // Cek double process: Jika order sudah 'paid', jangan proses lagi (untuk menghindari stok terpotong 2x)
            if ($order->payment_status === 'paid' && ($status === 'settlement' || $status === 'capture')) {
                DB::rollBack(); // Tidak ada perubahan DB
                return response()->json(['message' => 'Order already paid, skipping.'], 200);
            }

            switch ($status) {
                case 'pending':
                    $order->status = 'pending';
                    $order->payment_status = 'unpaid';
                    break;

                case 'settlement':
                case 'capture':
                    $order->status = 'completed';
                    $order->payment_status = 'paid';
                    $order->payment_gateway_ref = $payload['transaction_id'];

                    // Pastikan method reduceStock ada di Model Order
                    $order->reduceStock();
                    break;

                case 'deny':
                case 'cancel':
                case 'expire':
                    $order->status = 'cancelled';
                    $order->payment_status = 'unpaid';
                    break;
            }

            $order->save();
            DB::commit();

            return response()->json(['message' => 'Webhook processed'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Webhook Error: ' . $e->getMessage());
            return response()->json(['error' => 'Server Error: ' . $e->getMessage()], 500);
        }
    }
}
