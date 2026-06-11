@props([
    'items' => [] {{-- Array penampung data --}}
])

<div {{ $attributes->merge(['class' => 'bg-parchment border border-cream-200 rounded-card-lg p-8 paper-grain']) }}>
    <div class="flex flex-col">
        @if(isset($header))
            <div class="mb-6 pb-6 border-b border-cream-200">
                {{ $header }}
            </div>
        @endif

        {{-- Grid Container --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 font-body text-sm">
            {{-- Loop otomatis atom detail-item berdasarkan data array --}}
            @foreach($items as $item)
                <x-atoms.detail-item
                    :label="$item['label']"
                    :value="$item['value'] ?? null"
                    :isMono="$item['isMono'] ?? false"
                    :fullWidth="$item['fullWidth'] ?? false"
                >
                    {{-- Slot fallback jika isi value membutuhkan manipulasi HTML khusus --}}
                    @if(isset($item['slot']))
                        {!! $item['slot'] !!}
                    @endif
                </x-atoms.detail-item>
            @endforeach

            {{-- Tetap sediakan slot default utama untuk fleksibilitas tambahan --}}
            {{ $slot }}
        </div>

        @if(isset($actions))
            <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-cream-200">
                {{ $actions }}
            </div>
        @endif
    </div>
</div>
