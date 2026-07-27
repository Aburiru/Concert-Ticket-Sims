<?php

use App\Http\Controllers\TicketController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QrCodeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/* Ticket API Routes */
Route::get('/tickets', [TicketController::class, 'index']);
Route::post('/tickets/book', [TicketController::class, 'store']);

/* Order API Routes */
// These routes are related to order management, but since admin is removed, we might only need show for public view
// We'll keep them for now, but will review if they are still necessary for a pure simulation or can be simplified.
Route::get('/orders/{order}', [OrderController::class, 'show']); // To view an order

/* Payment API Routes */
Route::post('/payment/notification', [PaymentController::class, 'handleMidtransNotification']);

/* QR Code Routes */
Route::get('/ticket/{ticketId}/qrcode', [QrCodeController::class, 'show']);

/* E-Ticket Display Route */
Route::get('/ticket/{ticketId}', [OrderController::class, 'showTicket'])->name('ticket.show');

/* PDF Download Route */
Route::get('/download-ticket/{ticketId}', [OrderController::class, 'downloadTicket'])->name('ticket.download');
