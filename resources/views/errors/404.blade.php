@extends('layouts.guest')

@section('title', 'Page Not Found')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-rose-50 to-pink-50 py-12">
    <div class="max-w-md w-full space-y-8 text-center">
        <div class="animate-bounce">
            <div class="w-32 h-32 mx-auto mb-8 bg-gradient-to-br from-rose-100 to-pink-100 rounded-full flex items-center justify-center">
                <svg class="w-16 h-16 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        
        <div class="space-y-4">
            <h1 class="text-4xl font-bold text-gray-900 font-serif">Oops! Page Not Found</h1>
            <p class="text-lg text-gray-600">
                The page you're looking for seems to have vanished like a perfect hairstyle in the rain.
            </p>
            <p class="text-gray-500">
                Don't worry, we'll help you get back on track to your perfect look!
            </p>
        </div>
        
        <div class="space-y-4">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-rose-500 to-pink-600 text-white rounded-2xl font-semibold hover:from-rose-600 hover:to-pink-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Back to Home
            </a>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('services') }}" 
                   class="px-6 py-3 border-2 border-rose-500 text-rose-600 rounded-xl font-medium hover:bg-rose-50 transition-all duration-200">
                    View Our Services
                </a>
                <a href="{{ route('contact') }}" 
                   class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-all duration-200">
                    Contact Us
                </a>
            </div>
        </div>
        
        <div class="mt-12">
            <p class="text-sm text-gray-500">
                Error Code: 404 • 
                <a href="javascript:history.back()" class="text-rose-600 hover:text-rose-700 underline">
                    Go Back
                </a>
            </p>
        </div>
    </div>
</div>
@endsection