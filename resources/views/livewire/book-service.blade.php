<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Header -->
        <div class="text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 font-serif">
                Book Your Service
            </h2>
            <p class="text-gray-600 mt-2 text-lg">Professional salon booking made simple</p>
        </div>

        <!-- Progress Indicator -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                @for($i = 1; $i <= $maxSteps; $i++)
                    <div class="flex items-center {{ $i < $maxSteps ? 'flex-1' : '' }}">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full border-2 transition-all duration-300
                            {{ $currentStep >= $i ? 'bg-rose-500 border-rose-500 text-white' : 'border-gray-300 text-gray-400' }}">
                            @if($currentStep > $i)
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            @else
                                {{ $i }}
                            @endif
                        </div>
                        
                        @if($i < $maxSteps)
                            <div class="flex-1 h-0.5 ml-4 {{ $currentStep > $i ? 'bg-rose-500' : 'bg-gray-300' }} transition-all duration-300"></div>
                        @endif
                    </div>
                @endfor
            </div>
            
            <div class="flex justify-between text-sm font-medium text-gray-600">
                <span class="{{ $currentStep >= 1 ? 'text-rose-600' : '' }}">Select Service</span>
                <span class="{{ $currentStep >= 2 ? 'text-rose-600' : '' }}">Date & Time</span>
                <span class="{{ $currentStep >= 3 ? 'text-rose-600' : '' }}">Your Details</span>
                <span class="{{ $currentStep >= 4 ? 'text-rose-600' : '' }}">Confirmation</span>
            </div>
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
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    @endif
                    {{ $message }}
                </div>
            </div>
        @endif

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

        @if(!$isConfirmed)
            <!-- Main Booking Form -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Step 1: Service Selection -->
                @if($currentStep === 1)
                    <div class="bg-gradient-to-r from-rose-500 to-rose-600 px-6 py-4">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                            Step 1: Choose Your Service
                        </h3>
                    </div>

                    <div class="p-6">
                        @if($services && count($services) > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($services as $service)
                                    <div wire:click="selectService('{{ $service->_id }}')" 
                                         class="group cursor-pointer bg-white border-2 border-gray-200 rounded-2xl transition-all duration-200 hover:border-rose-300 hover:shadow-lg hover:-translate-y-1 {{ $selectedServiceId === $service->_id ? 'border-rose-500 bg-rose-50 shadow-lg' : '' }}">
                                        
                                        @if($service->image)
                                            <div class="w-full h-48 overflow-hidden rounded-t-2xl">
                                                <img src="{{ asset($service->image) }}" alt="{{ $service->name }}" 
                                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                            </div>
                                        @else
                                            <div class="w-full h-48 bg-gradient-to-br from-rose-100 to-pink-100 flex items-center justify-center rounded-t-2xl">
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
                                                @if(is_array($service->durations) && count($service->durations) > 0 && isset($service->durations[0]['minutes']))
                                                    <div class="flex items-center text-sm text-gray-500">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        {{ $service->durations[0]['minutes'] }} minutes
                                                    </div>
                                                @endif
                                                
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
                                        @if($selectedServiceId === $service->_id)
                                            <div class="absolute top-4 right-4 w-8 h-8 bg-rose-500 rounded-full flex items-center justify-center shadow-lg">
                                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Services Available</h3>
                                <p class="text-gray-600">Please check back later for available services.</p>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Step 2: Date and Time Selection -->
                @if($currentStep === 2)
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Step 2: Select Date & Time
                        </h3>
                    </div>

                    <div class="p-6 space-y-6">
                        <!-- Selected Service Summary -->
                        @if($selectedService)
                            <div class="bg-gray-50 rounded-xl p-4">
                                <h4 class="font-semibold text-gray-900 mb-2">Selected Service</h4>
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $selectedService->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $estimatedDuration }} minutes â€¢ Rs.{{ number_format($totalPrice, 0) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Date Selection -->
                            <div>
                                <label class="block text-lg font-semibold text-gray-900 mb-4">Select Date</label>
                                <input type="date" 
                                       wire:model.live="bookingDate" 
                                       wire:change="generateTimeSlots"
                                       min="{{ date('Y-m-d') }}"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-0 transition-colors duration-200">
                                
                                @if($bookingDate)
                                    <p class="mt-2 text-sm text-green-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Date selected: {{ \Carbon\Carbon::parse($bookingDate)->format('M j, Y') }}
                                    </p>
                                @endif
                                
                                @error('bookingDate')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Time Selection -->
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <label class="block text-lg font-semibold text-gray-900">Select Time</label>
                                    @if($bookingDate)
                                        <button wire:click="refreshTimeSlots" 
                                                class="text-sm text-purple-600 hover:text-purple-800 font-medium flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            Refresh Times
                                        </button>
                                    @else
                                        <span class="text-sm text-gray-500">Select a date first</span>
                                    @endif
                                </div>
                                
                                <!-- Debug Information -->
                                @if(config('app.debug'))
                                    <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-sm">
                                        <strong class="text-yellow-800">Debug Info:</strong><br>
                                        <span class="text-yellow-700">
                                            Current Step: {{ $currentStep }}<br>
                                            Booking Date: {{ $bookingDate ?? 'Not set' }}<br>
                                            Available Time Slots Count: {{ count($availableTimeSlots) }}<br>
                                            Selected Time: {{ $bookingTime ?? 'None' }}<br>
                                            Step 1 Complete: {{ $isStep1Complete ? 'Yes' : 'No' }}<br>
                                            Step 2 Complete: {{ $isStep2Complete ? 'Yes' : 'No' }}<br>
                                            Selected Service ID: {{ $selectedServiceId ?? 'None' }}<br>
                                            @if(count($availableTimeSlots) > 0)
                                                First 3 slots: {{ implode(', ', array_slice(array_column($availableTimeSlots, 'display'), 0, 3)) }}<br>
                                                All slot times: {{ implode(', ', array_column($availableTimeSlots, 'time')) }}
                                            @endif
                                        </span>
                                        
                                        <!-- Test Buttons -->
                                        <div class="mt-2 pt-2 border-t border-yellow-300">
                                            <strong class="text-yellow-800">Test Actions:</strong><br>
                                            <div class="flex gap-2 mt-1">
                                                <button wire:click="testClick" class="px-2 py-1 bg-red-200 text-red-800 rounded text-xs">
                                                    Test Wire Click
                                                </button>
                                                <button wire:click="selectTimeSlot('09:00')" class="px-2 py-1 bg-orange-200 text-orange-800 rounded text-xs">
                                                    Force Select 9:00 AM
                                                </button>
                                                <button wire:click="selectTimeSlotByIndex(0)" class="px-2 py-1 bg-purple-200 text-purple-800 rounded text-xs">
                                                    Force Select Index 0
                                                </button>
                                                <button wire:click="generateTimeSlots" class="px-2 py-1 bg-yellow-200 text-yellow-800 rounded text-xs">
                                                    Generate Slots
                                                </button>
                                                @if(count($availableTimeSlots) > 0)
                                                    <button wire:click="selectTimeSlotByIndex(0)" 
                                                            class="px-2 py-1 bg-blue-200 text-blue-800 rounded text-xs">
                                                        Select First Slot (Index)
                                                    </button>
                                                    <button wire:click="selectTimeSlot({{ json_encode($availableTimeSlots[0]['time']) }})" 
                                                            class="px-2 py-1 bg-green-200 text-green-800 rounded text-xs">
                                                        Select First Slot (Time)
                                                    </button>
                                                @endif
                                                <button wire:click="$refresh" class="px-2 py-1 bg-green-200 text-green-800 rounded text-xs">
                                                    Refresh Component
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($bookingDate && count($availableTimeSlots) > 0)
                                    <div class="mb-4">
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">Available Time Slots:</h4>
                                        <!-- Debug: Show raw time slot data -->
                                        @if(config('app.debug'))
                                            <div class="text-xs text-gray-500 mb-2">
                                                Time slots: {{ json_encode(array_column($availableTimeSlots, 'time')) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 max-h-64 overflow-y-auto">
                                        @foreach($availableTimeSlots as $index => $slot)
                                            <button type="button"
                                                    wire:click="selectTimeSlotByIndex({{ $index }})"
                                                    wire:loading.attr="disabled"
                                                    data-time="{{ $slot['time'] }}"
                                                    data-index="{{ $index }}"
                                                    class="group relative p-3 text-sm font-medium rounded-lg border-2 transition-all duration-200 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2
                                                           {{ $bookingTime === $slot['time'] 
                                                              ? 'border-purple-500 bg-purple-500 text-white shadow-lg transform scale-105' 
                                                              : 'border-gray-200 bg-white text-gray-700 hover:border-purple-300 hover:bg-purple-50' }}
                                                           {{ $slot['available'] ? 'cursor-pointer' : 'opacity-50 cursor-not-allowed' }}"
                                                    {{ !$slot['available'] ? 'disabled' : '' }}>
                                                <div class="flex items-center justify-center">
                                                    <svg class="w-4 h-4 mr-2 {{ $bookingTime === $slot['time'] ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    {{ $slot['display'] }}
                                                </div>
                                                @if($bookingTime === $slot['time'])
                                                    <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-400 rounded-full border-2 border-white"></div>
                                                @endif
                                                <div wire:loading wire:target="selectTimeSlot" class="absolute inset-0 bg-gray-100 bg-opacity-75 flex items-center justify-center rounded-lg">
                                                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-purple-500"></div>
                                                </div>
                                            </button>
                                        @endforeach
                                    </div>
                                @elseif($bookingDate && count($availableTimeSlots) === 0)
                                    <div class="text-center py-8">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <p class="mt-2 text-gray-500 font-medium">No available times for this date</p>
                                        <p class="text-gray-400 text-sm">Please select a different date</p>
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="mt-2 text-gray-500 font-medium">Select a date to see available times</p>
                                        <p class="text-gray-400 text-sm">Choose your preferred appointment date above</p>
                                    </div>
                                @endif
                                
                                @error('bookingTime')
                                    <p class="mt-3 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Booking Summary -->
                        @if($bookingDate && $bookingTime && $selectedService)
                            <div class="mt-6 p-4 bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-200 rounded-xl">
                                <h4 class="font-semibold text-purple-900 mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    Booking Summary
                                </h4>
                                <div class="grid md:grid-cols-3 gap-4 text-sm">
                                    <div>
                                        <span class="text-purple-600 font-medium">Service:</span>
                                        <p class="text-gray-900">{{ $selectedService->name }}</p>
                                    </div>
                                    <div>
                                        <span class="text-purple-600 font-medium">Date:</span>
                                        <p class="text-gray-900">{{ \Carbon\Carbon::parse($bookingDate)->format('M j, Y') }}</p>
                                    </div>
                                    <div>
                                        <span class="text-purple-600 font-medium">Time:</span>
                                        <p class="text-gray-900">{{ \Carbon\Carbon::createFromFormat('H:i', $bookingTime)->format('g:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Step 3: Customer Details -->
                @if($currentStep === 3)
                    <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-4">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Step 3: Your Details
                        </h3>
                    </div>

                    <div class="p-6 space-y-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                                <input type="text" 
                                       wire:model="customerName" 
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-amber-500 focus:ring-0 transition-colors duration-200"
                                       placeholder="Enter your full name">
                                @error('customerName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                                <input type="email" 
                                       wire:model="customerEmail" 
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-amber-500 focus:ring-0 transition-colors duration-200"
                                       placeholder="Enter your email">
                                @error('customerEmail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                                <input type="tel" 
                                       wire:model="customerPhone" 
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-amber-500 focus:ring-0 transition-colors duration-200"
                                       placeholder="Enter your phone number">
                                @error('customerPhone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Special Requests (Optional)</label>
                                <textarea wire:model="specialRequests" 
                                          rows="3"
                                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-amber-500 focus:ring-0 transition-colors duration-200"
                                          placeholder="Any special requests or notes..."></textarea>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Step 4: Confirmation -->
                @if($currentStep === 4)
                    <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Step 4: Confirm Your Booking
                        </h3>
                    </div>

                    <div class="p-6 space-y-6">
                        <!-- Booking Summary -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h4 class="font-bold text-gray-900 text-lg mb-4">Booking Summary</h4>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Service:</span>
                                    <span class="font-medium">{{ $selectedService->name ?? '' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Date:</span>
                                    <span class="font-medium">{{ $bookingDate ? \Carbon\Carbon::parse($bookingDate)->format('M j, Y') : '' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Time:</span>
                                    <span class="font-medium">{{ $bookingTime ? \Carbon\Carbon::parse($bookingTime)->format('g:i A') : '' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Duration:</span>
                                    <span class="font-medium">{{ $estimatedDuration }} minutes</span>
                                </div>
                                <div class="flex justify-between border-t pt-3">
                                    <span class="text-gray-600">Total Price:</span>
                                    <span class="font-bold text-lg text-rose-600">Rs.{{ number_format($totalPrice, 0) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Details -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h4 class="font-bold text-gray-900 text-lg mb-4">Customer Details</h4>
                            
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Name:</span>
                                    <span class="font-medium">{{ $customerName }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Email:</span>
                                    <span class="font-medium">{{ $customerEmail }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Phone:</span>
                                    <span class="font-medium">{{ $customerPhone }}</span>
                                </div>
                                @if($specialRequests)
                                    <div class="border-t pt-3">
                                        <span class="text-gray-600">Special Requests:</span>
                                        <p class="font-medium mt-1">{{ $specialRequests }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Navigation Buttons -->
                <div class="border-t border-gray-100 px-6 py-4 flex justify-between">
                    @if($currentStep > 1)
                        <button wire:click="previousStep" 
                                class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors duration-200 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Previous
                        </button>
                    @else
                        <div></div>
                    @endif

                    @if($currentStep < $maxSteps)
                        @php
                            $canContinue = false;
                            if ($currentStep == 1) $canContinue = $isStep1Complete;
                            elseif ($currentStep == 2) $canContinue = $isStep2Complete;
                            elseif ($currentStep == 3) $canContinue = $isStep3Complete;
                        @endphp
                        
                        <button wire:click="nextStep" 
                                wire:loading.attr="disabled"
                                {{ !$canContinue ? 'disabled' : '' }}
                                class="px-6 py-3 rounded-xl transition-colors duration-200 flex items-center
                                       {{ $canContinue 
                                          ? 'bg-rose-500 text-white hover:bg-rose-600 cursor-pointer' 
                                          : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}">
                            <span wire:loading.remove wire:target="nextStep">Continue</span>
                            <span wire:loading wire:target="nextStep">Processing...</span>
                            <svg wire:loading.remove wire:target="nextStep" class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            <div wire:loading wire:target="nextStep" class="ml-2 animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                        </button>
                    @else
                        <button wire:click="confirmBooking" 
                                class="px-8 py-3 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-colors duration-200 flex items-center font-semibold">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Confirm Booking
                        </button>
                    @endif
                </div>
            </div>
        @else
            <!-- Confirmation Success -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-8 text-center">
                    <svg class="w-16 h-16 text-white mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="text-2xl font-bold text-white mb-2">Booking Confirmed!</h3>
                    <p class="text-green-100">Your appointment has been successfully scheduled</p>
                </div>
                
                <div class="p-6 text-center">
                    <p class="text-gray-600 mb-6">
                        A confirmation email will be sent to {{ $customerEmail }} shortly with your appointment details.
                    </p>
                    
                    <button wire:click="resetForm" 
                            class="px-6 py-3 bg-rose-500 text-white rounded-xl hover:bg-rose-600 transition-colors duration-200">
                        Book Another Service
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
