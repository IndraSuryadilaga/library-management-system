<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'loan_id', 'amount', 'reason', 'paid_at'])]
class Fine extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'paid_at' => 'datetime',
        ];
    }

    /**
     * Get the user who incurred the fine.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the loan associated with the fine.
     */
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function scopeFilter($query, array $filters): void
    {
        // User filter
        $query->when($filters['user_id'] ?? false, function ($query, $userId) {
            $query->where('user_id', $userId);
        });

        // Loan filter
        $query->when($filters['loan_id'] ?? false, function ($query, $loanId) {
            $query->where('loan_id', $loanId);
        });

        // Payment status filter
        $query->when($filters['paid_status'] ?? false, function ($query, $paidStatus) {
            if ($paidStatus == 'paid') {
                $query->whereNotNull('paid_at');
            } elseif ($paidStatus == 'unpaid') {
                $query->whereNull('paid_at');
            }
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
