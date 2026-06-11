@extends('pages.admin.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-12 gap-bento-gap auto-rows-[180px]">

    <!-- Welcome Card -->
    <div class="col-span-12 row-span-1 bg-parchment border border-cream-200 rounded-card-lg p-6 flex flex-col justify-center paper-grain">
        <h2 class="font-display text-3xl font-semibold text-bark-500">Welcome, Admin!</h2>
        <p class="font-body text-base text-dusty mt-1">
            Here's a quick overview of the library's status.
        </p>
    </div>

    <!-- StatCard: Total Books -->
    <div class="col-span-4 row-span-1 bg-bark-500 text-cream-50 rounded-card p-5 flex flex-col justify-between book-spine">
        <span class="font-body text-sm font-medium opacity-70">Total Koleksi</span>
        <div>
            <p class="font-mono text-4xl font-medium">4.821</p>
            <p class="font-body text-xs opacity-60 mt-1">buku terdaftar</p>
        </div>
    </div>

    <!-- StatCard: Total Authors -->
    <div class="col-span-4 row-span-1 bg-sage-600 text-cream-50 rounded-card p-5 flex flex-col justify-between book-spine">
        <span class="font-body text-sm font-medium opacity-70">Total Penulis</span>
        <div>
            <p class="font-mono text-4xl font-medium">237</p>
            <p class="font-body text-xs opacity-60 mt-1">penulis terdaftar</p>
        </div>
    </div>

    <!-- StatCard: Books on Loan -->
    <div class="col-span-4 row-span-1 bg-terra-500 text-cream-50 rounded-card p-5 flex flex-col justify-between book-spine">
        <span class="font-body text-sm font-medium opacity-70">Buku Dipinjam</span>
        <div>
            <p class="font-mono text-4xl font-medium">92</p>
            <p class="font-body text-xs opacity-60 mt-1">saat ini</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-span-12 row-span-1 bg-cream-100 border border-cream-200 rounded-card p-5">
        <h3 class="font-display text-xl font-semibold text-bark-500 mb-3">Quick Actions</h3>
        <div class="flex gap-3">
            <a href="{{ route('admin.authors.create') }}" class="font-body font-semibold text-sm bg-terra-400 hover:bg-terra-500 text-white px-5 py-2.5 rounded-btn transition-colors duration-150">
                + Add New Author
            </a>
            <button class="font-body font-semibold text-sm bg-transparent border-2 border-bark-500 text-bark-500 hover:bg-bark-500 hover:text-cream-50 px-5 py-2.5 rounded-btn transition-all duration-150">
                Manage Books
            </button>
        </div>
    </div>

</div>
@endsection
