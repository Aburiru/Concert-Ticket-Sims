<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TicketType;

class AdminController extends Controller
{
    /**
     * Display a listing of ticket types.
     */
    public function index()
    {
        $ticketTypes = TicketType::all();
        return view('admin.tickets.index', compact('ticketTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:0',
            'remaining_stock' => 'required|integer|min:0',
        ]);

        TicketType::create($validated);

        return redirect()->route('admin.tickets.index')->with('success', 'Ticket type created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TicketType $ticketType)
    {
        return view('admin.tickets.show', compact('ticketType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TicketType $ticketType)
    {
        return view('admin.tickets.edit', compact('ticketType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TicketType $ticketType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:0',
            'remaining_stock' => 'required|integer|min:0',
        ]);

        $ticketType->update($validated);

        return redirect()->route('admin.tickets.index')->with('success', 'Ticket type updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketType $ticketType)
    {
        $ticketType->delete();

        return redirect()->route('admin.tickets.index')->with('success', 'Ticket type deleted successfully!');
    }
}
}
