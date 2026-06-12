<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'book_id', 'item_id', 'reservation_date', 'status'])]
class Reservation extends Model
{
    use HasFactory;

    // Define reservation statuses
    public const STATUS_PENDING = 'pending';
    public const STATUS_READY_FOR_PICKUP = 'ready_for_pickup';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_FULFILLED = 'fulfilled';

    /**
     * Get the user who made the reservation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that was reserved (if a general book reservation).
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the specific item that was reserved (if an item-specific reservation).
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function scopeFilter($query, array $filters): void
    {
        // User filter
        $query->when($filters['user_id'] ?? false, function ($query, $userId) {
            $query->where('user_id', $userId);
        });

        // Book filter
        $query->when($filters['book_id'] ?? false, function ($query, $bookId) {
            $query->where('book_id', $bookId);
        });

        // Status filter
        $query->when($filters['status'] ?? false, function ($query, $status) {
            $query->where('status', $status);
        });

        // Date range filter for reservation_date
        $query->when($filters['start_date'] ?? false, function ($query, $startDate) {
            $query->whereDate('reservation_date', '>=', $startDate);
        });

        $query->when($filters['end_date'] ?? false, function ($query, $endDate) {
            $query->whereDate('reservation_date', '<=', $endDate);
        });
    }
}
