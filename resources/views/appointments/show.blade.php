@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-serif font-bold text-gray-900">Appointment Details</h1>
            <p class="text-gray-600 mt-1">Appointment #{{ $appointment->id }}</p>
        </div>
        <div class="flex space-x-3">
            @if($appointment->status === 'pending' && $appointment->appointment_date->isAfter(now()->addHours(24)))
                <x-ui.button href="{{ route('appointments.edit', $appointment) }}" variant="outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Reschedule
                </x-ui.button>
            @endif
            <x-ui.button href="{{ route('appointments.index') }}" variant="ghost">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Appointments
            </x-ui.button>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Status Banner -->
    <div class="bg-gradient-to-r 
        @if($appointment->status === 'pending') from-yellow-50 to-yellow-100 border-yellow-200
        @elseif($appointment->status === 'confirmed') from-blue-50 to-blue-100 border-blue-200
        @elseif($appointment->status === 'in_progress') from-purple-50 to-purple-100 border-purple-200
        @elseif($appointment->status === 'completed') from-green-50 to-green-100 border-green-200
        @elseif($appointment->status === 'cancelled') from-red-50 to-red-100 border-red-200
        @else from-gray-50 to-gray-100 border-gray-200
        @endif
        rounded-lg border p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 
                    @if($appointment->status === 'pending') bg-yellow-500
                    @elseif($appointment->status === 'confirmed') bg-blue-500
                    @elseif($appointment->status === 'in_progress') bg-purple-500
                    @elseif($appointment->status === 'completed') bg-green-500
                    @elseif($appointment->status === 'cancelled') bg-red-500
                    @else bg-gray-500
                    @endif
                    rounded-full flex items-center justify-center">
                    @if($appointment->status === 'pending')
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @elseif($appointment->status === 'confirmed')
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    @elseif($appointment->status === 'completed')
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    @else
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @endif
                </div>
                <div>
                    <h2 class="text-lg font-semibold 
                        @if($appointment->status === 'pending') text-yellow-800
                        @elseif($appointment->status === 'confirmed') text-blue-800
                        @elseif($appointment->status === 'in_progress') text-purple-800
                        @elseif($appointment->status === 'completed') text-green-800
                        @elseif($appointment->status === 'cancelled') text-red-800
                        @else text-gray-800
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                    </h2>
                    <p class="text-sm 
                        @if($appointment->status === 'pending') text-yellow-600
                        @elseif($appointment->status === 'confirmed') text-blue-600
                        @elseif($appointment->status === 'in_progress') text-purple-600
                        @elseif($appointment->status === 'completed') text-green-600
                        @elseif($appointment->status === 'cancelled') text-red-600
                        @else text-gray-600
                        @endif">
                        @if($appointment->status === 'pending')
                            Your appointment is pending confirmation
                        @elseif($appointment->status === 'confirmed')
                            Your appointment is confirmed
                        @elseif($appointment->status === 'in_progress')
                            Your appointment is in progress
                        @elseif($appointment->status === 'completed')
                            Your appointment has been completed
                        @elseif($appointment->status === 'cancelled')
                            This appointment has been cancelled
                        @endif
                    </p>
                </div>
            </div>
            
            @if($appointment->status === 'pending' && $appointment->appointment_date->isAfter(now()->addHours(24)))
                <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <x-ui.button 
                        type="submit" 
                        variant="outline"
                        onclick="return confirm('Are you sure you want to cancel this appointment?')"
                        class="text-red-600 border-red-300 hover:bg-red-50"
                    >
                        Cancel Appointment
                    </x-ui.button>
                </form>
            @endif
        </div>
    </div>

    <!-- Main Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Appointment Information -->
        <div class="lg:col-span-2">
            <x-ui.card>
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Appointment Information</h3>
                
                <div class="space-y-6">
                    <!-- Service Details -->
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900">{{ $appointment->service->name }}</h4>
                            <p class="text-gray-600 text-sm mt-1">{{ $appointment->service->description }}</p>
                            <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                <span>{{ $appointment->service->duration }} minutes</span>
                                <span class="font-semibold text-primary-600">${{ number_format($appointment->price, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Staff Details -->
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-full flex items-center justify-center">
                            <span class="text-primary-600 font-semibold">
                                {{ substr($appointment->staff->first_name, 0, 1) }}{{ substr($appointment->staff->last_name, 0, 1) }}
                            </span>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900">{{ $appointment->staff->first_name }} {{ $appointment->staff->last_name }}</h4>
                            <p class="text-gray-600 text-sm mt-1">{{ $appointment->staff->specialization }}</p>
                            <p class="text-gray-500 text-sm">{{ $appointment->staff->experience_years }} years experience</p>
                        </div>
                    </div>

                    <!-- Date & Time -->
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900">{{ $appointment->appointment_date->format('l, F j, Y') }}</h4>
                            <p class="text-gray-600 text-sm mt-1">{{ $appointment->appointment_time->format('g:i A') }}</p>
                            <p class="text-gray-500 text-sm">
                                @if($appointment->appointment_date->isToday())
                                    Today
                                @elseif($appointment->appointment_date->isTomorrow())
                                    Tomorrow
                                @elseif($appointment->appointment_date->isFuture())
                                    {{ $appointment->appointment_date->diffForHumans() }}
                                @else
                                    {{ $appointment->appointment_date->diffForHumans() }}
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($appointment->notes)
                        <!-- Notes -->
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900">Special Requests</h4>
                                <p class="text-gray-600 text-sm mt-1">{{ $appointment->notes }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </x-ui.card>
        </div>

        <!-- Side Panel -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <x-ui.card>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                
                <div class="space-y-3">
                    @if($appointment->status === 'pending' && $appointment->appointment_date->isAfter(now()->addHours(24)))
                        <x-ui.button href="{{ route('appointments.edit', $appointment) }}" variant="outline" size="sm" class="w-full">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Reschedule
                        </x-ui.button>
                    @endif
                    
                    <x-ui.button href="{{ route('appointments.create') }}" variant="outline" size="sm" class="w-full">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Book Another
                    </x-ui.button>
                    
                    <x-ui.button href="{{ route('services') }}" variant="outline" size="sm" class="w-full">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Browse Services
                    </x-ui.button>
                </div>
            </x-ui.card>

            <!-- Salon Info -->
            <x-ui.card class="bg-gradient-to-br from-primary-50 to-secondary-50 border-primary-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Salon Information</h3>
                
                <div class="space-y-3 text-sm">
                    <div class="flex items-center text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        123 Beauty Street, Salon City
                    </div>
                    
                    <div class="flex items-center text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        (555) 123-4567
                    </div>
                    
                    <div class="flex items-center text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Mon-Sat: 9AM-6PM
                    </div>
                </div>
                
                <div class="mt-4 pt-4 border-t border-primary-200">
                    <p class="text-xs text-gray-500">
                        Please arrive 10 minutes early for your appointment.
                    </p>
                </div>
            </x-ui.card>
        </div>
    </div>
</div>
@endsection