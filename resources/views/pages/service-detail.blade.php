@extends('layouts.guest')

@section('title', $service->name . ' - Hair Service')
@section('description', Str::limit($service->description, 160))

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Service Header -->
            <div class="mb-12">
                <nav class="flex mb-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('home') }}" class="text-gray-500 hover:text-rose-600 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                </svg>
                                Home
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <a href="{{ route('services') }}" class="ml-1 text-gray-500 hover:text-rose-600 transition-colors md:ml-2">
                                    Services
                                </a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="ml-1 text-gray-700 md:ml-2">{{ $service->name }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-start">
                    <!-- Service Image Gallery -->
                    <div class="space-y-4 animate-slide-in-up">
                        <div class="aspect-square rounded-2xl overflow-hidden shadow-lg image-container">
                            @if($service->image)
                                <img src="{{ asset($service->image) }}" alt="{{ $service->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-rose-100 to-pink-100 flex items-center justify-center">
                                    <svg class="w-24 h-24 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8M7 7h10a2 2 0 012 2v8a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Additional Images Placeholder -->
                        <div class="grid grid-cols-3 gap-4">
                            @for($i = 1; $i <= 3; $i++)
                                <div class="aspect-square rounded-xl bg-gray-100 flex items-center justify-center opacity-50 hover:opacity-75 transition-opacity duration-200 cursor-pointer">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Service Details -->
                    <div class="animate-fade-in-scale">
                        @if($service->category)
                            <span class="inline-block px-3 py-1 text-sm font-medium rounded-full bg-gradient-to-r from-rose-100 to-pink-100 text-rose-800 mb-4">
                                {{ $service->category }}
                            </span>
                        @endif
                        
                        <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $service->name }}</h1>
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed">{{ $service->description }}</p>
                        
                        <!-- Service Features -->
                        <div class="grid sm:grid-cols-2 gap-6 mb-8">
                            <div class="bg-white rounded-xl p-6 border border-rose-100 shadow-sm">
                                <div class="flex items-center mb-3">
                                    <div class="w-8 h-8 bg-rose-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-gray-900">Starting Price</h3>
                                </div>
                                <p class="text-2xl font-bold text-rose-600">Rs.{{ number_format((float)$service->base_price, 0) }}</p>
                                <p class="text-sm text-gray-500 mt-1">Final price may vary based on hair length and condition</p>
                            </div>
                            
                            <div class="bg-white rounded-xl p-6 border border-rose-100 shadow-sm">
                                <div class="flex items-center mb-3">
                                    <div class="w-8 h-8 bg-rose-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-gray-900">Duration</h3>
                                </div>
                                @if(is_array($service->durations) && count($service->durations) > 0)
                                    @php
                                        $duration = $service->durations[0];
                                        $minutes = isset($duration['minutes']) ? $duration['minutes'] : 60;
                                        $hours = floor($minutes / 60);
                                        $remainingMins = $minutes % 60;
                                    @endphp
                                    <p class="text-2xl font-bold text-gray-900">
                                        @if($hours > 0)
                                            {{ $hours }}h {{ $remainingMins > 0 ? $remainingMins.'m' : '' }}
                                        @else
                                            {{ $minutes }}m
                                        @endif
                                    </p>
                                @else
                                    <p class="text-2xl font-bold text-gray-900">1h</p>
                                @endif
                                <p class="text-sm text-gray-500 mt-1">Approximate time for this service</p>
                            </div>
                        </div>

                        <!-- Pricing Calculator -->
                        <div class="bg-gradient-to-r from-rose-50 to-pink-50 rounded-xl p-6 mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pricing Calculator</h3>
                            
                            @if(isset($service->pricing_tiers) && is_array($service->pricing_tiers))
                                <div class="space-y-3">
                                    @foreach($service->pricing_tiers as $tier)
                                        <div class="flex justify-between items-center py-2 border-b border-rose-100 last:border-b-0">
                                            <span class="text-gray-700">{{ $tier['name'] ?? 'Standard' }}</span>
                                            <span class="font-semibold text-rose-600">Rs.{{ number_format((float)($tier['price'] ?? $service->base_price), 0) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center py-2 border-b border-rose-100">
                                        <span class="text-gray-700">Short Hair (Shoulder length or shorter)</span>
                                        <span class="font-semibold text-rose-600">Rs.{{ number_format((float)$service->base_price, 0) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-rose-100">
                                        <span class="text-gray-700">Medium Hair (Shoulder to chest)</span>
                                        <span class="font-semibold text-rose-600">Rs.{{ number_format((float)$service->base_price * 1.25, 0) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-gray-700">Long Hair (Chest length or longer)</span>
                                        <span class="font-semibold text-rose-600">Rs.{{ number_format((float)$service->base_price * 1.5, 0) }}</span>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="mt-4 p-3 bg-white rounded-lg border border-rose-200">
                                <p class="text-sm text-gray-600">
                                    <strong>Note:</strong> Final pricing will be confirmed during consultation based on your specific hair type, condition, and desired results.
                                </p>
                            </div>
                        </div>

                        <!-- Book Now Section -->
                        <div class="space-y-4">
                            <a href="{{ route('book-service') }}?service={{ $service->_id }}" 
                               class="w-full flex items-center justify-center px-8 py-4 bg-gradient-to-r from-rose-500 to-pink-600 text-white text-lg font-semibold rounded-2xl hover:from-rose-600 hover:to-pink-700 transition-all duration-200 hover:scale-105 shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Book This Service
                            </a>
                            
                            <div class="flex gap-4">
                                <a href="{{ route('contact') }}" 
                                   class="flex-1 flex items-center justify-center px-6 py-3 border-2 border-rose-500 text-rose-600 rounded-xl font-medium hover:bg-rose-50 transition-all duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Ask Questions
                                </a>
                                
                                <button onclick="shareService()" 
                                        class="flex-1 flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-600 rounded-xl font-medium hover:bg-gray-200 transition-all duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
                                    </svg>
                                    Share
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service Details & What to Expect -->
            <div class="grid lg:grid-cols-3 gap-8 mb-12">
                <!-- What's Included -->
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-rose-100">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">What's Included</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-rose-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-700">Professional consultation</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-rose-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-700">Premium hair products</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-rose-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-700">Hair wash & conditioning</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-rose-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-700">Professional styling</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-rose-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-700">Aftercare instructions</span>
                        </li>
                    </ul>
                </div>

                <!-- What to Expect -->
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-rose-100">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">What to Expect</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-6 h-6 bg-rose-100 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                <span class="text-xs font-bold text-rose-600">1</span>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Consultation</h4>
                                <p class="text-sm text-gray-600">Discuss your desired look and hair goals</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-6 h-6 bg-rose-100 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                <span class="text-xs font-bold text-rose-600">2</span>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Preparation</h4>
                                <p class="text-sm text-gray-600">Hair analysis and product selection</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-6 h-6 bg-rose-100 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                <span class="text-xs font-bold text-rose-600">3</span>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Service</h4>
                                <p class="text-sm text-gray-600">Professional treatment application</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-6 h-6 bg-rose-100 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                <span class="text-xs font-bold text-rose-600">4</span>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Styling</h4>
                                <p class="text-sm text-gray-600">Final styling and finishing touches</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reviews Summary -->
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-rose-100">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Customer Reviews</h3>
                    
                    <!-- Average Rating -->
                    <div class="text-center mb-6">
                        <div class="text-3xl font-bold text-gray-900">4.8</div>
                        <div class="flex justify-center items-center mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <p class="text-sm text-gray-600">Based on 127 reviews</p>
                    </div>
                    
                    <!-- Recent Reviews -->
                    <div class="space-y-4">
                        <div class="border-b border-gray-100 pb-4 last:border-b-0 last:pb-0">
                            <div class="flex items-center mb-2">
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-sm font-medium text-gray-900 ml-2">Sarah M.</span>
                            </div>
                            <p class="text-sm text-gray-600">"Absolutely amazing results! The team really knows what they're doing."</p>
                        </div>
                        
                        <div class="border-b border-gray-100 pb-4 last:border-b-0 last:pb-0">
                            <div class="flex items-center mb-2">
                                <div class="flex">
                                    @for($i = 1; $i <= 4; $i++)
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-sm font-medium text-gray-900 ml-2">Jessica L.</span>
                            </div>
                            <p class="text-sm text-gray-600">"Professional service and beautiful salon atmosphere."</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Services -->
            @if($relatedServices->count() > 0)
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8">Related Services</h2>
                    <div class="grid md:grid-cols-3 gap-6">
                        @foreach($relatedServices as $relatedService)
                            <a href="{{ route('service.show', $relatedService) }}" 
                               class="group bg-white rounded-xl shadow-lg border border-rose-100 overflow-hidden hover:shadow-xl transition-all duration-300 hover:scale-105">
                                @if($relatedService->image)
                                    <div class="h-48 overflow-hidden">
                                        <img src="{{ asset($relatedService->image) }}" alt="{{ $relatedService->name }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    </div>
                                @else
                                    <div class="h-48 bg-gradient-to-br from-rose-100 to-pink-100 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8M7 7h10a2 2 0 012 2v8a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2z"/>
                                        </svg>
                                    </div>
                                @endif
                                
                                <div class="p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-rose-600 transition-colors">
                                        {{ $relatedService->name }}
                                    </h3>
                                    <p class="text-gray-600 text-sm mb-3">{{ Str::limit($relatedService->description, 80) }}</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-bold text-rose-600">Rs.{{ number_format((float)$relatedService->base_price, 0) }}</span>
                                        <span class="text-sm text-gray-500">
                                            @if(is_array($relatedService->durations) && count($relatedService->durations) > 0)
                                                {{ $relatedService->durations[0]['minutes'] ?? '60' }}min
                                            @else
                                                60min
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- FAQ Section -->
            <div class="bg-white rounded-2xl p-8 shadow-lg border border-rose-100">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Frequently Asked Questions</h2>
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">How should I prepare for my appointment?</h3>
                        <p class="text-gray-600">Come with clean, dry hair unless otherwise specified. Bring photos of styles you like and be ready to discuss your hair goals during the consultation.</p>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Can I reschedule my appointment?</h3>
                        <p class="text-gray-600">Yes, we offer flexible rescheduling. Please give us at least 24 hours notice to avoid any cancellation fees.</p>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">What products do you use?</h3>
                        <p class="text-gray-600">We use only premium, professional-grade hair products from trusted brands. All products are selected based on your specific hair type and condition.</p>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Do you offer aftercare advice?</h3>
                        <p class="text-gray-600">Absolutely! We provide detailed aftercare instructions and product recommendations to help maintain your new look at home.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Share Function -->
    <script>
        function shareService() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $service->name }} - Luxe Hair Studio',
                    text: '{{ Str::limit($service->description, 100) }}',
                    url: window.location.href
                });
            } else {
                // Fallback - copy to clipboard
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('Link copied to clipboard!');
                });
            }
        }
    </script>
@endsection