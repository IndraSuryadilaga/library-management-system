@extends('pages.admin.admin')

@section('title', 'Tambah Penulis Baru')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-bento-gap">
            <div>
                <h1 class="font-display text-3xl font-semibold text-bark-500">Tambah Penulis Baru</h1>
                <p class="font-body text-base text-dusty mt-1">Isi formulir di bawah untuk menambahkan penulis baru.</p>
            </div>
            <x-atoms.button variant="tertiary" href="{{ route('admin.authors.index') }}">
                ← Kembali ke Daftar
            </x-atoms.button>
        </div>

        @if ($errors->any())
            {{-- Alert Error Tetap Sama --}}
        @endif

        <div class="bg-parchment border border-cream-200 rounded-card-lg p-6 paper-grain">
            <form action="{{ route('admin.authors.store') }}" method="POST">
                @csrf
                <x-organisms.dynamic-form
                    :fields="$authorFields"
                    :cancelUrl="route('admin.authors.index')"
                    submitLabel="Simpan Penulis"
                />
            </form>
        </div>
    </div>
@endsection
