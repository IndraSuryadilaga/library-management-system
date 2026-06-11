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
}
