@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-200 focus:border-rose-500 focus:ring-rose-500 focus:ring-4 focus:ring-rose-100 rounded-2xl shadow-sm bg-gray-50/50 hover:bg-white transition-all duration-200 px-4 py-3']) !!}>
