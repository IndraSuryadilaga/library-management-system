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

        {{-- 1. Definisikan susunan data komponen dalam bentuk Array Berstruktur --}}
        @php
            $bookDetails = [
                ['label' => 'ID Buku', 'value' => $book->id, 'isMono' => true],
                ['label' => 'Judul', 'value' => $book->title],
                ['label' => 'Penulis', 'value' => $book->author->name],
                ['label' => 'Penerbit', 'value' => $book->publisher->name],
                ['label' => 'Tahun Terbit', 'value' => $book->publication_year],
                ['label' => 'ISBN', 'value' => $book->isbn ?? '-', 'isMono' => true],
                [
                    'label' => 'Genre',
                    'fullWidth' => true,
                    // Gunakan mapping string untuk menggantikan struktur foreach manual
                    'slot' => $book->genres->map(fn($genre) => $genre->name)->implode(', ')
                ],
                ['label' => 'Dibuat pada', 'value' => $book->created_at->format('d F Y')],
                ['label' => 'Diperbarui pada', 'value' => $book->updated_at->format('d F Y')],
            ];
        @endphp

        {{-- 2. Panggil Detail Card dengan melempar data array di atas --}}
        <x-organisms.show-card :items="$bookDetails">

            {{-- Slot tombol aksi tetap diletakkan secara deklaratif --}}
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
