<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Concert Ticket Booking System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-background text-text font-inter selection:bg-yellow selection:text-text">
    <div x-data="ticketApp()" x-init="fetchTicketTypes()" class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Navbar -->
        <nav class="flex justify-between items-center mb-12 p-6 bg-yellow border-4 border-black rounded-xl shadow-neobrutalism">
            <div class="flex items-center space-x-3">
                <i data-lucide="ticket" class="w-8 h-8 text-black"></i>
                <span class="font-poppins text-2xl font-bold uppercase tracking-tighter">ConcertTIK</span>
            </div>
            <div class="hidden md:flex space-x-8 font-poppins font-bold uppercase text-sm">
                <a href="#" class="hover:underline underline-offset-4">Events</a>
                <a href="#" class="hover:underline underline-offset-4">How it works</a>
                <a href="#" class="hover:underline underline-offset-4">Support</a>
            </div>
            <a href="{{ route('login') }}" class="bg-black text-white px-6 py-2 rounded-xl font-poppins font-bold uppercase text-sm border-4 border-black hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all shadow-neobrutalism active:shadow-none active:translate-x-[6px] active:translate-y-[6px]">
                Admin Login
            </a>
        </nav>

        <!-- Hero Section -->
        <header class="mb-16 text-center">
            <h1 class="font-poppins text-6xl md:text-8xl font-black uppercase tracking-tighter leading-none mb-6">
                Rock the <span class="bg-pink px-4 border-4 border-black shadow-neobrutalism inline-block -rotate-2">Night</span>
            </h1>
            <p class="text-xl md:text-2xl font-medium max-w-2xl mx-auto mb-8">
                Experience the loudest, boldest concert of the year. Grab your tickets before they vanish into the mosh pit.
            </p>
            <div class="flex flex-wrap justify-center gap-6">
                <div class="flex items-center space-x-2 bg-cyan px-4 py-2 border-3 border-black rounded-xl font-bold shadow-[4px_4px_0px_0px_#000000]">
                    <i data-lucide="calendar" class="w-5 h-5"></i>
                    <span>OCT 24, 2026</span>
                </div>
                <div class="flex items-center space-x-2 bg-yellow px-4 py-2 border-3 border-black rounded-xl font-bold shadow-[4px_4px_0px_0px_#000000]">
                    <i data-lucide="map-pin" class="w-5 h-5"></i>
                    <span>ARENA STADIUM, JK</span>
                </div>
            </div>
        </header>

        <!-- Ticket Selection -->
        <section class="mb-16" x-show="ticketTypes.length > 0">
            <h2 class="font-poppins text-4xl font-black uppercase mb-8 flex items-center">
                <i data-lucide="zap" class="w-8 h-8 mr-3 text-pink"></i>
                Select Your Zone
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <template x-for="ticket in ticketTypes" :key="ticket.id">
                    <div class="bg-white border-4 border-black rounded-2xl p-8 shadow-neobrutalism hover:-translate-x-1 hover:-translate-y-1 transition-transform">
                        <div class="flex justify-between items-start mb-6">
                            <span :class="ticket.name === 'VIP' ? 'bg-yellow' : (ticket.name === 'TENGAH' ? 'bg-cyan' : 'bg-white')" class="text-xs font-black uppercase px-3 py-1 border-2 border-black rounded-full" x-text="ticket.name === 'TENGAH' ? 'Center' : ticket.name"></span>
                            <span class="font-poppins text-3xl font-black uppercase" x-text="ticket.name === 'TENGAH' ? 'CENTER' : ticket.name"></span>
                        </div>
                        <div class="text-5xl font-black mb-6" x-text="'Rp' + Number(ticket.price).toLocaleString('id-ID')"></div>
                        <ul class="space-y-3 mb-8 font-medium">
                            <li class="flex items-center"><i data-lucide="check" class="w-4 h-4 mr-2 text-success"></i> <span x-text="ticket.name === 'VIP' ? 'Front row seating' : 'Best view'"></span></li>
                            <li class="flex items-center"><i data-lucide="check" class="w-4 h-4 mr-2 text-success"></i> <span x-text="ticket.name === 'VIP' ? 'Meet & Greet' : 'Great acoustics'"></span></li>
                            <li class="flex items-center" :class="ticket.name !== 'VIP' ? 'text-text/40' : ''"><i :data-lucide="ticket.name !== 'VIP' ? 'x' : 'check'" class="w-4 h-4 mr-2"></i> <span x-text="ticket.name === 'VIP' ? 'Free Merchandise' : 'No Merchandise'"></span></li>
                        </ul>
                        <button @click="selectTicket(ticket)" class="w-full font-poppins font-black uppercase py-4 rounded-xl border-4 border-black shadow-[4px_4px_0px_0px_#000000] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] active:translate-x-[4px] active:translate-y-[4px] transition-all"
                            :class="ticket.name === 'VIP' ? 'bg-pink text-white' : (ticket.name === 'TENGAH' ? 'bg-cyan text-black' : 'bg-yellow text-black')">
                            Choose <span x-text="ticket.name === 'TENGAH' ? 'CENTER' : ticket.name"></span>
                        </button>
                    </div>
                </template>
            </div>
        </section>

        <!-- Booking Form -->
        <section class="max-w-2xl mx-auto">
            <div class="bg-surface border-4 border-black rounded-3xl p-10 shadow-neobrutalism">
                <h2 class="font-poppins text-3xl font-black uppercase mb-8 text-center underline decoration-yellow decoration-8 underline-offset-4">
                    Grab Your Tickets
                </h2>
                
                <div x-show="Object.keys(selectedTicket).length === 0" class="text-center py-8">
                    <p class="font-poppins font-bold uppercase text-xl mb-4">No Ticket Selected</p>
                    <p class="text-text/60">Please select a ticket type above to proceed.</p>
                </div>

                <div x-show="Object.keys(selectedTicket).length > 0" class="bg-white border-4 border-black rounded-2xl p-6 mb-6">
                    <h3 class="font-poppins font-black text-xl uppercase mb-4">Selected Ticket</h3>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-bold text-lg" x-text="selectedTicket.name === 'TENGAH' ? 'CENTER' : selectedTicket.name"></p>
                            <p class="text-text/60">Price: <span x-text="'Rp' + Number(selectedTicket.price).toLocaleString('id-ID')"></span></p>
                        </div>
                        <button @click="clearSelection()" class="text-danger font-bold hover:underline">Cancel</button>
                    </div>
                </div>

                <form @submit.prevent="bookTicket()" x-show="Object.keys(selectedTicket).length > 0" class="space-y-6">
                    <div>
                        <label class="block font-poppins font-bold uppercase text-sm mb-2">Full Name</label>
                        <input type="text" x-model="formData.full_name" required placeholder="John Doe" class="w-full bg-white border-3 border-black p-4 rounded-xl font-medium focus:outline-none focus:ring-4 focus:ring-yellow shadow-[4px_4px_0px_0px_#000000] transition-all">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-poppins font-bold uppercase text-sm mb-2">Email Address</label>
                            <input type="email" x-model="formData.email" required placeholder="john@example.com" class="w-full bg-white border-3 border-black p-4 rounded-xl font-medium focus:outline-none focus:ring-4 focus:ring-yellow shadow-[4px_4px_0px_0px_#000000] transition-all">
                        </div>
                        <div>
                            <label class="block font-poppins font-bold uppercase text-sm mb-2">Phone Number</label>
                            <input type="tel" x-model="formData.phone" required placeholder="0812..." class="w-full bg-white border-3 border-black p-4 rounded-xl font-medium focus:outline-none focus:ring-4 focus:ring-yellow shadow-[4px_4px_0px_0px_#000000] transition-all">
                        </div>
                    </div>
                    <div>
                        <label class="block font-poppins font-bold uppercase text-sm mb-2">Quantity</label>
                        <div class="flex items-center space-x-4">
                            <button type="button" @click="decrementQty()" class="bg-white border-3 border-black w-12 h-12 rounded-xl flex items-center justify-center font-black text-2xl shadow-[2px_2px_0px_0px_#000000] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none">-</button>
                            <input type="number" x-model="formData.quantity" readonly class="w-20 text-center bg-white border-3 border-black p-2 rounded-xl font-black text-xl shadow-[4px_4px_0px_0px_#000000]">
                            <button type="button" @click="incrementQty()" class="bg-yellow border-3 border-black w-12 h-12 rounded-xl flex items-center justify-center font-black text-2xl shadow-[2px_2px_0px_0px_#000000] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none">+</button>
                        </div>
                    </div>
                    
                    <div class="bg-white border-3 border-black rounded-xl p-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-bold">Total Price:</span>
                            <span class="font-black text-xl" x-text="'Rp' + Number(selectedTicket.price * formData.quantity).toLocaleString('id-ID')"></span>
                        </div>
                    </div>

                    <button type="submit" :disabled="loading" class="w-full bg-black text-white font-poppins font-black uppercase text-xl py-6 rounded-2xl border-4 border-black shadow-neobrutalism hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none active:translate-x-[6px] active:translate-y-[6px] transition-all disabled:opacity-50">
                        <span x-show="!loading">Proceed to Checkout</span>
                        <span x-show="loading">Processing...</span>
                    </button>
                </form>
            </div>
        </section>

        <!-- Loading/Processing Overlay -->
        <div x-show="loading" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white border-4 border-black rounded-2xl p-8 shadow-neobrutalism text-center">
                <div class="font-poppins font-black text-2xl uppercase mb-4">Processing Payment</div>
                <div class="animate-pulse font-bold">Please wait...</div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="mt-20 pt-12 border-t-4 border-black flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex items-center space-x-3">
                <i data-lucide="ticket" class="w-6 h-6 text-black"></i>
                <span class="font-poppins text-xl font-bold uppercase tracking-tighter">ConcertTIK</span>
            </div>
            <p class="font-bold text-sm uppercase">© 2026 Concert Ticket Booking System. All Rights Reserved.</p>
            <div class="flex space-x-6">
                <a href="#" class="bg-white border-2 border-black p-2 rounded-lg shadow-[2px_2px_0px_0px_#000000] hover:translate-x-[1px] hover:translate-y-[1px] hover:shadow-none"><i data-lucide="instagram" class="w-5 h-5"></i></a>
                <a href="#" class="bg-white border-2 border-black p-2 rounded-lg shadow-[2px_2px_0px_0px_#000000] hover:translate-x-[1px] hover:translate-y-[1px] hover:shadow-none"><i data-lucide="twitter" class="w-5 h-5"></i></a>
                <a href="#" class="bg-white border-2 border-black p-2 rounded-lg shadow-[2px_2px_0px_0px_#000000] hover:translate-x-[1px] hover:translate-y-[1px] hover:shadow-none"><i data-lucide="facebook" class="w-5 h-5"></i></a>
            </div>
        </footer>
    </div>

    <script>
        lucide.createIcons();
        
        function ticketApp() {
            return {
                ticketTypes: [],
                selectedTicket: {},
                formData: {
                    full_name: '',
                    email: '',
                    phone: '',
                    quantity: 1,
                    ticket_type_id: null
                },
                loading: false,

                async fetchTicketTypes() {
                    try {
                        const response = await fetch('/tickets');
                        this.ticketTypes = await response.json();
                    } catch (error) {
                        console.error('Error fetching tickets:', error);
                    }
                },

                selectTicket(ticket) {
                    this.selectedTicket = ticket;
                    this.formData.ticket_type_id = ticket.id;
                    window.scrollTo({ top: document.body.scrollHeight / 2, behavior: 'smooth' });
                },

                clearSelection() {
                    this.selectedTicket = {};
                    this.formData.ticket_type_id = null;
                },

                incrementQty() {
                    if (this.selectedTicket.remaining_stock > this.formData.quantity) {
                        this.formData.quantity++;
                    }
                },

                decrementQty() {
                    if (this.formData.quantity > 1) {
                        this.formData.quantity--;
                    }
                },

                async bookTicket() {
                    this.loading = true;
                    try {
                        const response = await fetch('/tickets/book', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(this.formData)
                        });

                        const result = await response.json();

                        if (response.ok && result.snap_token) {
                            snap.pay(result.snap_token, {
                                onSuccess: (result) => {
                                    window.location.href = '/ticket/' + result.order_id;
                                },
                                on_pending: (result) => {
                                    alert('Payment pending. Ticket ID: ' + result.order_id);
                                },
                                onError: (result) => {
                                    alert('Payment failed. Please try again.');
                                },
                                on_close: () => {
                                    this.loading = false;
                                }
                            });
                        } else {
                            alert(result.error || 'Failed to create order');
                            this.loading = false;
                        }
                    } catch (error) {
                        console.error('Booking error:', error);
                        alert('An error occurred. Please try again.');
                        this.loading = false;
                    }
                }
            }
        }
    </script>
</body>
</html>
