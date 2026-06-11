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
}
