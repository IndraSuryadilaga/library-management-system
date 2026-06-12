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
    public function index(Request $request)
    {
        $reservations = Reservation::with(['user', 'book'])
            ->filter($request->only(['user_id', 'book_id', 'status', 'start_date', 'end_date']))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $users = User::pluck('name', 'id');
        $books = Book::pluck('title', 'id');

        // Define filter configurations
        $reservationFilters = [
            ['name' => 'user_id', 'label' => 'Pengguna', 'placeholder' => 'Semua Pengguna', 'options' => $users, 'value' => $request->query('user_id')],
            ['name' => 'book_id', 'label' => 'Buku', 'placeholder' => 'Semua Buku', 'options' => $books, 'value' => $request->query('book_id')],
            ['name' => 'status', 'label' => 'Status', 'placeholder' => 'Semua Status', 'options' => ['pending' => 'Pending', 'ready_for_pickup' => 'Ready for Pickup', 'cancelled' => 'Cancelled', 'fulfilled' => 'Fulfilled'], 'value' => $request->query('status')],
            ['name' => 'start_date', 'label' => 'Dari Tanggal Reservasi', 'type' => 'date', 'value' => $request->query('start_date')],
            ['name' => 'end_date', 'label' => 'Sampai Tanggal Reservasi', 'type' => 'date', 'value' => $request->query('end_date')],
        ];

        return view('pages.admin.reservations.index', compact('reservations', 'reservationFilters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::pluck('name', 'id');
        $books = Book::pluck('title', 'id');
        $items = Item::selectRaw("barcode || ' - ' || (SELECT title FROM books WHERE id = items.book_id) as full_item_name, id")->pluck('full_item_name', 'id');

        $reservationFields = [
            ['name' => 'user_id', 'label' => 'Pengguna', 'type' => 'select', 'options' => $users, 'value' => old('user_id'), 'required' => true],
            ['name' => 'book_id', 'label' => 'Buku', 'type' => 'select', 'options' => $books, 'value' => old('book_id'), 'required' => true],
            ['name' => 'item_id', 'label' => 'Item (Opsional)', 'type' => 'select', 'options' => $items, 'value' => old('item_id')],
            ['name' => 'reservation_date', 'label' => 'Tanggal Reservasi', 'type' => 'date', 'value' => old('reservation_date'), 'required' => true],
            ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['pending' => 'Pending', 'ready_for_pickup' => 'Ready for Pickup', 'cancelled' => 'Cancelled', 'fulfilled' => 'Fulfilled'], 'value' => old('status'), 'required' => true],
        ];

        return view('pages.admin.reservations.create', compact('reservationFields'));
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
        $reservationDetails = [
            ['label' => 'ID Reservasi', 'value' => $reservation->id, 'isMono' => true],
            ['label' => 'Pengguna', 'value' => $reservation->user->name],
            ['label' => 'Buku', 'value' => $reservation->book->title],
            ['label' => 'Item', 'value' => $reservation->item->barcode ?? '-', 'isMono' => true],
            ['label' => 'Tanggal Reservasi', 'value' => $reservation->reservation_date],
            ['label' => 'Status', 'value' => $reservation->status],
            ['label' => 'Dibuat pada', 'value' => $reservation->created_at->format('d F Y')],
            ['label' => 'Diperbarui pada', 'value' => $reservation->updated_at->format('d F Y')],
        ];

        return view('pages.admin.reservations.show', compact('reservation', 'reservationDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        $users = User::pluck('name', 'id');
        $books = Book::pluck('title', 'id');
        $items = Item::selectRaw("barcode || ' - ' || (SELECT title FROM books WHERE id = items.book_id) as full_item_name, id")->pluck('full_item_name', 'id');

        $reservationFields = [
            ['name' => 'user_id', 'label' => 'Pengguna', 'type' => 'select', 'options' => $users, 'value' => old('user_id', $reservation->user_id), 'required' => true],
            ['name' => 'book_id', 'label' => 'Buku', 'type' => 'select', 'options' => $books, 'value' => old('book_id', $reservation->book_id), 'required' => true],
            ['name' => 'item_id', 'label' => 'Item (Opsional)', 'type' => 'select', 'options' => $items, 'value' => old('item_id', $reservation->item_id)],
            ['name' => 'reservation_date', 'label' => 'Tanggal Reservasi', 'type' => 'date', 'value' => old('reservation_date', $reservation->reservation_date), 'required' => true],
            ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['pending' => 'Pending', 'ready_for_pickup' => 'Ready for Pickup', 'cancelled' => 'Cancelled', 'fulfilled' => 'Fulfilled'], 'value' => old('status', $reservation->status), 'required' => true],
        ];

        return view('pages.admin.reservations.edit', compact('reservation', 'reservationFields'));
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
