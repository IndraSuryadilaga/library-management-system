<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Publisher;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $newestBooks = Book::latest()->take(4)->get();

        // Get two random genres
        $randomGenres = Genre::inRandomOrder()->take(2)->get();
        $genreA = $randomGenres->first();
        $genreB = $randomGenres->last();

        $genreABooks = Book::whereHas('genres', function ($query) use ($genreA) {
            if ($genreA) {
                $query->where('name', $genreA->name);
            }
        })->take(4)->get();

        $genreBBooks = Book::whereHas('genres', function ($query) use ($genreB) {
            if ($genreB) {
                $query->where('name', $genreB->name);
            }
        })->take(4)->get();

        return view('pages.index', compact('newestBooks', 'genreA', 'genreB', 'genreABooks', 'genreBBooks'));
    }

    public function catalog(Request $request)
    {
        $query = Book::query();

        // Search filter
        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                    ->orWhereHas('author', function ($q) use ($searchTerm) {
                        $q->where('name', 'like', $searchTerm);
                    });
            });
        }

        // Genre filter
        if ($request->has('genres') && !empty($request->genres)) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->whereIn('genres.id', $request->genres);
            });
        }

        // Author filter
        if ($request->has('authors') && !empty($request->authors)) {
            $query->whereIn('author_id', $request->authors);
        }

        // Publisher filter
        if ($request->has('publishers') && !empty($request->publishers)) {
            $query->whereIn('publisher_id', $request->publishers);
        }

        // Publication year filter
        if ($request->has('publication_years') && !empty($request->publication_years)) {
            $query->whereIn('publication_year', $request->publication_years);
        }

        $books = $query->paginate(12);
        $genres = Genre::all();
        $authors = Author::all();
        $publishers = Publisher::all();
        $publicationYears = Book::select('publication_year')->distinct()->orderBy('publication_year', 'desc')->pluck('publication_year');


        return view('pages.catalog', compact('books', 'genres', 'authors', 'publishers', 'publicationYears'));
    }

    public function showBook(Book $book)
    {
        return view('pages.show-book', compact('book'));
    }
}
