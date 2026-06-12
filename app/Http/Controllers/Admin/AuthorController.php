<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $authors = Author::filter($request->only(['search', 'start_date', 'end_date']))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $authorFilters = [
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

        return view('pages.admin.authors.index', compact('authors', 'authorFilters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authorFields = [
            [
                'name' => 'name',
                'label' => 'Nama',
                'value' => old('name'),
                'required' => true,
                'fullWidth' => true
            ],
            [
                'name' => 'bio',
                'label' => 'Biografi',
                'type' => 'textarea',
                'rows' => 6,
                'value' => old('bio'),
                'helper' => 'Berikan biografi singkat tentang penulis.',
                'fullWidth' => true
            ]
        ];

        return view('pages.admin.authors.create', compact('authorFields'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
        ]);

        Author::create($request->all());

        return redirect()->route('admin.authors.index')
                         ->with('success', 'Author created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        $authorDetails = [
            ['label' => 'ID Penulis', 'value' => $author->id, 'isMono' => true],
            ['label' => 'Jumlah Buku', 'value' => $author->books()->count(), 'isMono' => true],
            ['label' => 'Dibuat pada', 'value' => $author->created_at->format('d F Y')],
            ['label' => 'Diperbarui pada', 'value' => $author->updated_at->format('d F Y')],
            [
                'label' => 'Biografi',
                'fullWidth' => true,
                'slot' => $author->bio ? \Illuminate\Support\Str::markdown($author->bio) : '<p class="text-dusty italic">Biografi tidak tersedia.</p>'
            ],
        ];

        return view('pages.admin.authors.show', compact('author', 'authorDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        $authorFields = [
            [
                'name' => 'name',
                'label' => 'Nama',
                'value' => old('name', $author->name),
                'required' => true,
                'fullWidth' => true
            ],
            [
                'name' => 'bio',
                'label' => 'Biografi',
                'type' => 'textarea',
                'rows' => 6,
                'value' => old('bio', $author->bio),
                'helper' => 'Berikan biografi singkat tentang penulis.',
                'fullWidth' => true
            ]
        ];

        return view('pages.admin.authors.edit', compact('author', 'authorFields'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
        ]);

        $author->update($request->all());

        return redirect()->route('admin.authors.index')
                         ->with('success', 'Author updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();

        return redirect()->route('admin.authors.index')
                         ->with('success', 'Author deleted successfully.');
    }
}
