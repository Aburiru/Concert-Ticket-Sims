<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Concert Ticket Booking System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-background);
            color: var(--color-text);
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-background text-text selection:bg-yellow selection:text-text font-inter">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-yellow border-r-4 border-black shadow-neobrutalism flex flex-col p-6">
            <div class="flex items-center space-x-3 mb-10">
                <i data-lucide="ticket" class="w-8 h-8 text-black"></i>
                <span class="font-poppins text-2xl font-bold uppercase tracking-tighter">ConcertTIK</span>
            </div>
            <nav class="space-y-4 flex-1">
                <a href="{{ route('admin.tickets.index') }}" class="flex items-center space-x-3 p-3 rounded-xl border-4 border-black bg-white shadow-neobrutalism hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span class="font-poppins font-bold uppercase text-sm">Dashboard</span>
                </a>
                <a href="{{ route('admin.tickets.index') }}" class="flex items-center space-x-3 p-3 rounded-xl border-4 border-black bg-white shadow-neobrutalism hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all">
                    <i data-lucide="ticket" class="w-5 h-5"></i>
                    <span class="font-poppins font-bold uppercase text-sm">Ticket Types</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center space-x-3 p-3 rounded-xl border-4 border-black bg-white shadow-neobrutalism hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all">
                    <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                    <span class="font-poppins font-bold uppercase text-sm">Orders</span>
                </a>
            </nav>
            <div class="mt-auto">
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center space-x-3 p-3 rounded-xl border-4 border-black bg-black text-white shadow-neobrutalism hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                        <span class="font-poppins font-bold uppercase text-sm">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            @yield('content')
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>