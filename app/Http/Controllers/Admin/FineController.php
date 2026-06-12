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
    public function index(Request $request)
    {
        $fines = Fine::with(['user', 'loan'])
            ->filter($request->only(['user_id', 'loan_id', 'paid_status', 'start_date', 'end_date']))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $users = User::pluck('name', 'id');
        $loans = Loan::selectRaw("id || ' - ' || (SELECT name FROM users WHERE id = loans.user_id) as loan_info, id")->pluck('loan_info', 'id');

        // Define filter configurations
        $fineFilters = [
            [
                'name' => 'user_id',
                'label' => 'Pengguna',
                'placeholder' => 'Semua Pengguna',
                'options' => $users,
                'value' => $request->query('user_id')
            ],
            [
                'name' => 'loan_id',
                'label' => 'Peminjaman',
                'placeholder' => 'Semua Peminjaman',
                'options' => $loans,
                'value' => $request->query('loan_id')
            ],
            [
                'name' => 'paid_status',
                'label' => 'Status Pembayaran',
                'placeholder' => 'Semua Status',
                'options' => [
                    'paid' => 'Lunas',
                    'unpaid' => 'Belum Lunas',
                ],
                'value' => $request->query('paid_status')
            ],
            [
                'name' => 'start_date',
                'label' => 'Dari Tanggal Denda',
                'type' => 'date',
                'value' => $request->query('start_date')
            ],
            [
                'name' => 'end_date',
                'label' => 'Sampai Tanggal Denda',
                'type' => 'date',
                'value' => $request->query('end_date')
            ],
        ];

        return view('pages.admin.fines.index', compact('fines', 'fineFilters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::pluck('name', 'id');
        $loans = Loan::selectRaw("id || ' - ' || (SELECT name FROM users WHERE id = loans.user_id) as loan_info, id")->pluck('loan_info', 'id');

        $fineFields = [
            ['name' => 'user_id', 'label' => 'Pengguna', 'type' => 'select', 'options' => $users, 'value' => old('user_id'), 'required' => true],
            ['name' => 'loan_id', 'label' => 'Peminjaman', 'type' => 'select', 'options' => $loans, 'value' => old('loan_id'), 'required' => true],
            ['name' => 'amount', 'label' => 'Jumlah', 'type' => 'number', 'value' => old('amount'), 'required' => true],
            ['name' => 'reason', 'label' => 'Alasan', 'type' => 'textarea', 'value' => old('reason'), 'required' => true],
            ['name' => 'paid_at', 'label' => 'Dibayar Pada (Opsional)', 'type' => 'date', 'value' => old('paid_at')],
        ];

        return view('pages.admin.fines.create', compact('fineFields'));
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
        $fineDetails = [
            ['label' => 'ID Denda', 'value' => $fine->id, 'isMono' => true],
            ['label' => 'Pengguna', 'value' => $fine->user->name],
            ['label' => 'Peminjaman', 'value' => $fine->loan->id, 'isMono' => true],
            ['label' => 'Jumlah', 'value' => 'Rp ' . number_format($fine->amount, 2, ',', '.')],
            ['label' => 'Alasan', 'value' => $fine->reason, 'fullWidth' => true],
            ['label' => 'Dibayar Pada', 'value' => $fine->paid_at?->format('d F Y') ?? '-'],
            ['label' => 'Dibuat pada', 'value' => $fine->created_at->format('d F Y')],
            ['label' => 'Diperbarui pada', 'value' => $fine->updated_at->format('d F Y')],
        ];

        return view('pages.admin.fines.show', compact('fine', 'fineDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fine $fine)
    {
        $users = User::pluck('name', 'id');
        $loans = Loan::selectRaw("id || ' - ' || (SELECT name FROM users WHERE id = loans.user_id) as loan_info, id")->pluck('loan_info', 'id');

        $fineFields = [
            ['name' => 'user_id', 'label' => 'Pengguna', 'type' => 'select', 'options' => $users, 'value' => old('user_id', $fine->user_id), 'required' => true],
            ['name' => 'loan_id', 'label' => 'Peminjaman', 'type' => 'select', 'options' => $loans, 'value' => old('loan_id', $fine->loan_id), 'required' => true],
            ['name' => 'amount', 'label' => 'Jumlah', 'type' => 'number', 'value' => old('amount', $fine->amount), 'required' => true],
            ['name' => 'reason', 'label' => 'Alasan', 'type' => 'textarea', 'value' => old('reason', $fine->reason), 'required' => true],
            ['name' => 'paid_at', 'label' => 'Dibayar Pada (Opsional)', 'type' => 'date', 'value' => old('paid_at', $fine->paid_at?->format('Y-m-d'))],
        ];

        return view('pages.admin.fines.edit', compact('fine', 'fineFields'));
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
