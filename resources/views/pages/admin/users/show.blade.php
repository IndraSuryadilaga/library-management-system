@extends('pages.admin.admin')

@section('title', 'Detail Pengguna')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-bento-gap">
        <div>
            <h1 class="font-display text-3xl font-semibold text-bark-500">{{ $user->name }}</h1>
            <p class="font-body text-base text-dusty mt-1">Detail lengkap untuk pengguna.</p>
        </div>
        <x-atoms.button variant="tertiary" href="{{ route('admin.users.index') }}">
            ← Kembali ke Daftar
        </x-atoms.button>
    </div>

    @php
        $userDetails = [
            ['label' => 'ID Pengguna', 'value' => $user->id, 'isMono' => true],
            ['label' => 'Nama', 'value' => $user->name],
            ['label' => 'Email', 'value' => $user->email],
            ['label' => 'Role', 'value' => $user->role],
            ['label' => 'Dibuat pada', 'value' => $user->created_at->format('d F Y')],
            ['label' => 'Diperbarui pada', 'value' => $user->updated_at->format('d F Y')],
        ];
    @endphp

    <x-organisms.show-card :items="$userDetails">
        <x-slot:actions>
            <x-atoms.button variant="primary" href="{{ route('admin.users.edit', $user) }}">
                Ubah Pengguna
            </x-atoms.button>
            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus pengguna ini?')">
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
