@extends('pages.admin.admin')

@section('title', 'Detail Denda')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-bento-gap">
        <div>
            <h1 class="font-display text-3xl font-semibold text-bark-500">Detail Denda</h1>
            <p class="font-body text-base text-dusty mt-1">Detail lengkap untuk denda ID <span class="font-medium text-bark-500">{{ $fine->id }}</span>.</p>
        </div>
        <x-atoms.button variant="tertiary" href="{{ route('admin.fines.index') }}">
            ← Kembali ke Daftar
        </x-atoms.button>
    </div>

    @php
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
    @endphp

    <x-organisms.show-card :items="$fineDetails">
        <x-slot:actions>
            <x-atoms.button variant="primary" href="{{ route('admin.fines.edit', $fine) }}">
                Ubah Denda
            </x-atoms.button>
            <form action="{{ route('admin.fines.destroy', $fine) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus denda ini?')">
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
