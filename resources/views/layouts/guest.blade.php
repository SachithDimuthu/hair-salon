<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Luxe Hair Studio') }} - @yield('title', 'Professional Hair Care')</title>
        <meta name="description" content="@yield('description', 'Experience luxury hair care at Luxe Hair Studio. Professional styling, coloring, and treatments in an elegant atmosphere.')">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&family=playfair-display:400,500,600,700" rel="stylesheet" />

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles

        <!-- Additional Head Content -->
        @stack('head')
    </head>
    <body class="font-sans antialiased bg-white">
        <div class="min-h-screen flex flex-col">
            <!-- Public Navigation -->
            <nav class="bg-white shadow-sm border-b border-neutral-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <!-- Logo -->
                        <div class="flex items-center">
                            <a href="{{ route('home') }}" class="flex items-center">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('images/logo/luxe-hair-studio-horizontal.svg') }}" 
                                         alt="Luxe Hair Studio" 
                                         class="h-8 w-auto">
                                </div>
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden md:flex items-center space-x-8">
                            <a href="{{ route('home') }}" 
                               class="text-neutral-700 hover:text-primary-600 px-3 py-2 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'text-primary-600 border-b-2 border-primary-600' : '' }}">
                                Home
                            </a>
                            <a href="{{ route('services') }}" 
                               class="text-neutral-700 hover:text-primary-600 px-3 py-2 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('services') ? 'text-primary-600 border-b-2 border-primary-600' : '' }}">
                                Services
                            </a>
                            <a href="{{ route('staff') }}" 
                               class="text-neutral-700 hover:text-primary-600 px-3 py-2 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('staff') ? 'text-primary-600 border-b-2 border-primary-600' : '' }}">
                                Our Team
                            </a>
                            <a href="{{ route('about') }}" 
                               class="text-neutral-700 hover:text-primary-600 px-3 py-2 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('about') ? 'text-primary-600 border-b-2 border-primary-600' : '' }}">
                                About
                            </a>
                            <a href="{{ route('contact') }}" 
                               class="text-neutral-700 hover:text-primary-600 px-3 py-2 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('contact') ? 'text-primary-600 border-b-2 border-primary-600' : '' }}">
                                Contact
                            </a>
                        </div>

                        <!-- Auth Links -->
                        <div class="hidden md:flex items-center space-x-4">
                            @auth
                                <a href="{{ route('dashboard') }}" class="text-neutral-700 hover:text-primary-600 px-3 py-2 text-sm font-medium">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-neutral-700 hover:text-primary-600 px-3 py-2 text-sm font-medium">
                                    Login
                                </a>
                                <a href="{{ route('register') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                                    Book Now
                                </a>
                            @endauth
                        </div>

                        <!-- Mobile menu button -->
                        <div class="md:hidden flex items-center">
                            <button x-data="{ open: false }" @click="open = !open" type="button" class="text-neutral-700 hover:text-primary-600 focus:outline-none focus:text-primary-600" aria-label="toggle menu">
                                <svg x-show="!open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                                <svg x-show="open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile Navigation Menu -->
                <div x-data="{ open: false }" x-show="open" class="md:hidden">
                    <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t border-neutral-200">
                        <a href="{{ route('home') }}" class="block px-3 py-2 text-base font-medium text-neutral-700 hover:text-primary-600 hover:bg-neutral-50">Home</a>
                        <a href="{{ route('services') }}" class="block px-3 py-2 text-base font-medium text-neutral-700 hover:text-primary-600 hover:bg-neutral-50">Services</a>
                        <a href="{{ route('staff') }}" class="block px-3 py-2 text-base font-medium text-neutral-700 hover:text-primary-600 hover:bg-neutral-50">Our Team</a>
                        <a href="{{ route('about') }}" class="block px-3 py-2 text-base font-medium text-neutral-700 hover:text-primary-600 hover:bg-neutral-50">About</a>
                        <a href="{{ route('contact') }}" class="block px-3 py-2 text-base font-medium text-neutral-700 hover:text-primary-600 hover:bg-neutral-50">Contact</a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-base font-medium text-neutral-700 hover:text-primary-600 hover:bg-neutral-50">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-neutral-700 hover:text-primary-600 hover:bg-neutral-50">Login</a>
                            <a href="{{ route('register') }}" class="block px-3 py-2 text-base font-medium bg-primary-600 text-white rounded-md mx-3">Book Now</a>
                        @endauth
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="flex-1">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-neutral-900 text-white">
                <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <!-- Logo and Description -->
                        <div class="col-span-1 md:col-span-2">
                            <h3 class="text-xl font-heading font-bold text-white mb-4">
                                Luxe Hair Studio
                            </h3>
                            <p class="text-neutral-300 text-sm leading-relaxed mb-4">
                                Experience luxury hair care in an elegant atmosphere. Our expert stylists provide professional cutting, coloring, and styling services to help you look and feel your best.
                            </p>
                        </div>

                        <!-- Quick Links -->
                        <div>
                            <h4 class="text-lg font-semibold text-white mb-4">Quick Links</h4>
                            <ul class="space-y-2">
                                <li><a href="{{ route('services') }}" class="text-neutral-300 hover:text-white text-sm transition-colors duration-200">Services</a></li>
                                <li><a href="{{ route('staff') }}" class="text-neutral-300 hover:text-white text-sm transition-colors duration-200">Our Team</a></li>
                                <li><a href="{{ route('about') }}" class="text-neutral-300 hover:text-white text-sm transition-colors duration-200">About Us</a></li>
                                <li><a href="{{ route('contact') }}" class="text-neutral-300 hover:text-white text-sm transition-colors duration-200">Contact</a></li>
                            </ul>
                        </div>

                        <!-- Contact Info -->
                        <div>
                            <h4 class="text-lg font-semibold text-white mb-4">Contact Info</h4>
                            <ul class="space-y-2 text-sm text-neutral-300">
                                <li>123 Beauty Boulevard</li>
                                <li>Luxury City, LC 12345</li>
                                <li class="mt-2">
                                    <a href="tel:+1234567890" class="hover:text-white transition-colors duration-200">
                                        (123) 456-7890
                                    </a>
                                </li>
                                <li>
                                    <a href="mailto:info@luxehairstudio.com" class="hover:text-white transition-colors duration-200">
                                        info@luxehairstudio.com
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Copyright -->
                    <div class="border-t border-neutral-800 mt-8 pt-8 text-center">
                        <p class="text-neutral-400 text-sm">
                            &copy; {{ date('Y') }} Luxe Hair Studio. All rights reserved.
                        </p>
                    </div>
                </div>
            </footer>
        </div>

        @livewireScripts

        <!-- Additional Scripts -->
        @stack('scripts')
    </body>
</html>
