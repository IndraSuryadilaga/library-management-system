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
}
