@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-primary-50 to-secondary-50 rounded-lg shadow-sm border p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-serif font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}!</h1>
                <p class="text-gray-600 mt-1">We're excited to see you again</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">{{ now()->format('l, F j, Y') }}</p>
                <x-ui.button href="{{ route('appointments.create') }}" variant="primary" size="sm">
                    Book Appointment
                </x-ui.button>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Appointments -->
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
                    <p class="text-sm font-medium text-blue-600">Total Appointments</p>
                    <p class="text-2xl font-bold text-blue-900">{{ number_format($stats['total_appointments']) }}</p>
                </div>
            </div>
        </x-ui.card>

        <!-- Upcoming Appointments -->
        <x-ui.card class="bg-gradient-to-r from-green-50 to-green-100 border-green-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-green-600">Upcoming Appointments</p>
                    <p class="text-2xl font-bold text-green-900">{{ number_format($stats['upcoming_appointments']) }}</p>
                </div>
            </div>
        </x-ui.card>

        <!-- Total Orders -->
        <x-ui.card class="bg-gradient-to-r from-purple-50 to-purple-100 border-purple-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-purple-600">Total Orders</p>
                    <p class="text-2xl font-bold text-purple-900">{{ number_format($stats['total_orders']) }}</p>
                </div>
            </div>
        </x-ui.card>

        <!-- Total Spent -->
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
                    <p class="text-sm font-medium text-primary-600">Total Spent</p>
                    <p class="text-2xl font-bold text-primary-900">LKR {{ number_format($stats['total_spent'], 2) }}</p>
                </div>
            </div>
        </x-ui.card>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Upcoming Appointments -->
        <div class="lg:col-span-2">
            <x-ui.card>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Upcoming Appointments</h2>
                    <x-ui.button href="{{ route('appointments.index') }}" variant="outline" size="sm">
                        View All
                    </x-ui.button>
                </div>

                @if($upcomingAppointments->count() > 0)
                    <div class="space-y-4">
                        @foreach($upcomingAppointments as $appointment)
                            <div class="flex items-center justify-between p-4 border rounded-lg hover:shadow-md transition-shadow">
                                <div class="flex items-center space-x-4">
                                    <div class="text-center">
                                        <p class="text-lg font-bold text-primary-600">
                                            {{ $appointment->appointment_date->format('j') }}
                                        </p>
                                        <p class="text-xs text-gray-500 uppercase">
                                            {{ $appointment->appointment_date->format('M') }}
                                        </p>
                                    </div>
                                    <div class="w-12 h-12 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-full flex items-center justify-center">
                                        <span class="text-primary-600 font-semibold text-sm">
                                            {{ substr($appointment->staff->first_name, 0, 1) }}{{ substr($appointment->staff->last_name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $appointment->service->name }}</p>
                                        <p class="text-sm text-gray-600">
                                            with {{ $appointment->staff->first_name }} {{ $appointment->staff->last_name }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $appointment->appointment_time->format('g:i A') }} • {{ $appointment->service->duration }} min
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900">${{ number_format($appointment->service->price, 2) }}</p>
                                    <div class="mt-2 space-x-1">
                                        @if($appointment->appointment_date->isAfter(now()->addDay()))
                                            <x-ui.button 
                                                href="{{ route('appointments.edit', $appointment) }}" 
                                                variant="outline" 
                                                size="xs"
                                            >
                                                Reschedule
                                            </x-ui.button>
                                        @endif
                                        <x-ui.button 
                                            href="{{ route('appointments.show', $appointment) }}" 
                                            variant="ghost" 
                                            size="xs"
                                        >
                                            Details
                                        </x-ui.button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No upcoming appointments</h3>
                        <p class="text-gray-500 mb-4">Book your next appointment to maintain your beautiful look!</p>
                        <x-ui.button href="{{ route('appointments.create') }}" variant="primary">
                            Book Now
                        </x-ui.button>
                    </div>
                @endif
            </x-ui.card>
        </div>

        <!-- Quick Actions & Account -->
        <div class="space-y-6">
            <!-- Quick Book -->
            <x-ui.card class="bg-gradient-to-br from-primary-50 to-secondary-50 border-primary-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Book</h3>
                <p class="text-gray-600 mb-4">Ready for your next beauty session?</p>
                
                <div class="space-y-3">
                    <x-ui.button href="{{ route('appointments.create') }}" variant="primary" size="sm" class="w-full">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        New Appointment
                    </x-ui.button>
                    
                    <x-ui.button href="{{ route('services') }}" variant="outline" size="sm" class="w-full">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Browse Services
                    </x-ui.button>
                </div>
            </x-ui.card>

            <!-- Account Menu -->
            <x-ui.card>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">My Account</h3>
                
                <div class="space-y-2">
                    <a href="{{ route('profile.show') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile Settings
                    </a>
                    
                    <a href="{{ route('appointments.index') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        My Appointments
                    </a>
                    
                    <a href="{{ route('orders.index') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Order History
                    </a>
                    
                    <a href="{{ route('loyalty.index') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                        Loyalty Rewards
                    </a>
                </div>
            </x-ui.card>

            <!-- Membership Status -->
            <x-ui.card class="bg-gradient-to-br from-yellow-50 to-orange-50 border-yellow-200">
                <div class="flex items-center mb-3">
                    <svg class="w-6 h-6 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900">VIP Status</h3>
                </div>
                
                <p class="text-sm text-gray-600 mb-3">
                    You've spent LKR {{ number_format($stats['total_spent'], 2) }} with us! 
                    @if($stats['total_spent'] >= 100000)
                        You're a VIP member with exclusive benefits.
                    @else
                        Spend LKR {{ number_format(100000 - $stats['total_spent'], 2) }} more to become a VIP member.
                    @endif
                </p>
                
                <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                    <div class="bg-gradient-to-r from-yellow-400 to-orange-400 h-2 rounded-full" 
                         style="width: {{ min(($stats['total_spent'] / 100000) * 100, 100) }}%;">
                    </div>
                </div>
                
                <p class="text-xs text-gray-500">
                    {{ number_format(min(($stats['total_spent'] / 100000) * 100, 100), 1) }}% to VIP status
                </p>
            </x-ui.card>
        </div>
    </div>

    <!-- Recent Orders -->
    @if($recentOrders->count() > 0)
    <x-ui.card>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Recent Orders</h2>
            <x-ui.button href="{{ route('orders.index') }}" variant="outline" size="sm">
                View All Orders
            </x-ui.button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Services</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recentOrders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">#{{ $order->order_number }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    @foreach($order->orderItems as $item)
                                        <div>{{ $item->service->name }}</div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->format('M j, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                ${{ number_format($order->total_amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($order->status === 'completed') bg-green-100 text-green-800
                                    @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-ui.card>
    @endif
</div>
@endsection