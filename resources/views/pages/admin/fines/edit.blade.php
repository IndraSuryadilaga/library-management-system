@extends('pages.admin.admin')

@section('title', 'Ubah Denda')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-bento-gap">
        <div>
            <h1 class="font-display text-3xl font-semibold text-bark-500">Ubah Denda</h1>
            <p class="font-body text-base text-dusty mt-1">Perbarui detail untuk denda ID <span class="font-medium text-bark-500">{{ $fine->id }}</span>.</p>
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
        <form action="{{ route('admin.fines.update', $fine) }}" method="POST">
            @csrf
            @method('PUT')
            @php
                $fineFields = [
                    [
                        'name' => 'user_id',
                        'label' => 'Pengguna',
                        'type' => 'select',
                        'options' => $users->pluck('name', 'id')->toArray(),
                        'value' => old('user_id', $fine->user_id),
                        'required' => true
                    ],
                    [
                        'name' => 'loan_id',
                        'label' => 'Peminjaman',
                        'type' => 'select',
                        'options' => $loans->pluck('id', 'id')->toArray(),
                        'value' => old('loan_id', $fine->loan_id),
                        'required' => true
                    ],
                    [
                        'name' => 'amount',
                        'label' => 'Jumlah',
                        'type' => 'number',
                        'value' => old('amount', $fine->amount),
                        'required' => true
                    ],
                    [
                        'name' => 'reason',
                        'label' => 'Alasan',
                        'type' => 'textarea',
                        'value' => old('reason', $fine->reason),
                        'required' => true
                    ],
                    [
                        'name' => 'paid_at',
                        'label' => 'Dibayar Pada (Opsional)',
                        'type' => 'date',
                        'value' => old('paid_at', $fine->paid_at?->format('Y-m-d')),
                    ],
                ];
            @endphp

            <x-organisms.dynamic-form :fields="$fineFields" />
        </form>
    </div>
</div>
@endsection
