@props([
    'fields' => [] // Array konfigurasi input
])

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @foreach($fields as $field)
        <x-molecules.form-group
            :name="$field['name']"
            :label="$field['label']"
            :fullWidth="$field['fullWidth'] ?? false"
        >
            {{-- Escape Hatch: Jika butuh input kustom yang kompleks (misal: File Upload) --}}
            @if(isset($field['slot']))
                {!! $field['slot'] !!}

                {{-- Render Select Dropdown --}}
            @elseif(($field['type'] ?? 'text') === 'select')
                <x-atoms.select
                    :id="$field['name']"
                    {{-- Tambahkan [] pada name jika multiple --}}
                    :name="$field['name'] . (!empty($field['multiple']) ? '[]' : '')"
                    :required="$field['required'] ?? false"
                    :multiple="$field['multiple'] ?? false"
                >
                    @if(empty($field['multiple']))
                        <option value="">-- Pilih {{ $field['label'] }} --</option>
                    @endif

                    @foreach($field['options'] ?? [] as $optValue => $optLabel)
                        <option value="{{ $optValue }}"
                        @if(!empty($field['multiple']))
                            @selected(in_array($optValue, $field['value'] ?? []))
                            @else
                            @selected($optValue == ($field['value'] ?? ''))
                            @endif
                        >
                            {{ $optLabel }}
                        </option>
                    @endforeach
                </x-atoms.select>

            @elseif(($field['type'] ?? 'text') === 'textarea')
                <x-atoms.textarea
                    :id="$field['name']"
                    :name="$field['name']"
                    :rows="$field['rows'] ?? 4"
                    :required="$field['required'] ?? false"
                >{{ $field['value'] ?? '' }}</x-atoms.textarea>

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

    {{-- Slot tambahan (opsional) di bawah form --}}
    {{ $slot }}
</div>
<div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-cream-200">
    <x-atoms.button variant="secondary" href="{{ route('admin.authors.index') }}">Batal</x-atoms.button>
    <x-atoms.button variant="primary" type="submit">Simpan</x-atoms.button>
</div>
