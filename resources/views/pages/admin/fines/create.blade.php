@extends('pages.admin.admin')

@section('title', 'Tambah Denda Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-bento-gap">
        <div>
            <h1 class="font-display text-3xl font-semibold text-bark-500">Tambah Denda Baru</h1>
            <p class="font-body text-base text-dusty mt-1">Isi formulir di bawah untuk menambahkan denda baru.</p>
        </div>
        <x-atoms.button variant="tertiary" href="{{ route('admin.fines.index') }}">
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
        <form action="{{ route('admin.fines.store') }}" method="POST">
            @csrf
            @php
                $fineFields = [
                    [
                        'name' => 'user_id',
                        'label' => 'Pengguna',
                        'type' => 'select',
                        'options' => $users->pluck('name', 'id')->toArray(),
                        'value' => old('user_id'),
                        'required' => true
                    ],
                    [
                        'name' => 'loan_id',
                        'label' => 'Peminjaman',
                        'type' => 'select',
                        'options' => $loans->pluck('id', 'id')->toArray(),
                        'value' => old('loan_id'),
                        'required' => true
                    ],
                    [
                        'name' => 'amount',
                        'label' => 'Jumlah',
                        'type' => 'number',
                        'value' => old('amount'),
                        'required' => true
                    ],
                    [
                        'name' => 'reason',
                        'label' => 'Alasan',
                        'type' => 'textarea',
                        'value' => old('reason'),
                        'required' => true
                    ],
                    [
                        'name' => 'paid_at',
                        'label' => 'Dibayar Pada (Opsional)',
                        'type' => 'date',
                        'value' => old('paid_at'),
                    ],
                ];
            @endphp

            <x-organisms.dynamic-form :fields="$fineFields" />
        </form>
    </div>
</div>
@endsection
