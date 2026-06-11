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
    public function index()
    {
        $books = Book::with(['author', 'publisher'])->latest()->paginate(10);
        return view('pages.admin.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = Author::all();
        $publishers = Publisher::all();
        $genres = Genre::all();
        return view('pages.admin.books.create', compact('authors', 'publishers', 'genres'));
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
            'publication_year' => 'required|integer|min:1000|max:' . date('Y'),
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
        return view('pages.admin.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $authors = Author::all();
        $publishers = Publisher::all();
        $genres = Genre::all();
        return view('pages.admin.books.edit', compact('book', 'authors', 'publishers', 'genres'));
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
            'publication_year' => 'required|integer|min:1000|max:' . date('Y'),
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
