@extends('layouts.guest')

@section('title', 'Our Services')
@section('description', 'Discover our range of professional hair services including cuts, colors, treatments, and special occasion styling.')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent mb-4">
                    Our Services
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-8">
                    Experience luxury hair care with our comprehensive range of professional services, 
                    tailored to enhance your natural beauty and style.
                </p>
                
                <!-- Search Bar -->
                <div class="max-w-md mx-auto">
                    @livewire('global-search')
                </div>
            </div>

            <!-- Services Grid -->
            @if($services->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                    @foreach($services as $service)
                        <a href="{{ route('service.show', $service) }}" 
                           class="group bg-white rounded-2xl shadow-lg p-8 border border-rose-100/50 hover:shadow-xl transition-all duration-300 hover:scale-105 block">
                            @if($service->ServicePhoto)
                                <div class="w-full h-48 mb-6 rounded-xl overflow-hidden">
                                    <img src="{{ asset($service->ServicePhoto) }}" alt="{{ $service->ServiceName }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                </div>
                            @else
                                <div class="w-16 h-16 bg-gradient-to-br from-rose-500 to-pink-600 rounded-2xl flex items-center justify-center mb-6">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8M7 7h10a2 2 0 012 2v8a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2z"/>
                                    </svg>
                                </div>
                            @endif
                            
                            <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-rose-600 transition-colors">{{ $service->ServiceName }}</h3>
                            <p class="text-gray-600 mb-4">{{ Str::limit($service->Description, 120) }}</p>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 font-medium">Price:</span>
                                    <span class="text-lg font-bold text-rose-600">Rs.{{ number_format((float)$service->Price, 0) }}</span>
                                </div>
                                
                                <div class="pt-2">
                                    <span class="text-sm text-rose-600 font-medium group-hover:text-rose-700">
                                        View Details →
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <!-- No Services Available -->
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Services Available</h3>
                    <p class="text-gray-600 mb-6">Our services will be available soon. Please check back later.</p>
                    <a href="{{ route('contact') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-rose-500 to-pink-600 text-white rounded-xl font-medium hover:from-rose-600 hover:to-pink-700 transition-all duration-200">
                        Contact Us for Information
                    </a>
                </div>
            @endif

            <!-- CTA Section -->
            <div class="text-center bg-gradient-to-r from-rose-50 to-pink-50 rounded-2xl p-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Ready to Transform Your Look?</h2>
                <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                    Book your appointment today and experience the luxury and expertise that makes Luxe Hair Studio special.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('book-service') }}" 
                       class="px-8 py-4 bg-gradient-to-r from-rose-500 to-pink-600 text-white rounded-2xl font-semibold hover:from-rose-600 hover:to-pink-700 transition-all duration-200 hover:scale-105 shadow-lg">
                        Book Appointment
                    </a>
                    <a href="{{ route('contact') }}" 
                       class="px-8 py-4 border-2 border-rose-500 text-rose-600 rounded-2xl font-semibold hover:bg-rose-50 transition-all duration-200">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection