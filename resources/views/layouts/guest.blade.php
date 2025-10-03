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
            <!-- Professional Salon Navigation -->
            <nav class="bg-white/98 backdrop-blur-lg shadow-xl border-b border-rose-100/50 sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-24">
                        <!-- Elegant Logo Section -->
                        <div class="flex items-center space-x-4 group">
                            <div class="relative">
                                <a href="{{ route('home') }}" class="block">
                                    <img src="{{ asset('images/Logo.jpg') }}" alt="Luxe Hair Studio Logo" 
                                         class="h-12 w-auto rounded-lg shadow-md group-hover:shadow-lg transition-all duration-300">
                                </a>
                                <div class="absolute -inset-1 bg-gradient-to-r from-rose-500 to-pink-500 rounded-lg blur opacity-20 group-hover:opacity-40 transition duration-300"></div>
                            </div>
                            <div class="hidden sm:block">
                                <a href="{{ route('home') }}" class="block">
                                    <h1 class="text-2xl font-bold text-black font-serif tracking-wide">
                                        Luxe Hair Studio
                                    </h1>
                                    <p class="text-xs text-black font-medium tracking-widest uppercase">Professional Hair Care</p>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Professional Navigation Menu -->
                        <div class="hidden md:flex items-center space-x-1">
                            <a href="{{ route('home') }}" 
                               class="relative px-6 py-3 text-sm font-medium text-gray-700 hover:text-rose-600 transition-all duration-300 group {{ request()->routeIs('home') ? 'text-rose-600' : '' }}">
                                <span class="relative z-10 tracking-wide">HOME</span>
                                <div class="absolute inset-0 bg-gradient-to-r from-rose-50 to-pink-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 {{ request()->routeIs('home') ? 'opacity-100' : '' }}"></div>
                                @if(request()->routeIs('home'))
                                    <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-8 h-0.5 bg-gradient-to-r from-rose-500 to-pink-500 rounded-full"></div>
                                @endif
                            </a>
                            <a href="{{ route('services') }}" 
                               class="relative px-6 py-3 text-sm font-medium text-gray-700 hover:text-rose-600 transition-all duration-300 group {{ request()->routeIs('services') ? 'text-rose-600' : '' }}">
                                <span class="relative z-10 tracking-wide">SERVICES</span>
                                <div class="absolute inset-0 bg-gradient-to-r from-rose-50 to-pink-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 {{ request()->routeIs('services') ? 'opacity-100' : '' }}"></div>
                                @if(request()->routeIs('services'))
                                    <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-8 h-0.5 bg-gradient-to-r from-rose-500 to-pink-500 rounded-full"></div>
                                @endif
                            </a>
                            <a href="{{ route('about') }}" 
                               class="relative px-6 py-3 text-sm font-medium text-gray-700 hover:text-rose-600 transition-all duration-300 group {{ request()->routeIs('about') ? 'text-rose-600' : '' }}">
                                <span class="relative z-10 tracking-wide">ABOUT</span>
                                <div class="absolute inset-0 bg-gradient-to-r from-rose-50 to-pink-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 {{ request()->routeIs('about') ? 'opacity-100' : '' }}"></div>
                                @if(request()->routeIs('about'))
                                    <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-8 h-0.5 bg-gradient-to-r from-rose-500 to-pink-500 rounded-full"></div>
                                @endif
                            </a>
                            <a href="{{ route('contact') }}" 
                               class="relative px-6 py-3 text-sm font-medium text-gray-700 hover:text-rose-600 transition-all duration-300 group {{ request()->routeIs('contact') ? 'text-rose-600' : '' }}">
                                <span class="relative z-10 tracking-wide">CONTACT</span>
                                <div class="absolute inset-0 bg-gradient-to-r from-rose-50 to-pink-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 {{ request()->routeIs('contact') ? 'opacity-100' : '' }}"></div>
                                @if(request()->routeIs('contact'))
                                    <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-8 h-0.5 bg-gradient-to-r from-rose-500 to-pink-500 rounded-full"></div>
                                @endif
                            </a>
                            
                            <!-- Premium Book Service Button -->
                            <div class="ml-6">
                                <a href="{{ route('book-service') }}" 
                                   class="relative inline-flex items-center px-8 py-3 bg-gradient-to-r from-rose-500 via-pink-500 to-rose-600 text-white font-semibold text-sm tracking-wide rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 group overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-r from-rose-600 via-pink-600 to-rose-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <span class="relative z-10 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2z"/>
                                        </svg>
                                        BOOK APPOINTMENT
                                    </span>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Elegant Right Section -->
                        <div class="flex items-center justify-end space-x-6">
                            @auth
                                <!-- Elegant User Dropdown -->
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" 
                                            class="flex items-center space-x-3 px-4 py-2 bg-gradient-to-r from-gray-50 to-rose-50 hover:from-rose-50 hover:to-pink-50 rounded-full border border-rose-100 shadow-sm hover:shadow-md transition-all duration-300 group focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-opacity-50">
                                        <div class="w-8 h-8 bg-gradient-to-br from-rose-500 to-pink-600 rounded-full flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <div class="hidden sm:block text-left">
                                            <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                            <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role ?? 'Member' }}</p>
                                        </div>
                                        <svg class="w-4 h-4 text-gray-500 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>

                                    <!-- Elegant Dropdown Menu -->
                                    <div x-show="open" 
                                         @click.away="open = false"
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0 transform scale-95 translate-y-2"
                                         x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                                         x-transition:leave="transition ease-in duration-200"
                                         x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
                                         x-transition:leave-end="opacity-0 transform scale-95 translate-y-2"
                                         class="absolute right-0 mt-4 w-64 bg-white rounded-2xl shadow-2xl border border-rose-100 py-3 z-50 backdrop-blur-sm">
                                        
                                        <div class="px-6 py-4 border-b border-gray-100">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-12 h-12 bg-gradient-to-br from-rose-500 to-pink-600 rounded-full flex items-center justify-center">
                                                    <span class="text-white font-bold text-lg">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                                    <p class="text-sm text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="py-2">
                                            @if(Auth::user()->isAdmin())
                                                <a href="{{ route('admin.dashboard') }}" 
                                                   class="flex items-center px-6 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-rose-50 hover:to-pink-50 hover:text-rose-600 transition-all duration-200">
                                                    <svg class="w-5 h-5 mr-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H9a2 2 0 01-2-2z"/>
                                                    </svg>
                                                    <span class="font-medium">Admin Dashboard</span>
                                                </a>
                                            @elseif(Auth::user()->isCustomer())
                                                <a href="{{ route('customer.dashboard') }}" 
                                                   class="flex items-center px-6 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-rose-50 hover:to-pink-50 hover:text-rose-600 transition-all duration-200">
                                                    <svg class="w-5 h-5 mr-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                    <span class="font-medium">My Dashboard</span>
                                                </a>
                                            @endif

                                            <a href="{{ url('/user/profile') }}" 
                                               class="flex items-center px-6 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-rose-50 hover:to-pink-50 hover:text-rose-600 transition-all duration-200">
                                                <svg class="w-5 h-5 mr-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <span class="font-medium">Profile Settings</span>
                                            </a>
                                        </div>

                                        <div class="border-t border-gray-100 pt-2">
                                            <form method="POST" action="{{ route('logout') }}" class="block">
                                                @csrf
                                                <button type="submit" 
                                                        class="w-full flex items-center px-6 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-red-50 hover:to-rose-50 hover:text-red-600 transition-all duration-200 text-left">
                                                    <svg class="w-5 h-5 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                                    </svg>
                                                    <span class="font-medium">Sign Out</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Elegant Login Button -->
                                <a href="{{ route('login') }}" 
                                   class="inline-flex items-center px-6 py-2.5 bg-white border-2 border-rose-200 text-rose-600 font-semibold text-sm tracking-wide rounded-full hover:bg-gradient-to-r hover:from-rose-50 hover:to-pink-50 hover:border-rose-300 transition-all duration-300 shadow-sm hover:shadow-md">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                    </svg>
                                    CLIENT LOGIN
                                </a>
                            @endauth
                            
                            <!-- Elegant Mobile Menu Button -->
                            <div class="md:hidden">
                                <button x-data x-on:click="$refs.mobileMenu.classList.toggle('hidden')" 
                                        class="inline-flex items-center justify-center p-3 rounded-full text-gray-600 hover:text-rose-600 hover:bg-gradient-to-r hover:from-rose-50 hover:to-pink-50 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-opacity-50 transition-all duration-300 border border-gray-200 hover:border-rose-200">
                                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mobile Navigation Menu -->
                    <div x-ref="mobileMenu" class="hidden md:hidden border-t border-gray-100 py-4">
                        <div class="space-y-2">
                            <a href="{{ route('home') }}" class="block px-4 py-3 text-base font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('home') ? 'text-rose-600 bg-rose-50' : '' }}">Home</a>
                            <a href="{{ route('services') }}" class="block px-4 py-3 text-base font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('services') ? 'text-rose-600 bg-rose-50' : '' }}">Services</a>
                            <a href="{{ route('about') }}" class="block px-4 py-3 text-base font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('about') ? 'text-rose-600 bg-rose-50' : '' }}">About</a>
                            <a href="{{ route('contact') }}" class="block px-4 py-3 text-base font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('contact') ? 'text-rose-600 bg-rose-50' : '' }}">Contact</a>
                            <a href="{{ route('book-service') }}" class="block px-4 py-3 text-base font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors duration-200">Book Service</a>
                            
                            @auth
                                <!-- Mobile User Section -->
                                <div class="border-t border-gray-100 pt-4 mt-4">
                                    <div class="px-4 py-2">
                                        <div class="flex items-center space-x-3 mb-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-rose-500 to-pink-600 rounded-full flex items-center justify-center shadow-sm">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @if(Auth::user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-base font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors duration-200">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H9a2 2 0 01-2-2z"/>
                                            </svg>
                                            Admin Dashboard
                                        </a>
                                    @elseif(Auth::user()->isCustomer())
                                        <a href="{{ route('customer.dashboard') }}" class="flex items-center px-4 py-3 text-base font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors duration-200">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            My Dashboard
                                        </a>
                                    @endif
                                    
                                    <a href="{{ url('/user/profile') }}" class="flex items-center px-4 py-3 text-base font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Profile
                                    </a>
                                    
                                    <form method="POST" action="{{ route('logout') }}" class="block">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center px-4 py-3 text-base font-semibold text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition-colors duration-200 text-left">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            @else
                                <a href="{{ route('login') }}" class="block px-4 py-3 text-base font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors duration-200">Login</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="flex-1">
                @if(isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </main>

            <!-- Professional Footer -->
            <footer class="bg-gray-900 text-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                        <!-- About Section -->
                        <div class="lg:col-span-2">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-10 h-10 bg-gradient-to-br from-rose-500 to-rose-600 rounded-lg flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold font-serif">Luxe Hair Studio</h3>
                            </div>
                            <p class="text-gray-300 leading-relaxed mb-6 max-w-md">
                                Sri Lanka's premier destination for luxury hair care and beauty services. Where elegance meets expertise, and every visit transforms your look and confidence.
                            </p>
                            <div class="flex space-x-4">
                                <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-rose-600 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                    </svg>
                                </a>
                                <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-rose-600 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                                    </svg>
                                </a>
                                <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-rose-600 transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.083.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.001z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Quick Links -->
                        <div>
                            <h4 class="text-lg font-semibold mb-6">Quick Links</h4>
                            <ul class="space-y-3">
                                <li><a href="{{ route('book-service') }}" class="text-gray-300 hover:text-rose-400 transition-colors duration-200">Book Appointment</a></li>
                                <li><a href="{{ route('services') }}" class="text-gray-300 hover:text-rose-400 transition-colors duration-200">Our Services</a></li>
                                <li><a href="{{ route('about') }}" class="text-gray-300 hover:text-rose-400 transition-colors duration-200">About Us</a></li>
                                <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-rose-400 transition-colors duration-200">Contact Us</a></li>
                                <li><a href="{{ route('admin.dashboard') }}" class="text-gray-300 hover:text-rose-400 transition-colors duration-200">Admin Portal</a></li>
                            </ul>
                        </div>
                        
                        <!-- Contact Info -->
                        <div>
                            <h4 class="text-lg font-semibold mb-6">Contact Information</h4>
                            <div class="space-y-4">
                                <div class="flex items-start space-x-3">
                                    <svg class="w-5 h-5 text-rose-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <div>
                                        <p class="text-gray-300">123 Main Street</p>
                                        <p class="text-gray-300">Kandy, Sri Lanka</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-rose-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <p class="text-gray-300">+94 71 234 5678</p>
                                </div>
                                
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-rose-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-gray-300">info@luxehairstudio.lk</p>
                                </div>
                                
                                <div class="flex items-start space-x-3">
                                    <svg class="w-5 h-5 text-rose-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div>
                                        <p class="text-gray-300">Mon - Sat: 9:00 AM - 7:00 PM</p>
                                        <p class="text-gray-300">Sunday: 10:00 AM - 5:00 PM</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Copyright -->
                    <div class="border-t border-gray-800 mt-12 pt-8 text-center">
                        <p class="text-gray-400">
                            © {{ date('Y') }} Luxe Hair Studio. All rights reserved. 
                            <span class="text-rose-400">Created by Sachith for APIIT.</span>
                        </p>
                    </div>
                </div>
            </footer>
        </div>

        @livewireScripts

        <!-- Additional Scripts -->
        @stack('scripts')
        
        <!-- Alpine.js for mobile menu -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </body>
</html>
