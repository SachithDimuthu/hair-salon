<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Luxe Hair Studio - Professional Hair Care</title>
    <meta name="description" content="Experience luxury hair care at Luxe Hair Studio. Professional styling, coloring, and treatments in an elegant atmosphere.">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&family=playfair-display:400,500,600,700" rel="stylesheet" />
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gradient-to-br from-rose-50 via-white to-gray-50 min-h-screen">
    <!-- Tailwind CSS is now working! Test elements removed. -->
    


    <!-- Enhanced Navigation -->
    <nav class="bg-white/95 backdrop-blur-md shadow-lg border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/Logo.jpg') }}" alt="Luxe Hair Studio Logo" class="h-10 w-auto">
                    </a>
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-gray-900 font-serif tracking-tight hover:text-rose-600 transition-colors duration-200">
                        Luxe Hair Studio
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" 
                       class="text-base font-semibold text-gray-600 hover:text-rose-600 transition-colors duration-200 px-4 py-2 rounded-lg hover:bg-rose-50 {{ request()->routeIs('home') ? 'text-rose-600 bg-rose-50' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('services') }}" 
                       class="text-base font-semibold text-gray-600 hover:text-rose-600 transition-colors duration-200 px-4 py-2 rounded-lg hover:bg-rose-50 {{ request()->routeIs('services') ? 'text-rose-600 bg-rose-50' : '' }}">
                        Services
                    </a>
                    <a href="{{ route('about') }}" 
                       class="text-base font-semibold text-gray-600 hover:text-rose-600 transition-colors duration-200 px-4 py-2 rounded-lg hover:bg-rose-50 {{ request()->routeIs('about') ? 'text-rose-600 bg-rose-50' : '' }}">
                        About
                    </a>
                    <a href="{{ route('contact') }}" 
                       class="text-base font-semibold text-gray-600 hover:text-rose-600 transition-colors duration-200 px-4 py-2 rounded-lg hover:bg-rose-50 {{ request()->routeIs('contact') ? 'text-rose-600 bg-rose-50' : '' }}">
                        Contact
                    </a>
                    <a href="{{ route('book-service') }}" 
                       class="text-base font-semibold text-gray-600 hover:text-rose-600 transition-colors duration-200 px-4 py-2 rounded-lg hover:bg-rose-50">
                        Book Service
                    </a>
                    
                    <!-- Search Component -->
                    <div class="hidden lg:block w-80">
                        @livewire('global-search')
                    </div>
                    
                    @auth
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    class="flex items-center space-x-2 text-gray-600 hover:text-rose-600 transition-colors duration-200 px-4 py-2 rounded-lg hover:bg-rose-50 focus:outline-none">
                                <div class="w-8 h-8 bg-gradient-to-br from-rose-500 to-pink-600 rounded-full flex items-center justify-center shadow-sm">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <span class="text-base font-semibold">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform scale-95"
                                 x-transition:enter-end="opacity-100 transform scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform scale-100"
                                 x-transition:leave-end="opacity-0 transform scale-95"
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50">
                                
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm text-gray-500">Signed in as</p>
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->email }}</p>
                                </div>

                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" 
                                       class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-rose-50 hover:text-rose-600 transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H9a2 2 0 01-2-2z"/>
                                        </svg>
                                        Admin Dashboard
                                    </a>
                                @elseif(Auth::user()->isCustomer())
                                    <a href="{{ route('customer.dashboard') }}" 
                                       class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-rose-50 hover:text-rose-600 transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        My Dashboard
                                    </a>
                                @endif

                                <a href="{{ url('/user/profile') }}" 
                                   class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-rose-50 hover:text-rose-600 transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Profile
                                </a>

                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-200 text-left">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" 
                           class="text-base font-semibold text-gray-600 hover:text-rose-600 transition-colors duration-200 px-4 py-2 rounded-lg hover:bg-rose-50">
                            Login
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button x-data x-on:click="$refs.mobileMenu.classList.toggle('hidden')" 
                            class="text-gray-600 hover:text-gray-900 focus:outline-none focus:text-gray-900 transition-colors duration-200 p-2 rounded-lg hover:bg-gray-100">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
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
                    
                    <!-- Mobile Search -->
                    <div class="px-4 py-3">
                        @livewire('global-search')
                    </div>
                    
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

    <!-- Hero Section -->
    <div class="relative min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8 py-20">
        <!-- Background Pattern -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-rose-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-amber-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse animation-delay-2000"></div>
        </div>
        
        <div class="relative text-center max-w-5xl mx-auto">
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-gray-900 mb-8 font-serif leading-tight">
                Welcome to
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-rose-600 to-rose-500 block">
                    Luxe Hair Studio
                </span>
            </h1>
            
            <p class="text-lg md:text-xl lg:text-2xl text-gray-600 mb-12 max-w-4xl mx-auto leading-relaxed">
                Transform your look with our expert stylists in an elegant, luxurious environment. 
                <span class="text-rose-600 font-semibold">Where beauty meets artistry</span>, and every visit is a pampering experience.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 lg:gap-8 justify-center items-center">
                <a href="{{ route('book-service') }}" 
                   class="group bg-gradient-to-r from-rose-500 to-pink-600 hover:from-rose-600 hover:to-pink-700 text-white px-10 py-5 rounded-2xl text-lg font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-2 flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Book Appointment</span>
                </a>
                
                <a href="{{ route('services') }}" 
                   class="group bg-white hover:bg-gray-50 text-gray-700 px-10 py-5 rounded-2xl text-lg font-semibold border-2 border-gray-200 hover:border-rose-300 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-2 flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>Our Services</span>
                </a>
            </div>

            <!-- Featured Services Preview -->
            <div class="mt-20 max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 font-serif">Our Featured Services</h2>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed">
                        Experience luxury and expertise with our premium salon services designed to enhance your natural beauty
                    </p>
                </div>
                
                <!-- Dynamic Service Preview -->
                @livewire('home-page')
            </div>
        </div>
    </div>

    <!-- Why Choose Luxe Hair Studio Section -->
    <div class="py-24 bg-gradient-to-br from-gray-50 to-rose-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6 font-serif">Why Choose Luxe Hair Studio?</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed">Experience the difference of personalized luxury beauty services in our elegant, welcoming environment.</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                <div class="bg-white p-8 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 h-full flex flex-col text-center group">
                    <div class="w-20 h-20 bg-gradient-to-r from-rose-500 to-pink-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:shadow-xl transition-shadow duration-300">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Expert Stylists</h3>
                    <p class="text-base text-gray-600 leading-relaxed flex-grow">Our professionally trained team brings years of experience and ongoing education to every service.</p>
                </div>
                
                <div class="bg-white p-8 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 h-full flex flex-col text-center group">
                    <div class="w-20 h-20 bg-gradient-to-r from-rose-500 to-pink-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:shadow-xl transition-shadow duration-300">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Premium Products</h3>
                    <p class="text-base text-gray-600 leading-relaxed flex-grow">We use only the finest professional-grade products to ensure exceptional results and hair health.</p>
                </div>
                
                <div class="bg-white p-8 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 h-full flex flex-col text-center group">
                    <div class="w-20 h-20 bg-gradient-to-r from-rose-500 to-pink-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:shadow-xl transition-shadow duration-300">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Personalized Care</h3>
                    <p class="text-base text-gray-600 leading-relaxed flex-grow">Every service is customized to your unique style, preferences, and hair type for perfect results.</p>
                </div>
                
                <div class="bg-white p-8 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 h-full flex flex-col text-center group">
                    <div class="w-20 h-20 bg-gradient-to-r from-rose-500 to-pink-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:shadow-xl transition-shadow duration-300">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Luxurious Environment</h3>
                    <p class="text-base text-gray-600 leading-relaxed flex-grow">Relax and unwind in our beautifully designed salon with a peaceful, upscale atmosphere.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action Section -->
    <div class="py-24 bg-gradient-to-r from-rose-500 to-pink-600 relative overflow-hidden">
        <!-- Background decoration -->
        <div class="absolute inset-0 bg-black opacity-10"></div>
        
        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-8 md:p-12 shadow-2xl border border-white/20">
                <div class="text-center">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6 font-serif">Ready for Your Transformation?</h2>
                    <p class="text-lg md:text-xl text-rose-100 mb-10 max-w-3xl mx-auto leading-relaxed">
                        Book your appointment today and discover why our clients trust us with their most important beauty moments.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 lg:gap-6 justify-center items-center">
                        <a href="{{ route('book-service') }}" 
                           class="bg-white text-rose-600 px-8 py-4 rounded-2xl text-lg font-semibold hover:bg-gray-100 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 inline-flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Book Your Appointment</span>
                        </a>
                        <a href="{{ route('contact') }}" 
                           class="border-2 border-white text-white px-8 py-4 rounded-2xl text-lg font-semibold hover:bg-white hover:text-rose-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 inline-flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>Contact Us</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                    <p class="text-gray-200 leading-relaxed mb-6 max-w-md">
                        Sri Lanka's premier destination for luxury hair care and beauty services. Where elegance meets expertise, and every visit transforms your look and confidence.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center hover:bg-rose-600 transition-colors duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center hover:bg-rose-600 transition-colors duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center hover:bg-rose-600 transition-colors duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.083.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.001z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-rose-400-lg-semibold mb-6">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('book-service') }}" class="text-gray-200 hover:text-rose-400 transition-colors duration-200">Book Appointment</a></li>
                        <li><a href="{{ route('services') }}" class="text-gray-200 hover:text-rose-400 transition-colors duration-200">Our Services</a></li>
                        <li><a href="{{ route('admin.dashboard') }}" class="text-gray-200 hover:text-rose-400 transition-colors duration-200">Admin Portal</a></li>
                        <li><a href="{{ route('admin.services') }}" class="text-gray-200 hover:text-rose-400 transition-colors duration-200">Manage Services</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-200 hover:text-rose-400 transition-colors duration-200">Contact Us</a></li>
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
                                <p class="text-gray-200">123 Main Street</p>
                                <p class="text-gray-200">Kandy, Sri Lanka</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-rose-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <p class="text-gray-200">+94 71 234 5678</p>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-rose-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-gray-200">info@luxehairstudio.lk</p>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-rose-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-gray-200">Mon - Sat: 9:00 AM - 7:00 PM</p>
                                <p class="text-gray-200">Sunday: 10:00 AM - 5:00 PM</p>
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
    
    <!-- Alpine.js for mobile menu -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireScripts
    
    <style>
        .animation-delay-2000 {
            animation-delay: 2s;
        }
    </style>
</body>
</html>