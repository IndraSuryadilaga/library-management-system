@props([
    'name',
    'value' => [],
    'placeholder' => 'Pilih beberapa opsi...',
    'options' => [], // Array [id => nama]
    'disabled' => false
])

@php
    $cleanName = str_replace('[]', '', $name);
    $defaultValue = old($cleanName, is_array($value) ? $value : ($value ? [$value] : []));
@endphp

<div
    x-data="{
        open: false,
        selectedValue: @js($defaultValue),
        options: @js((object) $options),

        toggleOption(val) {
            const strVal = val.toString();
            const index = this.selectedValue.findIndex(item => item.toString() === strVal);

            if (index > -1) {
                this.selectedValue.splice(index, 1);
            } else {
                this.selectedValue.push(val);
            }
        },

        removeOption(val, event) {
            event.stopPropagation(); // Mencegah dropdown terbuka saat klik tombol 'X'
            const strVal = val.toString();
            this.selectedValue = this.selectedValue.filter(item => item.toString() !== strVal);
        },

        isSelected(val) {
            return this.selectedValue.some(item => item.toString() === val.toString());
        }
    }"
    @click.outside="open = false"
    @keyup.escape="open = false"
    class="relative w-full"
>
    {{-- HIDDEN INPUTS --}}
    <template x-for="val in selectedValue" :key="val">
        <input type="hidden" name="{{ $cleanName }}[]" :value="val" {{ $disabled ? 'disabled' : '' }}>
    </template>
    <template x-if="selectedValue.length === 0">
        <input type="hidden" name="{{ $cleanName }}[]" value="" {{ $disabled ? 'disabled' : '' }}>
    </template>

    {{-- Tombol Pemicu / Area Input --}}
    <button
        type="button"
        @click="open = !open"
        :disabled="{{ $disabled ? 'true' : 'false' }}"
        class="w-full flex items-center justify-between font-body text-sm text-ink bg-cream-100 border border-cream-200 rounded-[20px] px-4 py-2 min-h-[46px] focus:outline-none focus:ring-1 focus:ring-bark-300/50 focus:border-bark-300/50 focus:bg-white transition-all duration-150 text-left"
        :class="{
            'bg-white border-bark-300 ring-1 ring-bark-300': open,
            'opacity-50 cursor-not-allowed': {{ $disabled ? 'true' : 'false' }}
        }"
    >
        <div class="flex flex-wrap gap-1.5 items-center w-full pr-2">
            {{-- Placeholder (Muncul jika tidak ada yang dipilih) --}}
            <span x-show="selectedValue.length === 0" class="text-dusty">{{ $placeholder }}</span>

            {{-- Merender opsi terpilih sebagai Tags/Badges --}}
            <template x-for="val in selectedValue" :key="val">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-bark-100 text-bark-700 border border-bark-200">
                    <span x-text="options[val]"></span>
                    {{-- Tombol Silang 'X' untuk menghapus --}}
                    <button type="button" @click="removeOption(val, $event)" class="ml-1.5 inline-flex items-center justify-center text-bark-400 hover:text-bark-600 focus:outline-none rounded-full focus:bg-bark-200 transition-colors">
                        <svg class="h-3.5 w-3.5" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                            <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" />
                        </svg>
                    </button>
                </span>
            </template>
        </div>

        {{-- Ikon Panah --}}
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
        <template x-for="id in Object.keys(options)" :key="id">
            <div
                @click="toggleOption(id)"
                class="px-4 py-2.5 cursor-pointer transition-colors duration-150 flex items-center justify-between"
                {{-- Highlight Background untuk opsi yang terpilih --}}
                :class="isSelected(id) ? 'bg-sage-100 text-sage-800 font-medium' : 'text-ink hover:bg-cream-50'"
            >
                <span x-text="options[id]"></span>
            </div>
        </template>
    </div>
</div>
