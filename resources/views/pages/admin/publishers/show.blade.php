@extends('pages.admin.admin')

@section('title', 'Detail Penerbit')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-bento-gap">
        <div>
            <h1 class="font-display text-3xl font-semibold text-bark-500">{{ $publisher->name }}</h1>
            <p class="font-body text-base text-dusty mt-1">Detail lengkap untuk penerbit.</p>
        </div>
        <x-atoms.button variant="tertiary" href="{{ route('admin.publishers.index') }}">
            ← Kembali ke Daftar
        </x-atoms.button>
    </div>

    <x-organisms.show-card :items="$publisherDetails">
        <x-slot:actions>
            <x-atoms.button variant="primary" href="{{ route('admin.publishers.edit', $publisher) }}">
                Ubah Penerbit
            </x-atoms.button>
            <form action="{{ route('admin.publishers.destroy', $publisher) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus penerbit ini?')">
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
