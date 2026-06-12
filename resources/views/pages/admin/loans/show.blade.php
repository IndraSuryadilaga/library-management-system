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
