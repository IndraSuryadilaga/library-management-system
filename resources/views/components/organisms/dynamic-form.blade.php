<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @foreach($fields as $field)
        <x-molecules.form-group
            :name="$field['name']"
            :label="$field['label']"
            :fullWidth="$field['fullWidth'] ?? false"
        >
            @if(isset($field['slot']))
                {!! $field['slot'] !!}

                {{-- 1. JIKA MULTIPLE = TRUE, PANGGIL KOMPONEN MULTIPLE-SELECT --}}
            @elseif(($field['type'] ?? 'text') === 'select' && !empty($field['multiple']))
                <x-atoms.multiple-select
                    :name="$field['name']"
                    :placeholder="$field['placeholder'] ?? 'Pilih beberapa ' . $field['label']"
                    :options="$field['options'] ?? []"
                    :value="$field['value'] ?? []"
                />

                {{-- 2. JIKA MULTIPLE = FALSE, PANGGIL SELECT NATIVE HTML --}}
            @elseif(($field['type'] ?? 'text') === 'select' && empty($field['multiple']))
                <x-atoms.select
                    :id="$field['name']"
                    :name="$field['name']"
                    :required="$field['required'] ?? false"
                    :placeholder="$field['placeholder'] ?? 'Pilih ' . $field['label']"
                    :options="$field['options'] ?? []"
                    :value="$field['value'] ?? ''"
                />

                {{-- 3. RENDER TEXTAREA --}}
            @elseif(($field['type'] ?? 'text') === 'textarea')
                <x-atoms.textarea
                    :id="$field['name']"
                    :name="$field['name']"
                    :rows="$field['rows'] ?? 4"
                    :required="$field['required'] ?? false"
                >{{ $field['value'] ?? '' }}</x-atoms.textarea>

                {{-- 4. RENDER INPUT STANDAR --}}
            @else
                <x-atoms.input
                    :type="$field['type'] ?? 'text'"
                    :id="$field['name']"
                    :name="$field['name']"
                    value="{{ $field['value'] ?? '' }}"
                    :required="$field['required'] ?? false"
                />
            @endif
        </x-molecules.form-group>
    @endforeach

    {{ $slot }}
</div>

{{-- AREA TOMBOL DINAMIS --}}
@if($cancelUrl || $submitLabel)
    <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-cream-200">
        @if($cancelUrl)
            <x-atoms.button variant="secondary" :href="$cancelUrl">
                Batal
            </x-atoms.button>
        @endif

        @if($submitLabel)
            <x-atoms.button variant="primary" type="submit">
                {{ $submitLabel }}
            </x-atoms.button>
        @endif
    </div>
@endif
