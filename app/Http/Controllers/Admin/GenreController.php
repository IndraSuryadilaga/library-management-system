<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $genres = Genre::filter($request->only(['search', 'start_date', 'end_date']))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $genreFilters = [
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

        return view('pages.admin.genres.index', compact('genres', 'genreFilters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genreFields = [
            ['name' => 'name', 'label' => 'Nama Genre', 'value' => old('name'), 'required' => true, 'fullWidth' => true],
        ];

        return view('pages.admin.genres.create', compact('genreFields'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:genres,name',
        ]);

        Genre::create($request->only('name'));

        return redirect()->route('admin.genres.index')
            ->with('success', 'Genre created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        $genreDetails = [
            ['label' => 'ID Genre', 'value' => $genre->id, 'isMono' => true],
            ['label' => 'Nama Genre', 'value' => $genre->name],
            ['label' => 'Jumlah Buku', 'value' => $genre->books()->count(), 'isMono' => true],
            ['label' => 'Dibuat pada', 'value' => $genre->created_at->format('d F Y')],
            ['label' => 'Diperbarui pada', 'value' => $genre->updated_at->format('d F Y')],
        ];

        return view('pages.admin.genres.show', compact('genre', 'genreDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre)
    {
        $genreFields = [
            ['name' => 'name', 'label' => 'Nama Genre', 'value' => old('name', $genre->name), 'required' => true, 'fullWidth' => true],
        ];

        return view('pages.admin.genres.edit', compact('genre', 'genreFields'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:genres,name,' . $genre->id,
        ]);

        $genre->update($request->only('name'));

        return redirect()->route('admin.genres.index')
            ->with('success', 'Genre updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();

        return redirect()->route('admin.genres.index')
            ->with('success', 'Genre deleted successfully.');
    }
}
