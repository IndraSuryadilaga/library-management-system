@extends('pages.admin.admin')

@section('title', 'Ubah Item')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-bento-gap">
        <div>
            <h1 class="font-display text-3xl font-semibold text-bark-500">Ubah Item</h1>
            <p class="font-body text-base text-dusty mt-1">Perbarui detail untuk item dengan barcode <span class="font-medium text-bark-500">{{ $item->barcode }}</span>.</p>
        </div>
        <x-atoms.button variant="tertiary" href="{{ route('admin.items.index') }}">
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
        <form action="{{ route('admin.items.update', $item) }}" method="POST">
            @csrf
            @method('PUT')
            @php
                $itemFields = [
                    [
                        'name' => 'book_id',
                        'label' => 'Buku',
                        'type' => 'select',
                        'options' => $books->pluck('title', 'id')->toArray(),
                        'value' => old('book_id', $item->book_id),
                        'required' => true
                    ],
                    [
                        'name' => 'barcode',
                        'label' => 'Barcode',
                        'value' => old('barcode', $item->barcode),
                        'required' => true
                    ],
                    [
                        'name' => 'status',
                        'label' => 'Status',
                        'type' => 'select',
                        'options' => [
                            'available' => 'Available',
                            'loaned' => 'Loaned',
                            'lost' => 'Lost',
                            'damaged' => 'Damaged',
                        ],
                        'value' => old('status', $item->status),
                        'required' => true
                    ],
                ];
            @endphp

            <x-organisms.dynamic-form :fields="$itemFields" />
    </div>
</div>
@endsection
