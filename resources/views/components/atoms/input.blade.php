@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-pill w-full font-body text-sm text-ink bg-cream-100 border border-cream-200 rounded-btn px-4 py-3 placeholder:text-dusty focus:outline-none focus:ring-1 focus:ring-bark-300/50 focus:border-bark-300/50 focus:bg-white transition-all duration-150']) !!}>
