<?php

namespace App\Http\Controllers;

use App\Mail\ETicketMail;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function handleMidtransNotification(Request $request)
    {
        // ======================
        // 🛡️ SECURITY: Verify Signature
        // ======================
        $signature = $request->header('X-Midtrans-Signature');
        $secretKey = config('services.midtrans.secret_key');
        
        // Validate Midtrans signature
        if (!$this->verifySignature($request->getContent(), $signature, $secretKey)) {
            Log::warning('Invalid Midtrans webhook signature received', [
                'ip' => $request->ip(),
                'headers' => $request->headers(),
            ]);
            return response()->json(['error' => 'Invalid or missing signature', 'code' => 403], 403);
        }

        $notification = $request->all();

        $orderId = $notification['order_id'] ?? null;
        $transactionStatus = $notification['transaction_status'] ?? null;
        $paymentType = $notification['payment_type'] ?? null;
        $fraudStatus = $notification['fraud_status'] ?? null;
        $grossAmount = $notification['gross_amount'] ?? null;
        $transactionId = $notification['transaction_id'] ?? null;

        if (!$orderId || !$transactionId) {
            return response()->json(['error' => 'Invalid notification'], 400);
        }

        $order = Order::where('ticket_id', $orderId)->first();
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        if ($order->payment_status === 'success') {
            return response()->json(['message' => 'Notification processed'], 200);
        }

        Payment::create([
            'order_id' => $order->id,
            'transaction_id' => $transactionId,
            'payment_type' => $paymentType,
            'gross_amount' => $grossAmount,
            'transaction_status' => $transactionStatus,
            'fraud_status' => $fraudStatus,
        ]);

        // Update order payment status based on transaction status
        $statusMapping = [
            'pending' => 'pending',
            'settlement' => 'success',
            'capture' => 'success',
            'deny' => 'failed',
            'expire' => 'expired',
            'cancel' => 'cancelled',
        ];

        $newOrderStatus = $statusMapping[strtolower($transactionStatus)] ?? $order->payment_status;
        $order->update(['payment_status' => $newOrderStatus]);

        // Send e-ticket email if payment was successful
        if ($newOrderStatus === 'success') {
            try {
                Mail::to($order->email)
                    ->send(new ETicketMail($order));
            } catch (\Exception $e) {
                Log::error('Failed to send e-ticket email', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        Log::info('Midtrans payment processed', [
            'order_id' => $order->id,
            'transaction_id' => $transactionId,
            'transaction_status' => $transactionStatus,
            'payment_status' => $newOrderStatus,
            'user' => $order->user_name,
        ]);

        return response()->json(['message' => 'Notification processed'], 200);
    }

    private function verifySignature($data, $hmac, $key)
    {
        $hash = hash_hmac('sha256', $data, $key);
        return hash_equals($hash, $hmac);
    }
}