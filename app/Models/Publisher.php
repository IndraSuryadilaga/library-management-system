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

    public function scopeFilter($query, array $filters): void
    {
        // Search filter by name or email
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $searchTerm = '%' . trim($search) . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->whereRaw('LOWER(name) LIKE LOWER(?)', [$searchTerm])
                    ->orWhereRaw('LOWER(email) LIKE LOWER(?)', [$searchTerm]);
            });
        });

        // Date range filter for created_at
        $query->when($filters['start_date'] ?? false, function ($query, $startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        });

        $query->when($filters['end_date'] ?? false, function ($query, $endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        });
    }
}
