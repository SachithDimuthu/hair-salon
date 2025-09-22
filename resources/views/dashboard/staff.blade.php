@extends('layouts.app')

@section('title', 'Staff Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-serif font-bold text-gray-900">Staff Dashboard</h1>
                <p class="text-gray-600 mt-1">Welcome back, {{ auth()->user()->name }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">{{ now()->format('l, F j, Y') }}</p>
                <p class="text-lg font-semibold text-primary-600">{{ now()->format('g:i A') }}</p>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Today's Appointments -->
        <x-ui.card class="bg-gradient-to-r from-blue-50 to-blue-100 border-blue-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-blue-600">Today's Appointments</p>
                    <p class="text-2xl font-bold text-blue-900">{{ number_format($stats['todays_appointments']) }}</p>
                </div>
            </div>
        </x-ui.card>

        <!-- Pending Appointments -->
        <x-ui.card class="bg-gradient-to-r from-yellow-50 to-yellow-100 border-yellow-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-yellow-600">Pending Appointments</p>
                    <p class="text-2xl font-bold text-yellow-900">{{ number_format($stats['pending_appointments']) }}</p>
                </div>
            </div>
        </x-ui.card>

        <!-- Completed Appointments -->
        <x-ui.card class="bg-gradient-to-r from-green-50 to-green-100 border-green-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-green-600">Completed This Month</p>
                    <p class="text-2xl font-bold text-green-900">{{ number_format($stats['completed_appointments']) }}</p>
                </div>
            </div>
        </x-ui.card>

        <!-- Monthly Revenue -->
        <x-ui.card class="bg-gradient-to-r from-primary-50 to-primary-100 border-primary-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-primary-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-primary-600">Monthly Revenue</p>
                    <p class="text-2xl font-bold text-primary-900">${{ number_format($stats['monthly_revenue'], 2) }}</p>
                </div>
            </div>
        </x-ui.card>
    </div>

    <!-- Today's Schedule and Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Today's Schedule -->
        <div class="lg:col-span-2">
            <x-ui.card>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Today's Schedule</h2>
                    <div class="flex space-x-2">
                        <x-ui.button href="{{ route('staff.appointments.calendar') }}" variant="outline" size="sm">
                            Calendar View
                        </x-ui.button>
                        <x-ui.button href="{{ route('staff.appointments.index') }}" variant="outline" size="sm">
                            All Appointments
                        </x-ui.button>
                    </div>
                </div>

                @if($appointments->count() > 0)
                    <div class="space-y-4">
                        @foreach($appointments as $appointment)
                            <div class="flex items-center justify-between p-4 border rounded-lg 
                                @if($appointment->status === 'confirmed') border-green-200 bg-green-50
                                @elseif($appointment->status === 'pending') border-yellow-200 bg-yellow-50
                                @elseif($appointment->status === 'completed') border-blue-200 bg-blue-50
                                @else border-red-200 bg-red-50
                                @endif">
                                <div class="flex items-center space-x-4">
                                    <div class="text-center">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $appointment->appointment_time->format('g:i') }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $appointment->appointment_time->format('A') }}
                                        </p>
                                    </div>
                                    <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                                        <span class="text-primary-600 font-semibold text-sm">
                                            {{ substr($appointment->customer->first_name, 0, 1) }}{{ substr($appointment->customer->last_name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">
                                            {{ $appointment->customer->first_name }} {{ $appointment->customer->last_name }}
                                        </p>
                                        <p class="text-sm text-gray-600">{{ $appointment->service->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $appointment->service->duration }} minutes</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($appointment->status === 'confirmed') bg-green-100 text-green-800
                                        @elseif($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($appointment->status === 'completed') bg-blue-100 text-blue-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                    <p class="text-sm text-gray-500 mt-1">${{ number_format($appointment->service->price, 2) }}</p>
                                    @if($appointment->status === 'confirmed')
                                        <div class="mt-2 space-x-1">
                                            <x-ui.button 
                                                href="{{ route('staff.appointments.start', $appointment) }}" 
                                                variant="primary" 
                                                size="xs"
                                            >
                                                Start
                                            </x-ui.button>
                                        </div>
                                    @elseif($appointment->status === 'pending')
                                        <div class="mt-2 space-x-1">
                                            <x-ui.button 
                                                href="{{ route('staff.appointments.confirm', $appointment) }}" 
                                                variant="primary" 
                                                size="xs"
                                            >
                                                Confirm
                                            </x-ui.button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No appointments today</h3>
                        <p class="text-gray-500">Enjoy your free time!</p>
                    </div>
                @endif
            </x-ui.card>
        </div>

        <!-- Quick Actions & Profile -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <x-ui.card>
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Quick Actions</h2>
                
                <div class="space-y-3">
                    <x-ui.button href="{{ route('staff.appointments.create') }}" variant="primary" size="sm" class="w-full justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Book Appointment
                    </x-ui.button>
                    
                    <x-ui.button href="{{ route('staff.customers.index') }}" variant="outline" size="sm" class="w-full justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m3 5.197H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        View Clients
                    </x-ui.button>
                    
                    <x-ui.button href="{{ route('staff.schedule.index') }}" variant="outline" size="sm" class="w-full justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Manage Schedule
                    </x-ui.button>
                    
                    <x-ui.button href="{{ route('staff.profile.edit') }}" variant="outline" size="sm" class="w-full justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Update Profile
                    </x-ui.button>
                </div>
            </x-ui.card>

            <!-- Performance Summary -->
            <x-ui.card>
                <h2 class="text-xl font-semibold text-gray-900 mb-6">This Month</h2>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Completed Services</span>
                        <span class="font-semibold text-gray-900">{{ $stats['completed_appointments'] }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Revenue Generated</span>
                        <span class="font-semibold text-primary-600">${{ number_format($stats['monthly_revenue'], 2) }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Average per Service</span>
                        <span class="font-semibold text-gray-900">
                            ${{ $stats['completed_appointments'] > 0 ? number_format($stats['monthly_revenue'] / $stats['completed_appointments'], 2) : '0.00' }}
                        </span>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Pending Reviews</span>
                        <span class="font-semibold text-yellow-600">{{ $stats['pending_appointments'] }}</span>
                    </div>
                </div>
                
                <div class="mt-6">
                    <x-ui.button href="{{ route('staff.reports.monthly') }}" variant="ghost" size="sm" class="w-full">
                        View Detailed Report
                    </x-ui.button>
                </div>
            </x-ui.card>
        </div>
    </div>

    <!-- Recent Activity -->
    <x-ui.card>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Recent Activity</h2>
        </div>
        
        <div class="flow-root">
            <ul class="-mb-8">
                <li>
                    <div class="relative pb-8">
                        <div class="relative flex space-x-3">
                            <div>
                                <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </span>
                            </div>
                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                <div>
                                    <p class="text-sm text-gray-500">Completed appointment with <span class="font-medium text-gray-900">Sarah Johnson</span></p>
                                </div>
                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                    2 hours ago
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                
                <li>
                    <div class="relative pb-8">
                        <div class="relative flex space-x-3">
                            <div>
                                <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </span>
                            </div>
                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                <div>
                                    <p class="text-sm text-gray-500">New appointment booked with <span class="font-medium text-gray-900">Michael Chen</span></p>
                                </div>
                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                    4 hours ago
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                
                <li>
                    <div class="relative">
                        <div class="relative flex space-x-3">
                            <div>
                                <span class="h-8 w-8 rounded-full bg-yellow-500 flex items-center justify-center ring-8 ring-white">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </span>
                            </div>
                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                <div>
                                    <p class="text-sm text-gray-500">Schedule updated for <span class="font-medium text-gray-900">tomorrow</span></p>
                                </div>
                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                    6 hours ago
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </x-ui.card>
</div>
@endsection