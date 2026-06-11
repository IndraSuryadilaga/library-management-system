@props([
    // The style of the button: 'primary', 'secondary', 'tertiary', or 'danger'
    'variant' => 'primary',
    // The HTML button type: 'button', 'submit', or 'reset'
    'type' => 'button',
])

@php
    $isLink = $attributes->has('href');
    $isDisabled = $attributes->get('disabled') !== null && $attributes->get('disabled') !== false;

    // Base classes from the design system, applied to all variants
    $baseClasses = 'inline-flex items-center justify-center gap-2 font-body text-sm rounded-btn transition-colors duration-150';

    // Variant-specific classes from DESIGN.md.
    $styles = [
        'primary'   => 'px-6 py-3 font-semibold rounded-pill bg-terra-400 text-white hover:bg-terra-500 disabled:bg-cream-200 disabled:text-dusty disabled:cursor-not-allowed',
        'secondary' => 'px-6 py-3 font-semibold rounded-pill bg-transparent border-2 border-bark-500 text-bark-500 hover:bg-bark-500 hover:text-cream-50 disabled:border-cream-200 disabled:text-dusty disabled:bg-transparent disabled:cursor-not-allowed',
        'tertiary'  => 'font-medium text-bark-400 rounded-pill hover:text-bark-600 hover:underline disabled:text-dusty disabled:no-underline disabled:cursor-not-allowed',
        'danger'    => 'px-6 py-3 font-semibold rounded-pill bg-transparent border-2 border-red-500 text-red-500 hover:bg-red-500 hover:text-white disabled:border-cream-200 disabled:text-dusty disabled:bg-transparent disabled:cursor-not-allowed',
    ];

    $appliedClasses = $baseClasses . ' ' . ($styles[$variant] ?? $styles['primary']);

    if ($isLink && $isDisabled) {
        $attributes = $attributes->except('href')->merge([
            'role' => 'link',
            'aria-disabled' => 'true',
        ]);
    }
@endphp

@if($isLink)
    <a {{ $attributes->except(['disabled', 'type', 'variant'])->merge(['class' => $appliedClasses]) }}>
        @if(isset($icon))
            <span class="flex items-center justify-center shrink-0">
                {{ $icon }}
            </span>
        @endif
        <span>{{ $slot }}</span>
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->except(['type', 'variant'])->merge(['class' => $appliedClasses]) }}
        @if($isDisabled) disabled @endif
    >
        @if(isset($icon))
            <span class="flex items-center justify-center shrink-0">
                {{ $icon }}
            </span>
        @endif
        <span>{{ $slot }}</span>
    </button>
@endif
