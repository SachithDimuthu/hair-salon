@extends('layouts.app')

@section('title', 'Book Appointment')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="text-center">
        <h1 class="text-3xl font-serif font-bold text-gray-900">Book Your Appointment</h1>
        <p class="text-gray-600 mt-2">Follow the steps below to schedule your perfect beauty session</p>
    </div>

    <!-- Progress Steps -->
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-primary-500 text-white rounded-full flex items-center justify-center text-sm font-medium">1</div>
                    <span class="text-sm font-medium text-primary-600">Service</span>
                </div>
                <div class="w-12 h-0.5 bg-gray-300"></div>
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gray-300 text-gray-500 rounded-full flex items-center justify-center text-sm font-medium step-2">2</div>
                    <span class="text-sm text-gray-500 step-2-text">Staff</span>
                </div>
                <div class="w-12 h-0.5 bg-gray-300"></div>
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gray-300 text-gray-500 rounded-full flex items-center justify-center text-sm font-medium step-3">3</div>
                    <span class="text-sm text-gray-500 step-3-text">Date & Time</span>
                </div>
                <div class="w-12 h-0.5 bg-gray-300"></div>
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gray-300 text-gray-500 rounded-full flex items-center justify-center text-sm font-medium step-4">4</div>
                    <span class="text-sm text-gray-500 step-4-text">Confirm</span>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('appointments.store') }}" method="POST" id="appointmentForm">
        @csrf
        
        <!-- Step 1: Service Selection -->
        <x-ui.card id="step-1">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Choose Your Service</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($services as $service)
                    <div class="service-option border rounded-lg p-4 cursor-pointer hover:border-primary-300 hover:shadow-md transition-all"
                         onclick="selectService({{ $service->id }}, '{{ $service->name }}', {{ $service->price }}, {{ $service->duration }})">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="font-semibold text-gray-900">{{ $service->name }}</h3>
                            <span class="text-lg font-bold text-primary-600">${{ number_format($service->price, 2) }}</span>
                        </div>
                        
                        <p class="text-sm text-gray-600 mb-3">{{ $service->description }}</p>
                        
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $service->duration }} min
                            </span>
                            <span class="text-primary-500 font-medium">Select</span>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <input type="hidden" name="service_id" id="selected_service_id" required>
            
            <div class="mt-6 flex justify-end">
                <x-ui.button type="button" onclick="nextStep(2)" id="step-1-next" disabled variant="primary">
                    Continue to Staff Selection
                </x-ui.button>
            </div>
        </x-ui.card>

        <!-- Step 2: Staff Selection -->
        <x-ui.card id="step-2" class="hidden">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Choose Your Stylist</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($staff as $stylist)
                    <div class="staff-option border rounded-lg p-6 cursor-pointer hover:border-primary-300 hover:shadow-md transition-all"
                         onclick="selectStaff({{ $stylist->id }}, '{{ $stylist->first_name }} {{ $stylist->last_name }}')">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-full flex items-center justify-center">
                                <span class="text-primary-600 font-semibold text-lg">
                                    {{ substr($stylist->first_name, 0, 1) }}{{ substr($stylist->last_name, 0, 1) }}
                                </span>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900">{{ $stylist->first_name }} {{ $stylist->last_name }}</h3>
                                <p class="text-sm text-gray-600">{{ $stylist->specialization }}</p>
                                <p class="text-sm text-gray-500">{{ $stylist->experience_years }} years experience</p>
                            </div>
                            <div class="text-primary-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <input type="hidden" name="staff_id" id="selected_staff_id" required>
            
            <div class="mt-6 flex justify-between">
                <x-ui.button type="button" onclick="previousStep(1)" variant="outline">
                    Back to Services
                </x-ui.button>
                <x-ui.button type="button" onclick="nextStep(3)" id="step-2-next" disabled variant="primary">
                    Continue to Date & Time
                </x-ui.button>
            </div>
        </x-ui.card>

        <!-- Step 3: Date & Time Selection -->
        <x-ui.card id="step-3" class="hidden">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Select Date & Time</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Date Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Choose Date</label>
                    <x-ui.input 
                        type="date" 
                        name="appointment_date" 
                        id="appointment_date"
                        min="{{ now()->format('Y-m-d') }}"
                        max="{{ now()->addMonths(3)->format('Y-m-d') }}"
                        onchange="updateTimeSlots()"
                        required
                    />
                </div>
                
                <!-- Time Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Choose Time</label>
                    <div id="time-slots" class="grid grid-cols-3 gap-2">
                        <p class="col-span-3 text-gray-500 text-sm">Please select a date first</p>
                    </div>
                    <input type="hidden" name="appointment_time" id="selected_time" required>
                </div>
            </div>
            
            <!-- Notes -->
            <div class="mt-6">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Special Requests (Optional)</label>
                <textarea 
                    name="notes" 
                    id="notes" 
                    rows="3" 
                    class="block w-full border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500"
                    placeholder="Any special requests or notes for your stylist..."
                ></textarea>
            </div>
            
            <div class="mt-6 flex justify-between">
                <x-ui.button type="button" onclick="previousStep(2)" variant="outline">
                    Back to Staff
                </x-ui.button>
                <x-ui.button type="button" onclick="nextStep(4)" id="step-3-next" disabled variant="primary">
                    Review Booking
                </x-ui.button>
            </div>
        </x-ui.card>

        <!-- Step 4: Confirmation -->
        <x-ui.card id="step-4" class="hidden">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Confirm Your Appointment</h2>
            
            <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Service:</span>
                    <span class="font-semibold" id="confirm-service">-</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Stylist:</span>
                    <span class="font-semibold" id="confirm-staff">-</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Date:</span>
                    <span class="font-semibold" id="confirm-date">-</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Time:</span>
                    <span class="font-semibold" id="confirm-time">-</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Duration:</span>
                    <span class="font-semibold" id="confirm-duration">-</span>
                </div>
                <hr class="border-gray-200">
                <div class="flex justify-between items-center text-lg">
                    <span class="font-semibold text-gray-900">Total:</span>
                    <span class="font-bold text-primary-600" id="confirm-price">$0.00</span>
                </div>
            </div>
            
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-sm text-blue-700">
                        <p class="font-medium">Booking Policy:</p>
                        <ul class="mt-1 list-disc list-inside space-y-1">
                            <li>Appointments can be cancelled or rescheduled up to 24 hours in advance</li>
                            <li>Please arrive 10 minutes early for your appointment</li>
                            <li>Late arrivals may result in shortened service time</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 flex justify-between">
                <x-ui.button type="button" onclick="previousStep(3)" variant="outline">
                    Back to Date & Time
                </x-ui.button>
                <x-ui.button type="submit" variant="primary">
                    Confirm Booking
                </x-ui.button>
            </div>
        </x-ui.card>
    </form>
</div>

<script>
let selectedService = null;
let selectedStaff = null;
let selectedDate = null;
let selectedTime = null;

function selectService(id, name, price, duration) {
    // Remove previous selection
    document.querySelectorAll('.service-option').forEach(el => {
        el.classList.remove('border-primary-500', 'bg-primary-50');
    });
    
    // Add selection to clicked service
    event.currentTarget.classList.add('border-primary-500', 'bg-primary-50');
    
    // Store selection
    selectedService = { id, name, price, duration };
    document.getElementById('selected_service_id').value = id;
    
    // Enable next button
    document.getElementById('step-1-next').disabled = false;
}

function selectStaff(id, name) {
    // Remove previous selection
    document.querySelectorAll('.staff-option').forEach(el => {
        el.classList.remove('border-primary-500', 'bg-primary-50');
    });
    
    // Add selection to clicked staff
    event.currentTarget.classList.add('border-primary-500', 'bg-primary-50');
    
    // Store selection
    selectedStaff = { id, name };
    document.getElementById('selected_staff_id').value = id;
    
    // Enable next button
    document.getElementById('step-2-next').disabled = false;
}

function selectTime(time) {
    // Remove previous selection
    document.querySelectorAll('.time-slot').forEach(el => {
        el.classList.remove('bg-primary-500', 'text-white');
        el.classList.add('bg-white', 'text-gray-700');
    });
    
    // Add selection to clicked time
    event.currentTarget.classList.add('bg-primary-500', 'text-white');
    event.currentTarget.classList.remove('bg-white', 'text-gray-700');
    
    // Store selection
    selectedTime = time;
    document.getElementById('selected_time').value = time;
    
    // Enable next button
    document.getElementById('step-3-next').disabled = false;
}

function updateTimeSlots() {
    const date = document.getElementById('appointment_date').value;
    const timeSlotsContainer = document.getElementById('time-slots');
    
    if (!date || !selectedStaff) {
        timeSlotsContainer.innerHTML = '<p class="col-span-3 text-gray-500 text-sm">Please select a date and staff member</p>';
        return;
    }
    
    // Generate time slots (9 AM to 6 PM, excluding lunch 12-1 PM)
    const timeSlots = [
        '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
        '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', 
        '16:00', '16:30', '17:00', '17:30'
    ];
    
    let slotsHtml = '';
    timeSlots.forEach(time => {
        const displayTime = new Date(`2000-01-01 ${time}`).toLocaleTimeString('en-US', {
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });
        
        slotsHtml += `
            <button type="button" 
                    class="time-slot p-2 text-sm border rounded-lg bg-white text-gray-700 hover:bg-primary-100 transition-colors"
                    onclick="selectTime('${time}')">
                ${displayTime}
            </button>
        `;
    });
    
    timeSlotsContainer.innerHTML = slotsHtml;
}

function nextStep(step) {
    // Hide current step
    document.querySelectorAll('[id^="step-"]').forEach(el => el.classList.add('hidden'));
    
    // Show next step
    document.getElementById(`step-${step}`).classList.remove('hidden');
    
    // Update progress indicators
    updateProgressIndicators(step);
    
    // Update confirmation if going to step 4
    if (step === 4) {
        updateConfirmation();
    }
}

function previousStep(step) {
    // Hide current step
    document.querySelectorAll('[id^="step-"]').forEach(el => el.classList.add('hidden'));
    
    // Show previous step
    document.getElementById(`step-${step}`).classList.remove('hidden');
    
    // Update progress indicators
    updateProgressIndicators(step);
}

function updateProgressIndicators(currentStep) {
    for (let i = 1; i <= 4; i++) {
        const circle = document.querySelector(`.step-${i}`);
        const text = document.querySelector(`.step-${i}-text`);
        
        if (i <= currentStep) {
            circle.classList.remove('bg-gray-300', 'text-gray-500');
            circle.classList.add('bg-primary-500', 'text-white');
            if (text) {
                text.classList.remove('text-gray-500');
                text.classList.add('text-primary-600', 'font-medium');
            }
        } else {
            circle.classList.remove('bg-primary-500', 'text-white');
            circle.classList.add('bg-gray-300', 'text-gray-500');
            if (text) {
                text.classList.remove('text-primary-600', 'font-medium');
                text.classList.add('text-gray-500');
            }
        }
    }
}

function updateConfirmation() {
    if (selectedService) {
        document.getElementById('confirm-service').textContent = selectedService.name;
        document.getElementById('confirm-price').textContent = `$${selectedService.price.toFixed(2)}`;
        document.getElementById('confirm-duration').textContent = `${selectedService.duration} minutes`;
    }
    
    if (selectedStaff) {
        document.getElementById('confirm-staff').textContent = selectedStaff.name;
    }
    
    if (selectedDate) {
        const date = new Date(selectedDate);
        document.getElementById('confirm-date').textContent = date.toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }
    
    if (selectedTime) {
        const time = new Date(`2000-01-01 ${selectedTime}`);
        document.getElementById('confirm-time').textContent = time.toLocaleTimeString('en-US', {
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });
    }
}

// Listen for date changes
document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('appointment_date');
    if (dateInput) {
        dateInput.addEventListener('change', function() {
            selectedDate = this.value;
            updateTimeSlots();
        });
    }
});
</script>
@endsection