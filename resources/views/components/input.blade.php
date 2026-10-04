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

<div class="luxury-form-group mb-3">
    @if($label)
        <label for="{{ $name }}" class="d-block text-xs text-uppercase tracking-widest text-gold mb-2 fw-medium">
            {{ $label }} @if($required)<span class="text-danger">*</span>@endif
        </label>
    @endif
    
    <div class="position-relative">
        @if($icon)
            <div class="position-absolute top-50 start-0 translate-middle-y ps-3 d-flex align-items-center pointer-events-none text-gold opacity-50">
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
                'class' => 'form-control form-control-luxury ' . ($icon ? 'ps-5' : '')
            ]) }}
        >
    </div>

    @error($name)
        <p class="text-danger text-xs mt-1 mb-0">{{ $message }}</p>
    @enderror
</div>
