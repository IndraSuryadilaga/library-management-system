@extends('pages.admin.admin')

@section('title', 'Detail Genre')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-bento-gap">
        <div>
            <h1 class="font-display text-3xl font-semibold text-bark-500">{{ $genre->name }}</h1>
            <p class="font-body text-base text-dusty mt-1">Detail lengkap untuk genre.</p>
        </div>
        <x-atoms.button variant="tertiary" href="{{ route('admin.genres.index') }}">
            ← Kembali ke Daftar
        </x-atoms.button>
    </div>

    @php
        $genreDetails = [
            ['label' => 'ID Genre', 'value' => $genre->id, 'isMono' => true],
            ['label' => 'Nama Genre', 'value' => $genre->name],
            ['label' => 'Dibuat pada', 'value' => $genre->created_at->format('d F Y')],
            ['label' => 'Diperbarui pada', 'value' => $genre->updated_at->format('d F Y')],
        ];
    @endphp

    <x-organisms.show-card :items="$genreDetails">
        <x-slot:actions>
            <x-atoms.button variant="primary" href="{{ route('admin.genres.edit', $genre) }}">
                Ubah Genre
            </x-atoms.button>
            <form action="{{ route('admin.genres.destroy', $genre) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus genre ini?')">
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
