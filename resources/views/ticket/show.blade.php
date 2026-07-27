<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Ticket - {{ $order->ticket_id }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="antialiased font-sans bg-surface text-text">
    <div class="max-w-3xl mx-auto px-6 py-12">
        <div class="bg-background rounded-4xl p-10 shadow-bento-lg text-center">
            <h1 class="text-4xl font-extrabold text-primary mb-4">E-Ticket Confirmed!</h1>
            <p class="text-text/70 text-lg mb-8">Your ticket for the event is ready.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10 text-left">
                <!-- QR Code Card -->
                <div class="bg-surface rounded-3xl p-6 shadow-bento flex flex-col items-center justify-center">
                    <h3 class="font-bold text-xl mb-4">Scan QR Code</h3>
                    <img src="/ticket/{{ $order->ticket_id }}/qrcode" alt="Ticket QR Code" class="w-48 h-48 rounded-xl bg-white p-2 shadow-sm mb-4">
                    <p class="text-sm text-text/60">Show this at the entrance.</p>
                </div>

                <!-- Ticket Details Summary -->
                <div class="bg-surface rounded-3xl p-6 shadow-bento space-y-4">
                    <h3 class="font-bold text-xl mb-4">Details</h3>
                    <div><p class="text-sm text-text/50 uppercase">Ticket ID</p><p class="font-bold">{{ $order->ticket_id }}</p></div>
                    <div><p class="text-sm text-text/50 uppercase">Buyer Name</p><p class="font-bold">{{ $order->user_name }}</p></div>
                    <div><p class="text-sm text-text/50 uppercase">Ticket Type</p><p class="font-bold">{{ $order->ticketType->name }}</p></div>
                    <div><p class="text-sm text-text/50 uppercase">Quantity</p><p class="font-bold">{{ $order->quantity }}</p></div>
                </div>
            </div>

            <!-- Event Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10 text-left">
                <div class="bg-surface rounded-3xl p-6 shadow-bento">
                    <p class="text-sm text-text/50 uppercase">Event Name</p>
                    <p class="font-bold text-lg">{{ $order->ticketType->event_name }}</p>
                </div>
                <div class="bg-surface rounded-3xl p-6 shadow-bento">
                    <p class="text-sm text-text/50 uppercase">Date & Time</p>
                    <p class="font-bold text-lg">{{ \Carbon\Carbon::parse($order->ticketType->event_date)->format('F j, Y - H:i') }} WIB</p>
                </div>
                <div class="bg-surface rounded-3xl p-6 shadow-bento">
                    <p class="text-sm text-text/50 uppercase">Location</p>
                    <p class="font-bold text-lg">{{ $order->ticketType->event_location }}</p>
                </div>
            </div>

            <div class="flex justify-center gap-4">
                <button onclick="window.print()" class="bg-primary text-white px-6 py-3 rounded-xl font-bold shadow-bento hover:shadow-bento-hover hover:-translate-y-0.5 transition-all">
                    <i data-lucide="printer" class="w-5 h-5 inline-block mr-2"></i> Print Ticket
                </button>
                <a href="/download-ticket/{{ $order->ticket_id }}" class="bg-accent text-white px-6 py-3 rounded-xl font-bold shadow-bento hover:shadow-bento-hover hover:-translate-y-0.5 transition-all inline-flex items-center">
                    <i data-lucide="download" class="w-5 h-5 inline-block mr-2"></i> Download PDF
                </a>
            </div>
        </div>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>