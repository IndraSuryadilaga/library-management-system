@props([
    'title',
    'isOpen' => false // Apakah default-nya terbuka?
])

<div x-data="{ open: {{ $isOpen ? 'true' : 'false' }} }" class="border-b border-cream-200/60 py-4 last:border-0">
    {{-- Header Accordion Pemicu Buka-Tutup --}}
    <button @click="open = !open" type="button" class="flex w-full items-center justify-between text-bark-600 hover:text-bark-800 transition-colors focus:outline-none">
        <span class="font-semibold font-display text-base">{{ $title }}</span>
        <svg class="w-5 h-5 transition-transform duration-200 text-dusty" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    {{-- Konten Dinamis Di Dalam Accordion --}}
    <div x-show="open"
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="pt-3"
    >
        {{-- Slot menampung apa pun inputan yang kita kirim dari view --}}
        {{ $slot }}
    </div>
</div>
