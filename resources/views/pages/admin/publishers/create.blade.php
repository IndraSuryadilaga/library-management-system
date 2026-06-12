@extends('pages.admin.admin')

@section('title', 'Tambah Penerbit Baru')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-bento-gap">
            <div>
                <h1 class="font-display text-3xl font-semibold text-bark-500">Tambah Penerbit Baru</h1>
                <p class="font-body text-base text-dusty mt-1">Isi formulir di bawah untuk menambahkan penerbit baru.</p>
            </div>
            <x-atoms.button variant="tertiary" href="{{ route('admin.publishers.index') }}">
                ← Kembali ke Daftar
            </x-atoms.button>
        </div>

        @if ($errors->any())
            {{-- Alert Error --}}
        @endif

        <div class="bg-parchment border border-cream-200 rounded-card-lg p-6 paper-grain">
            <form action="{{ route('admin.publishers.store') }}" method="POST">
                @csrf
                <x-organisms.dynamic-form
                    :fields="$publisherFields"
                    :cancelUrl="route('admin.publishers.index')"
                    submitLabel="Simpan Penerbit"
                />
            </form>
        </div>
    </div>
@endsection
