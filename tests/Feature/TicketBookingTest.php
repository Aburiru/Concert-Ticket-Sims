<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\TicketType;
use App\Models\Order;
use Illuminate\Support\Facades\Http;

class TicketBookingTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        // Set a default admin fee for tests
        config(['app.admin_fee' => 5000]); // Example fixed admin fee
    }

    public function test_it_can_book_a_ticket_successfully(){
        // Create a ticket type
        $ticketType = TicketType::create([
            'name' => 'VIP',
            'price' => 500000,
            'quota' => 100,
            'remaining_stock' => 100,
            'event_name' => 'Test Event',
            'event_date' => '2026-12-31',
            'event_location' => 'Test Venue',
        ]);

        // Mock Midtrans API response for token generation
        Http::fake([
            'https://app.sandbox.midtrans.com/snap/v1/transactions' => Http::response([
                'token' => 'mock_snap_token',
                'redirect_url' => 'http://example.com/payment/redirect',
            ]),
        ]);

        // Data for booking
        $bookingData = [
            'full_name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'ticket_type_id' => $ticketType->id,
            'quantity' => 2,
        ];

        // Calculate expected total price including admin fee
        $expectedSubtotal = $ticketType->price * $bookingData['quantity'];
        $expectedAdminFee = config('app.admin_fee');
        $expectedTotalPrice = $expectedSubtotal + $expectedAdminFee;

        // Book the ticket
        $response = $this->postJson('/tickets/book', $bookingData);

        // Assert response
        $response->assertStatus(200);
        $response->assertJsonStructure(['order_id', 'snap_token', 'total_price']);
        $response->assertJson([
            'total_price' => $expectedTotalPrice,
        ]);

        // Assert order was created in the database
        $this->assertDatabaseHas('orders', [
            'user_name' => $bookingData['full_name'],
            'email' => $bookingData['email'],
            'ticket_type_id' => $ticketType->id,
            'quantity' => $bookingData['quantity'],
            'total_price' => $expectedTotalPrice,
            'admin_fee' => $expectedAdminFee,
            'payment_status' => 'pending',
        ]);

        // Assert ticket stock was decremented
        $updatedTicketType = TicketType::find($ticketType->id);
        $this->assertEquals($ticketType->remaining_stock - $bookingData['quantity'], $updatedTicketType->remaining_stock);
    }

    public function test_it_fails_to_book_if_stock_is_insufficient(){
        // Create a ticket type with low stock
        $ticketType = TicketType::create([
            'name' => 'VIP',
            'price' => 500000,
            'quota' => 1,
            'remaining_stock' => 1,
            'event_name' => 'Test Event',
            'event_date' => '2026-12-31',
            'event_location' => 'Test Venue',
        ]);

        // Data for booking more tickets than available
        $bookingData = [
            'full_name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'ticket_type_id' => $ticketType->id,
            'quantity' => 2,
        ];

        // Attempt to book tickets
        $response = $this->postJson('/tickets/book', $bookingData);

        // Assert response indicates insufficient stock
        $response->assertStatus(422);
        $response->assertJson(['error' => 'Insufficient stock for selected ticket type']);

        // Assert order was not created and stock remains the same
        $this->assertDatabaseCount('orders', 0);
        $this->assertEquals(1, TicketType::find($ticketType->id)->remaining_stock);
    }
}
