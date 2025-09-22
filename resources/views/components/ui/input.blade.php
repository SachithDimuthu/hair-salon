@props([
    'label' => null,
    'type' => 'text',
    'name' => null,
    'id' => null,
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'error' => null,
    'hint' => null,
    'icon' => null,
    'iconPosition' => 'left',
    'size' => 'md'
])

@php
$inputId = $id ?? $name ?? uniqid('input_');

$baseClasses = 'block w-full border border-neutral-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500 disabled:bg-neutral-50 disabled:text-neutral-500 disabled:cursor-not-allowed';

$sizeClasses = [
    'sm' => 'px-3 py-2 text-sm',
    'md' => 'px-3 py-2 text-base',
    'lg' => 'px-4 py-3 text-lg',
];

$errorClasses = $error ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : '';

$classes = $baseClasses . ' ' . $sizeClasses[$size] . ' ' . $errorClasses;

if ($icon) {
    $classes .= $iconPosition === 'left' ? ' pl-10' : ' pr-10';
}
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'space-y-1']) }}>
    @if($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-neutral-700">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        @if($icon && $iconPosition === 'left')
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <x-dynamic-component :component="$icon" class="h-5 w-5 text-neutral-400" />
            </div>
        @endif

        <input 
            type="{{ $type }}"
            id="{{ $inputId }}"
            @if($name) name="{{ $name }}" @endif
            @if($value) value="{{ $value }}" @endif
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($required) required @endif
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
            class="{{ $classes }}"
            {{ $attributes->except(['class', 'label', 'error', 'hint', 'icon', 'iconPosition', 'size']) }}
        />

        @if($icon && $iconPosition === 'right')
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <x-dynamic-component :component="$icon" class="h-5 w-5 text-neutral-400" />
            </div>
        @endif
    </div>

    @if($hint && !$error)
        <p class="text-sm text-neutral-500">{{ $hint }}</p>
    @endif

    @if($error)
        <p class="text-sm text-red-600">{{ $error }}</p>
    @endif
</div>