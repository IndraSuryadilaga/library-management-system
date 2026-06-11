@extends('pages.admin.admin')

@section('title', 'Ubah Reservasi')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-bento-gap">
        <div>
            <h1 class="font-display text-3xl font-semibold text-bark-500">Ubah Reservasi</h1>
            <p class="font-body text-base text-dusty mt-1">Perbarui detail untuk reservasi ID <span class="font-medium text-bark-500">{{ $reservation->id }}</span>.</p>
        </div>
        <x-atoms.button variant="tertiary" href="{{ route('admin.reservations.index') }}">
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
        <form action="{{ route('admin.reservations.update', $reservation) }}" method="POST">
            @csrf
            @method('PUT')
            @php
                $reservationFields = [
                    [
                        'name' => 'user_id',
                        'label' => 'Pengguna',
                        'type' => 'select',
                        'options' => $users->pluck('name', 'id')->toArray(),
                        'value' => old('user_id', $reservation->user_id),
                        'required' => true
                    ],
                    [
                        'name' => 'book_id',
                        'label' => 'Buku',
                        'type' => 'select',
                        'options' => $books->pluck('title', 'id')->toArray(),
                        'value' => old('book_id', $reservation->book_id),
                        'required' => true
                    ],
                    [
                        'name' => 'item_id',
                        'label' => 'Item (Opsional)',
                        'type' => 'select',
                        'options' => $items->pluck('barcode', 'id')->toArray(),
                        'value' => old('item_id', $reservation->item_id),
                    ],
                    [
                        'name' => 'reservation_date',
                        'label' => 'Tanggal Reservasi',
                        'type' => 'date',
                        'value' => old('reservation_date', $reservation->reservation_date),
                        'required' => true
                    ],
                    [
                        'name' => 'status',
                        'label' => 'Status',
                        'type' => 'select',
                        'options' => [
                            'pending' => 'Pending',
                            'ready_for_pickup' => 'Ready for Pickup',
                            'cancelled' => 'Cancelled',
                            'fulfilled' => 'Fulfilled',
                        ],
                        'value' => old('status', $reservation->status),
                        'required' => true
                    ],
                ];
            @endphp

            <x-organisms.dynamic-form :fields="$reservationFields" />

        </form>
    </div>
</div>
@endsection
