@extends('pages.admin.admin')

@section('title', 'Ubah Genre')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-bento-gap">
            <div>
                <h1 class="font-display text-3xl font-semibold text-bark-500">Ubah Genre</h1>
                <p class="font-body text-base text-dusty mt-1">Perbarui detail untuk <span class="font-medium text-bark-500">{{ $genre->name }}</span>.</p>
            </div>
            <x-atoms.button variant="tertiary" href="{{ route('admin.genres.index') }}">
                ← Kembali ke Daftar
            </x-atoms.button>
        </div>

        @if ($errors->any())
            {{-- Alert Error --}}
        @endif

        <div class="bg-parchment border border-cream-200 rounded-card-lg p-6 paper-grain">
            <form action="{{ route('admin.genres.update', $genre) }}" method="POST">
                @csrf
                @method('PUT')

                @php
                    $genreFields = [
                        [
                            'name' => 'name',
                            'label' => 'Nama Genre',
                            'value' => old('name', $genre->name),
                            'required' => true,
                            'fullWidth' => true
                        ]
                    ];
                @endphp

                <x-organisms.dynamic-form :fields="$genreFields" />
            </form>
        </div>
    </div>
@endsection
