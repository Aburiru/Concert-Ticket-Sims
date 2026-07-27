<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your E-Ticket</title>
    <style>
        body { font-family: 'Inter', Arial, sans-serif; background-color: #F4F4F5; margin: 0; padding: 20px; color: #18181B; }
        .container { max-width: 600px; margin: 0 auto; background: #FFFFFF; border-radius: 24px; padding: 20px; box-shadow: 0 8px 32px -8px rgba(0, 0, 0, 0.1); }
        .header { text-align: center; background-color: #3B82F6; border-radius: 16px; padding: 20px; margin-bottom: 20px; color: #FFFFFF; }
        .header h1 { margin: 0; font-size: 24px; text-transform: uppercase; font-family: 'Poppins', sans-serif; }
        .content { padding: 10px 0; }
        .ticket-id { font-size: 20px; font-weight: bold; text-align: center; margin: 20px 0; color: #3B82F6; font-family: 'Poppins', sans-serif; }
        .details { background-color: #F4F4F5; padding: 15px; border-radius: 16px; margin-bottom: 20px; }
        .details p { margin: 5px 0; font-size: 14px; }
        .footer { text-align: center; font-size: 12px; color: #666; margin-top: 20px; border-top: 1px solid #E2E8F0; padding-top: 10px; }
        .btn { display: inline-block; background: #8B5CF6; color: #FFFFFF; padding: 12px 24px; text-decoration: none; border-radius: 12px; font-weight: bold; margin-top: 10px; box-shadow: 0 4px 16px -4px rgba(0,0,0,0.08); }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Concert Ticket Confirmed!</h1>
        </div>
        <div class="content">
            <p>Hello {{ $order->user_name }},</p>
            <p>Your payment for the concert ticket was successful. Your e-ticket is attached to this email.</p>
            <p class="ticket-id">Ticket ID: {{ $order->ticket_id }}</p>

            <div class="details">
                <p><strong>Ticket Type:</strong> {{ $order->ticketType->name }}</p>
                <p><strong>Quantity:</strong> {{ $order->quantity }}</p>
                <p><strong>Total Price:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                <p><strong>Event:</strong> {{ $order->ticketType->event_name }}</p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($order->ticketType->event_date)->format('F j, Y') }}</p>
                <p><strong>Location:</strong> {{ $order->ticketType->event_location }}</p>
            </div>

            <p>Please present this e-ticket or the QR code at the venue entrance.</p>

            <div style="text-align: center; margin-top: 20px;">
                <a href="{{ url('/ticket/' . $order->ticket_id) }}" class="btn">View Ticket Online</a>
            </div>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} Concert Ticket Booking System. All Rights Reserved.</p>
            <p>This is an automated email. Please do not reply.</p>
        </div>
    </div>
</body>
</html>