<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['title', 'isbn', 'publication_year', 'author_id', 'publisher_id'])]
class Book extends Model
{
    use HasFactory;

    /**
     * Get the author of the book.
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Get the publisher of the book.
     */
    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    /**
     * Get the genres associated with the book.
     */
    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    /**
     * Get the items (physical copies) for the book.
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function scopeFilter($query, array $filters): void
    {
        // Search filter
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $searchTerm = '%' . trim($search) . '%';
            $query->where(function ($q) use ($searchTerm) {
                // Menggunakan whereRaw LOWER untuk mengatasi case-sensitivity jika beda DB
                $q->whereRaw('LOWER(title) LIKE LOWER(?)', [$searchTerm])
                    ->orWhereRaw('LOWER(isbn) LIKE LOWER(?)', [$searchTerm]);
            });
        });

        // Author filter
        $query->when($filters['author_id'] ?? false, function ($query, $authorId) {
            $query->where('author_id', $authorId);
        });

        // Publisher filter
        $query->when($filters['publisher_id'] ?? false, function ($query, $publisherId) {
            $query->where('publisher_id', $publisherId);
        });

        // Genre filter
        $query->when($filters['genre_id'] ?? false, function ($query, $genreId) {
            $query->whereHas('genres', function ($q) use ($genreId) {
                $q->where('genres.id', $genreId);
            });
        });
    }
}
