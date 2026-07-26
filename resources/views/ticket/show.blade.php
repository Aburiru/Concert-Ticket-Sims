<div class="max-w-2xl mx-auto bg-white border-4 border-black rounded-3xl p-10 shadow-neobrutalism text-center">
    <div class="mb-8">
        <div class="text-5xl font-poppins font-black uppercase tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-pink-500 mb-4">
            E-Ticket Confirmed!
        </div>
        <p class="text-xl font-medium text-text/70">Your {{ $order->ticketType->name }} ticket is ready.</p>
    </div>

    <div class="bg-surface border-3 border-black rounded-2xl p-8 mb-8">
        <h3 class="font-poppins text-2xl font-bold uppercase mb-6">Ticket Details</h3>
        
        <div class="grid grid-cols-2 gap-6 text-left">
            <div>
                <p class="text-sm uppercase text-text/60 mb-1">Ticket ID</p>
                <p class="font-bold text-lg">{{ $order->ticket_id }}</p>
            </div>
            <div>
                <p class="text-sm uppercase text-text/60 mb-1">Date</p>
                <p class="font-bold text-lg">{{ now()->format('M d, Y') }}</p>
            </div>
            <div>
                <p class="text-sm uppercase text-text/60 mb-1">Event</p>
                <p class="font-bold text-lg">{{ $order->ticketType->name }}</p>
            </div>
            <div>
                <p class="text-sm uppercase text-text/60 mb-1">Time</p>
                <p class="font-bold text-lg">{{ now()->format('H:i') }} WIB</p>
            </div>
            <div>
                <p class="text-sm uppercase text-text/60 mb-1">Buyer Name</p>
                <p class="font-bold text-lg">{{ $order->user_name }}</p>
            </div>
            <div>
                <p class="text-sm uppercase text-text/60 mb-1">Ticket Quantity</p>
                <p class="font-bold text-lg">{{ $order->quantity }} {{ $order->ticketType->name }} Ticket{{ $order->quantity > 1 ? 's' : '' }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white border-4 border-black rounded-2xl p-8 mb-8">
        <h3 class="font-poppins text-2xl font-bold uppercase mb-6">QR Code</h3>
        <div class="flex justify-center">
            <img src="/ticket/{{ $order->ticket_id }}/qrcode" alt="Ticket QR Code" class="w-48 h-48 border-2 border-black rounded-lg">
        </div>
        <p class="text-sm text-text/60 mt-4">Show this QR code at the venue entrance for check-in.</p>
    </div>

    <div class="flex flex-wrap justify-center gap-4">
        <button onclick="window.print()" class="bg-black text-white font-poppins font-bold uppercase px-8 py-4 rounded-xl border-4 border-black shadow-neobrutalism hover:translate-x-1 hover:translate-y-1 active:translate-x-2 active:translate-y-2 transition-all">
            Print Ticket
        </button>
        <a href="/download-ticket/{{ $order->ticket_id }}" class="bg-cyan text-black font-poppins font-bold uppercase px-8 py-4 rounded-xl border-4 border-black shadow-[4px_4px_0px_0px_#000000] hover:translate-x-1 hover:translate-y-1 active:translate-x-2 active:translate-y-2 transition-all inline-block">
            Download as PDF
        </a>
    </div>
</div>
<style>
@media print {
    body { margin: 0; }
    .max-w-2xl { max-width: none; margin: 0; border: none; box-shadow: none; }
    button, a { display: none; }
}
</style>