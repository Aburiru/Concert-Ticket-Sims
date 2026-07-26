<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\QrCodeService;

class QrCodeController extends Controller
{
    protected $qrCodeService;

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }

    /**
     * Generate and return QR code for a given order.
     */
    public function show(string $ticketId)
    {
        $order = Order::where('ticket_id', $ticketId)->firstOrFail();

        $qrCodeImage = $this->qrCodeService->generateQrCodeForOrder($order);

        if (!$qrCodeImage) {
            return response()->json(['error' => 'Could not generate QR code for this order.'], 400);
        }

        return response($qrCodeImage, 200)->header('Content-Type', 'image/png');
    }
}