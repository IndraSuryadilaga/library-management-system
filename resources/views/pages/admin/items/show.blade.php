@extends('pages.admin.admin')

@section('title', 'Detail Item')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-bento-gap">
        <div>
            <h1 class="font-display text-3xl font-semibold text-bark-500">Detail Item</h1>
            <p class="font-body text-base text-dusty mt-1">Detail lengkap untuk item dengan barcode <span class="font-medium text-bark-500">{{ $item->barcode }}</span>.</p>
        </div>
        <x-atoms.button variant="tertiary" href="{{ route('admin.items.index') }}">
            ← Kembali ke Daftar
        </x-atoms.button>
    </div>

    @php
        $itemDetails = [
            ['label' => 'ID Item', 'value' => $item->id, 'isMono' => true],
            ['label' => 'Barcode', 'value' => $item->barcode, 'isMono' => true],
            ['label' => 'Judul Buku', 'value' => $item->book->title],
            ['label' => 'Status', 'value' => $item->status],
            ['label' => 'Dibuat pada', 'value' => $item->created_at->format('d F Y')],
            ['label' => 'Diperbarui pada', 'value' => $item->updated_at->format('d F Y')],
        ];
    @endphp

    <x-organisms.show-card :items="$itemDetails">
        <x-slot:actions>
            <x-atoms.button variant="primary" href="{{ route('admin.items.edit', $item) }}">
                Ubah Item
            </x-atoms.button>
            <form action="{{ route('admin.items.destroy', $item) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus item ini?')">
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
