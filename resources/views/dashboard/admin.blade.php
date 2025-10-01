@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-rose-50 to-pink-50 rounded-lg shadow-sm border border-rose-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-serif font-bold bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent">Admin Dashboard</h1>
                <p class="text-rose-700 mt-1">Welcome back, {{ auth()->user()->name }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-rose-500">{{ now()->format('l, F j, Y') }}</p>
                <p class="text-lg font-semibold text-rose-600">{{ now()->format('g:i A') }}</p>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6">
        <!-- Booking Trends Chart -->
        <x-ui.card>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Booking Trends (Last 6 Months)</h2>
                <div class="w-3 h-3 bg-rose-500 rounded-full"></div>
            </div>
            <div class="h-64">
                <canvas id="bookingTrendsChart"></canvas>
            </div>
        </x-ui.card>

        <!-- Status Distribution Chart -->
        <x-ui.card>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Booking Status Distribution</h2>
                <div class="flex space-x-2">
                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                </div>
            </div>
            <div class="h-64">
                <canvas id="statusDistributionChart"></canvas>
            </div>
        </x-ui.card>
    </div>

    <!-- Popular Services Chart -->
    <div class="mb-6">
        <x-ui.card>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Most Popular Services</h2>
                <span class="text-sm text-gray-500">Based on booking frequency</span>
            </div>
            <div class="h-80">
                <canvas id="popularServicesChart"></canvas>
            </div>
        </x-ui.card>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Bookings -->
        <x-ui.card class="bg-gradient-to-r from-rose-50 to-rose-100 border-rose-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-rose-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-rose-600">Total Bookings</p>
                    <p class="text-2xl font-bold text-rose-900">{{ number_format($stats['total_bookings']) }}</p>
                </div>
            </div>
        </x-ui.card>

        <!-- Unique Customers -->
        <x-ui.card class="bg-gradient-to-r from-pink-50 to-pink-100 border-pink-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-pink-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-pink-600">Unique Customers</p>
                    <p class="text-2xl font-bold text-pink-900">{{ number_format($stats['unique_customers']) }}</p>
                </div>
            </div>
        </x-ui.card>

        <!-- Today's Bookings -->
        <x-ui.card class="bg-gradient-to-r from-red-50 to-red-100 border-red-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-red-600">Today's Bookings</p>
                    <p class="text-2xl font-bold text-red-900">{{ number_format($stats['todays_bookings']) }}</p>
                </div>
            </div>
        </x-ui.card>

        <!-- Monthly Revenue -->
        <x-ui.card class="bg-gradient-to-r from-rose-50 to-rose-100 border-rose-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-rose-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-rose-600">Monthly Revenue</p>
                    <p class="text-2xl font-bold text-rose-900">${{ number_format($stats['monthly_revenue'], 2) }}</p>
                </div>
            </div>
        </x-ui.card>
    </div>

    <!-- Additional Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Services -->
        <x-ui.card class="bg-gradient-to-r from-pink-50 to-pink-100 border-pink-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-pink-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-pink-600">Total Services</p>
                    <p class="text-xl font-bold text-pink-900">{{ number_format($stats['total_services']) }}</p>
                </div>
            </div>
        </x-ui.card>

        <!-- Total Appointments -->
        <x-ui.card class="bg-gradient-to-r from-rose-50 to-rose-100 border-rose-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-rose-400 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h2m0 0h2a2 2 0 002-2V7a2 2 0 00-2-2H9m0 0V5a2 2 0 012-2h2a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-rose-600">Confirmed Bookings</p>
                    <p class="text-xl font-bold text-rose-900">{{ number_format($stats['confirmed_bookings']) }}</p>
                </div>
            </div>
        </x-ui.card>

        <!-- Pending Appointments -->
        <x-ui.card class="bg-gradient-to-r from-amber-50 to-amber-100 border-amber-200">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-amber-600">Pending Bookings</p>
                    <p class="text-xl font-bold text-amber-900">{{ number_format($stats['pending_bookings']) }}</p>
                </div>
            </div>
        </x-ui.card>
    </div>

    <!-- Recent Bookings and Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Bookings -->
        <div class="lg:col-span-2">
            <x-ui.card>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Recent Bookings</h2>
                    <x-ui.button href="{{ route('admin.bookings.index') }}" variant="outline" size="sm">
                        View All
                    </x-ui.button>
                </div>

                @if($recentBookings->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentBookings as $booking)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 bg-rose-100 rounded-full flex items-center justify-center">
                                        <span class="text-rose-600 font-semibold text-sm">
                                            {{ substr($booking->customer_first_name, 0, 1) }}{{ substr($booking->customer_last_name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">
                                            {{ $booking->customer_first_name }} {{ $booking->customer_last_name }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $booking->service_name }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($booking->booking_date)->format('M j') }} at {{ \Carbon\Carbon::parse($booking->booking_time)->format('g:i A') }}
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            {{ $booking->customer_email }} • {{ $booking->customer_phone }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                        @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($booking->status === 'completed') bg-blue-100 text-blue-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                    <p class="text-sm text-gray-500 mt-1">${{ number_format($booking->total_price, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-gray-500">No recent bookings</p>
                    </div>
                @endif
            </x-ui.card>
        </div>

        <!-- Quick Actions -->
        <div>
            <x-ui.card>
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Quick Actions</h2>
                
                <div class="space-y-3">
                    <x-ui.button href="{{ route('admin.bookings.index') }}" class="w-full justify-center bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        New Booking
                    </x-ui.button>
                    
                    <x-ui.button href="{{ route('admin.customers') }}" variant="outline" size="sm" class="w-full justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Manage Customers
                    </x-ui.button>
                    
                    <x-ui.button href="{{ route('admin.services') }}" variant="outline" size="sm" class="w-full justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Manage Services
                    </x-ui.button>
                    
                    <x-ui.button href="{{ route('admin.deals') }}" variant="outline" size="sm" class="w-full justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        Manage Deals
                    </x-ui.button>
                    
                    <x-ui.button href="{{ route('admin.dashboard') }}" variant="outline" size="sm" class="w-full justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Dashboard Analytics
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
                        <p class="text-sm font-medium text-green-600">Today's Revenue</p>
                        <p class="text-lg font-bold text-green-900">${{ number_format($stats['today_revenue'], 2) }}</p>
                    </div>
                    <div class="text-green-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
                
                <div class="flex justify-between items-center p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-blue-600">Average Booking Value</p>
                        <p class="text-lg font-bold text-blue-900">${{ number_format($stats['avg_booking_value'], 2) }}</p>
                    </div>
                    <div class="text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>

                <div class="flex justify-between items-center p-4 bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-purple-600">New Customers Today</p>
                        <p class="text-lg font-bold text-purple-900">{{ number_format($stats['new_customers_today']) }}</p>
                    </div>
                    <div class="text-purple-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                </div>

                <div class="flex justify-between items-center p-4 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-yellow-600">Completed Bookings</p>
                        <p class="text-lg font-bold text-yellow-900">{{ number_format($stats['completed_bookings']) }}</p>
                    </div>
                    <div class="text-yellow-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
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
                @if($popularServices->count() > 0)
                    <div class="space-y-3">
                        @foreach($popularServices as $service)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $service->service_name }}</p>
                                    <p class="text-sm text-gray-500">Service ID: {{ $service->service_id }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-primary-600">{{ $service->booking_count }} bookings</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">No service data available yet.</p>
                @endif
            </div>

            {{-- Top Staff section commented out until staff management is implemented --}}
            {{-- 
            <!-- Top Staff -->
            <div>
                <h3 class="text-lg font-medium text-gray-800 mb-3">Top Performing Staff</h3>
                <p class="text-gray-500 text-sm">Staff performance tracking coming soon.</p>
            </div>
            --}}
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
                <div class="text-2xl font-bold text-blue-600">{{ $stats['todays_bookings'] }}</div>
                <div class="text-sm text-blue-800">Today's Bookings</div>
            </div>
            
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <div class="text-2xl font-bold text-green-600">{{ $stats['confirmed_bookings'] }}</div>
                <div class="text-sm text-green-800">Confirmed</div>
            </div>
            
            <div class="text-center p-4 bg-yellow-50 rounded-lg">
                <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending_bookings'] }}</div>
                <div class="text-sm text-yellow-800">Pending</div>
            </div>
            
            <div class="text-center p-4 bg-purple-50 rounded-lg">
                <div class="text-2xl font-bold text-purple-600">{{ $stats['active_services'] }}</div>
                <div class="text-sm text-purple-800">Active Services</div>
            </div>
        </div>
    </x-ui.card>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Salon theme colors
const salonColors = {
    rose: '#f43f5e',
    pink: '#ec4899',
    lightRose: '#fda4af',
    lightPink: '#f9a8d4',
    green: '#10b981',
    yellow: '#f59e0b',
    blue: '#3b82f6',
    purple: '#8b5cf6'
};

// Booking Trends Chart (Line Chart)
const trendsCtx = document.getElementById('bookingTrendsChart').getContext('2d');
const bookingTrendsData = @json($bookingTrends);
const trendsLabels = bookingTrendsData.map(item => `${item.year}-${item.month.padStart(2, '0')}`);
const trendsValues = bookingTrendsData.map(item => item.count);

const bookingTrendsChart = new Chart(trendsCtx, {
    type: 'line',
    data: {
        labels: trendsLabels,
        datasets: [{
            label: 'Bookings',
            data: trendsValues,
            borderColor: salonColors.rose,
            backgroundColor: salonColors.lightRose + '20',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: salonColors.rose,
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: '#f1f5f9'
                },
                ticks: {
                    color: '#64748b'
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    color: '#64748b'
                }
            }
        }
    }
});

// Status Distribution Chart (Doughnut Chart)
const statusCtx = document.getElementById('statusDistributionChart').getContext('2d');
const statusData = @json($bookingStatusDistribution);
const statusDistributionChart = new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: Object.keys(statusData),
        datasets: [{
            data: Object.values(statusData),
            backgroundColor: [
                salonColors.green,
                salonColors.yellow,
                salonColors.blue,
                salonColors.purple
            ],
            borderWidth: 0,
            hoverOffset: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    usePointStyle: true,
                    color: '#374151'
                }
            }
        }
    }
});

// Popular Services Chart (Horizontal Bar Chart)
const servicesCtx = document.getElementById('popularServicesChart').getContext('2d');
const servicesData = @json($popularServices);
const servicesLabels = servicesData.map(item => item.service_name);
const servicesValues = servicesData.map(item => item.booking_count);

const popularServicesChart = new Chart(servicesCtx, {
    type: 'bar',
    data: {
        labels: servicesLabels,
        datasets: [{
            label: 'Bookings',
            data: servicesValues,
            backgroundColor: [
                salonColors.rose,
                salonColors.pink,
                salonColors.lightRose,
                salonColors.lightPink,
                salonColors.purple
            ],
            borderRadius: 8,
            borderSkipped: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        indexAxis: 'y',
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            x: {
                beginAtZero: true,
                grid: {
                    color: '#f1f5f9'
                },
                ticks: {
                    color: '#64748b'
                }
            },
            y: {
                grid: {
                    display: false
                },
                ticks: {
                    color: '#64748b',
                    maxTicksLimit: 5
                }
            }
        }
    }
});
</script>
@endsection