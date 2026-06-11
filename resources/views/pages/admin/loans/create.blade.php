@extends('pages.admin.admin')

@section('title', 'Tambah Peminjaman Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-bento-gap">
        <div>
            <h1 class="font-display text-3xl font-semibold text-bark-500">Tambah Peminjaman Baru</h1>
            <p class="font-body text-base text-dusty mt-1">Isi formulir di bawah untuk menambahkan peminjaman baru.</p>
        </div>
        <x-atoms.button variant="tertiary" href="{{ route('admin.loans.index') }}">
            ← Kembali ke Daftar
        </x-atoms.button>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-card relative mb-bento-gap" role="alert">
            <strong class="font-bold">Oops! Terjadi kesalahan.</strong>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-parchment border border-cream-200 rounded-card-lg p-6 paper-grain">
        <form action="{{ route('admin.loans.store') }}" method="POST">
            @csrf
            @php
                $loanFields = [
                    [
                        'name' => 'user_id',
                        'label' => 'Pengguna',
                        'type' => 'select',
                        'options' => $users->pluck('name', 'id')->toArray(),
                        'value' => old('user_id'),
                        'required' => true
                    ],
                    [
                        'name' => 'item_id',
                        'label' => 'Item',
                        'type' => 'select',
                        'options' => $items->pluck('barcode', 'id')->toArray(),
                        'value' => old('item_id'),
                        'required' => true
                    ],
                    [
                        'name' => 'loan_date',
                        'label' => 'Tanggal Pinjam',
                        'type' => 'date',
                        'value' => old('loan_date'),
                        'required' => true
                    ],
                    [
                        'name' => 'due_date',
                        'label' => 'Jatuh Tempo',
                        'type' => 'date',
                        'value' => old('due_date'),
                        'required' => true
                    ],
                    [
                        'name' => 'return_date',
                        'label' => 'Tanggal Kembali (Opsional)',
                        'type' => 'date',
                        'value' => old('return_date'),
                    ],
                ];
            @endphp

            <x-organisms.dynamic-form :fields="$loanFields" />

        </form>
    </div>
</div>
@endsection
