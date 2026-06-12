<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Genre;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $books = Book::with(['author', 'publisher', 'genres'])
            ->filter($request->only(['search', 'author_id', 'publisher_id', 'genre_id']))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $authors = Author::pluck('name', 'id');
        $publishers = Publisher::pluck('name', 'id');
        $genres = Genre::pluck('name', 'id');

        // Definisikan konfigurasi filter di sini
        $bookFilters = [
            [
                'name' => 'author_id',
                'label' => 'Penulis',
                'placeholder' => 'Semua Penulis',
                'options' => $authors,
                'value' => $request->query('author_id')
            ],
            [
                'name' => 'publisher_id',
                'label' => 'Penerbit',
                'placeholder' => 'Semua Penerbit',
                'options' => $publishers,
                'value' => $request->query('publisher_id')
            ],
            [
                'name' => 'genre_id',
                'label' => 'Genre',
                'placeholder' => 'Semua Genre',
                'options' => $genres,
                'value' => $request->query('genre_id')
            ]
        ];

        return view('pages.admin.books.index', compact('books', 'bookFilters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Langsung konversi ke Array Key-Value di Controller
        $authors = Author::pluck('name', 'id')->toArray();
        $publishers = Publisher::pluck('name', 'id')->toArray();
        $genres = Genre::pluck('name', 'id')->toArray();

        $bookFields = [
            [
                'name' => 'title', 'label' => 'Judul Buku', 'value' => old('title'),
                'required' => true, 'fullWidth' => true
            ],
            [
                'name' => 'author_id', 'label' => 'Penulis', 'type' => 'select',
                'options' => $authors, 'value' => old('author_id'), 'required' => true
            ],
            [
                'name' => 'publisher_id', 'label' => 'Penerbit', 'type' => 'select',
                'options' => $publishers, 'value' => old('publisher_id'), 'required' => true
            ],
            [
                'name' => 'publication_year', 'label' => 'Tahun Terbit', 'type' => 'number',
                'value' => old('publication_year'), 'required' => true
            ],
            [
                'name' => 'isbn', 'label' => 'ISBN', 'value' => old('isbn')
            ],
            [
                'name' => 'genres', 'label' => 'Genre', 'type' => 'select', 'multiple' => true,
                'options' => $genres, 'value' => old('genres', []), 'fullWidth' => true
            ],
        ];

        // Hanya passing bookFields
        return view('pages.admin.books.create', compact('bookFields'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'publication_year' => 'required|integer|gt:1800|lt:2024',
            'isbn' => 'nullable|string|max:20|unique:books,isbn',
            'genres' => 'nullable|array',
            'genres.*' => 'exists:genres,id',
        ]);

        $book = Book::create($request->only('title', 'author_id', 'publisher_id', 'publication_year', 'isbn'));

        if ($request->has('genres')) {
            $book->genres()->sync($request->genres);
        }

        return redirect()->route('admin.books.index')
            ->with('success', 'Book created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $bookDetails = [
            ['label' => 'ID Buku', 'value' => $book->id, 'isMono' => true],
            ['label' => 'Judul', 'value' => $book->title],
            ['label' => 'Penulis', 'value' => $book->author->name],
            ['label' => 'Penerbit', 'value' => $book->publisher->name],
            ['label' => 'Tahun Terbit', 'value' => $book->publication_year],
            ['label' => 'ISBN', 'value' => $book->isbn ?? '-', 'isMono' => true],
            [
                'label' => 'Genre',
                'fullWidth' => true,
                // Menggunakan pluck()->implode() jauh lebih bersih daripada map()
                'slot' => $book->genres->pluck('name')->implode(', ')
            ],
            ['label' => 'Dibuat pada', 'value' => $book->created_at->format('d F Y')],
            ['label' => 'Diperbarui pada', 'value' => $book->updated_at->format('d F Y')],
        ];

        return view('pages.admin.books.show', compact('book', 'bookDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $authors = Author::pluck('name', 'id')->toArray();
        $publishers = Publisher::pluck('name', 'id')->toArray();
        $genres = Genre::pluck('name', 'id')->toArray();

        $bookFields = [
            [
                'name' => 'title', 'label' => 'Judul Buku', 'value' => old('title', $book->title),
                'required' => true, 'fullWidth' => true
            ],
            [
                'name' => 'author_id', 'label' => 'Penulis', 'type' => 'select',
                'options' => $authors, 'value' => old('author_id', $book->author_id), 'required' => true
            ],
            [
                'name' => 'publisher_id', 'label' => 'Penerbit', 'type' => 'select',
                'options' => $publishers, 'value' => old('publisher_id', $book->publisher_id), 'required' => true
            ],
            [
                'name' => 'publication_year', 'label' => 'Tahun Terbit', 'type' => 'number',
                'value' => old('publication_year', $book->publication_year), 'required' => true
            ],
            [
                'name' => 'isbn', 'label' => 'ISBN', 'value' => old('isbn', $book->isbn)
            ],
            [
                'name' => 'genres', 'label' => 'Genre', 'type' => 'select', 'multiple' => true,
                'options' => $genres, 'value' => old('genres', $book->genres->pluck('id')->toArray() ?? []),
                'fullWidth' => true
            ],
        ];

        return view('pages.admin.books.edit', compact('book', 'bookFields'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'publication_year' => 'required|integer|gt:1800|lt:2024',
            'isbn' => 'nullable|string|max:20|unique:books,isbn,' . $book->id,
            'genres' => 'nullable|array',
            'genres.*' => 'exists:genres,id',
        ]);

        $book->update($request->only('title', 'author_id', 'publisher_id', 'publication_year', 'isbn'));

        if ($request->has('genres')) {
            $book->genres()->sync($request->genres);
        } else {
            $book->genres()->detach();
        }

        return redirect()->route('admin.books.index')
            ->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->genres()->detach();
        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Book deleted successfully.');
    }
}
