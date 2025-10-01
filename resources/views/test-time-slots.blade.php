<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Time Slot Test - No Cache</title>
    
    <!-- Tailwind CSS - Direct from CDN to bypass cache -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body class="bg-gray-100">
    <div class="min-h-screen py-12">
        <div class="max-w-4xl mx-auto px-4">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-8">Time Slot Selection Test (Cache-Free)</h1>
                
                <!-- Book Service Component - Isolated -->
                @livewire('book-service')
                
                <!-- Extra Debug Info -->
                <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded">
                    <h3 class="font-bold text-blue-800">Cache Test Info:</h3>
                    <p class="text-blue-700 text-sm mt-2">
                        This page bypasses all cached assets and uses direct CDN resources.<br>
                        Current time: {{ now()->format('Y-m-d H:i:s') }}<br>
                        If you still see console errors, the issue is deeper than cache.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Livewire Scripts -->
    @livewireScripts
    
    <!-- Simple Alpine.js from CDN - No conflicts -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        console.log('Cache-free test page loaded at:', new Date().toISOString());
        console.log('Livewire available:', typeof window.Livewire !== 'undefined');
        console.log('Alpine available:', typeof window.Alpine !== 'undefined');
    </script>
</body>
</html>