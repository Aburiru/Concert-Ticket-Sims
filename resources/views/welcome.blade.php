<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Concert') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <style>
        [x-cloak] { display: none !important; }
        @keyframes toast-enter { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes toast-exit { from { opacity: 1; transform: translateY(0); } to { opacity: 0; transform: translateY(-10px); } }
        .toast-enter { animation: toast-enter 200ms ease-out; }
        .toast-exit { animation: toast-exit 150ms ease-in; }
    </style>
</head>
<body class="antialiased font-sans bg-surface text-text">
    <div x-data="ticketApp()" x-init="fetchTicketTypes()" class="max-w-7xl mx-auto px-6 py-6">
        <!-- Floating Navbar -->
        <nav class="sticky top-6 z-50 mb-12 px-8 py-4 bg-white/80 backdrop-blur-xl border border-white/50 rounded-full shadow-bento flex justify-between items-center">
            <div class="font-bold text-xl">ConcertTIK</div>
            <div class="flex gap-6 text-sm font-medium">
                <a href="#" class="text-text/70 hover:text-primary transition-colors">Events</a>
                <a href="#" class="text-text/70 hover:text-primary transition-colors">Support</a>
                <button @click="$refs.bookingForm.scrollIntoView({ behavior: 'smooth', block: 'center' })" class="bg-primary text-white px-5 py-2 rounded-full font-bold shadow-bento hover:shadow-bento-hover hover:-translate-y-0.5 transition-all">Book Now</button>
            </div>
        </nav>

        <main class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Hero (Span 2x2) -->
            <section class="md:col-span-2 md:row-span-2 bg-gradient-to-br from-primary to-accent rounded-4xl p-10 text-white shadow-bento-lg flex flex-col justify-end relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <i data-lucide="music" class="w-full h-full text-white"></i>
                </div>
                <div class="relative z-10">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/20 backdrop-blur-sm border border-white/30 rounded-full text-white font-bold text-sm uppercase tracking-wider mb-4">
                        <i data-lucide="zap" class="w-4 h-4"></i>
                        Live Concert
                    </span>
                    <h1 class="text-5xl font-extrabold mb-4">Rock the <span x-text="eventDetails.name || 'Night'"></span></h1>
                    <p class="text-white/80 text-lg">Experience the loudest, boldest concert of the year. Grab your tickets before they vanish.</p>
                </div>
            </section>

            <!-- Stats/Info Cards -->
            <div class="bg-white rounded-3xl p-8 shadow-bento flex flex-col justify-between">
                <div>
                    <h3 class="text-sm text-text/50 font-bold uppercase mb-2">Location</h3>
                    <p class="text-2xl font-bold" x-text="eventDetails.location || 'Arena Stadium, JK'"></p>
                </div>
                <div class="mt-4">
                    <i data-lucide="map-pin" class="w-8 h-8 text-primary"></i>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-8 shadow-bento flex flex-col justify-between">
                <div>
                    <h3 class="text-sm text-text/50 font-bold uppercase mb-2">Date</h3>
                    <p class="text-2xl font-bold" x-text="eventDetails.date || 'Oct 24, 2026'"></p>
                </div>
                <div class="mt-4">
                    <i data-lucide="calendar" class="w-8 h-8 text-accent"></i>
                </div>
            </div>

            <!-- Ticket Selection Grid -->
            <section class="md:col-span-4 bg-white rounded-4xl p-10 shadow-bento-lg">
                <h2 class="text-3xl font-extrabold mb-8 text-center">Select Your Zone</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <template x-for="ticket in ticketTypes" :key="ticket.id">
                        <article @click="selectTicket(ticket)" :class="{ 'opacity-50 cursor-not-allowed': ticket.remaining_stock <= 0 }"
                            class="bg-surface rounded-3xl p-6 border-2 border-transparent hover:border-primary transition-all shadow-bento hover:shadow-bento-hover hover:-translate-y-0.5 cursor-pointer">
                            <h4 class="font-bold text-lg mb-2" x-text="ticket.name"></h4>
                            <p class="text-3xl font-extrabold mb-4" x-text="'Rp' + Number(ticket.price).toLocaleString('id-ID')"></p>
                            <span x-show="ticket.remaining_stock > 0" class="text-sm text-text/60" x-text="ticket.remaining_stock + ' remaining'"></span>
                            <span x-show="ticket.remaining_stock <= 0" class="text-sm text-danger font-bold">Sold Out</span>
                        </article>
                    </template>
                    <div x-show="ticketTypes.length === 0" class="md:col-span-3 text-center py-10 text-text/60">No tickets available.</div>
                </div>
            </section>

            <!-- Booking Form Section -->
            <section class="md:col-span-4 max-w-2xl mx-auto w-full">
                <article x-ref="bookingForm" class="bg-white rounded-4xl p-10 shadow-bento-lg">
                    <h2 class="text-3xl font-extrabold mb-8 text-center">Grab Your Tickets</h2>
                    
                    <div x-show="!selectedTicket.id" class="text-center py-10 text-text/60">
                        <i data-lucide="ticket" class="w-16 h-16 mx-auto text-text/30 mb-4"></i>
                        <p>Please select a ticket type above.</p>
                    </div>

                    <div x-show="selectedTicket.id">
                        <div class="bg-surface rounded-2xl p-6 mb-8 flex justify-between items-center shadow-sm">
                            <div>
                                <h3 class="font-bold text-xl" x-text="selectedTicket.name"></h3>
                                <p class="text-text/60" x-text="'Rp' + Number(selectedTicket.price).toLocaleString('id-ID') + ' x ' + formData.quantity"></p>
                            </div>
                            <button @click="clearSelection()" class="text-danger font-bold text-sm uppercase hover:underline">Clear</button>
                        </div>

                        <form @submit.prevent="bookTicket()" class="space-y-6">
                            <div>
                                <label for="full_name" class="block text-sm font-medium text-text-700 mb-1">Full Name</label>
                                <input type="text" id="full_name" x-model="formData.full_name" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary focus:ring-primary" placeholder="John Doe">
                                <p x-show="errors.full_name" class="text-danger text-sm mt-1" x-text="errors.full_name"></p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-text-700 mb-1">Email</label>
                                    <input type="email" id="email" x-model="formData.email" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary focus:ring-primary" placeholder="john@example.com">
                                    <p x-show="errors.email" class="text-danger text-sm mt-1" x-text="errors.email"></p>
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-text-700 mb-1">Phone</label>
                                    <input type="tel" id="phone" x-model="formData.phone" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary focus:ring-primary" placeholder="0812...">
                                    <p x-show="errors.phone" class="text-danger text-sm mt-1" x-text="errors.phone"></p>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-text-700 mb-1">Quantity</label>
                                <div class="flex items-center gap-4">
                                    <button type="button" @click="decrementQty()" :disabled="formData.quantity <= 1" class="bg-surface text-text px-4 py-2 rounded-lg shadow-sm hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed">-</button>
                                    <span class="text-xl font-bold" x-text="formData.quantity"></span>
                                    <button type="button" @click="incrementQty()" :disabled="formData.quantity >= selectedTicket.remaining_stock" class="bg-surface text-text px-4 py-2 rounded-lg shadow-sm hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed">+</button>
                                    <span class="text-sm text-text/60">Max: <span x-text="selectedTicket.remaining_stock"></span></span>
                                </div>
                            </div>

                            <div class="bg-surface rounded-2xl p-6 space-y-3 shadow-sm">
                                <div class="flex justify-between"><span>Subtotal</span><span x-text="subtotalDisplay"></span></div>
                                <div class="flex justify-between"><span>Admin Fee</span><span x-text="adminFeeDisplay"></span></div>
                                <div class="flex justify-between font-bold text-lg border-t pt-3 mt-3"><span>Total</span><span x-text="totalDisplay"></span></div>
                            </div>

                            <button type="submit" :disabled="loading || !isFormValid" class="w-full bg-primary text-white py-4 rounded-xl font-bold shadow-bento hover:shadow-bento-hover hover:-translate-y-0.5 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                <span x-show="!loading">Proceed to Payment</span>
                                <span x-show="loading">Processing...</span>
                            </button>
                        </form>
                    </div>
                </article>
            </section>
        </main>
    </div>

    <!-- Toast Container -->
    <div x-show="toasts.length > 0" class="fixed bottom-6 right-6 z-50 flex flex-col gap-3" style="pointer-events: none;">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="toast.visible" x-transition:enter="toast-enter" x-transition:leave="toast-exit" 
                class="flex items-center gap-3 px-6 py-4 rounded-xl border-2 border-white/50 shadow-bento-lg w-96 max-w-sm"
                :class="toast.type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'"
                style="pointer-events: auto;">
                <i :data-lucide="toast.type === 'success' ? 'check-circle' : 'alert-circle'" class="w-6 h-6 flex-shrink-0"></i>
                <span class="font-bold flex-1" x-text="toast.message"></span>
                <button @click="removeToast(toast.id)" class="flex-shrink-0 w-8 h-8 rounded-lg bg-black/20 hover:bg-black/30 transition-colors flex items-center justify-center">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        </template>
    </div>

    <!-- Loading Overlay -->
    <div x-show="loading" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white rounded-3xl p-10 shadow-bento-lg text-center w-96 max-w-sm">
            <div class="w-16 h-16 mx-auto mb-6 bg-primary/20 rounded-full flex items-center justify-center">
                <i data-lucide="loader" class="w-8 h-8 text-primary animate-spin"></i>
            </div>
            <div class="font-bold text-2xl mb-3">Processing Payment</div>
            <div class="text-text/70">Please wait while we redirect you to payment...</div>
        </div>
    </div>

    <script>
        lucide.createIcons();
        
        function ticketApp() {
            return {
                ticketTypes: [],
                eventDetails: { name: '', date: '', location: '' },
                selectedTicket: {},
                formData: { full_name: '', email: '', phone: '', quantity: 1, ticket_type_id: null },
                errors: {},
                adminFee: {{ config('app.admin_fee') ?? 0 }},
                loading: false,
                toasts: [],
                toastId: 0,

                get subtotal() { if (!this.selectedTicket.price) return 0; return this.selectedTicket.price * this.formData.quantity; },
                get total() { return this.subtotal + this.adminFee; },
                get subtotalDisplay() { return 'Rp' + Number(this.subtotal).toLocaleString('id-ID'); },
                get adminFeeDisplay() { return 'Rp' + Number(this.adminFee).toLocaleString('id-ID'); },
                get totalDisplay() { return 'Rp' + Number(this.total).toLocaleString('id-ID'); },
                get isFormValid() { return this.formData.full_name && this.formData.email && this.formData.phone && this.formData.quantity > 0 && !this.errors.full_name && !this.errors.email && !this.errors.phone; },

                async fetchTicketTypes() {
                    try {
                        const response = await fetch('/tickets');
                        this.ticketTypes = await response.json();
                        if (this.ticketTypes.length > 0) {
                            const event = this.ticketTypes[0];
                            this.eventDetails = {
                                name: event.event_name || 'Concert 2026',
                                date: event.event_date ? this.formatDate(event.event_date) : 'Oct 24, 2026',
                                location: event.event_location || 'Arena Stadium, JK'
                            };
                        }
                    } catch (error) {
                        console.error('Error fetching tickets:', error);
                        this.showToast('Failed to load tickets. Please refresh.', 'error');
                    }
                },

                formatDate(dateString) {
                    if (!dateString) return '';
                    const date = new Date(dateString);
                    return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                },

                selectTicket(ticket) {
                    this.selectedTicket = ticket;
                    this.formData.ticket_type_id = ticket.id;
                    this.formData.quantity = 1;
                    this.errors = {};
                    this.$nextTick(() => { this.$refs.bookingForm?.scrollIntoView({ behavior: 'smooth', block: 'center' }); });
                },

                clearSelection() { this.selectedTicket = {}; this.formData.ticket_type_id = null; this.formData.quantity = 1; this.errors = {}; },

                decrementQty() { if (this.formData.quantity > 1) this.formData.quantity--; },
                incrementQty() { if (this.formData.quantity < this.selectedTicket.remaining_stock) this.formData.quantity++; },

                validateField(field) {
                    this.errors[field] = ''; // Clear previous error
                    const value = this.formData[field];
                    
                    if (!value || value.trim() === '') {
                        this.errors[field] = field.replace('_', ' ').charAt(0).toUpperCase() + field.replace('_', ' ').slice(1) + ' is required.';
                        return false;
                    }
                    
                    if (field === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                        this.errors[field] = 'Please enter a valid email address.';
                        return false;
                    }
                    
                    if (field === 'phone' && !/^[0-9+\-\s]{10,}$/.test(value)) {
                        this.errors[field] = 'Please enter a valid phone number (min 10 digits, numbers only).';
                        return false;
                    }
                    
                    return true;
                },

                validateAllFields() {
                    let isValid = true;
                    ['full_name', 'email', 'phone'].forEach(field => {
                        if (!this.validateField(field)) {
                            isValid = false;
                        }
                    });
                    return isValid;
                },

                async bookTicket() {
                    if (!this.validateAllFields()) {
                        this.showToast('Please correct the errors in the form.', 'error');
                        return;
                    }

                    if (!this.selectedTicket.id) {
                        this.showToast('Please select a ticket type.', 'error');
                        return;
                    }

                    this.loading = true;
                    this.formData.ticket_type_id = this.selectedTicket.id; // Ensure ticket_type_id is set

                    try {
                        const response = await fetch('/tickets/book', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(this.formData)
                        });

                        const data = await response.json();

                        if (response.ok && data.snap_token) {
                            this.showToast('Redirecting to payment...', 'success');
                            window.snap.pay(data.snap_token, {
                                onSuccess: (result) => {
                                    this.showToast('Payment successful! Redirecting to ticket...', 'success');
                                    setTimeout(() => window.location.href = `/ticket/${data.order_id}`, 1500);
                                },
                                onPending: (result) => {
                                    this.showToast('Payment pending. Please complete the payment.', 'error');
                                    this.loading = false;
                                },
                                onError: (result) => {
                                    this.showToast('Payment failed. Please try again.', 'error');
                                    this.loading = false;
                                },
                                onClose: () => {
                                    this.showToast('Payment cancelled.', 'error');
                                    this.loading = false;
                                }
                            });
                        } else {
                            this.showToast(data.error || 'Failed to create order. Please try again.', 'error');
                            this.loading = false;
                        }
                    } catch (error) {
                        console.error('Booking error:', error);
                        this.showToast('An unexpected error occurred. Please try again.', 'error');
                        this.loading = false;
                    }
                },

                showToast(message, type) {
                    const id = ++this.toastId;
                    this.toasts.push({ id, message, type, visible: true });
                    setTimeout(() => {
                        this.removeToast(id);
                    }, 5000);
                    this.$nextTick(() => { lucide.createIcons(); });
                },

                removeToast(id) {
                    const toast = this.toasts.find(t => t.id === id);
                    if (toast) {
                        toast.visible = false;
                        setTimeout(() => {
                            this.toasts = this.toasts.filter(t => t.id !== id);
                        }, 150);
                    }
                }
            };
        }
    </script>
</body>
</html>