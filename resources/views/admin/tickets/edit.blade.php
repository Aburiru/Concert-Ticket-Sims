<!-- resources/views/admin/tickets/edit.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto bg-white border-4 border-black rounded-3xl p-10 shadow-neobrutalism">
    <h1 class="font-poppins text-3xl font-black uppercase mb-8 text-center underline decoration-yellow decoration-8 underline-offset-4">Edit Ticket Type: {{ $ticketType->name }}</h1>

    <form action="{{ route('admin.tickets.update', $ticketType->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        <div>
            <label for="name" class="block font-poppins font-bold uppercase text-sm mb-2">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $ticketType->name) }}" class="w-full bg-white border-3 border-black p-4 rounded-xl font-medium focus:outline-none focus:ring-4 focus:ring-yellow shadow-[4px_4px_0px_0px_#000000] transition-all" required>
            @error('name')
                <p class="text-danger text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="price" class="block font-poppins font-bold uppercase text-sm mb-2">Price</label>
            <input type="number" name="price" id="price" step="0.01" value="{{ old('price', $ticketType->price) }}" class="w-full bg-white border-3 border-black p-4 rounded-xl font-medium focus:outline-none focus:ring-4 focus:ring-yellow shadow-[4px_4px_0px_0px_#000000] transition-all" required>
            @error('price')
                <p class="text-danger text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="quota" class="block font-poppins font-bold uppercase text-sm mb-2">Quota</label>
            <input type="number" name="quota" id="quota" value="{{ old('quota', $ticketType->quota) }}" class="w-full bg-white border-3 border-black p-4 rounded-xl font-medium focus:outline-none focus:ring-4 focus:ring-yellow shadow-[4px_4px_0px_0px_#000000] transition-all" required>
            @error('quota')
                <p class="text-danger text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="remaining_stock" class="block font-poppins font-bold uppercase text-sm mb-2">Remaining Stock</label>
            <input type="number" name="remaining_stock" id="remaining_stock" value="{{ old('remaining_stock', $ticketType->remaining_stock) }}" class="w-full bg-white border-3 border-black p-4 rounded-xl font-medium focus:outline-none focus:ring-4 focus:ring-yellow shadow-[4px_4px_0px_0px_#000000] transition-all" required>
            @error('remaining_stock')
                <p class="text-danger text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="w-full bg-black text-white font-poppins font-black uppercase text-xl py-4 rounded-xl border-4 border-black shadow-neobrutalism hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none active:translate-x-[6px] active:translate-y-[6px] transition-all">
            Update Ticket Type
        </button>
    </form>
</div>
@endsection