<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\AdminController;
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
Route::post('/orders/store', [OrderController::class, 'store']);
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{order}', [OrderController::class, 'show']);
Route::put('/orders/{order}', [OrderController::class, 'update']);
Route::delete('/orders/{order}', [OrderController::class, 'destroy']);

/* Payment API Routes */
Route::post('/payment/notification', [PaymentController::class, 'handleMidtransNotification']);

/* QR Code Routes */
Route::get('/ticket/{ticketId}/qrcode', [QrCodeController::class, 'show']);

/* E-Ticket Display Route */
Route::get('/ticket/{ticketId}', [OrderController::class, 'showTicket'])->name('ticket.show');

/* PDF Download Route */
Route::get('/download-ticket/{ticketId}', [OrderController::class, 'downloadTicket'])->name('ticket.download');

/* Admin Routes - Protected with Authentication */
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('tickets', AdminController::class);
    Route::resource('orders', OrderController::class);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
