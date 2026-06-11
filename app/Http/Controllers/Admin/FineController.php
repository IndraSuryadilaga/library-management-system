<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fine;
use App\Models\User;
use App\Models\Loan;
use Illuminate\Http\Request;

class FineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fines = Fine::with(['user', 'loan'])->latest()->paginate(10);
        return view('pages.admin.fines.index', compact('fines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $loans = Loan::all();
        return view('pages.admin.fines.create', compact('users', 'loans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'loan_id' => 'required|exists:loans,id',
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string|max:255',
            'paid_at' => 'nullable|date',
        ]);

        Fine::create($request->all());

        return redirect()->route('admin.fines.index')
            ->with('success', 'Fine created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fine $fine)
    {
        return view('pages.admin.fines.show', compact('fine'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fine $fine)
    {
        $users = User::all();
        $loans = Loan::all();
        return view('pages.admin.fines.edit', compact('fine', 'users', 'loans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fine $fine)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'loan_id' => 'required|exists:loans,id',
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string|max:255',
            'paid_at' => 'nullable|date',
        ]);

        $fine->update($request->all());

        return redirect()->route('admin.fines.index')
            ->with('success', 'Fine updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fine $fine)
    {
        $fine->delete();

        return redirect()->route('admin.fines.index')
            ->with('success', 'Fine deleted successfully.');
    }
}
