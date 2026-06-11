@extends('pages.admin.admin')

@section('title', 'Detail Reservasi')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-bento-gap">
        <div>
            <h1 class="font-display text-3xl font-semibold text-bark-500">Detail Reservasi</h1>
            <p class="font-body text-base text-dusty mt-1">Detail lengkap untuk reservasi ID <span class="font-medium text-bark-500">{{ $reservation->id }}</span>.</p>
        </div>
        <x-atoms.button variant="tertiary" href="{{ route('admin.reservations.index') }}">
            ← Kembali ke Daftar
        </x-atoms.button>
    </div>

    @php
        $reservationDetails = [
            ['label' => 'ID Reservasi', 'value' => $reservation->id, 'isMono' => true],
            ['label' => 'Pengguna', 'value' => $reservation->user->name],
            ['label' => 'Buku', 'value' => $reservation->book->title],
            ['label' => 'Item', 'value' => $reservation->item->barcode ?? '-', 'isMono' => true],
            ['label' => 'Tanggal Reservasi', 'value' => $reservation->reservation_date],
            ['label' => 'Status', 'value' => $reservation->status],
            ['label' => 'Dibuat pada', 'value' => $reservation->created_at->format('d F Y')],
            ['label' => 'Diperbarui pada', 'value' => $reservation->updated_at->format('d F Y')],
        ];
    @endphp

    <x-organisms.show-card :items="$reservationDetails">
        <x-slot:actions>
            <x-atoms.button variant="primary" href="{{ route('admin.reservations.edit', $reservation) }}">
                Ubah Reservasi
            </x-atoms.button>
            <form action="{{ route('admin.reservations.destroy', $reservation) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus reservasi ini?')">
                @csrf
                @method('DELETE')
                <x-atoms.button variant="danger" type="submit">
                    Hapus
                </x-atoms.button>
            </form>
        </x-slot:actions>
    </x-organisms.show-card>
</div>
@endsection
