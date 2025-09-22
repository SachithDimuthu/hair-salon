@extends('layouts.guest')

@section('title', 'Welcome to Luxe Hair Studio')
@section('description', 'Professional salon management system for Luxe Hair Studio')

@section('content')
<!-- Hero Section -->
<div class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Background overlay -->
    <div class="absolute inset-0 bg-gradient-to-br from-primary-50/80 via-white/90 to-secondary-50/80"></div>
    
    <!-- Decorative elements -->
    <div class="absolute top-1/4 -left-20 w-96 h-96 bg-gradient-to-r from-primary-100 to-secondary-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-float"></div>
    <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-gradient-to-r from-secondary-100 to-primary-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-float-delayed"></div>
    
    <div class="relative z-10 text-center max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-5xl sm:text-6xl lg:text-7xl font-serif font-bold text-gray-900 mb-6 leading-tight">
            Welcome to
            <span class="text-primary-600 block">Luxe Hair Studio</span>
        </h1>
        
        <p class="text-xl lg:text-2xl text-gray-600 mb-8 max-w-3xl mx-auto leading-relaxed">
            Professional salon management system
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <x-ui.button 
                href="{{ route('services') }}" 
                variant="primary" 
                size="lg"
                class="transform hover:scale-105 transition-transform duration-200"
            >
                Explore Our Services
            </x-ui.button>
            
            @guest
            <x-ui.button 
                href="{{ route('login') }}" 
                variant="outline" 
                size="lg"
                class="transform hover:scale-105 transition-transform duration-200"
            >
                Login
            </x-ui.button>
            @else
            <x-ui.button 
                href="{{ route('dashboard') }}" 
                variant="outline" 
                size="lg"
                class="transform hover:scale-105 transition-transform duration-200"
            >
                Dashboard
            </x-ui.button>
            @endguest
        </div>
    </div>
</div>

@endsection