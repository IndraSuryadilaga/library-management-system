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
    public function index()
    {
        $loans = Loan::with(['user', 'item.book'])->latest()->paginate(10);
        return view('pages.admin.loans.index', compact('loans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $items = Item::where('status', 'available')->get();
        return view('pages.admin.loans.create', compact('users', 'items'));
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
        return view('pages.admin.loans.show', compact('loan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Loan $loan)
    {
        $users = User::all();
        $items = Item::all(); // Show all items in edit, in case we need to change it
        return view('pages.admin.loans.edit', compact('loan', 'users', 'items'));
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
