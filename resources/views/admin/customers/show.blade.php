@extends('layouts.app')

@section('title', 'Customer Details')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-serif font-bold text-gray-900">
                {{ $customer->first_name }} {{ $customer->last_name }}
            </h1>
            <p class="text-gray-600 mt-1">Customer ID: #{{ $customer->id }}</p>
        </div>
        <div class="flex space-x-3">
            <x-ui.button href="{{ route('admin.customers.edit', $customer) }}" variant="outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Customer
            </x-ui.button>
            <x-ui.button href="{{ route('admin.customers.index') }}" variant="ghost">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Customers
            </x-ui.button>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Customer Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <x-ui.card class="bg-gradient-to-r from-blue-50 to-blue-100 border-blue-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-blue-600">Total Appointments</p>
                    <p class="text-2xl font-bold text-blue-900">{{ $stats['total_appointments'] }}</p>
                </div>
            </div>
        </x-ui.card>

        <x-ui.card class="bg-gradient-to-r from-green-50 to-green-100 border-green-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-green-600">Completed</p>
                    <p class="text-2xl font-bold text-green-900">{{ $stats['completed_appointments'] }}</p>
                </div>
            </div>
        </x-ui.card>

        <x-ui.card class="bg-gradient-to-r from-purple-50 to-purple-100 border-purple-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-purple-600">Total Spent</p>
                    <p class="text-2xl font-bold text-purple-900">${{ number_format($stats['total_spent'], 2) }}</p>
                </div>
            </div>
        </x-ui.card>

        <x-ui.card class="bg-gradient-to-r from-yellow-50 to-yellow-100 border-yellow-200">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-yellow-600">Avg Order Value</p>
                    <p class="text-2xl font-bold text-yellow-900">${{ number_format($stats['avg_order_value'], 2) }}</p>
                </div>
            </div>
        </x-ui.card>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Customer Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Details -->
            <x-ui.card>
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Personal Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Full Name</label>
                        <p class="text-gray-900">{{ $customer->first_name }} {{ $customer->last_name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                        <p class="text-gray-900">{{ $customer->user->email }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Phone</label>
                        <p class="text-gray-900">{{ $customer->phone }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Date of Birth</label>
                        <p class="text-gray-900">
                            @if($customer->date_of_birth)
                                {{ $customer->date_of_birth->format('F j, Y') }}
                                <span class="text-sm text-gray-500">({{ $customer->date_of_birth->age }} years old)</span>
                            @else
                                <span class="text-gray-500">Not provided</span>
                            @endif
                        </p>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Address</label>
                        <p class="text-gray-900">
                            {{ $customer->address ?: 'Not provided' }}
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Member Since</label>
                        <p class="text-gray-900">{{ $customer->created_at->format('F j, Y') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Customer Status</label>
                        <div class="flex items-center space-x-2">
                            @if($stats['total_spent'] >= 1000)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    VIP Customer
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Regular Customer
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </x-ui.card>

            <!-- Recent Appointments -->
            <x-ui.card>
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Appointments</h3>
                    <span class="text-sm text-gray-500">Last 5 appointments</span>
                </div>

                @if($customer->appointments->count() > 0)
                    <div class="space-y-4">
                        @foreach($customer->appointments->take(5) as $appointment)
                            <div class="flex items-center justify-between p-4 border rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="text-center min-w-0">
                                        <p class="text-lg font-bold text-primary-600">
                                            {{ $appointment->appointment_date->format('j') }}
                                        </p>
                                        <p class="text-xs text-gray-500 uppercase">
                                            {{ $appointment->appointment_date->format('M') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $appointment->service->name }}</p>
                                        <p class="text-sm text-gray-600">
                                            with {{ $appointment->staff->first_name }} {{ $appointment->staff->last_name }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $appointment->appointment_time->format('g:i A') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900">${{ number_format($appointment->price, 2) }}</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($appointment->status === 'completed') bg-green-100 text-green-800
                                        @elseif($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($appointment->status === 'confirmed') bg-blue-100 text-blue-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-gray-500">No appointments yet</p>
                    </div>
                @endif
            </x-ui.card>
        </div>

        <!-- Side Panel -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <x-ui.card>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                
                <div class="space-y-3">
                    <x-ui.button href="{{ route('admin.customers.edit', $customer) }}" variant="outline" size="sm" class="w-full">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Information
                    </x-ui.button>
                    
                    <x-ui.button href="#" variant="outline" size="sm" class="w-full">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Book Appointment
                    </x-ui.button>
                    
                    <x-ui.button href="#" variant="outline" size="sm" class="w-full">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Send Email
                    </x-ui.button>
                </div>
            </x-ui.card>

            <!-- Customer Profile -->
            <x-ui.card class="bg-gradient-to-br from-primary-50 to-secondary-50 border-primary-200">
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-primary-600 font-bold text-2xl">
                            {{ substr($customer->first_name, 0, 1) }}{{ substr($customer->last_name, 0, 1) }}
                        </span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $customer->first_name }} {{ $customer->last_name }}</h3>
                    <p class="text-gray-600">Customer ID: #{{ $customer->id }}</p>
                    
                    @if($stats['total_spent'] >= 1000)
                        <div class="mt-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                VIP Member
                            </span>
                        </div>
                    @endif
                </div>
            </x-ui.card>

            <!-- Recent Orders -->
            @if($customer->orders->count() > 0)
                <x-ui.card>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Orders</h3>
                    
                    <div class="space-y-3">
                        @foreach($customer->orders->take(3) as $order)
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">#{{ $order->order_number }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->created_at->format('M j, Y') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-gray-900">${{ number_format($order->total_amount, 2) }}</p>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                        @if($order->status === 'completed') bg-green-100 text-green-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-ui.card>
            @endif
        </div>
    </div>
</div>
@endsection