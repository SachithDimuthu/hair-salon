<div class="min-h-screen bg-gradient-to-br from-rose-50 via-white to-gray-50">
    <!-- Loading Overlay -->
    <div wire:loading.delay class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 shadow-2xl flex items-center space-x-4">
            <div class="relative">
                <div class="w-8 h-8 rounded-full border-4 border-gray-200"></div>
                <div class="w-8 h-8 rounded-full border-4 border-rose-500 border-t-transparent animate-spin absolute top-0 left-0"></div>
            </div>
            <span class="text-gray-700 font-medium">Processing your booking...</span>
        </div>
    </div>

    @if($isConfirmed)
        <!-- Success Page -->
        <div class="min-h-screen flex items-center justify-center py-8">
            <div class="max-w-md w-full mx-auto px-4">
                <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Booking Confirmed!</h2>
                    <p class="text-gray-600 mb-6">Your appointment has been successfully booked. We'll send you a confirmation email shortly.</p>
                    <button wire:click="startNewBooking" 
                            class="w-full bg-gradient-to-r from-rose-500 to-pink-600 hover:from-rose-600 hover:to-pink-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300">
                        Book Another Service
                    </button>
                </div>
            </div>
        </div>
    @else
        <!-- Main Booking Interface -->
        <div class="py-8">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Book Your Service</h1>
                    <p class="text-lg text-gray-600">Professional salon booking made simple</p>
                </div>

                <!-- Progress Bar -->
                <div class="mb-8">
                    <div class="flex items-center justify-center">
                        <div class="flex items-center space-x-4">
                            @for($i = 1; $i <= $maxSteps; $i++)
                                <div class="flex items-center">
                                    <!-- Step Circle -->
                                    <div class="relative">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-semibold transition-all duration-300
                                            {{ $currentStep >= $i ? 'bg-rose-600 text-white shadow-lg' : 'bg-gray-200 text-gray-600' }}">
                                            @if($currentStep > $i)
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                            @else
                                                {{ $i }}
                                            @endif
                                        </div>
                                        <!-- Step Label -->
                                        <div class="absolute top-12 left-1/2 transform -translate-x-1/2 whitespace-nowrap">
                                            <span class="text-xs font-medium {{ $currentStep >= $i ? 'text-rose-600' : 'text-gray-500' }}">
                                                @if($i == 1) Service
                                                @elseif($i == 2) Date
                                                @elseif($i == 3) Time
                                                @elseif($i == 4) Details
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Connector Line -->
                                    @if($i < $maxSteps)
                                        <div class="w-12 h-1 {{ $currentStep > $i ? 'bg-rose-600' : 'bg-gray-200' }} rounded-full transition-all duration-300"></div>
                                    @endif
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- Messages -->
                @if($message)
                    <div class="mb-6">
                        <div class="p-4 rounded-xl {{ $messageType === 'success' ? 'bg-green-50 border border-green-200 text-green-800' : 'bg-red-50 border border-red-200 text-red-800' }} shadow-sm">
                            <div class="flex items-center">
                                @if($messageType === 'success')
                                    <svg class="w-5 h-5 mr-3 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 mr-3 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                                {{ $message }}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Main Content Card -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    
                    <!-- Step 1: Service Selection -->
                    @if($currentStep == 1)
                        <div class="p-8">
                            <div class="text-center mb-8">
                                <h2 class="text-2xl font-bold text-gray-900 mb-2">Choose Your Service</h2>
                                <p class="text-gray-600">Select the service you'd like to book</p>
                            </div>

                            @if($services && count($services) > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach($services as $service)
                                        <div wire:click="selectService('{{ $service['_id'] }}')" 
                                             class="group cursor-pointer border-2 rounded-xl transition-all duration-300 hover:shadow-lg hover:-translate-y-1 {{ $selectedServiceId == $service['_id'] ? 'border-rose-500 bg-rose-50 shadow-lg' : 'border-gray-200 hover:border-rose-300' }}">
                                            
                                            <!-- Service Image -->
                                            <div class="aspect-w-16 aspect-h-12 overflow-hidden rounded-t-xl">
                                                @if($service['image'])
                                                    <img src="{{ asset($service['image']) }}" alt="{{ $service['name'] }}" 
                                                         class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                                @else
                                                    <div class="w-full h-48 bg-gradient-to-br from-rose-100 to-pink-100 flex items-center justify-center">
                                                        <svg class="w-12 h-12 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8M7 7h10a2 2 0 012 2v8a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2z"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <!-- Service Details -->
                                            <div class="p-6">
                                                <div class="flex justify-between items-start mb-3">
                                                    <h3 class="font-bold text-gray-900 text-lg">{{ $service['name'] }}</h3>
                                                    <span class="text-rose-600 font-bold text-xl">LKR {{ number_format($service['base_price']) }}</span>
                                                </div>
                                                
                                                <p class="text-sm text-gray-600 mb-4 leading-relaxed">{{ Str::limit($service['description'], 100) }}</p>
                                                
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center text-sm text-gray-500">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        {{ $service['durations'][0]['minutes'] ?? 60 }} mins
                                                    </div>
                                                    
                                                    @if($service['category'])
                                                        <span class="px-3 py-1 bg-rose-100 text-rose-700 text-xs font-medium rounded-full">
                                                            {{ $service['category'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                                
                                                <!-- Selection Indicator -->
                                                @if($selectedServiceId == $service['_id'])
                                                    <div class="mt-4 flex items-center justify-center">
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-rose-100 text-rose-800">
                                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                            </svg>
                                                            Selected
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Services Available</h3>
                                    <p class="text-gray-500">Please check back later for available services.</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Step 2: Date Selection -->
                    @if($currentStep == 2)
                        <div class="p-8">
                            <div class="text-center mb-8">
                                <h2 class="text-2xl font-bold text-gray-900 mb-2">Select Your Preferred Date</h2>
                                <p class="text-gray-600">Choose when you'd like to book your appointment</p>
                            </div>

                            <div class="max-w-md mx-auto">
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-3">
                                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Appointment Date
                                    </label>
                                    <input type="date" 
                                           wire:model.live="bookingDate"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-colors duration-200 text-lg"
                                           min="{{ date('Y-m-d') }}">
                                    @error('bookingDate')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                @if($bookingDate)
                                    <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-rose-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="text-rose-800 font-medium">
                                                Date selected: {{ \Carbon\Carbon::parse($bookingDate)->format('l, F j, Y') }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Step 3: Time Selection -->
                    @if($currentStep == 3)
                        <div class="p-8">
                            <div class="text-center mb-8">
                                <h2 class="text-2xl font-bold text-gray-900 mb-2">Choose Your Time</h2>
                                <p class="text-gray-600">Select your preferred appointment time</p>
                            </div>

                            <div class="max-w-3xl mx-auto">
                                <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                                    @foreach($availableTimeSlots as $timeSlot)
                                        <button wire:click="selectTimeSlot('{{ $timeSlot }}')"
                                                class="px-4 py-3 border-2 rounded-xl font-medium transition-all duration-200 {{ $bookingTime == $timeSlot ? 'border-rose-500 bg-rose-50 text-rose-700' : 'border-gray-200 hover:border-rose-300 hover:bg-rose-50' }}">
                                            {{ $timeSlot }}
                                        </button>
                                    @endforeach
                                </div>

                                @if($bookingTime)
                                    <div class="mt-6 p-4 bg-rose-50 border border-rose-200 rounded-xl text-center">
                                        <span class="text-rose-800 font-medium">
                                            Selected time: {{ $bookingTime }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Step 4: Customer Details & Confirmation -->
                    @if($currentStep == 4)
                        <div class="p-8">
                            <div class="text-center mb-8">
                                <h2 class="text-2xl font-bold text-gray-900 mb-2">Your Details & Confirmation</h2>
                                <p class="text-gray-600">Please provide your contact information and review your booking</p>
                            </div>

                            <div class="max-w-4xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <!-- Customer Details Form -->
                                <div class="space-y-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                                            <input type="text" 
                                                   wire:model.live="firstName"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-colors duration-200"
                                                   placeholder="Enter your first name">
                                            @error('firstName')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                                            <input type="text" 
                                                   wire:model.live="lastName"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-colors duration-200"
                                                   placeholder="Enter your last name">
                                            @error('lastName')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                                        <input type="email" 
                                               wire:model.live="email"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-colors duration-200"
                                               placeholder="Enter your email address">
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                                        <input type="tel" 
                                               wire:model.live="phone"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-colors duration-200"
                                               placeholder="Enter your phone number">
                                        @error('phone')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Special Requests (Optional)</label>
                                        <textarea wire:model.live="specialRequests"
                                                  rows="4"
                                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-colors duration-200"
                                                  placeholder="Any special requests or additional information..."></textarea>
                                    </div>
                                </div>

                                <!-- Booking Summary -->
                                <div class="bg-gradient-to-br from-rose-50 to-pink-50 border border-rose-200 rounded-xl p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Booking Summary</h3>
                                    
                                    <div class="space-y-4">
                                        <div class="flex justify-between items-center py-2 border-b border-rose-200">
                                            <span class="text-gray-600">Service:</span>
                                            <span class="font-medium text-gray-900">{{ $selectedService['name'] ?? 'N/A' }}</span>
                                        </div>
                                        
                                        <div class="flex justify-between items-center py-2 border-b border-rose-200">
                                            <span class="text-gray-600">Date:</span>
                                            <span class="font-medium text-gray-900">
                                                {{ $bookingDate ? \Carbon\Carbon::parse($bookingDate)->format('M j, Y') : 'N/A' }}
                                            </span>
                                        </div>
                                        
                                        <div class="flex justify-between items-center py-2 border-b border-rose-200">
                                            <span class="text-gray-600">Time:</span>
                                            <span class="font-medium text-gray-900">{{ $bookingTime ?? 'N/A' }}</span>
                                        </div>
                                        
                                        <div class="flex justify-between items-center py-2 border-b border-rose-200">
                                            <span class="text-gray-600">Duration:</span>
                                            <span class="font-medium text-gray-900">{{ $estimatedDuration }} minutes</span>
                                        </div>
                                        
                                        <div class="flex justify-between items-center py-3 bg-white rounded-lg px-4">
                                            <span class="text-lg font-semibold text-gray-900">Total Price:</span>
                                            <span class="text-xl font-bold text-rose-600">LKR {{ number_format($totalPrice) }}</span>
                                        </div>
                                    </div>

                                    <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                        <p class="text-sm text-blue-800">
                                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                            </svg>
                                            By confirming your booking, you agree to our terms and conditions. You will receive a confirmation email after booking.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Navigation Buttons -->
                    <div class="px-8 py-6 bg-gray-50 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <!-- Previous Button -->
                            @if($currentStep > 1)
                                <button wire:click="previousStep" 
                                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    <span>Previous</span>
                                </button>
                            @else
                                <div></div>
                            @endif

                            <!-- Next/Confirm Button -->
                            @if($currentStep < $maxSteps)
                                <button wire:click="nextStep" 
                                        class="bg-gradient-to-r from-rose-500 to-pink-600 hover:from-rose-600 hover:to-pink-700 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl flex items-center space-x-2">
                                    <span>Continue</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </button>
                            @else
                                <!-- Main Confirm Button -->
                                    <button wire:click="confirmBooking" 
                                            wire:loading.attr="disabled"
                                            wire:loading.class="opacity-50 cursor-not-allowed"
                                            type="button"
                                            class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-10 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center space-x-3 min-w-[220px]">
                                        <svg wire:loading.remove class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <div wire:loading class="w-6 h-6 border-2 border-white border-t-transparent rounded-full animate-spin flex-shrink-0"></div>
                                        <span class="whitespace-nowrap font-bold">✅ Confirm Booking</span>
                                    </button>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif
</div>