<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['book_id', 'barcode', 'status'])]
class Item extends Model
{
    use HasFactory;

    // Define item statuses
    public const STATUS_AVAILABLE = 'available';
    public const STATUS_LOANED = 'loaned';
    public const STATUS_LOST = 'lost';
    public const STATUS_DAMAGED = 'damaged';

    /**
     * Get the book that owns the item.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the current loan for the item.
     */
    public function currentLoan()
    {
        return $this->hasOne(Loan::class)->latestOfMany();
    }

    /**
     * Get all loans for the item.
     */
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function scopeFilter($query, array $filters): void
    {
        // Search filter by barcode
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $searchTerm = '%' . trim($search) . '%';
            $query->whereRaw('LOWER(barcode) LIKE LOWER(?)', [$searchTerm]);
        });

        // Book filter
        $query->when($filters['book_id'] ?? false, function ($query, $bookId) {
            $query->where('book_id', $bookId);
        });

        // Status filter
        $query->when($filters['status'] ?? false, function ($query, $status) {
            $query->where('status', $status);
        });
    }
}
