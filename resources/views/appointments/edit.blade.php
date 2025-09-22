@extends('layouts.app')

@section('title', 'Reschedule Appointment')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-serif font-bold text-gray-900">Reschedule Appointment</h1>
            <p class="text-gray-600 mt-1">Update your appointment details</p>
        </div>
        <x-ui.button href="{{ route('appointments.show', $appointment) }}" variant="ghost">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Details
        </x-ui.button>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Current Appointment Info -->
    <x-ui.card class="bg-gray-50 border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Current Appointment</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-medium text-gray-700 mb-2">Service & Staff</h4>
                <p class="text-gray-900">{{ $appointment->service->name }}</p>
                <p class="text-gray-600 text-sm">with {{ $appointment->staff->first_name }} {{ $appointment->staff->last_name }}</p>
            </div>
            <div>
                <h4 class="font-medium text-gray-700 mb-2">Current Date & Time</h4>
                <p class="text-gray-900">{{ $appointment->appointment_date->format('l, F j, Y') }}</p>
                <p class="text-gray-600 text-sm">{{ $appointment->appointment_time->format('g:i A') }}</p>
            </div>
        </div>
    </x-ui.card>

    <!-- Edit Form -->
    <form action="{{ route('appointments.update', $appointment) }}" method="POST" id="rescheduleForm">
        @csrf
        @method('PUT')
        
        <x-ui.card>
            <h3 class="text-xl font-semibold text-gray-900 mb-6">Update Appointment Details</h3>
            
            <div class="space-y-6">
                <!-- Service Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Service</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($services as $service)
                            <div class="service-option border rounded-lg p-4 cursor-pointer hover:border-primary-300 transition-all
                                {{ $service->id == $appointment->service_id ? 'border-primary-500 bg-primary-50' : '' }}"
                                 onclick="selectService({{ $service->id }}, {{ $service->price }})">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-medium text-gray-900">{{ $service->name }}</h4>
                                    <span class="text-lg font-semibold text-primary-600">${{ number_format($service->price, 2) }}</span>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">{{ $service->description }}</p>
                                <p class="text-xs text-gray-500">{{ $service->duration }} minutes</p>
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="service_id" id="selected_service_id" value="{{ $appointment->service_id }}" required>
                </div>

                <!-- Staff Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Stylist</label>
                    <div class="space-y-3">
                        @foreach($staff as $stylist)
                            <div class="staff-option border rounded-lg p-4 cursor-pointer hover:border-primary-300 transition-all
                                {{ $stylist->id == $appointment->staff_id ? 'border-primary-500 bg-primary-50' : '' }}"
                                 onclick="selectStaff({{ $stylist->id }})">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-full flex items-center justify-center">
                                        <span class="text-primary-600 font-semibold">
                                            {{ substr($stylist->first_name, 0, 1) }}{{ substr($stylist->last_name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">{{ $stylist->first_name }} {{ $stylist->last_name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $stylist->specialization }}</p>
                                        <p class="text-sm text-gray-500">{{ $stylist->experience_years }} years experience</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="staff_id" id="selected_staff_id" value="{{ $appointment->staff_id }}" required>
                </div>

                <!-- Date & Time Selection -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Date -->
                    <div>
                        <label for="appointment_date" class="block text-sm font-medium text-gray-700 mb-2">New Date</label>
                        <x-ui.input 
                            type="date" 
                            name="appointment_date" 
                            id="appointment_date"
                            value="{{ $appointment->appointment_date->format('Y-m-d') }}"
                            min="{{ now()->format('Y-m-d') }}"
                            max="{{ now()->addMonths(3)->format('Y-m-d') }}"
                            onchange="updateTimeSlots()"
                            required
                        />
                    </div>
                    
                    <!-- Time -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">New Time</label>
                        <div id="time-slots" class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto">
                            <!-- Time slots will be populated by JavaScript -->
                        </div>
                        <input type="hidden" name="appointment_time" id="selected_time" value="{{ $appointment->appointment_time->format('H:i') }}" required>
                    </div>
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Special Requests (Optional)</label>
                    <textarea 
                        name="notes" 
                        id="notes" 
                        rows="3" 
                        class="block w-full border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500"
                        placeholder="Any special requests or notes for your stylist..."
                    >{{ $appointment->notes }}</textarea>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex justify-between">
                <x-ui.button type="button" onclick="history.back()" variant="outline">
                    Cancel Changes
                </x-ui.button>
                <x-ui.button type="submit" variant="primary">
                    Update Appointment
                </x-ui.button>
            </div>
        </x-ui.card>
    </form>
</div>

<script>
let selectedServiceId = {{ $appointment->service_id }};
let selectedStaffId = {{ $appointment->staff_id }};

function selectService(id, price) {
    // Remove previous selection
    document.querySelectorAll('.service-option').forEach(el => {
        el.classList.remove('border-primary-500', 'bg-primary-50');
    });
    
    // Add selection to clicked service
    event.currentTarget.classList.add('border-primary-500', 'bg-primary-50');
    
    // Update hidden input
    selectedServiceId = id;
    document.getElementById('selected_service_id').value = id;
    
    // Update time slots if staff is also selected
    if (selectedStaffId) {
        updateTimeSlots();
    }
}

function selectStaff(id) {
    // Remove previous selection
    document.querySelectorAll('.staff-option').forEach(el => {
        el.classList.remove('border-primary-500', 'bg-primary-50');
    });
    
    // Add selection to clicked staff
    event.currentTarget.classList.add('border-primary-500', 'bg-primary-50');
    
    // Update hidden input
    selectedStaffId = id;
    document.getElementById('selected_staff_id').value = id;
    
    // Update time slots
    updateTimeSlots();
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
    
    // Update hidden input
    document.getElementById('selected_time').value = time;
}

function updateTimeSlots() {
    const date = document.getElementById('appointment_date').value;
    const timeSlotsContainer = document.getElementById('time-slots');
    
    if (!date || !selectedStaffId) {
        timeSlotsContainer.innerHTML = '<p class="col-span-2 text-gray-500 text-sm">Please select date and staff</p>';
        return;
    }
    
    // Generate time slots (9 AM to 6 PM, excluding lunch 12-1 PM)
    const timeSlots = [
        '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
        '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', 
        '16:00', '16:30', '17:00', '17:30'
    ];
    
    const currentTime = document.getElementById('selected_time').value;
    
    let slotsHtml = '';
    timeSlots.forEach(time => {
        const displayTime = new Date(`2000-01-01 ${time}`).toLocaleTimeString('en-US', {
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });
        
        const isSelected = time === currentTime;
        const buttonClass = isSelected 
            ? 'time-slot p-2 text-sm border rounded-lg bg-primary-500 text-white transition-colors'
            : 'time-slot p-2 text-sm border rounded-lg bg-white text-gray-700 hover:bg-primary-100 transition-colors';
        
        slotsHtml += `
            <button type="button" 
                    class="${buttonClass}"
                    onclick="selectTime('${time}')">
                ${displayTime}
            </button>
        `;
    });
    
    timeSlotsContainer.innerHTML = slotsHtml;
}

// Initialize time slots on page load
document.addEventListener('DOMContentLoaded', function() {
    updateTimeSlots();
});
</script>
@endsection