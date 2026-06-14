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
        <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @if ($book->cover)
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Cover Saat Ini</label>
{{--                    <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover" class="mt-2 h-48 w-auto">--}}
                    <img src="{{ asset($book->cover) }}" alt="Cover" class="mt-2 h-64 w-auto mx-auto rounded-lg shadow-lg">
                </div>
            @endif

            <x-organisms.dynamic-form
                :fields="$bookFields"
                :cancelUrl="route('admin.books.index')"
                submitLabel="Perbarui Buku"
            />
        </form>
    </div>
</div>
@endsection
