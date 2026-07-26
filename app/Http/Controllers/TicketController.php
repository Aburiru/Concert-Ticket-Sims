<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TicketType;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class TicketController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Return all ticket types as JSON
        return response()->json(TicketType::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'quantity' => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($validated) {
            $ticketType = TicketType::lockForUpdate()->find($validated['ticket_type_id']);

            // Check if enough quota/remaining stock
            if ($ticketType->remaining_stock < $validated['quantity']) {
                return response()->json([
                    'error' => 'Insufficient stock for selected ticket type'
                ], 422);
            }

            $ticketId = 'TIX-' . strtoupper(Str::random(8));

            // Create Order
            $order = Order::create([
                'ticket_id' => $ticketId,
                'user_name' => $validated['full_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'ticket_type_id' => $ticketType->id,
                'quantity' => $validated['quantity'],
                'total_price' => $ticketType->price * $validated['quantity'],
                'payment_status' => 'pending',
                'payment_method' => 'midtrans',
            ]);

            // Update remaining stock
            $ticketType->decrement('remaining_stock', $validated['quantity']);

            // Generate Midtrans Snap Token
            $params = [
                'transaction_details' => [
                    'order_id' => $ticketId,
                    'gross_amount' => (int) $order->total_price,
                ],
                'customer_details' => [
                    'first_name' => $validated['full_name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                ],
            ];

            try {
                $snapToken = Snap::getSnapToken($params);
                $order->update(['midtrans_order_id' => $ticketId]);
                return response()->json([
                    'order_id' => $order->ticket_id,
                    'snap_token' => $snapToken,
                    'total_price' => $order->total_price,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Failed to generate payment token',
                    'details' => $e->getMessage()
                ], 500);
            }
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return response()->json($order->load('ticketType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'payment_status' => 'sometimes|required|in:pending,success,failed,expired,cancelled',
            'midtrans_order_id' => 'nullable|string',
        ]);
        $order->update($validated);
        return response()->json($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }
}
