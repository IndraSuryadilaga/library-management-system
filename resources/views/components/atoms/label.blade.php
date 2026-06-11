@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-body text-sm font-medium text-bark-600 mb-1.5']) }}>
    {{ $value ?? $slot }}
</label>
