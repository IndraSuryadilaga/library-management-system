@props([
    'action' => '#',
    'placeholder' => 'Cari...',
    'value' => ''
])

<form action="{{ $action }}" method="GET" {{ $attributes->merge(['class' => 'w-full max-w-3xl mx-auto']) }}>
    <div class="relative bg-cream-100 rounded-full shadow-card">
        <input
            type="search"
            name="search"
            placeholder="{{ $placeholder }}"
            value="{{ $value }}"
            class="w-full bg-transparent py-4 pl-6 pr-24 border-none font-body text-bark-600 placeholder-dusty"
        >
        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
            <x-atoms.button type="submit" variant="tertiary" class="rounded-full py-2! px-6!">
                Cari
            </x-atoms.button>
        </div>
    </div>
</form>
