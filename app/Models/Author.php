<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'bio'])]
class Author extends Model
{
    use HasFactory;

    /**
     * Get the books by the author.
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
