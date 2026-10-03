@props([
    'variant' => 'gold', // 'gold', 'outline', 'maroon', 'whatsapp', 'ghost'
    'size' => 'md', // 'sm', 'md', 'lg'
    'href' => null,
    'type' => 'button',
    'icon' => null,
    'class' => ''
])

@php
$sizeClasses = [
    'sm' => 'px-3 py-1.5 text-xs',
    'md' => 'px-6 py-3 text-xs tracking-widest',
    'lg' => 'px-8 py-4 text-sm tracking-widest'
][$size] ?? 'px-6 py-3 text-xs tracking-widest';

$variantClasses = [
    'gold' => 'btn-gold',
    'outline' => 'btn-outline-gold',
    'maroon' => 'btn-maroon',
    'whatsapp' => 'btn-whatsapp',
    'ghost' => 'btn-ghost'
][$variant] ?? 'btn-gold';
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "$variantClasses $class"]) }}>
        @if($icon) <i class="{{ $icon }} mr-2"></i> @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "$variantClasses $class"]) }}>
        @if($icon) <i class="{{ $icon }} mr-2"></i> @endif
        {{ $slot }}
    </button>
@endif
