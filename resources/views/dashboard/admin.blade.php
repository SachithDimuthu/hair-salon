@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-serif font-bold text-gray-900">Admin Dashboard</h1>
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
        <!-- Total Customers -->
        <x-ui.card class="bg-gradient-to-r from-blue-50 to-blue-100 border-blue-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m3 5.197H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-blue-600">Total Customers</p>
                    <p class="text-2xl font-bold text-blue-900">{{ number_format($stats['total_customers']) }}</p>
                </div>
            </div>
        </x-ui.card>

        <!-- Total Staff -->
        <x-ui.card class="bg-gradient-to-r from-green-50 to-green-100 border-green-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-green-600">Total Staff</p>
                    <p class="text-2xl font-bold text-green-900">{{ number_format($stats['total_staff']) }}</p>
                </div>
            </div>
        </x-ui.card>

        <!-- Today's Appointments -->
        <x-ui.card class="bg-gradient-to-r from-purple-50 to-purple-100 border-purple-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-purple-600">Today's Appointments</p>
                    <p class="text-2xl font-bold text-purple-900">{{ number_format($stats['todays_appointments']) }}</p>
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

    <!-- Additional Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Services -->
        <x-ui.card class="bg-gradient-to-r from-orange-50 to-orange-100 border-orange-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-orange-600">Total Services</p>
                    <p class="text-xl font-bold text-orange-900">{{ number_format($stats['total_services']) }}</p>
                </div>
            </div>
        </x-ui.card>

        <!-- Total Appointments -->
        <x-ui.card class="bg-gradient-to-r from-indigo-50 to-indigo-100 border-indigo-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h2m0 0h2a2 2 0 002-2V7a2 2 0 00-2-2H9m0 0V5a2 2 0 012-2h2a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-indigo-600">Total Appointments</p>
                    <p class="text-xl font-bold text-indigo-900">{{ number_format($stats['total_appointments']) }}</p>
                </div>
            </div>
        </x-ui.card>

        <!-- Pending Appointments -->
        <x-ui.card class="bg-gradient-to-r from-yellow-50 to-yellow-100 border-yellow-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-yellow-600">Pending Appointments</p>
                    <p class="text-xl font-bold text-yellow-900">{{ number_format($stats['pending_appointments']) }}</p>
                </div>
            </div>
        </x-ui.card>
    </div>

    <!-- Recent Appointments and Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Appointments -->
        <div class="lg:col-span-2">
            <x-ui.card>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Recent Appointments</h2>
                    <x-ui.button href="{{ route('admin.appointments.index') }}" variant="outline" size="sm">
                        View All
                    </x-ui.button>
                </div>

                @if($recentAppointments->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentAppointments as $appointment)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                                        <span class="text-primary-600 font-semibold text-sm">
                                            {{ substr($appointment->customer->first_name, 0, 1) }}{{ substr($appointment->customer->last_name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">
                                            {{ $appointment->customer->first_name }} {{ $appointment->customer->last_name }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $appointment->service->name }} with {{ $appointment->staff->first_name }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $appointment->appointment_date->format('M j') }} at {{ $appointment->appointment_time->format('g:i A') }}
                                        </p>
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
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-gray-500">No recent appointments</p>
                    </div>
                @endif
            </x-ui.card>
        </div>

        <!-- Quick Actions -->
        <div>
            <x-ui.card>
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Quick Actions</h2>
                
                <div class="space-y-3">
                    <x-ui.button href="{{ route('admin.appointments.create') }}" variant="primary" size="sm" class="w-full justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        New Appointment
                    </x-ui.button>
                    
                    <x-ui.button href="{{ route('admin.staff.create') }}" variant="outline" size="sm" class="w-full justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Add Staff Member
                    </x-ui.button>
                    
                    <x-ui.button href="{{ route('admin.services.create') }}" variant="outline" size="sm" class="w-full justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Add Service
                    </x-ui.button>
                    
                    <x-ui.button href="{{ route('admin.customers.index') }}" variant="outline" size="sm" class="w-full justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m3 5.197H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Manage Customers
                    </x-ui.button>
                    
                    <x-ui.button href="{{ route('admin.reports.index') }}" variant="outline" size="sm" class="w-full justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        View Reports
                    </x-ui.button>
                </div>
            </x-ui.card>
        </div>
    </div>

    <!-- Enhanced Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Revenue Analytics -->
        <x-ui.card>
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Revenue Analytics</h2>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-green-600">Weekly Revenue</p>
                        <p class="text-lg font-bold text-green-900">${{ number_format($stats['weekly_revenue'], 2) }}</p>
                    </div>
                    <div class="text-green-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
                
                <div class="flex justify-between items-center p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-blue-600">Average Appointment Value</p>
                        <p class="text-lg font-bold text-blue-900">${{ number_format($stats['avg_appointment_value'], 2) }}</p>
                    </div>
                    <div class="text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>

                <div class="flex justify-between items-center p-4 bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-purple-600">New Customers This Month</p>
                        <p class="text-lg font-bold text-purple-900">{{ number_format($stats['new_customers_this_month']) }}</p>
                    </div>
                    <div class="text-purple-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                </div>

                <div class="flex justify-between items-center p-4 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-yellow-600">VIP Customers</p>
                        <p class="text-lg font-bold text-yellow-900">{{ number_format($stats['vip_customers']) }}</p>
                    </div>
                    <div class="text-yellow-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </x-ui.card>

        <!-- Performance Insights -->
        <x-ui.card>
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Performance Insights</h2>
            
            <!-- Top Services -->
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-800 mb-3">Top Services</h3>
                @if($topServices->count() > 0)
                    <div class="space-y-3">
                        @foreach($topServices as $service)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $service->name }}</p>
                                    <p class="text-sm text-gray-500">${{ number_format($service->base_price, 2) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-primary-600">{{ $service->appointment_services_count }} bookings</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">No service data available yet.</p>
                @endif
            </div>

            <!-- Top Staff -->
            <div>
                <h3 class="text-lg font-medium text-gray-800 mb-3">Top Performing Staff</h3>
                @if($topStaff->count() > 0)
                    <div class="space-y-3">
                        @foreach($topStaff as $staffMember)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center">
                                        <span class="text-primary-600 font-medium text-sm">
                                            {{ substr($staffMember->first_name, 0, 1) }}{{ substr($staffMember->last_name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $staffMember->first_name }} {{ $staffMember->last_name }}</p>
                                        <p class="text-sm text-gray-500">{{ ucfirst($staffMember->position) }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-primary-600">{{ $staffMember->appointments_count }} appointments</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">No staff performance data available yet.</p>
                @endif
            </div>
        </x-ui.card>
    </div>

    <!-- Today's Performance -->
    <x-ui.card>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Today's Performance</h2>
            <span class="text-sm text-gray-500">{{ now()->format('l, F j, Y') }}</span>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="text-center p-4 bg-blue-50 rounded-lg">
                <div class="text-2xl font-bold text-blue-600">{{ $stats['todays_appointments'] }}</div>
                <div class="text-sm text-blue-800">Total Appointments</div>
            </div>
            
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <div class="text-2xl font-bold text-green-600">{{ $stats['completed_appointments_today'] }}</div>
                <div class="text-sm text-green-800">Completed</div>
            </div>
            
            <div class="text-center p-4 bg-yellow-50 rounded-lg">
                <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending_appointments'] }}</div>
                <div class="text-sm text-yellow-800">Pending</div>
            </div>
            
            <div class="text-center p-4 bg-purple-50 rounded-lg">
                <div class="text-2xl font-bold text-purple-600">{{ $stats['active_staff'] }}</div>
                <div class="text-sm text-purple-800">Active Staff</div>
            </div>
        </div>
    </x-ui.card>
</div>
@endsection