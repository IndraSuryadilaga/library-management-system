<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\User;
use App\Models\Item;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $loans = Loan::with(['user', 'item.book'])
            ->filter($request->only(['user_id', 'item_id', 'start_date', 'end_date']))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $users = User::pluck('name', 'id');
        $items = Item::selectRaw("barcode || ' - ' || (SELECT title FROM books WHERE id = items.book_id) as full_item_name, id")->pluck('full_item_name', 'id');

        // Define filter configurations
        $loanFilters = [
            ['name' => 'user_id', 'label' => 'Pengguna', 'placeholder' => 'Semua Pengguna', 'options' => $users, 'value' => $request->query('user_id')],
            ['name' => 'item_id', 'label' => 'Item', 'placeholder' => 'Semua Item', 'options' => $items, 'value' => $request->query('item_id')],
            ['name' => 'start_date', 'label' => 'Dari Tanggal Pinjam', 'type' => 'date', 'value' => $request->query('start_date')],
            ['name' => 'end_date', 'label' => 'Sampai Tanggal Pinjam', 'type' => 'date', 'value' => $request->query('end_date')],
        ];

        return view('pages.admin.loans.index', compact('loans', 'loanFilters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::pluck('name', 'id');
        $items = Item::where('status', 'available')->selectRaw("barcode || ' - ' || (SELECT title FROM books WHERE id = items.book_id) as full_item_name, id")->pluck('full_item_name', 'id');

        $loanFields = [
            ['name' => 'user_id', 'label' => 'Pengguna', 'type' => 'select', 'options' => $users, 'value' => old('user_id'), 'required' => true],
            ['name' => 'item_id', 'label' => 'Item', 'type' => 'select', 'options' => $items, 'value' => old('item_id'), 'required' => true],
            ['name' => 'loan_date', 'label' => 'Tanggal Pinjam', 'type' => 'date', 'value' => old('loan_date'), 'required' => true],
            ['name' => 'due_date', 'label' => 'Jatuh Tempo', 'type' => 'date', 'value' => old('due_date'), 'required' => true],
            ['name' => 'return_date', 'label' => 'Tanggal Kembali (Opsional)', 'type' => 'date', 'value' => old('return_date')],
        ];

        return view('pages.admin.loans.create', compact('loanFields'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'item_id' => 'required|exists:items,id',
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:loan_date',
            'return_date' => 'nullable|date|after_or_equal:loan_date',
        ]);

        $loan = Loan::create($request->all());

        // Update item status
        $item = Item::find($request->item_id);
        $item->status = 'loaned';
        $item->save();

        return redirect()->route('admin.loans.index')
            ->with('success', 'Loan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        $loanDetails = [
            ['label' => 'ID Peminjaman', 'value' => $loan->id, 'isMono' => true],
            ['label' => 'Pengguna', 'value' => $loan->user->name],
            ['label' => 'Item', 'value' => $loan->item->book->title . ' (' . $loan->item->barcode . ')'],
            ['label' => 'Tanggal Pinjam', 'value' => $loan->loan_date],
            ['label' => 'Jatuh Tempo', 'value' => $loan->due_date],
            ['label' => 'Tanggal Kembali', 'value' => $loan->return_date ?? '-'],
            ['label' => 'Dibuat pada', 'value' => $loan->created_at->format('d F Y')],
            ['label' => 'Diperbarui pada', 'value' => $loan->updated_at->format('d F Y')],
        ];

        return view('pages.admin.loans.show', compact('loan', 'loanDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Loan $loan)
    {
        $users = User::pluck('name', 'id');
        $items = Item::selectRaw("barcode || ' - ' || (SELECT title FROM books WHERE id = items.book_id) as full_item_name, id")->pluck('full_item_name', 'id');

        $loanFields = [
            ['name' => 'user_id', 'label' => 'Pengguna', 'type' => 'select', 'options' => $users, 'value' => old('user_id', $loan->user_id), 'required' => true],
            ['name' => 'item_id', 'label' => 'Item', 'type' => 'select', 'options' => $items, 'value' => old('item_id', $loan->item_id), 'required' => true],
            ['name' => 'loan_date', 'label' => 'Tanggal Pinjam', 'type' => 'date', 'value' => old('loan_date', $loan->loan_date), 'required' => true],
            ['name' => 'due_date', 'label' => 'Jatuh Tempo', 'type' => 'date', 'value' => old('due_date', $loan->due_date), 'required' => true],
            ['name' => 'return_date', 'label' => 'Tanggal Kembali (Opsional)', 'type' => 'date', 'value' => old('return_date', $loan->return_date)],
        ];

        return view('pages.admin.loans.edit', compact('loan', 'loanFields'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loan $loan)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'item_id' => 'required|exists:items,id',
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:loan_date',
            'return_date' => 'nullable|date|after_or_equal:loan_date',
        ]);

        // If the item was changed, update the old and new items' statuses
        if ($request->item_id != $loan->item_id) {
            $oldItem = Item::find($loan->item_id);
            $oldItem->status = 'available';
            $oldItem->save();

            $newItem = Item::find($request->item_id);
            $newItem->status = 'loaned';
            $newItem->save();
        }

        // If the book is returned, update the item's status
        if ($request->filled('return_date') && is_null($loan->return_date)) {
            $item = Item::find($request->item_id);
            $item->status = 'available';
            $item->save();
        }

        $loan->update($request->all());

        return redirect()->route('admin.loans.index')
            ->with('success', 'Loan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        // Update item status before deleting loan
        $item = Item::find($loan->item_id);
        if ($item) {
            $item->status = 'available';
            $item->save();
        }

        $loan->delete();

        return redirect()->route('admin.loans.index')
            ->with('success', 'Loan deleted successfully.');
    }
}
