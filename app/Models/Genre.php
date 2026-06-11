<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name'])]
class Genre extends Model
{
    use HasFactory;

    /**
     * Get the books that belong to this genre.
     */
    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
}
