<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $publishers = Publisher::filter($request->only(['search', 'start_date', 'end_date']))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $publisherFilters = [
            [
                'name' => 'start_date',
                'label' => 'Dari Tanggal',
                'type' => 'date',
                'value' => request('start_date')
            ],
            [
                'name' => 'end_date',
                'label' => 'Sampai Tanggal',
                'type' => 'date',
                'value' => request('end_date')
            ]
        ];

        return view('pages.admin.publishers.index', compact('publishers', 'publisherFilters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $publisherFields = [
            ['name' => 'name', 'label' => 'Nama Penerbit', 'value' => old('name'), 'required' => true, 'fullWidth' => true],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'value' => old('email')],
            ['name' => 'phone', 'label' => 'Telepon', 'type' => 'tel', 'value' => old('phone')],
            ['name' => 'address', 'label' => 'Alamat', 'type' => 'textarea', 'value' => old('address'), 'fullWidth' => true],
        ];

        return view('pages.admin.publishers.create', compact('publisherFields'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:publishers,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        Publisher::create($request->all());

        return redirect()->route('admin.publishers.index')
            ->with('success', 'Publisher created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Publisher $publisher)
    {
        $publisherDetails = [
            ['label' => 'ID Penerbit', 'value' => $publisher->id, 'isMono' => true],
            ['label' => 'Nama Penerbit', 'value' => $publisher->name],
            ['label' => 'Email', 'value' => $publisher->email ?? '-'],
            ['label' => 'Telepon', 'value' => $publisher->phone ?? '-'],
            ['label' => 'Alamat', 'value' => $publisher->address ?? '-', 'fullWidth' => true],
            ['label' => 'Jumlah Buku', 'value' => $publisher->books()->count(), 'isMono' => true],
            ['label' => 'Dibuat pada', 'value' => $publisher->created_at->format('d F Y')],
            ['label' => 'Diperbarui pada', 'value' => $publisher->updated_at->format('d F Y')],
        ];

        return view('pages.admin.publishers.show', compact('publisher', 'publisherDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publisher $publisher)
    {
        $publisherFields = [
            ['name' => 'name', 'label' => 'Nama Penerbit', 'value' => old('name', $publisher->name), 'required' => true, 'fullWidth' => true],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'value' => old('email', $publisher->email)],
            ['name' => 'phone', 'label' => 'Telepon', 'type' => 'tel', 'value' => old('phone', $publisher->phone)],
            ['name' => 'address', 'label' => 'Alamat', 'type' => 'textarea', 'value' => old('address', $publisher->address), 'fullWidth' => true],
        ];

        return view('pages.admin.publishers.edit', compact('publisher', 'publisherFields'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publisher $publisher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:publishers,email,' . $publisher->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $publisher->update($request->all());

        return redirect()->route('admin.publishers.index')
            ->with('success', 'Publisher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return redirect()->route('admin.publishers.index')
            ->with('success', 'Publisher deleted successfully.');
    }
}
