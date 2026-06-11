<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'address', 'phone', 'email'])]
class Publisher extends Model
{
    use HasFactory;

    /**
     * Get the books published by the publisher.
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
