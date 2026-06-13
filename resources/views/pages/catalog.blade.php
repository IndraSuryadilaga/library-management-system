@extends('templates.app')

@section('title', 'Katalog Buku')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <!-- Page Title -->
    <header class="text-center mb-12">
        <h1 class="font-display text-5xl font-bold text-bark-600">Katalog Buku</h1>
        <p class="font-body text-lg text-dusty mt-4 max-w-2xl mx-auto">
            Temukan buku favoritmu dari ribuan koleksi yang tersedia.
        </p>
    </header>

    <!-- Search Bar -->
    <section class="mb-12">
        <x-molecules.search-bar
            action="{{ route('catalog') }}"
            placeholder="Cari berdasarkan judul, penulis, atau genre..."
            value="{{ request('search') }}"
        />
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Filters Section (Left) -->
        <aside class="lg:col-span-1">
            <div class="bg-parchment paper-grain border border-cream-200 p-6 rounded-card-lg shadow-sm sticky top-24">

                {{-- Header Filter & Tombol Reset --}}
                <div class="flex items-center justify-between mb-4 pb-4 border-b border-cream-200">
                    <h2 class="font-display text-xl font-semibold text-bark-500">Filter Katalog</h2>

                    {{-- Tombol reset aktif jika ada parameter filter di URL --}}
                    @if(request()->only(['genres', 'publishers', 'start_year', 'end_year']))
                        <a href="{{ route('catalog') }}" class="text-sm font-body font-medium text-terra-400 hover:text-terra-600 transition-colors">
                            Reset
                        </a>
                    @endif
                </div>

                <form action="{{ route('catalog') }}" method="GET">

                    <div class="mb-6 flex flex-col">

                        {{-- 1. FILTER GENRE (CHECKBOX) --}}
                        <x-molecules.accordion-filter title="Genre" :isOpen="true">
                            <div class="space-y-1 max-h-48 overflow-y-auto pr-2 scrollbar-hide">
                                @foreach($genres as $genre)
                                    <label class="flex items-center p-2 rounded-lg hover:bg-cream-100/50 cursor-pointer transition-colors group">
                                        <input type="checkbox" name="genres[]" value="{{ $genre->id }}"
                                               class="w-4 h-4 rounded border-cream-300 text-bark-500 shadow-sm focus:border-bark-300 focus:ring focus:ring-bark-200 focus:ring-opacity-50 transition-colors"
                                            @checked(in_array($genre->id, (array) request('genres', [])))>
                                        <span class="ml-3 font-body text-sm text-dusty group-hover:text-ink transition-colors">{{ $genre->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </x-molecules.accordion-filter>

                        {{-- 2. FILTER PENERBIT (CHECKBOX) --}}
                        <x-molecules.accordion-filter title="Penerbit">
                            <div class="space-y-1 max-h-48 overflow-y-auto pr-2 scrollbar-hide">
                                @foreach($publishers as $publisher)
                                    <label class="flex items-center p-2 rounded-lg hover:bg-cream-100/50 cursor-pointer transition-colors group">
                                        <input type="checkbox" name="publishers[]" value="{{ $publisher->id }}"
                                               class="w-4 h-4 rounded border-cream-300 text-bark-500 shadow-sm focus:border-bark-300 focus:ring focus:ring-bark-200 focus:ring-opacity-50 transition-colors"
                                            @checked(in_array($publisher->id, (array) request('publishers', [])))>
                                        <span class="ml-3 font-body text-sm text-dusty group-hover:text-ink transition-colors">{{ $publisher->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </x-molecules.accordion-filter>

                        {{-- 3. FILTER TAHUN TERBIT (NUMERIC RANGE INPUT - TANPA CHECKBOX) --}}
                        <x-molecules.accordion-filter title="Tahun Terbit">
                            <div class="grid grid-cols-2 gap-3 px-1 py-2">
                                <div>
                                    <label for="start_year" class="block font-body text-xs text-dusty mb-1">Dari</label>
                                    <input
                                        type="number"
                                        id="start_year"
                                        name="start_year"
                                        value="{{ request('start_year') }}"
                                        placeholder="Contoh: 2010"
                                        min="1000"
                                        max="{{ date('Y') }}"
                                        class="w-full font-body text-sm text-ink bg-cream-100 border border-cream-200 rounded-pill px-3 py-2 focus:outline-none focus:ring-1 focus:ring-bark-300 focus:border-bark-300 focus:bg-white transition-all duration-150"
                                    >
                                </div>
                                <div>
                                    <label for="end_year" class="block font-body text-xs text-dusty mb-1">Sampai</label>
                                    <input
                                        type="number"
                                        id="end_year"
                                        name="end_year"
                                        value="{{ request('end_year') }}"
                                        placeholder="{{ date('Y') }}"
                                        min="1000"
                                        max="{{ date('Y') }}"
                                        class="w-full font-body text-sm text-ink bg-cream-100 border border-cream-200 rounded-pill px-3 py-2 focus:outline-none focus:ring-1 focus:ring-bark-300 focus:border-bark-300 focus:bg-white transition-all duration-150"
                                    >
                                </div>
                            </div>
                        </x-molecules.accordion-filter>

                    </div>

                    <div class="flex flex-col gap-3 mt-8">
                        <x-atoms.button type="submit" variant="primary" class="w-full justify-center">
                            Terapkan Filter
                        </x-atoms.button>

                        {{-- Tombol Reset akan me-refresh halaman ke rute katalog bersih tanpa parameter --}}
                        <x-atoms.button variant="secondary" href="{{ route('catalog') }}" class="w-full justify-center">
                            Reset Filter
                        </x-atoms.button>
                    </div>
                </form>
            </div>
        </aside>

        <!-- Books Grid (Right) -->
        <main class="lg:col-span-3">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($books as $book)
                    <x-organisms.book-card :book="$book" />
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="font-body text-lg text-dusty">Tidak ada buku yang ditemukan.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $books->withQueryString()->links() }}
            </div>
        </main>
    </div>
</div>
@endsection
