<div class="min-h-screen bg-gradient-to-br from-rose-50 via-white to-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-center">
                <div class="flex items-center space-x-4">
                    <!-- Step 1 -->
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-semibold
                            {{ $currentStep >= 1 ? 'bg-rose-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                            1
                        </div>
                        <span class="ml-2 text-sm font-medium {{ $currentStep >= 1 ? 'text-rose-600' : 'text-gray-500' }}">Service</span>
                    </div>
                    
                    <div class="w-8 h-1 {{ $currentStep >= 2 ? 'bg-rose-600' : 'bg-gray-200' }} rounded-full"></div>
                    
                    <!-- Step 2 -->
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-semibold
                            {{ $currentStep >= 2 ? 'bg-rose-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                            2
                        </div>
                        <span class="ml-2 text-sm font-medium {{ $currentStep >= 2 ? 'text-rose-600' : 'text-gray-500' }}">Date</span>
                    </div>
                    
                    <div class="w-8 h-1 {{ $currentStep >= 3 ? 'bg-rose-600' : 'bg-gray-200' }} rounded-full"></div>
                    
                    <!-- Step 3 -->
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-semibold
                            {{ $currentStep >= 3 ? 'bg-rose-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                            3
                        </div>
                        <span class="ml-2 text-sm font-medium {{ $currentStep >= 3 ? 'text-rose-600' : 'text-gray-500' }}">Details</span>
                    </div>
                    
                    <div class="w-8 h-1 {{ $currentStep >= 4 ? 'bg-rose-600' : 'bg-gray-200' }} rounded-full"></div>
                    
                    <!-- Step 4 -->
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-semibold
                            {{ $currentStep >= 4 ? 'bg-rose-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                            4
                        </div>
                        <span class="ml-2 text-sm font-medium {{ $currentStep >= 4 ? 'text-rose-600' : 'text-gray-500' }}">Confirm</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages -->
        @if($message)
            <div class="mb-6 p-4 rounded-lg {{ $messageType === 'success' ? 'bg-green-50 border border-green-200 text-green-700' : ($messageType === 'error' ? 'bg-red-50 border border-red-200 text-red-700' : 'bg-blue-50 border border-blue-200 text-blue-700') }}">
                {{ $message }}
            </div>
        @endif

        <!-- Main Form -->
        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8">
            
            <!-- Step 1: Service Selection -->
            @if($currentStep == 1)
            <div>
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-3">Choose Your Service</h2>
                    <p class="text-lg text-gray-600">Select the service you'd like to book</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($services as $service)
                    <div class="service-card cursor-pointer p-6 border-2 rounded-xl transition-all duration-300 hover:shadow-lg {{ $selectedServiceId == ($service['_id'] ?? '') ? 'border-rose-500 bg-rose-50' : 'border-gray-200 hover:border-rose-300' }}"
                         wire:click="selectService('{{ $service['_id'] ?? '' }}')">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-rose-500 to-pink-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8m-5-10v20a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2h-6a2 2 0 00-2 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $service['name'] ?? 'Unnamed Service' }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ $service['description'] ?? 'No description available' }}</p>
                            <div class="flex items-center justify-center space-x-4 text-sm">
                                <span class="font-semibold text-rose-600">LKR {{ number_format($service['base_price'] ?? 0) }}</span>
                                <span class="text-gray-500">{{ $service['durations'][0]['minutes'] ?? 60 }} mins</span>
                            </div>
                            @if($selectedServiceId == ($service['_id'] ?? ''))
                                <div class="mt-3">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-rose-100 text-rose-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Selected
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Services Available</h3>
                        <p class="text-gray-500">Please check back later for available services.</p>
                    </div>
                    @endforelse
                </div>
            </div>
            @endif

            <!-- Step 2: Date Selection -->
            @if($currentStep == 2)
            <div>
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-3">Select Your Preferred Date</h2>
                    <p class="text-lg text-gray-600">Choose when you'd like to book your appointment</p>
                </div>

                <div class="max-w-md mx-auto">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Appointment Date
                        </label>
                        <input type="date" 
                               wire:model.live="bookingDate"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-colors duration-200 text-lg"
                               min="{{ date('Y-m-d') }}">
                        @error('bookingDate')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    @if($bookingDate)
                    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-lg">
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

                <div class="flex justify-between mt-8">
                    <button wire:click="previousStep" 
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300">
                        Previous
                    </button>
                    
                    @if($bookingDate)
                    <button wire:click="nextStep" 
                            class="bg-gradient-to-r from-rose-500 to-pink-600 hover:from-rose-600 hover:to-pink-700 text-white px-8 py-3 rounded-xl text-lg font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        Continue to Details
                    </button>
                    @else
                    <button disabled 
                            class="bg-gray-300 text-gray-500 px-8 py-3 rounded-xl text-lg font-semibold cursor-not-allowed">
                        Select Date to Continue
                    </button>
                    @endif
                </div>
            </div>
            @endif

            <!-- Step 3: Customer Details -->
            @if($currentStep == 3)
            <div>
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-3">Your Details</h2>
                    <p class="text-lg text-gray-600">Please provide your contact information</p>
                </div>

                <div class="max-w-2xl mx-auto space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                            <input type="text" 
                                   wire:model.live="firstName"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-colors duration-200"
                                   placeholder="Enter your first name">
                            @error('firstName')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                            <input type="text" 
                                   wire:model.live="lastName"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-colors duration-200"
                                   placeholder="Enter your last name">
                            @error('lastName')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" 
                               wire:model.live="email"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-colors duration-200"
                               placeholder="Enter your email address">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" 
                               wire:model.live="phone"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-colors duration-200"
                               placeholder="Enter your phone number">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Special Requests (Optional)</label>
                        <textarea wire:model.live="specialRequests"
                                  rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-colors duration-200"
                                  placeholder="Any special requests or additional information..."></textarea>
                    </div>
                </div>

                <div class="flex justify-between mt-8">
                    <button wire:click="previousStep" 
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300">
                        Previous
                    </button>
                    
                    <button wire:click="nextStep" 
                            class="bg-gradient-to-r from-rose-500 to-pink-600 hover:from-rose-600 hover:to-pink-700 text-white px-8 py-3 rounded-xl text-lg font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        Review Booking
                    </button>
                </div>
            </div>
            @endif

            <!-- Step 4: Confirmation -->
            @if($currentStep == 4)
            <div>
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-3">Confirm Your Booking</h2>
                    <p class="text-lg text-gray-600">Please review your appointment details</p>
                </div>

                <div class="max-w-2xl mx-auto">
                    <div class="bg-gradient-to-r from-rose-50 to-pink-50 border border-rose-200 rounded-xl p-6 mb-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6 text-center">Booking Summary</h3>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-3 border-b border-rose-200">
                                <span class="text-gray-600 font-medium">Service:</span>
                                <span class="text-gray-900 font-semibold">{{ $selectedService['name'] ?? 'N/A' }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-3 border-b border-rose-200">
                                <span class="text-gray-600 font-medium">Date:</span>
                                <span class="text-gray-900 font-semibold">
                                    {{ $bookingDate ? \Carbon\Carbon::parse($bookingDate)->format('l, F j, Y') : 'N/A' }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-center py-3 border-b border-rose-200">
                                <span class="text-gray-600 font-medium">Time:</span>
                                <span class="text-gray-900 font-semibold">9:00 AM (Default)</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-3 border-b border-rose-200">
                                <span class="text-gray-600 font-medium">Duration:</span>
                                <span class="text-gray-900 font-semibold">{{ $estimatedDuration }} minutes</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-3 border-b border-rose-200">
                                <span class="text-gray-600 font-medium">Price:</span>
                                <span class="text-gray-900 font-semibold text-lg">LKR {{ number_format($totalPrice) }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-3 border-b border-rose-200">
                                <span class="text-gray-600 font-medium">Customer:</span>
                                <span class="text-gray-900 font-semibold">{{ $firstName }} {{ $lastName }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-3 border-b border-rose-200">
                                <span class="text-gray-600 font-medium">Contact:</span>
                                <div class="text-right">
                                    <div class="text-gray-900 font-semibold">{{ $email }}</div>
                                    <div class="text-gray-600 text-sm">{{ $phone }}</div>
                                </div>
                            </div>
                            
                            @if($specialRequests)
                            <div class="py-3">
                                <span class="text-gray-600 font-medium block mb-2">Special Requests:</span>
                                <p class="text-gray-900 bg-white p-3 rounded-lg border">{{ $specialRequests }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="text-center mb-6">
                        <p class="text-sm text-gray-600">
                            By confirming your booking, you agree to our terms and conditions. 
                            You will receive a confirmation email shortly after booking.
                        </p>
                    </div>
                </div>

                <div class="flex justify-between mt-8">
                    <button wire:click="previousStep" 
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300">
                        Previous
                    </button>
                    
                    <button wire:click="confirmBooking" 
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-50 cursor-not-allowed"
                            class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-8 py-3 rounded-xl text-lg font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center space-x-2">
                        <svg wire:loading.remove class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <div wire:loading class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                        <span>Confirm Booking</span>
                    </button>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>