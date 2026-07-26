<!-- resources/views/admin/tickets/show.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto bg-white border-4 border-black rounded-3xl p-10 shadow-neobrutalism">
    <h1 class="font-poppins text-3xl font-black uppercase mb-8 text-center underline decoration-yellow decoration-8 underline-offset-4">Ticket Type Details: {{ $ticketType->name }}</h1>

    <div class="space-y-6 text-lg">
        <div>
            <span class="block font-poppins font-bold uppercase text-sm mb-1 text-text/60">ID:</span>
            <span class="font-medium">{{ $ticketType->id }}</span>
        </div>
        <div>
            <span class="block font-poppins font-bold uppercase text-sm mb-1 text-text/60">Name:</span>
            <span class="font-medium">{{ $ticketType->name }}</span>
        </div>
        <div>
            <span class="block font-poppins font-bold uppercase text-sm mb-1 text-text/60">Price:</span>
            <span class="font-medium">Rp{{ number_format($ticketType->price, 0, ',', '.') }}</span>
        </div>
        <div>
            <span class="block font-poppins font-bold uppercase text-sm mb-1 text-text/60">Quota:</span>
            <span class="font-medium">{{ $ticketType->quota }}</span>
        </div>
        <div>
            <span class="block font-poppins font-bold uppercase text-sm mb-1 text-text/60">Remaining Stock:</span>
            <span class="font-medium">{{ $ticketType->remaining_stock }}</span>
        </div>
        <div>
            <span class="block font-poppins font-bold uppercase text-sm mb-1 text-text/60">Created At:</span>
            <span class="font-medium">{{ $ticketType->created_at->format('M d, Y H:i') }}</span>
        </div>
        <div>
            <span class="block font-poppins font-bold uppercase text-sm mb-1 text-text/60">Last Updated:</span>
            <span class="font-medium">{{ $ticketType->updated_at->format('M d, Y H:i') }}</span>
        </div>
    </div>

    <div class="mt-8 flex justify-center">
        <a href="{{ route('admin.tickets.index') }}" class="bg-black text-white font-poppins font-bold uppercase px-8 py-3 rounded-xl border-4 border-black shadow-neobrutalism hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all">
            Back to List
        </a>
    </div>
</div>
@endsection