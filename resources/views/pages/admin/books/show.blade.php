@extends('pages.admin.admin')

@section('title', 'Detail Buku')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-bento-gap">
            <div>
                <h1 class="font-display text-3xl font-semibold text-bark-500">{{ $book->title }}</h1>
                <p class="font-body text-base text-dusty mt-1">Detail lengkap untuk buku.</p>
            </div>
            <x-atoms.button variant="tertiary" href="{{ route('admin.books.index') }}">
                ← Kembali ke Daftar
            </x-atoms.button>
        </div>

        @if ($book->cover)
            <div class="mb-4">
                <img src="{{ asset($book->cover) }}" alt="Cover" class="mt-2 h-64 w-auto mx-auto rounded-lg shadow-lg">
{{--                <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover" class="mt-2 h-64 w-auto mx-auto rounded-lg shadow-lg">--}}
            </div>
        @endif

        <x-organisms.show-card :items="$bookDetails">
            <x-slot:actions>
                <x-atoms.button variant="primary" href="{{ route('admin.books.edit', $book) }}">
                    Ubah Buku
                </x-atoms.button>
                <form action="{{ route('admin.books.destroy', $book) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus buku ini?')">
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
