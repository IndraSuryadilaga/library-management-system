@props([
    'name',
    'value' => '',
    'placeholder' => 'Pilih opsi...',
    'options' => [],
    'disabled' => false
])

<div
    x-data="{
        open: false,
        selectedValue: @js((string) old($name, $value)),
        options: @js((object) $options),

        get selectedLabel() {
            return (this.selectedValue !== '' && this.options[this.selectedValue])
                ? this.options[this.selectedValue]
                : '{{ $placeholder }}';
        },

        selectOption(val) {
            this.selectedValue = val;
            this.open = false;
        }
    }"
    @click.outside="open = false"
    @keyup.escape="open = false"
    class="relative w-full"
>
    {{-- Input Asli (Hidden) --}}
    <input type="hidden" name="{{ $name }}" x-model="selectedValue" {{ $disabled ? 'disabled' : '' }}>

    {{-- Tombol Pemicu --}}
    <button
        type="button"
        @click="open = !open"
        :disabled="{{ $disabled ? 'true' : 'false' }}"
        class="w-full flex items-center justify-between font-body text-sm text-ink bg-cream-100 border border-cream-200 rounded-pill px-4 py-3 focus:outline-none focus:ring-1 focus:ring-bark-300/50 focus:border-bark-300/50 focus:bg-white transition-all duration-150 text-left"
        :class="{
            'bg-white border-bark-300 ring-1 ring-bark-300': open,
            'opacity-50 cursor-not-allowed': {{ $disabled ? 'true' : 'false' }}
        }"
    >
        <span x-text="selectedLabel" :class="{ 'text-dusty': !selectedValue }">{{ $placeholder }}</span>

        <svg class="w-4 h-4 text-dusty transition-transform duration-200 shrink-0" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    {{-- Menu List Dropdown --}}
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95 translate-y-1"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-1"
        class="absolute z-50 w-full mt-2 bg-white border border-cream-200 rounded-2xl shadow-xl overflow-hidden py-1.5 max-h-60 overflow-y-auto paper-grain font-body text-sm"
    >
        {{-- Opsi Kosong --}}
        <div
            @click="selectOption('')"
            class="px-4 py-2.5 cursor-pointer transition-colors duration-150 flex items-center justify-between"
            :class="{ 'bg-cream-100/50 text-bark-500 font-medium': selectedValue === '', 'hover:bg-cream-50 text-dusty': selectedValue !== '' }"
        >
            <span>{{ $placeholder }}</span>
        </div>

        {{-- Looping Pilihan --}}
        <template x-for="id in Object.keys(options)" :key="id">
            <div
                @click="selectOption(id)"
                class="px-4 py-2.5 cursor-pointer transition-colors duration-150 flex items-center justify-between"
                :class="{ 'bg-cream-100/80 text-bark-600 font-bold': selectedValue == id, 'hover:bg-cream-50 text-ink': selectedValue != id }"
            >
                <span x-text="options[id]"></span>
                <svg x-show="selectedValue == id" class="w-4 h-4 text-bark-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </template>
    </div>
</div>
