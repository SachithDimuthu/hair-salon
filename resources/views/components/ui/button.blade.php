@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'target' => null,
    'disabled' => false,
    'loading' => false,
    'icon' => null,
    'iconPosition' => 'left'
])

@php
$baseClasses = 'inline-flex items-center justify-center font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

$variantClasses = [
    'primary' => 'bg-primary-600 hover:bg-primary-700 focus:ring-primary-500 text-white shadow-sm',
    'secondary' => 'bg-secondary-600 hover:bg-secondary-700 focus:ring-secondary-500 text-white shadow-sm',
    'outline' => 'border border-primary-300 text-primary-700 bg-white hover:bg-primary-50 focus:ring-primary-500',
    'ghost' => 'text-primary-600 hover:text-primary-700 hover:bg-primary-50 focus:ring-primary-500',
    'danger' => 'bg-red-600 hover:bg-red-700 focus:ring-red-500 text-white shadow-sm',
    'success' => 'bg-green-600 hover:bg-green-700 focus:ring-green-500 text-white shadow-sm',
    'neutral' => 'bg-neutral-600 hover:bg-neutral-700 focus:ring-neutral-500 text-white shadow-sm',
];

$sizeClasses = [
    'xs' => 'px-2.5 py-1.5 text-xs rounded',
    'sm' => 'px-3 py-2 text-sm rounded-md',
    'md' => 'px-4 py-2 text-sm rounded-md',
    'lg' => 'px-4 py-2 text-base rounded-md',
    'xl' => 'px-6 py-3 text-base rounded-md',
];

$classes = $baseClasses . ' ' . $variantClasses[$variant] . ' ' . $sizeClasses[$size];

$iconSizeClasses = [
    'xs' => 'w-3 h-3',
    'sm' => 'w-4 h-4',
    'md' => 'w-4 h-4',
    'lg' => 'w-5 h-5',
    'xl' => 'w-5 h-5',
];

$iconSize = $iconSizeClasses[$size];
@endphp

@if($href)
    <a href="{{ $href }}" 
       @if($target) target="{{ $target }}" @endif
       {{ $attributes->merge(['class' => $classes]) }}
       @if($disabled) aria-disabled="true" @endif>
        
        @if($loading)
            <svg class="animate-spin -ml-1 mr-3 {{ $iconSize }} text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($icon && $iconPosition === 'left')
            <x-dynamic-component :component="$icon" class="{{ $iconSize }} mr-2" />
        @endif

        {{ $slot }}

        @if($icon && $iconPosition === 'right')
            <x-dynamic-component :component="$icon" class="{{ $iconSize }} ml-2" />
        @endif
    </a>
@else
    <button type="{{ $type }}" 
            {{ $attributes->merge(['class' => $classes]) }}
            @if($disabled || $loading) disabled @endif>
        
        @if($loading)
            <svg class="animate-spin -ml-1 mr-3 {{ $iconSize }} text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($icon && $iconPosition === 'left')
            <x-dynamic-component :component="$icon" class="{{ $iconSize }} mr-2" />
        @endif

        {{ $slot }}

        @if($icon && $iconPosition === 'right')
            <x-dynamic-component :component="$icon" class="{{ $iconSize }} ml-2" />
        @endif
    </button>
@endif