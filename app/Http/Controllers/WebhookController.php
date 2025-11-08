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

        $hashed = hash("sha512", $payload['order_id'] . $payload['status_code'] . $payload['gross_amount'] . $serverKey);

        if (($payload['signature_key'] ?? '') !== $hashed) {
            Log::warning('Webhook Midtrans: Signature tidak valid.', $payload);
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        $order = Order::where('invoice_number', $payload['order_id'])->first();

        if (!$order) {
            Log::error('Webhook Midtrans: Order tidak ditemukan.', $payload);
            return response()->json(['error' => 'Order not found'], 404);
        }

        $status = $payload['transaction_status'];

        Log::info("MIDTRANS CALLBACK STATUS: {$status} untuk order {$order->invoice_number}");

        try {
            DB::beginTransaction();

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
            return response()->json(['error' => 'Server Error'], 500);
        }
    }
}
