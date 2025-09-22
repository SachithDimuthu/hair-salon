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
    <body class="font-sans antialiased bg-neutral-50">
        <x-banner />

        <div class="min-h-screen">
            <!-- Enhanced Navigation -->
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow-sm border-b border-neutral-200">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="min-h-screen bg-neutral-50">
                {{ $slot }}
            </main>
        </div>

        <!-- Modals -->
        @stack('modals')

        <!-- Scripts -->
        @livewireScripts
        
        <!-- Additional Scripts -->
        @stack('scripts')

        <!-- Toast Notifications -->
        <script>
            // Listen for Livewire events and show toast notifications
            document.addEventListener('livewire:init', () => {
                Livewire.on('notify', (event) => {
                    const { type, message, title } = event;
                    showToast(type, message, title);
                });
            });

            function showToast(type, message, title = null) {
                const toast = document.createElement('div');
                toast.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transform transition-all duration-300 ${getToastClasses(type)}`;
                
                const content = `
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            ${getToastIcon(type)}
                        </div>
                        <div class="ml-3">
                            ${title ? `<p class="text-sm font-medium">${title}</p>` : ''}
                            <p class="text-sm ${title ? 'mt-1' : ''}">${message}</p>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-gray-400 hover:text-gray-600">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                `;
                
                toast.innerHTML = content;
                document.body.appendChild(toast);

                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.remove();
                    }
                }, 5000);
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
        </script>
    </body>
</html>
