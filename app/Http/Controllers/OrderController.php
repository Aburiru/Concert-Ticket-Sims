<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function showTicket(string $ticketId)
    {
        $order = Order::where('ticket_id', $ticketId)->firstOrFail();
        return view('ticket.show', ['order' => $order]);
    }

    public function index()
    {
        return response()->json(Order::with('ticketType')->get());
    }

    public function show(Order $order)
    {
        return response()->json($order->load('ticketType', 'payment'));
    }

    public function update(Request $request, Order $order)
    {
        $order->update($request->all());
        return response()->json($order);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }
}
