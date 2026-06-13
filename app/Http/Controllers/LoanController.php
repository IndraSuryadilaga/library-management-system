<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    /**
     * Show the form for creating a new loan request.
     */
    public function create(Book $book)
    {
        // You might want to add logic here to check if the book is available for loan
        return view('pages.loan.create', compact('book'));
    }

    /**
     * Store a newly created loan request in storage.
     */
    public function store(Request $request, Book $book)
    {
        $request->validate([
            'loan_date' => 'required|date|after_or_equal:today',
        ]);

        // Create the loan
        Loan::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'loan_date' => $request->loan_date,
            'due_date' => now()->addDays(7),
            'status' => 'PENDING',
        ]);

        return redirect()->route('show.book', $book)->with('success', 'Pengajuan peminjaman berhasil dikirim. Silakan tunggu konfirmasi dari admin.');
    }
}
