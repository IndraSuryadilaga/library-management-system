@extends('pages.admin.admin')

@section('title', 'Ubah Buku')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-bento-gap">
        <div>
            <h1 class="font-display text-3xl font-semibold text-bark-500">Ubah Buku</h1>
            <p class="font-body text-base text-dusty mt-1">Perbarui detail untuk <span class="font-medium text-bark-500">{{ $book->title }}</span>.</p>
        </div>
        <x-atoms.button variant="tertiary" href="{{ route('admin.books.index') }}">
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
        <form action="{{ route('admin.books.update', $book) }}" method="POST">
            @csrf
            @method('PUT')
            @php
                // Konfigurasi Field untuk Form Buku
                $bookFields = [
                    [
                        'name' => 'title',
                        'label' => 'Judul Buku',
                        'value' => old('title', $book?->title),
                        'required' => true,
                        'fullWidth' => true
                    ],
                    [
                        'name' => 'author_id',
                        'label' => 'Penulis',
                        'type' => 'select',
                        'options' => $authors->pluck('name', 'id')->toArray(),
                        'value' => old('author_id', $book?->author_id),
                        'required' => true
                    ],
                    [
                        'name' => 'publisher_id',
                        'label' => 'Penerbit',
                        'type' => 'select',
                        'options' => $publishers->pluck('name', 'id')->toArray(),
                        'value' => old('publisher_id', $book?->publisher_id),
                        'required' => true
                    ],
                    [
                        'name' => 'publication_year',
                        'label' => 'Tahun Terbit',
                        'type' => 'number',
                        'value' => old('publication_year', $book?->publication_year),
                        'required' => true
                    ],
                    [
                        'name' => 'isbn',
                        'label' => 'ISBN',
                        'value' => old('isbn', $book?->isbn)
                    ],
                    [
                        'name' => 'genres',
                        'label' => 'Genre',
                        'type' => 'select',
                        'multiple' => true,
                        'options' => $genres->pluck('name', 'id')->toArray(),
                        'value' => old('genres', $book?->genres->pluck('id')->toArray() ?? []),
                        'fullWidth' => true
                    ],
                ];
            @endphp

            <x-organisms.dynamic-form :fields="$bookFields" />
        </form>
    </div>
</div>
@endsection
