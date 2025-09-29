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
    <!-- Enhanced Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-rose-500 to-rose-600 rounded-lg flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
                        </svg>
                    </div>
                    <a href="{{ route('home') }}" class="text-xl font-bold text-gray-900 font-serif tracking-tight">
                        Luxe Hair Studio
                    </a>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" 
                       class="text-gray-600 hover:text-rose-600 font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'text-rose-600 border-b-2 border-rose-600 pb-1' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('book-service') }}" 
                       class="text-gray-600 hover:text-rose-600 font-medium transition-colors duration-200 {{ request()->routeIs('book-service') ? 'text-rose-600 border-b-2 border-rose-600 pb-1' : '' }}">
                        Book Service
                    </a>
                    
                    <!-- Admin Section -->
                    <div class="relative group">
                        <button class="text-gray-600 hover:text-rose-600 font-medium transition-colors duration-200 flex items-center space-x-1">
                            <span>Admin</span>
                            <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-all duration-200">
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-rose-600 transition-colors duration-200">Dashboard</a>
                            <a href="{{ route('admin.customers') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-rose-600 transition-colors duration-200">Manage Customers</a>
                            <a href="{{ route('admin.services') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-rose-600 transition-colors duration-200">Manage Services</a>
                            <a href="{{ route('admin.deals') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 hover:text-rose-600 transition-colors duration-200">Manage Deals</a>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button x-data x-on:click="$refs.mobileMenu.classList.toggle('hidden')" 
                            class="text-gray-600 hover:text-gray-900 focus:outline-none focus:text-gray-900 transition-colors duration-200">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Mobile Navigation Menu -->
            <div x-ref="mobileMenu" class="hidden md:hidden border-t border-gray-100 py-4">
                <div class="space-y-1">
                    <a href="{{ route('home') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200">Home</a>
                    <a href="{{ route('book-service') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200">Book Service</a>
                    <div class="border-t border-gray-100 mt-2 pt-2">
                        <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wide">Admin</div>
                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200">Dashboard</a>
                        <a href="{{ route('admin.customers') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200">Manage Customers</a>
                        <a href="{{ route('admin.services') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200">Manage Services</a>
                        <a href="{{ route('admin.deals') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg transition-colors duration-200">Manage Deals</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen bg-gray-50">
        @if($component === 'book-service')
            @livewire('book-service')
        @elseif($component === 'dashboard')
            @livewire('dashboard')
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