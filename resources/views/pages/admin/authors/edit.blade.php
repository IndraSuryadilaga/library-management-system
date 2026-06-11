@extends('pages.admin.admin')

@section('title', 'Ubah Penulis')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-bento-gap">
            <div>
                <h1 class="font-display text-3xl font-semibold text-bark-500">Ubah Penulis</h1>
                <p class="font-body text-base text-dusty mt-1">Perbarui detail untuk <span class="font-medium text-bark-500">{{ $author->name }}</span>.</p>
            </div>
            <x-atoms.button variant="tertiary" href="{{ route('admin.authors.index') }}">
                ← Kembali ke Daftar
            </x-atoms.button>
        </div>

        @if ($errors->any())
            {{-- Alert Error Tetap Sama --}}
        @endif

        <div class="bg-parchment border border-cream-200 rounded-card-lg p-6 paper-grain">
            <form action="{{ route('admin.authors.update', $author) }}" method="POST">
                @csrf
                @method('PUT')

                @php
                    $authorFields = [
                        [
                            'name' => 'name',
                            'label' => 'Nama',
                            'value' => old('name', $author->name),
                            'required' => true,
                            'fullWidth' => true
                        ],
                        [
                            'name' => 'bio',
                            'label' => 'Biografi',
                            'type' => 'textarea',
                            'rows' => 6,
                            'value' => old('bio', $author->bio),
                            'helper' => 'Berikan biografi singkat tentang penulis.',
                            'fullWidth' => true
                        ]
                    ];
                @endphp

                {{-- Panggil Dynamic Form Organism --}}
                <x-organisms.dynamic-form :fields="$authorFields" />
            </form>
        </div>
    </div>
@endsection
