@extends('templates.app')

@section('title', 'Form Pengajuan Peminjaman')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <header class="text-center mb-8">
        <h1 class="font-display text-4xl font-bold text-bark-600">Form Peminjaman Buku</h1>
        <p class="font-body text-lg text-dusty mt-2">
            Ajukan peminjaman untuk buku "{{ $book->title }}".
        </p>
    </header>

    <div class="bg-cream-100 p-8 rounded-card shadow-card">
        <form action="{{ route('loan.store', $book) }}" method="POST">
            @csrf

            <!-- Book Details -->
            <div class="mb-6 flex items-start space-x-6">
                <img src="{{ $book->cover }}" alt="Cover of {{ $book->title }}" class="rounded-md shadow-md w-24 h-36 object-cover">
                <div>
                    <h2 class="font-display text-2xl font-semibold text-bark-600">{{ $book->title }}</h2>
                    <p class="font-body text-md text-dusty">oleh {{ $book->author->name }}</p>
                    <p class="font-body text-sm text-dusty mt-1">{{ $book->publisher->name }}, {{ $book->publication_year }}</p>
                </div>
            </div>

            <!-- Loan Date Input -->
            <div class="mb-6">
                <label for="loan_date" class="block font-semibold text-lg text-bark-600 mb-2">Tanggal Peminjaman</label>
                <input
                    type="date"
                    id="loan_date"
                    name="loan_date"
                    min="{{ now()->toDateString() }}"
                    value="{{ old('loan_date', now()->toDateString()) }}"
                    class="w-full font-body text-ink bg-white border border-cream-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                    required
                >
                @error('loan_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Loan Terms -->
            <div class="mb-8 p-4 bg-cream-200/50 border border-cream-200 rounded-md">
                <h3 class="font-semibold text-md text-bark-600 mb-2">Syarat & Ketentuan</h3>
                <ul class="list-disc list-inside font-body text-sm text-dusty space-y-1">
                    <li>Durasi peminjaman standar adalah 7 hari.</li>
                    <li>Keterlambatan pengembalian akan dikenakan denda.</li>
                    <li>Harap jaga kondisi buku dengan baik.</li>
                    <li>Pengajuan akan ditinjau oleh admin perpustakaan.</li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('show.book', $book) }}" class="font-body text-dusty hover:text-bark-600">
                    Batal
                </a>
                <x-atoms.button type="submit" variant="primary">
                    Kirim Pengajuan
                </x-atoms.button>
            </div>
        </form>
    </div>
</div>
@endsection
