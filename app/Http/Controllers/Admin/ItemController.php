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
    public function index(Request $request)
    {
        $items = Item::with('book')
            ->filter($request->only(['search', 'book_id', 'status']))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $books = Book::pluck('title', 'id');

        // Define filter configurations
        $itemFilters = [
            [
                'name' => 'book_id',
                'label' => 'Buku',
                'placeholder' => 'Semua Buku',
                'options' => $books,
                'value' => $request->query('book_id')
            ],
            [
                'name' => 'status',
                'label' => 'Status',
                'placeholder' => 'Semua Status',
                'options' => [
                    'available' => 'Available',
                    'loaned' => 'Loaned',
                    'lost' => 'Lost',
                    'damaged' => 'Damaged',
                ],
                'value' => $request->query('status')
            ],
        ];

        return view('pages.admin.items.index', compact('items', 'itemFilters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $books = Book::pluck('title', 'id');

        $itemFields = [
            ['name' => 'book_id', 'label' => 'Buku', 'type' => 'select', 'options' => $books, 'value' => old('book_id'), 'required' => true],
            ['name' => 'barcode', 'label' => 'Barcode', 'value' => old('barcode'), 'required' => true],
            ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['available' => 'Available', 'loaned' => 'Loaned', 'lost' => 'Lost', 'damaged' => 'Damaged'], 'value' => old('status'), 'required' => true],
        ];

        return view('pages.admin.items.create', compact('itemFields'));
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
        $itemDetails = [
            ['label' => 'ID Item', 'value' => $item->id, 'isMono' => true],
            ['label' => 'Barcode', 'value' => $item->barcode, 'isMono' => true],
            ['label' => 'Judul Buku', 'value' => $item->book->title],
            ['label' => 'Status', 'value' => $item->status],
            ['label' => 'Dibuat pada', 'value' => $item->created_at->format('d F Y')],
            ['label' => 'Diperbarui pada', 'value' => $item->updated_at->format('d F Y')],
        ];

        return view('pages.admin.items.show', compact('item', 'itemDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        $books = Book::pluck('title', 'id');

        $itemFields = [
            ['name' => 'book_id', 'label' => 'Buku', 'type' => 'select', 'options' => $books, 'value' => old('book_id', $item->book_id), 'required' => true],
            ['name' => 'barcode', 'label' => 'Barcode', 'value' => old('barcode', $item->barcode), 'required' => true],
            ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['available' => 'Available', 'loaned' => 'Loaned', 'lost' => 'Lost', 'damaged' => 'Damaged'], 'value' => old('status', $item->status), 'required' => true],
        ];

        return view('pages.admin.items.edit', compact('item', 'itemFields'));
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
