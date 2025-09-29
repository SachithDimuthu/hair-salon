<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Header -->
        <div class="text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 font-serif">
                Book a Service
            </h2>
            <p class="text-gray-600 mt-2 text-lg">Choose from our premium salon services and schedule your appointment</p>
        </div>

        <!-- Messages -->
        @if($message)
            <div class="p-4 rounded-2xl {{ $messageType === 'success' ? 'bg-green-50 border border-green-200 text-green-800' : 'bg-red-50 border border-red-200 text-red-800' }} shadow-sm">
                <div class="flex items-center">
                    @if($messageType === 'success')
                        <svg class="w-5 h-5 mr-3 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    @else
                        <svg class="w-5 h-5 mr-3 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    @endif
                    <span class="font-medium">{{ $message }}</span>
                </div>
            </div>
        @endif

        <!-- Main Booking Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-rose-500 to-rose-600 px-6 py-4">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Service Booking Form
                </h3>
            </div>

            <form wire:submit="bookService" class="p-6 space-y-8">
                <!-- Available Services Grid -->
                <div>
                    <label class="block text-lg font-semibold text-gray-900 mb-6 font-serif">
                        Choose Your Service
                    </label>
                    
                    @if($services && count($services) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($services as $service)
                                <div class="relative">
                                    <input type="radio" wire:model="selectedServiceId" value="{{ $service->_id }}" 
                                           id="service-{{ $service->_id }}" class="sr-only peer">
                                    <label for="service-{{ $service->_id }}" 
                                           class="block bg-white border-2 border-gray-200 rounded-2xl cursor-pointer transition-all duration-200 hover:border-rose-300 hover:shadow-lg hover:-translate-y-1 peer-checked:border-rose-500 peer-checked:bg-rose-50 peer-checked:shadow-lg overflow-hidden">
                                        
                                        <!-- Service Image -->
                                        @if($service->image)
                                            <div class="w-full h-48 overflow-hidden">
                                                <img src="{{ asset($service->image) }}" alt="{{ $service->name }}" 
                                                     class="w-full h-full object-cover">
                                            </div>
                                        @else
                                            <div class="w-full h-48 bg-gradient-to-br from-rose-100 to-pink-100 flex items-center justify-center">
                                                <svg class="w-12 h-12 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8M7 7h10a2 2 0 012 2v8a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        
                                        <div class="p-6">
                                            <div class="flex justify-between items-start mb-3">
                                                <h4 class="font-bold text-gray-900 text-lg">{{ $service->name }}</h4>
                                                <span class="text-rose-600 font-bold text-xl">Rs.{{ number_format((float)$service->base_price, 0) }}</span>
                                            </div>
                                            
                                            <p class="text-sm text-gray-600 mb-4 leading-relaxed">{{ Str::limit($service->description, 100) }}</p>
                                            
                                            <div class="space-y-2">
                                                <!-- Service Duration -->
                                                @if(is_array($service->durations) && count($service->durations) > 0 && isset($service->durations[0]['minutes']))
                                                    <div class="flex items-center text-sm text-gray-500">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        {{ $service->durations[0]['minutes'] }} minutes
                                                    </div>
                                                @endif
                                                
                                                <!-- Service Category -->
                                                @if($service->category)
                                                    <div class="flex items-center">
                                                        <span class="inline-block px-3 py-1 bg-rose-100 text-rose-700 text-xs font-medium rounded-full">
                                                            {{ $service->category }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <!-- Selected indicator -->
                                        <div class="absolute top-4 right-4 w-8 h-8 bg-rose-500 rounded-full items-center justify-center hidden peer-checked:flex shadow-lg">
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-300">
                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No Services Available</h3>
                            <p class="text-gray-600">Please check back later or contact us directly to book your service.</p>
                        </div>
                    @endif

                    @error('selectedServiceId')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Booking Date -->
                <div>
                    <label for="bookingDate" class="block text-lg font-semibold text-gray-900 mb-3 font-serif">
                        Preferred Date & Time
                    </label>
                    <div class="relative">
                        <input type="datetime-local" 
                               wire:model="bookingDate" 
                               id="bookingDate" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-colors duration-200 text-gray-900 text-lg"
                               min="{{ date('Y-m-d\TH:i', strtotime('+1 hour')) }}">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('bookingDate')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">Please select a date and time at least 1 hour from now.</p>
                </div>

                <!-- Additional Notes (Optional) -->
                <div>
                    <label for="notes" class="block text-lg font-semibold text-gray-900 mb-3 font-serif">
                        Additional Notes (Optional)
                    </label>
                    <textarea wire:model="notes" 
                              id="notes" 
                              rows="4" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-colors duration-200 text-gray-900 resize-none"
                              placeholder="Any special requests or information we should know about?"></textarea>
                    <p class="mt-2 text-sm text-gray-500">Let us know about any allergies, preferences, or special requirements.</p>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <button type="button" 
                            onclick="window.history.back()"
                            class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all duration-200 transform hover:-translate-y-0.5">
                        Cancel
                    </button>
                    <button type="submit" 
                            wire:loading.attr="disabled"
                            class="group bg-rose-500 hover:bg-rose-600 disabled:opacity-50 disabled:cursor-not-allowed text-white px-8 py-3 rounded-xl font-medium transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 flex items-center space-x-2">
                        <svg wire:loading.remove wire:target="bookService" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <svg wire:loading wire:target="bookService" class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span wire:loading.remove wire:target="bookService">Book Service</span>
                        <span wire:loading wire:target="bookService">Booking...</span>
                    </button>
                </div>
            </form>
        </div>

        
        

    <!-- Service Details -->
            @if($selectedServiceId)
                @php
                    $selectedService = $services->where('_id', $selectedServiceId)->first();
                @endphp
                @if($selectedService)
                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-6 rounded-xl border border-purple-200">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-gray-900">{{ $selectedService->ServiceName }}</h3>
                            <span class="text-2xl font-bold text-purple-600">£{{ number_format($selectedService->Price, 2) }}</span>
                        </div>
                        <p class="text-gray-700 mb-4">{{ $selectedService->Description }}</p>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-gray-600">Duration: {{ $selectedService->Duration ?? 60 }} minutes</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                <span class="text-gray-600">Category: {{ $selectedService->Category ?? 'Service' }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            

    </form>

    <!-- Customer's Current Bookings -->
    @auth('customer')
        <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100">
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-xl p-4 mb-6">
                <h3 class="text-xl font-bold">Your Current Bookings</h3>
            </div>
            @php
                $customerBookings = auth('customer')->user()->services()
                    ->wherePivot('Status', 'booked')
                    ->withPivot(['BookedAt', 'Status'])
                    ->get();
            @endphp
            
            @if($customerBookings->count() > 0)
                <div class="space-y-4">
                    @foreach($customerBookings as $booking)
                        <div class="bg-gradient-to-r from-gray-50 to-purple-50 p-6 rounded-xl border border-purple-100 hover:shadow-md transition-all duration-200">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900 text-lg mb-2">{{ $booking->ServiceName }}</h4>
                                    <div class="flex items-center text-gray-600 mb-2">
                                        <svg class="w-4 h-4 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($booking->pivot->BookedAt)->format('M d, Y g:i A') }}</span>
                                    </div>
                                    <span class="inline-block px-3 py-1 text-sm bg-green-100 text-green-800 rounded-full font-medium">
                                        {{ ucfirst($booking->pivot->Status) }}
                                    </span>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                                        Rs.{{ number_format($booking->Price, 0) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-gray-500 text-lg">You have no current bookings.</p>
                    <p class="text-gray-400 text-sm mt-2">Book your first service above!</p>
                </div>
            @endif
        </div>
    @else
        <div class="bg-gradient-to-r from-blue-50 to-purple-50 p-6 border border-blue-200 rounded-xl">
            <div class="flex items-center">
                <svg class="w-8 h-8 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="text-blue-800 font-semibold">
                        Please <a href="{{ route('login') }}" class="underline hover:text-blue-600 transition-colors">login</a> to book services and view your bookings.
                    </p>
                    <p class="text-blue-600 text-sm mt-1">Create an account to track your appointments and booking history.</p>
                </div>
            </div>
        </div>
    @endauth

    <!-- Service Benefits Section -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center font-serif">Why Choose Luxe Hair Studio?</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-rose-500 to-rose-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-md">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Professional Excellence</h4>
                    <p class="text-gray-600">Expert stylists with years of experience in the latest trends and techniques.</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-md">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Flexible Scheduling</h4>
                    <p class="text-gray-600">Book appointments that fit your busy schedule with our easy online booking system.</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-md">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Premium Experience</h4>
                    <p class="text-gray-600">Enjoy a luxurious atmosphere with high-quality products and personalized service.</p>
                </div>
            </div>
        </div>
    </div>
    
</div>
