@extends('pages.admin.admin')

@section('title', 'Detail Penulis')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-bento-gap">
        <div>
            <h1 class="font-display text-3xl font-semibold text-bark-500">{{ $author->name }}</h1>
            <p class="font-body text-base text-dusty mt-1">Detail lengkap untuk penulis.</p>
        </div>
        <x-atoms.button variant="tertiary" href="{{ route('admin.authors.index') }}">
            ← Kembali ke Daftar
        </x-atoms.button>
    </div>

    @php
        $authorDetails = [
            ['label' => 'ID Penulis', 'value' => $author->id, 'isMono' => true],
            ['label' => 'Jumlah Buku', 'value' => 0, 'isMono' => true], // Placeholder
            ['label' => 'Dibuat pada', 'value' => $author->created_at->format('d F Y')],
            ['label' => 'Diperbarui pada', 'value' => $author->updated_at->format('d F Y')],
            [
                'label' => 'Biografi',
                'fullWidth' => true,
                'slot' => $author->bio ? \Illuminate\Support\Str::markdown($author->bio) : '<p class="text-dusty italic">Biografi tidak tersedia.</p>'
            ],
        ];
    @endphp

    <x-organisms.show-card :items="$authorDetails">
        <x-slot:actions>
            <x-atoms.button variant="primary" href="{{ route('admin.authors.edit', $author) }}">
                Ubah Penulis
            </x-atoms.button>
            <form action="{{ route('admin.authors.destroy', $author) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus penulis ini?')">
                @csrf
                @method('DELETE')
                <x-atoms.button variant="danger" type="submit">
                    Hapus
                </x-atoms.button>
            </form>
        </x-slot:actions>
    </x-organisms.show-card>
</div>
@endsection
