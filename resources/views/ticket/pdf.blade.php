<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket - {{ $order->ticket_id }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; margin: 0; padding: 0; background-color: #F4F4F5; color: #18181B; }
        .container { width: 100%; max-width: 800px; margin: 20px auto; background-color: #FFFFFF; border-radius: 24px; padding: 40px; box-shadow: 0 8px 32px -8px rgba(0, 0, 0, 0.1); }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { font-family: 'Poppins', sans-serif; font-size: 32px; color: #3B82F6; margin-bottom: 10px; }
        .header p { font-size: 16px; color: #18181B; opacity: 0.7; }
        .qr-section { text-align: center; margin-bottom: 30px; }
        .qr-section img { width: 180px; height: 180px; border: 1px solid #E2E8F0; border-radius: 12px; padding: 10px; background-color: #FFFFFF; box-shadow: 0 4px 16px -4px rgba(0,0,0,0.08); }
        .details-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 30px; }
        .detail-item { background-color: #F4F4F5; border-radius: 16px; padding: 20px; }
        .detail-item .label { font-size: 12px; color: #18181B; opacity: 0.5; text-transform: uppercase; margin-bottom: 5px; }
        .detail-item .value { font-size: 16px; font-weight: bold; color: #18181B; }
        .full-span { grid-column: span 2; }
        .event-info-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .event-info-item { background-color: #F4F4F5; border-radius: 16px; padding: 20px; }
        .event-info-item .label { font-size: 12px; color: #18181B; opacity: 0.5; text-transform: uppercase; margin-bottom: 5px; }
        .event-info-item .value { font-size: 16px; font-weight: bold; color: #18181B; }
        .button-section { text-align: center; margin-top: 30px; }
        .button-section a { display: inline-block; background-color: #3B82F6; color: #FFFFFF; padding: 12px 25px; border-radius: 12px; text-decoration: none; font-family: 'Poppins', sans-serif; font-weight: bold; font-size: 14px; box-shadow: 0 4px 16px -4px rgba(0,0,0,0.08); transition: background-color 0.3s; }
        .button-section a:hover { background-color: #2563EB; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>E-Ticket Confirmation</h1>
            <p>Your digital ticket for the event.</p>
        </div>

        <div class="qr-section">
            <img src="/ticket/{{ $order->ticket_id }}/qrcode" alt="Ticket QR Code">
            <p style="margin-top: 15px; font-size: 14px; opacity: 0.6;">Present this QR code at the venue entrance.</p>
        </div>

        <div class="details-grid">
            <div class="detail-item full-span">
                <p class="label">Ticket ID</p>
                <p class="value">{{ $order->ticket_id }}</p>
            </div>
            <div class="detail-item">
                <p class="label">Buyer Name</p>
                <p class="value">{{ $order->user_name }}</p>
            </div>
            <div class="detail-item">
                <p class="label">Ticket Type</p>
                <p class="value">{{ $order->ticketType->name }}</p>
            </div>
            <div class="detail-item">
                <p class="label">Quantity</p>
                <p class="value">{{ $order->quantity }}</p>
            </div>
            <div class="detail-item">
                <p class="label">Total Paid</p>
                <p class="value">Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="event-info-grid">
            <div class="event-info-item">
                <p class="label">Event Name</p>
                <p class="value">{{ $order->ticketType->event_name }}</p>
            </div>
            <div class="event-info-item">
                <p class="label">Event Date</p>
                <p class="value">{{ \Carbon\Carbon::parse($order->ticketType->event_date)->format('F j, Y') }}</p>
            </div>
            <div class="event-info-item">
                <p class="label">Event Location</p>
                <p class="value">{{ $order->ticketType->event_location }}</p>
            </div>
        </div>

        <div class="button-section">
            <a href="{{ url('/ticket/' . $order->ticket_id) }}">View Online</a>
        </div>
    </div>
</body>
</html>