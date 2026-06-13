@extends('templates.app')

@section('title', 'Pustaka Nusantara')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Hero Section -->
    <header class="text-center py-16">
        <h1 class="font-display text-5xl font-bold text-bark-600">Pustaka Nusantara</h1>
        <p class="font-body text-lg text-dusty mt-4 max-w-2xl mx-auto">
            Jelajahi lebih dari <span class="font-semibold text-bark-500">10,000</span> buku khusus di perpustakaan digital kami.
        </p>
        <div class="mt-8">
            <x-atoms.button href="{{ route('show.register') }}" variant="primary">
                Jadi Anggota & Pinjam Buku
            </x-atoms.button>
        </div>
    </header>

    <!-- Search Bar -->
    <section class="mb-16">
        <x-molecules.search-bar
            action="{{ route('catalog') }}"
            placeholder="Cari berdasarkan judul, penulis, atau genre..."
        />
    </section>

    <!-- Bento Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-bento-gap-lg">

        <!-- Left Column -->
        <div class="lg:col-span-4 space-y-bento-gap-lg">
            <!-- Newest Books -->
            <section>
                <h2 class="font-display text-3xl font-semibold text-bark-500 mb-4">Buku Terbaru</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-bento-gap">
                    @foreach ($newestBooks as $book)
                        <x-organisms.book-card :book="$book" />
                    @endforeach
                </div>
            </section>

            <!-- Genre A Books -->
            @if($genreA)
            <section>
                <h2 class="font-display text-3xl font-semibold text-bark-500 mb-4">{{ $genreA->name }}</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-bento-gap">
                    @foreach ($genreABooks as $book)
                        <x-organisms.book-card :book="$book" />
                    @endforeach
                </div>
            </section>
            @endif

            <!-- Genre B Books -->
            @if($genreB)
            <section>
                <h2 class="font-display text-3xl font-semibold text-bark-500 mb-4">{{ $genreB->name }}</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-bento-gap">
                    @foreach ($genreBBooks as $book)
                        <x-organisms.book-card :book="$book" />
                    @endforeach
                </div>
            </section>
            @endif
        </div>

        <!-- Right Column -->
        <div class="lg:col-span-1">
            <aside class="sticky top-bento-gap-lg">
                <h2 class="font-display text-3xl font-semibold text-bark-500 mb-4">Trending</h2>
                <!-- Stack Carousel -->
                <div class="relative h-96">
                    <!-- Card 1 -->
                    <div class="absolute w-full h-full bg-cream-100 rounded-card shadow-card p-4 transform transition-transform duration-500" style="transform: translateY(0) scale(1);">
                        <img src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1630199313l/58694508.jpg" alt="Book" class="rounded-md mb-2 aspect-[2/3] object-cover w-full">
                        <h3 class="font-semibold text-bark-600">The Love Hypothesis</h3>
                    </div>
                    <!-- Card 2 -->
                    <div class="absolute w-full h-full bg-cream-100 rounded-card shadow-card p-4 transform transition-transform duration-500" style="transform: translateY(1rem) scale(0.95); z-index: -1;">
                        <img src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1503229332l/36232034.jpg" alt="Book" class="rounded-md mb-2 aspect-[2/3] object-cover w-full">
                    </div>
                    <!-- Card 3 -->
                    <div class="absolute w-full h-full bg-cream-100 rounded-card shadow-card p-4 transform transition-transform duration-500" style="transform: translateY(2rem) scale(0.9); z-index: -2;">
                        <img src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1602190253l/52578297.jpg" alt="Book" class="rounded-md mb-2 aspect-[2/3] object-cover w-full">
                    </div>
                </div>
            </aside>
        </div>

    </div>
</div>
@endsection
