<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Book;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::with('book')->latest()->paginate(10);
        return view('pages.admin.items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $books = Book::all();
        return view('pages.admin.items.create', compact('books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'barcode' => 'required|string|max:255|unique:items,barcode',
            'status' => 'required|in:available,loaned,lost,damaged',
        ]);

        Item::create($request->all());

        return redirect()->route('admin.items.index')
            ->with('success', 'Item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        return view('pages.admin.items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        $books = Book::all();
        return view('pages.admin.items.edit', compact('item', 'books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'barcode' => 'required|string|max:255|unique:items,barcode,' . $item->id,
            'status' => 'required|in:available,loaned,lost,damaged',
        ]);

        $item->update($request->all());

        return redirect()->route('admin.items.index')
            ->with('success', 'Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('admin.items.index')
            ->with('success', 'Item deleted successfully.');
    }
}
