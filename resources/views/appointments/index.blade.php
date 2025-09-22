@extends('layouts.app')

@section('title', 'My Appointments')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-serif font-bold text-gray-900">My Appointments</h1>
            <p class="text-gray-600 mt-1">Manage your upcoming and past appointments</p>
        </div>
        <x-ui.button href="{{ route('appointments.create') }}" variant="primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Book New Appointment
        </x-ui.button>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter Tabs -->
    <div class="bg-white rounded-lg shadow-sm border">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                <button class="border-primary-500 text-primary-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" 
                        onclick="filterAppointments('all')">
                    All Appointments
                </button>
                <button class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                        onclick="filterAppointments('upcoming')">
                    Upcoming
                </button>
                <button class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                        onclick="filterAppointments('completed')">
                    Completed
                </button>
                <button class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                        onclick="filterAppointments('cancelled')">
                    Cancelled
                </button>
            </nav>
        </div>
    </div>

    <!-- Appointments List -->
    @if($appointments->count() > 0)
        <div class="space-y-4">
            @foreach($appointments as $appointment)
                <x-ui.card class="appointment-card" data-status="{{ $appointment->status }}" data-date="{{ $appointment->appointment_date }}">
                    <div class="flex items-center justify-between">
                        <!-- Left Side - Date & Service Info -->
                        <div class="flex items-center space-x-6">
                            <!-- Date Badge -->
                            <div class="text-center min-w-0 flex-shrink-0">
                                <div class="w-16 h-16 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-xl flex flex-col items-center justify-center">
                                    <span class="text-lg font-bold text-primary-600">
                                        {{ $appointment->appointment_date->format('j') }}
                                    </span>
                                    <span class="text-xs text-primary-500 uppercase font-medium">
                                        {{ $appointment->appointment_date->format('M') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Service & Staff Info -->
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $appointment->service->name }}</h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($appointment->status === 'confirmed') bg-blue-100 text-blue-800
                                        @elseif($appointment->status === 'in_progress') bg-purple-100 text-purple-800
                                        @elseif($appointment->status === 'completed') bg-green-100 text-green-800
                                        @elseif($appointment->status === 'cancelled') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                                    </span>
                                </div>
                                
                                <div class="flex items-center text-gray-600 space-x-4">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-sm">{{ $appointment->appointment_time->format('g:i A') }}</span>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span class="text-sm">{{ $appointment->staff->first_name }} {{ $appointment->staff->last_name }}</span>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-sm">{{ $appointment->service->duration }} min</span>
                                    </div>
                                </div>

                                @if($appointment->notes)
                                    <p class="text-sm text-gray-500 mt-2">
                                        <span class="font-medium">Notes:</span> {{ $appointment->notes }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- Right Side - Price & Actions -->
                        <div class="flex items-center space-x-4">
                            <div class="text-right">
                                <p class="text-xl font-bold text-gray-900">${{ number_format($appointment->price, 2) }}</p>
                                <p class="text-sm text-gray-500">{{ $appointment->appointment_date->format('l, M j') }}</p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col space-y-2">
                                <x-ui.button 
                                    href="{{ route('appointments.show', $appointment) }}" 
                                    variant="outline" 
                                    size="sm"
                                >
                                    View Details
                                </x-ui.button>

                                @if($appointment->status === 'pending' && $appointment->appointment_date->isAfter(now()->addHours(24)))
                                    <x-ui.button 
                                        href="{{ route('appointments.edit', $appointment) }}" 
                                        variant="ghost" 
                                        size="sm"
                                    >
                                        Reschedule
                                    </x-ui.button>
                                @endif

                                @if($appointment->status === 'pending' && $appointment->appointment_date->isAfter(now()->addHours(24)))
                                    <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <x-ui.button 
                                            type="submit" 
                                            variant="ghost" 
                                            size="sm"
                                            onclick="return confirm('Are you sure you want to cancel this appointment?')"
                                            class="text-red-600 hover:text-red-700"
                                        >
                                            Cancel
                                        </x-ui.button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </x-ui.card>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $appointments->links() }}
        </div>
    @else
        <x-ui.card class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No appointments found</h3>
            <p class="text-gray-500 mb-6">You haven't booked any appointments yet. Start your beauty journey today!</p>
            <x-ui.button href="{{ route('appointments.create') }}" variant="primary">
                Book Your First Appointment
            </x-ui.button>
        </x-ui.card>
    @endif
</div>

<script>
function filterAppointments(filter) {
    const appointments = document.querySelectorAll('.appointment-card');
    const tabs = document.querySelectorAll('nav button');
    
    // Update tab styles
    tabs.forEach(tab => {
        tab.className = 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm';
    });
    event.target.className = 'border-primary-500 text-primary-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm';
    
    // Filter appointments
    appointments.forEach(appointment => {
        const status = appointment.dataset.status;
        const date = new Date(appointment.dataset.date);
        const now = new Date();
        
        let show = false;
        
        switch(filter) {
            case 'all':
                show = true;
                break;
            case 'upcoming':
                show = date >= now && ['pending', 'confirmed'].includes(status);
                break;
            case 'completed':
                show = status === 'completed';
                break;
            case 'cancelled':
                show = status === 'cancelled';
                break;
        }
        
        appointment.style.display = show ? 'block' : 'none';
    });
}
</script>
@endsection