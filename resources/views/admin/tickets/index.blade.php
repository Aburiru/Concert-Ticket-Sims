<!-- resources/views/admin/tickets/index.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="font-poppins text-4xl font-black uppercase">Manage Ticket Types</h1>
        <a href="{{ route('admin.tickets.create') }}" class="bg-yellow text-black font-poppins font-bold uppercase px-6 py-2 rounded-xl border-4 border-black shadow-neobrutalism hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all">
            Add New Ticket Type
        </a>
    </div>

    @if (session('success'))
        <div class="bg-success text-white p-4 rounded-xl border-4 border-black shadow-neobrutalism mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border-4 border-black rounded-2xl p-8 shadow-neobrutalism">
        <table class="min-w-full divide-y divide-black">
            <thead class="bg-surface">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-r-4 border-black">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-r-4 border-black">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-r-4 border-black">Price</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-r-4 border-black">Quota</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider border-r-4 border-black">Remaining Stock</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black">
                @foreach ($ticketTypes as $ticketType)
                    <tr class="hover:bg-surface transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap border-r-4 border-black">{{ $ticketType->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap border-r-4 border-black">{{ $ticketType->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap border-r-4 border-black">Rp{{ number_format($ticketType->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap border-r-4 border-black">{{ $ticketType->quota }}</td>
                        <td class="px-6 py-4 whitespace-nowrap border-r-4 border-black">{{ $ticketType->remaining_stock }}</td>
                        <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                            <a href="{{ route('admin.tickets.edit', $ticketType->id) }}" class="text-cyan hover:text-cyan/80 font-bold">Edit</a>
                            <form action="{{ route('admin.tickets.destroy', $ticketType->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-danger hover:text-danger/80 font-bold">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection