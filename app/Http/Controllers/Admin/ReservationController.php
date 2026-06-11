<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Book;
use App\Models\Item;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::with(['user', 'book'])->latest()->paginate(10);
        return view('pages.admin.reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $books = Book::all();
        $items = Item::where('status', 'available')->get();
        return view('pages.admin.reservations.create', compact('users', 'books', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'item_id' => 'nullable|exists:items,id',
            'reservation_date' => 'required|date',
            'status' => 'required|in:pending,ready_for_pickup,cancelled,fulfilled',
        ]);

        Reservation::create($request->all());

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Reservation created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        return view('pages.admin.reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        $users = User::all();
        $books = Book::all();
        $items = Item::all();
        return view('pages.admin.reservations.edit', compact('reservation', 'users', 'books', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'item_id' => 'nullable|exists:items,id',
            'reservation_date' => 'required|date',
            'status' => 'required|in:pending,ready_for_pickup,cancelled,fulfilled',
        ]);

        $reservation->update($request->all());

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Reservation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Reservation deleted successfully.');
    }
}
