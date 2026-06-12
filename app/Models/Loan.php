<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['item_id', 'user_id', 'loan_date', 'due_date', 'return_date'])]
class Loan extends Model
{
    use HasFactory;

    /**
     * Get the item associated with the loan.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the user who made the loan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, array $filters): void
    {
        // User filter
        $query->when($filters['user_id'] ?? false, function ($query, $userId) {
            $query->where('user_id', $userId);
        });

        // Item filter
        $query->when($filters['item_id'] ?? false, function ($query, $itemId) {
            $query->where('item_id', $itemId);
        });

        // Date range filter for loan_date
        $query->when($filters['start_date'] ?? false, function ($query, $startDate) {
            $query->whereDate('loan_date', '>=', $startDate);
        });

        $query->when($filters['end_date'] ?? false, function ($query, $endDate) {
            $query->whereDate('loan_date', '<=', $endDate);
        });
    }
}
