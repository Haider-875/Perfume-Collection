@props([
    'label' => null,
    'name' => '',
    'type' => 'text',
    'placeholder' => '',
    'value' => '',
    'required' => false,
    'icon' => null,
    'error' => null
])

<div class="luxury-form-group mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-xs uppercase tracking-widest text-gold mb-2 font-medium">
            {{ $label }} @if($required)<span class="text-maroon">*</span>@endif
        </label>
    @endif
    
    <div class="relative">
        @if($icon)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gold/60">
                <i class="{{ $icon }}"></i>
            </div>
        @endif
        
        <input 
            type="{{ $type }}" 
            name="{{ $name }}" 
            id="{{ $name }}" 
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            @if($required) required @endif
            {{ $attributes->merge([
                'class' => 'w-full bg-[#120B0C] border border-[#C9A24B]/30 rounded px-4 py-3 text-sm text-[#F5EFE6] placeholder-stone-500 focus:outline-none focus:border-[#C9A24B] focus:ring-1 focus:ring-[#C9A24B] transition-all duration-300 ' . ($icon ? 'pl-10' : '')
            ]) }}
        >
    </div>

    @error($name)
        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
