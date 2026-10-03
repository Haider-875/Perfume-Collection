@props(['type' => 'gold', 'text' => ''])

@php
$classes = match($type) {
    'danger' => 'background: #801313; border: 1px solid #C0392B; color: #FFF;',
    'success' => 'background: rgba(39, 174, 96, 0.2); border: 1px solid #27ae60; color: #2ecc71;',
    'maroon' => 'background: rgba(74, 14, 23, 0.4); border: 1px solid rgba(201, 162, 75, 0.4); color: var(--gold-bright);',
    default => 'background: var(--gold-gradient); color: #080304; font-weight: 700;',
};
@endphp

<span style="{{ $classes }} font-family: var(--font-heading); font-size: 0.7rem; letter-spacing: 0.1em; text-transform: uppercase; padding: 4px 10px; border-radius: 3px; display: inline-block;">
    {{ $slot->isEmpty() ? $text : $slot }}
</span>
