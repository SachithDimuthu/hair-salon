@props([
    'variant' => 'default',
    'padding' => 'default',
    'shadow' => 'default',
    'border' => true,
    'hover' => false
])

@php
$baseClasses = 'bg-white rounded-lg';

$variantClasses = [
    'default' => '',
    'primary' => 'bg-gradient-to-br from-primary-50 to-white border-primary-200',
    'secondary' => 'bg-gradient-to-br from-secondary-50 to-white border-secondary-200',
    'success' => 'bg-gradient-to-br from-green-50 to-white border-green-200',
    'warning' => 'bg-gradient-to-br from-yellow-50 to-white border-yellow-200',
    'error' => 'bg-gradient-to-br from-red-50 to-white border-red-200',
];

$paddingClasses = [
    'none' => '',
    'sm' => 'p-4',
    'default' => 'p-6',
    'lg' => 'p-8',
    'xl' => 'p-10',
];

$shadowClasses = [
    'none' => '',
    'sm' => 'shadow-sm',
    'default' => 'shadow-md',
    'lg' => 'shadow-lg',
    'xl' => 'shadow-xl',
    'luxe' => 'shadow-luxe',
    'luxe-lg' => 'shadow-luxe-lg',
];

$borderClass = $border ? 'border border-neutral-200' : '';
$hoverClass = $hover ? 'hover:shadow-lg transition-shadow duration-200' : '';

$classes = trim($baseClasses . ' ' . 
    $variantClasses[$variant] . ' ' . 
    $paddingClasses[$padding] . ' ' . 
    $shadowClasses[$shadow] . ' ' . 
    $borderClass . ' ' . 
    $hoverClass);
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>