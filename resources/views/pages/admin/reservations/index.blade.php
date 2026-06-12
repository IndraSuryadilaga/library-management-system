@extends('pages.admin.admin')

@section('title', 'Kelola Reservasi')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-bento-gap">
        <div>
            <h1 class="font-display text-3xl font-semibold text-bark-500">Daftar Reservasi</h1>
            <p class="font-body text-base text-dusty mt-1">Kelola semua data reservasi di perpustakaan.</p>
        </div>
        <x-atoms.button variant="primary" href="{{ route('admin.reservations.create') }}">
            + Tambah Reservasi
        </x-atoms.button>
    </div>

    <x-organisms.filter-form
        :action="route('admin.reservations.index')"
        :resetUrl="route('admin.reservations.index')"
        searchLabel="Cari Reservasi"
        :searchValue="request('search')"
        :filters="$reservationFilters"
    />

    @if (session('success'))
        <div class="bg-sage-200/50 border border-sage-200 text-sage-600 px-4 py-3 rounded-card relative mb-bento-gap" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <x-molecules.table :headers="['ID', 'Pengguna', 'Buku', 'Tanggal Reservasi', 'Status', 'Aksi']">
        @forelse ($reservations as $reservation)
            <tr class="border-b border-cream-200 hover:bg-cream-100/70 transition-colors duration-150">
                <td class="px-6 py-4 font-mono text-bark-400">{{ $reservation->id }}</td>
                <td class="px-6 py-4 font-medium text-bark-600/80">{{ $reservation->user->name }}</td>
                <td class="px-6 py-4 font-medium text-bark-600/80">{{ $reservation->book->title }}</td>
                <td class="px-6 py-4 font-body text-dusty">{{ $reservation->reservation_date }}</td>
                <td class="px-6 py-4 font-body text-bark-600/80">{{ $reservation->status }}</td>
                <td class="px-6 py-4 text-center">
                    <div class="flex items-center justify-center space-x-3">
                        <x-atoms.button variant="tertiary" href="{{ route('admin.reservations.show', $reservation) }}">Lihat</x-atoms.button>
                        <x-atoms.button variant="tertiary" href="{{ route('admin.reservations.edit', $reservation) }}" class="text-terra-400 hover:text-terra-500">Ubah</x-atoms.button>
                        <form action="{{ route('admin.reservations.destroy', $reservation) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus reservasi ini?')">
                            @csrf
                            @method('DELETE')
                            <x-atoms.button variant="tertiary" type="submit" class="text-red-500 hover:text-red-700">Hapus</x-atoms.button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center py-12">
                    <div class="flex flex-col items-center">
                        <span class="text-4xl mb-2">📅</span>
                        <p class="font-body text-dusty">Tidak ada data reservasi.</p>
                        <p class="font-body text-sm text-dusty">Coba tambahkan reservasi baru.</p>
                    </div>
                </td>
            </tr>
        @endforelse
    </x-molecules.table>

    <div class="mt-bento-gap">
        {{ $reservations->links() }}
    </div>
</div>
@endsection
