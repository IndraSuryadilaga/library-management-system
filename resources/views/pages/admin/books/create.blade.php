@extends('pages.admin.admin')

@section('title', 'Tambah Buku Baru')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-bento-gap">
            <div>
                <h1 class="font-display text-3xl font-semibold text-bark-500">Tambah Buku Baru</h1>
                <p class="font-body text-base text-dusty mt-1">Isi formulir di bawah untuk menambahkan buku baru.</p>
            </div>
            <x-atoms.button variant="tertiary" href="{{ route('admin.books.index') }}">
                ← Kembali ke Daftar
            </x-atoms.button>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-card relative mb-bento-gap" role="alert">
                <strong class="font-bold">Oops! Terjadi kesalahan.</strong>
                <ul class="mt-2 list-disc list-inside text-sm ">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-parchment border border-cream-200 rounded-card-lg p-6 paper-grain">
            <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <x-organisms.dynamic-form
                    :fields="$bookFields"
                    :cancelUrl="route('admin.books.index')"
                    submitLabel="Simpan Buku"
                />
            </form>
        </div>
    </div>
@endsection
