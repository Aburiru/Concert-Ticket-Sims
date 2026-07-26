<?php

namespace App\Services;

use SimpleSoftwareIO\QrCode\QrCode;
use App\Models\Order;

class QrCodeService
{
    public function generateQrCodeForOrder(Order $order)
    {
        // Ensure order is paid and has necessary data
        if ($order->payment_status !== 'success' || !$order->ticket_id) {
            return null; // Or handle error appropriately
        }

        // Data to be encoded in the QR code
        // This can be customized, e.g., include ticket ID, event details, etc.
        $qrData = url('/ticket/' . $order->ticket_id); // Example: URL to a ticket view page

        // Generate QR code image
        $qrCode = QrCode::format('png')->size(300)->generate($qrData);

        return $qrCode;
    }
}