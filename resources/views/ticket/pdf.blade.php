<div class="text-2xl font-poppins font-bold mb-6 text-yellow underline decoration-yellow decoration-8 underline-offset-4">
    Your E-ticket!
</div>

<div class="flex justify-center">
    <img src="/ticket/{{ $order->ticket_id }}/qrcode" alt="Ticket QR Code" class="w-48 h-48 border-4 border-black rounded-xl shadow-neobrutalism">
</div>

<table class="w-full max-w-2xl mx-auto mt-8 border-3 border-black rounded-2xl overflow-hidden">
    <tr class="border-b border-black">
        <td class="p-4"><span class="font-poppins font-black uppercase text-xl">Ticket ID</span></td>
        <td class="p-4">{{ $order->ticket_id }}</td>
    </tr>
    <tr class="border-b border-black">
        <td><span class="font-poppins font-bold uppercase text-sm">Date</span></td>
        <td class="p-4">{{ now()->format('F j, Y') }}</td>
    </tr>
    <tr class="border-b border-black">
        <td><span class="font-poppins font-bold uppercase text-sm">Event</span></td>
        <td class="p-4">{{ $order->ticketType->name }}</td>
    </tr>
    <tr class="border-b border-black">
        <td><span class="font-poppins font-bold uppercase text-sm">Time</span></td>
        <td class="p-4">{{ now()->format('H:i') }} WIB</td>
    </tr>
    <tr class="border-b border-black">
        <td><span class="font-poppins font-bold uppercase text-sm">Buyer</span></td>
        <td class="p-4">{{ $order->user_name }}</td>
    </tr>
    <tr class="border-b border-black">
        <td><span class="font-poppins font-bold uppercase text-sm">Quantity</span></td>
        <td class="p-4">{{ $order->quantity }} × {{ $order->ticketType->name }}</td>
    </tr>
    <tr class="border-b border-black">
        <td><span class="font-poppins font-bold uppercase text-sm">Total Paid</span></td>
        <td class="p-4">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
    </tr>
</table>

<div class="mt-8 flex justify-center space-x-4">
    <button onclick="window.print()" class="bg-black text-white font-poppins font-bold uppercase px-8 py-3 rounded-xl border-4 border-black shadow-[4px_4px_0px_0px_#000000] hover:translate-x-1 hover:translate-y-1 active:translate-x-2 active:translate-y-2 transition-all">
        Print
    </button>
    <a href="/download-ticket/{{ $order->ticket_id }}" class="bg-cyan text-black font-poppins font-bold uppercase px-8 py-3 rounded-xl border-4 border-black shadow-[4px_4px_0px_0px_#000000] hover:translate-x-1 hover:translate-y-1 active:translate-x-2 active:translate-y-2 transition-all">
        Download PDF
    </a>
</div>