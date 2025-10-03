<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxe Hair Studio - {{ ucfirst(str_replace('-', ' ', $component ?? 'Home')) }}</title>
    <meta name="description" content="Professional salon management system for Luxe Hair Studio - Experience luxury hair care and beauty services.">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&family=playfair-display:400,500,600,700" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-50 min-h-screen">
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
                
                <!-- Elegant Admin Dropdown -->
                <div class="flex items-center justify-end space-x-6">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex items-center space-x-3 px-4 py-2 bg-gradient-to-r from-gray-50 to-rose-50 hover:from-rose-50 hover:to-pink-50 rounded-full border border-rose-100 shadow-sm hover:shadow-md transition-all duration-300 group focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-opacity-50">
                            <div class="w-8 h-8 bg-gradient-to-br from-rose-500 to-pink-600 rounded-full flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="hidden sm:block text-left">
                                <p class="text-sm font-semibold text-gray-900">Admin Panel</p>
                                <p class="text-xs text-gray-500">Management Tools</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-500 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Admin Dropdown Menu -->
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
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">Admin Tools</p>
                                        <p class="text-sm text-gray-500">Management Dashboard</p>
                                    </div>
                                </div>
                            </div>

                            <div class="py-2">
                                <a href="{{ route('admin.dashboard') }}" 
                                   class="flex items-center px-6 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-rose-50 hover:to-pink-50 hover:text-rose-600 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H9a2 2 0 01-2-2z"/>
                                    </svg>
                                    <span class="font-medium">Dashboard</span>
                                </a>
                                <a href="{{ route('admin.bookings.index') }}" 
                                   class="flex items-center px-6 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-rose-50 hover:to-pink-50 hover:text-rose-600 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="font-medium">Manage Bookings</span>
                                </a>
                                <a href="{{ route('admin.customers') }}" 
                                   class="flex items-center px-6 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-rose-50 hover:to-pink-50 hover:text-rose-600 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                    </svg>
                                    <span class="font-medium">Manage Customers</span>
                                </a>
                                <a href="{{ route('admin.services') }}" 
                                   class="flex items-center px-6 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-rose-50 hover:to-pink-50 hover:text-rose-600 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                    </svg>
                                    <span class="font-medium">Manage Services</span>
                                </a>
                                <a href="{{ route('admin.deals') }}" 
                                   class="flex items-center px-6 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-rose-50 hover:to-pink-50 hover:text-rose-600 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    <span class="font-medium">Manage Deals</span>
                                </a>
                            </div>
                        </div>
                    </div>

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
                    <a href="{{ route('book-service') }}" class="block px-4 py-3 text-base font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors duration-200 {{ request()->routeIs('book-service') ? 'text-rose-600 bg-rose-50' : '' }}">Book Service</a>
                    
                    <div class="border-t border-gray-100 mt-4 pt-4">
                        <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wide">Admin Panel</div>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-base font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H9a2 2 0 01-2-2z"/>
                            </svg>
                            Dashboard
                        </a>
                        <a href="{{ route('admin.bookings.index') }}" class="flex items-center px-4 py-3 text-base font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Manage Bookings
                        </a>
                        <a href="{{ route('admin.customers') }}" class="flex items-center px-4 py-3 text-base font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                            Manage Customers
                        </a>
                        <a href="{{ route('admin.services') }}" class="flex items-center px-4 py-3 text-base font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                            Manage Services
                        </a>
                        <a href="{{ route('admin.deals') }}" class="flex items-center px-4 py-3 text-base font-semibold text-gray-700 hover:bg-rose-50 hover:text-rose-600 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            Manage Deals
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen bg-gray-50">
        @if($component === 'book-service')
            @livewire('book-service')
        @elseif($component === 'test-button')
            @livewire('test-button')
        @elseif($component === 'dashboard')
            @livewire('dashboard')
        @elseif($component === 'manage-bookings')
            @livewire('manage-bookings')
        @elseif($component === 'manage-customers')
            @livewire('manage-customers')
        @elseif($component === 'manage-services')
            @livewire('manage-services')
        @elseif($component === 'manage-deals')
            @livewire('manage-deals')
        @else
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="text-center">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">Welcome to Luxe Hair Studio</h1>
                    <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">Your premier destination for professional hair care and beauty services in an elegant, luxurious atmosphere.</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('book-service') }}" 
                           class="bg-rose-500 hover:bg-rose-600 text-white px-8 py-4 rounded-xl font-medium transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                            Book Your Service
                        </a>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-8 py-4 rounded-xl font-medium transition-all duration-200 transform hover:-translate-y-0.5">
                            Admin Dashboard
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </main>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    @livewireScripts
    
    <!-- Alpine.js for mobile menu -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Toast Notifications -->
    <script>
        // Toast notification system
        function showToast(type, message, title = null) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `p-4 rounded-xl shadow-lg max-w-sm transform transition-all duration-300 translate-x-full opacity-0 ${getToastClasses(type)}`;
            
            const content = `
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        ${getToastIcon(type)}
                    </div>
                    <div class="ml-3 flex-1">
                        ${title ? `<p class="text-sm font-medium">${title}</p>` : ''}
                        <p class="text-sm ${title ? 'mt-1' : ''}">${message}</p>
                    </div>
                    <button onclick="removeToast(this.parentElement.parentElement)" class="ml-4 text-current opacity-70 hover:opacity-100 transition-opacity duration-200">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            `;
            
            toast.innerHTML = content;
            container.appendChild(toast);

            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-x-full', 'opacity-0');
            }, 100);

            // Auto remove
            setTimeout(() => {
                removeToast(toast);
            }, 5000);
        }

        function removeToast(toast) {
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.remove();
                }
            }, 300);
        }

        function getToastClasses(type) {
            const classes = {
                success: 'bg-green-50 border border-green-200 text-green-800',
                error: 'bg-red-50 border border-red-200 text-red-800',
                warning: 'bg-yellow-50 border border-yellow-200 text-yellow-800',
                info: 'bg-blue-50 border border-blue-200 text-blue-800'
            };
            return classes[type] || classes.info;
        }

        function getToastIcon(type) {
            const icons = {
                success: '<svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>',
                error: '<svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>',
                warning: '<svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>',
                info: '<svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>'
            };
            return icons[type] || icons.info;
        }

        // Listen for Livewire events
        document.addEventListener('livewire:init', () => {
            Livewire.on('notify', (event) => {
                const { type, message, title } = event;
                showToast(type, message, title);
            });
        });
    </script>
</body>
</html>
</html>