@props([
    'action',
    'resetUrl',
    'searchLabel' => 'Cari Data',
    'searchValue' => request('search'),
    'searchName' => 'search',
    'searchPlaceholder' => 'Ketik kata kunci pencarian...',
    'filters' => []
])

@php
    // Menghitung total input: 1 (untuk kotak search teks) + jumlah filter dropdown
    $totalInputs = count($filters) + 1;

    // Memetakan kelas Tailwind secara statis agar terbaca oleh JIT Compiler Tailwind
    $desktopGridClass = match($totalInputs) {
        1 => 'lg:grid-cols-1',
        2 => 'lg:grid-cols-2',
        3 => 'lg:grid-cols-3',
        4 => 'lg:grid-cols-4',
        5 => 'lg:grid-cols-5',
        default => 'lg:grid-cols-4',
    };
@endphp

<div class="mb-bento-gap">
    <form action="{{ $action }}" method="GET" class="bg-parchment border border-cream-200 rounded-card-lg p-5 paper-grain">

        <div class="flex flex-col gap-6">

            {{-- GRID UTAMA: Pencarian & Filter Menyatu --}}
            {{-- Mobile: 1 Kolom | Tablet: 2 Kolom | Desktop: Sebaris Menyesuaikan --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 {{ $desktopGridClass }} gap-4">

                {{-- Input Pencarian Teks (Selalu di urutan pertama) --}}
                <div class="w-full">
                    <x-molecules.form-group :name="$searchName" :label="$searchLabel">
                        <x-atoms.input
                            type="search"
                            :id="$searchName"
                            :name="$searchName"
                            :value="$searchValue"
                            :placeholder="$searchPlaceholder"
                        />
                    </x-molecules.form-group>
                </div>

                {{-- Dropdown Filters Dinamis (Mengikuti di sebelah kanannya) --}}
                @foreach($filters as $filter)
                    <div class="w-full">
                        <x-molecules.form-group :name="$filter['name']" :label="$filter['label']">

                            {{-- Memanggil Custom Select Atom --}}
                            <x-atoms.select
                                :name="$filter['name']"
                                :placeholder="$filter['placeholder'] ?? 'Semua ' . $filter['label']"
                                :options="$filter['options'] ?? []"
                                :value="$filter['value'] ?? ''"
                            />

                        </x-molecules.form-group>
                    </div>
                @endforeach

            </div>

            {{-- Bagian Bawah: Aksi / Tombol --}}
            {{-- Mobile: Tombol Stacked | Desktop: Sejajar ke Kanan --}}
            <div class="flex flex-col sm:flex-row items-center justify-end gap-3">
                <x-atoms.button variant="secondary" :href="$resetUrl" class="w-full sm:w-auto justify-center text-xs">
                    Reset
                </x-atoms.button>
                <x-atoms.button variant="primary" type="submit" class="w-full sm:w-auto justify-center text-xs">
                    Terapkan Filter
                </x-atoms.button>
            </div>

        </div>

    </form>
</div>
