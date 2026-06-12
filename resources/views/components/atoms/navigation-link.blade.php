@props([
    'href' => '#',
    'active' => false,
    'type' => 'a'
])

@php
    $baseClasses = 'font-body text-sm font-medium px-6 py-3 rounded-btn transition-colors duration-200 rounded-pill';
    $activeClasses = 'bg-terra-400 text-cream-50';
    $inactiveClasses = 'text-dusty hover:bg-terra-300 hover:text-cream-50';

    $classes = $baseClasses . ' ' . ($active ? $activeClasses : $inactiveClasses);
@endphp

@if($type === 'button' || $type === 'submit')
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@else
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@endif
