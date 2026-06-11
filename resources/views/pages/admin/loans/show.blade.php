@extends('pages.admin.admin')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-bento-gap">
        <div>
            <h1 class="font-display text-3xl font-semibold text-bark-500">Detail Peminjaman</h1>
            <p class="font-body text-base text-dusty mt-1">Detail lengkap untuk peminjaman ID <span class="font-medium text-bark-500">{{ $loan->id }}</span>.</p>
        </div>
        <x-atoms.button variant="tertiary" href="{{ route('admin.loans.index') }}">
            ← Kembali ke Daftar
        </x-atoms.button>
    </div>

    @php
        $loanDetails = [
            ['label' => 'ID Peminjaman', 'value' => $loan->id, 'isMono' => true],
            ['label' => 'Pengguna', 'value' => $loan->user->name],
            ['label' => 'Item', 'value' => $loan->item->book->title . ' (' . $loan->item->barcode . ')'],
            ['label' => 'Tanggal Pinjam', 'value' => $loan->loan_date],
            ['label' => 'Jatuh Tempo', 'value' => $loan->due_date],
            ['label' => 'Tanggal Kembali', 'value' => $loan->return_date ?? '-'],
            ['label' => 'Dibuat pada', 'value' => $loan->created_at->format('d F Y')],
            ['label' => 'Diperbarui pada', 'value' => $loan->updated_at->format('d F Y')],
        ];
    @endphp

    <x-organisms.show-card :items="$loanDetails">
        <x-slot:actions>
            <x-atoms.button variant="primary" href="{{ route('admin.loans.edit', $loan) }}">
                Ubah Peminjaman
            </x-atoms.button>
            <form action="{{ route('admin.loans.destroy', $loan) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus peminjaman ini?')">
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
