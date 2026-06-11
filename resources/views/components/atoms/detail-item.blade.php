@props([
    'label',
    'value' => null,
    'isMono' => false,
    'fullWidth' => false
])

<div @class([
    'flex justify-between border-b border-cream-200/50 py-2',
    'md:col-span-2' => $fullWidth
])>
    <span class="text-dusty">{{ $label }}:</span>
    <span @class([
        'font-medium text-bark-500 text-right',
        'font-mono' => $isMono,
    ])>
        {{-- Menampilkan prop value, atau slot jika nilainya berupa iterasi loop/HTML --}}
        {{ $value ?? $slot }}
    </span>
</div>
