@extends('layouts.guest')

@section('title', 'Server Error')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-red-50 to-orange-50 py-12">
    <div class="max-w-md w-full space-y-8 text-center">
        <div class="animate-pulse">
            <div class="w-32 h-32 mx-auto mb-8 bg-gradient-to-br from-red-100 to-orange-100 rounded-full flex items-center justify-center">
                <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
        </div>
        
        <div class="space-y-4">
            <h1 class="text-4xl font-bold text-gray-900 font-serif">Something Went Wrong</h1>
            <p class="text-lg text-gray-600">
                We're experiencing some technical difficulties. Our team has been notified and is working on a fix.
            </p>
            <p class="text-gray-500">
                Please try again in a few moments, or contact us if the problem persists.
            </p>
        </div>
        
        <div class="space-y-4">
            <button onclick="window.location.reload()" 
                    class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-red-500 to-orange-600 text-white rounded-2xl font-semibold hover:from-red-600 hover:to-orange-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Try Again
            </button>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}" 
                   class="px-6 py-3 border-2 border-red-500 text-red-600 rounded-xl font-medium hover:bg-red-50 transition-all duration-200">
                    Return Home
                </a>
                <a href="{{ route('contact') }}" 
                   class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-all duration-200">
                    Contact Support
                </a>
            </div>
        </div>
        
        <div class="mt-12">
            <p class="text-sm text-gray-500">
                Error Code: 500 • Server Error
            </p>
        </div>
    </div>
</div>
@endsection