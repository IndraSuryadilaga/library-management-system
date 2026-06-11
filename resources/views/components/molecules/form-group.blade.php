@props([
    'name',
    'label',
    'fullWidth' => false,
    'helper' => null // Tambahkan ini
])

<div @class(['md:col-span-2' => $fullWidth])>
    @if($label)
        <x-atoms.label :for="$name" :value="$label" />
    @endif

    {{ $slot }}

    {{-- Tampilkan teks bantuan jika ada --}}
    @if($helper)
        <p class="font-body text-xs text-dusty mt-1.5">{{ $helper }}</p>
    @endif
</div>
