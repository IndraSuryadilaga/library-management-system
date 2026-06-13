@extends('templates.app')

@section('title', $book->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
            <p class="font-bold">Berhasil</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Book Cover -->
        <div class="md:col-span-1">
            <img src="{{ $book->cover }}" alt="Cover of {{ $book->title }}" class="rounded-lg shadow-lg w-full">
        </div>

        <!-- Book Details -->
        <div class="md:col-span-2">
            <h1 class="font-display text-4xl font-bold text-bark-600 mb-2">{{ $book->title }}</h1>
            <p class="font-body text-lg text-dusty mb-4">by <span class="font-semibold text-bark-500">{{ $book->author->name }}</span></p>

            <div class="mb-6">
                <h2 class="font-semibold text-xl text-bark-600 mb-2">Detail Buku</h2>
                <ul class="font-body text-dusty space-y-2">
                    <li><strong>Penerbit:</strong> {{ $book->publisher->name }}</li>
                    <li><strong>Tahun Terbit:</strong> {{ $book->publication_year }}</li>
                    <li><strong>ISBN:</strong> {{ $book->isbn }}</li>
                </ul>
            </div>

            <div class="mb-6">
                <h2 class="font-semibold text-xl text-bark-600 mb-2">Genre</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($book->genres as $genre)
                        <span class="bg-cream-200 text-bark-600 text-sm font-semibold px-3 py-1 rounded-full">{{ $genre->name }}</span>
                    @endforeach
                </div>
            </div>

            <div class="mt-8">
                <x-atoms.button href="{{ route('loan.create', $book) }}" variant="primary">
                    Pinjam Buku
                </x-atoms.button>
            </div>
        </div>
    </div>
</div>
@endsection
