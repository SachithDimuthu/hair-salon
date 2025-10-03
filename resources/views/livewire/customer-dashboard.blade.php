<div class="space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-rose-50/80 to-pink-50/80 backdrop-blur-sm rounded-2xl shadow-lg border border-rose-200/50 p-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-serif font-bold bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent">Welcome back, {{ auth()->user()->name }}!</h1>
                <p class="text-rose-700/80 mt-2 text-lg">We're excited to see you again</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-rose-600/70 font-medium">{{ now()->format('l, F j, Y') }}</p>
                <x-ui.button href="{{ route('appointments.create') }}" variant="primary" size="sm" class="mt-2 bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 shadow-lg">
                    Book Appointment
                </x-ui.button>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Appointments -->
        <x-ui.card class="bg-gradient-to-br from-rose-50/80 to-pink-50/80 backdrop-blur-sm border-rose-200/50 shadow-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-br from-rose-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-rose-600">Total Appointments</p>
                    <p class="text-2xl font-bold text-rose-900">{{ number_format($stats['total_appointments']) }}</p>
                </div>
            </div>
        </x-ui.card>

        <!-- Upcoming Appointments -->
        <x-ui.card class="bg-gradient-to-br from-emerald-50/80 to-teal-50/80 backdrop-blur-sm border-emerald-200/50 shadow-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-emerald-600">Upcoming Appointments</p>
                    <p class="text-2xl font-bold text-emerald-900">{{ number_format($stats['upcoming_appointments']) }}</p>
                </div>
            </div>
        </x-ui.card>

        <!-- Total Orders -->
        <x-ui.card class="bg-gradient-to-br from-violet-50/80 to-purple-50/80 backdrop-blur-sm border-violet-200/50 shadow-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-br from-violet-500 to-purple-500 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-violet-600">Total Orders</p>
                    <p class="text-2xl font-bold text-violet-900">{{ number_format($stats['total_orders']) }}</p>
                </div>
            </div>
        </x-ui.card>

        <!-- Total Spent -->
        <x-ui.card class="bg-gradient-to-br from-amber-50/80 to-orange-50/80 backdrop-blur-sm border-amber-200/50 shadow-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-amber-600">Total Spent</p>
                    <p class="text-2xl font-bold text-amber-900">LKR {{ number_format($stats['total_spent'], 2) }}</p>
                </div>
            </div>
        </x-ui.card>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Upcoming Appointments -->
        <div class="lg:col-span-2">
            <x-ui.card class="bg-gradient-to-br from-white/80 to-rose-50/50 backdrop-blur-sm border-rose-200/30 shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent">Upcoming Appointments</h2>
                    <x-ui.button href="{{ route('appointments.index') }}" variant="outline" size="sm" class="border-rose-300 text-rose-600 hover:bg-rose-50">
                        View All
                    </x-ui.button>
                </div>

                @if($upcomingAppointments->count() > 0)
                    <div class="space-y-4">
                        @foreach($upcomingAppointments as $appointment)
                            <div class="flex items-center justify-between p-4 border border-rose-200/50 rounded-xl hover:shadow-md transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                <div class="flex items-center space-x-4">
                                    <div class="text-center">
                                        <p class="text-lg font-bold text-rose-600">
                                            {{ \Carbon\Carbon::parse($appointment->booking_date)->format('j') }}
                                        </p>
                                        <p class="text-xs text-rose-500 uppercase">
                                            {{ \Carbon\Carbon::parse($appointment->booking_date)->format('M') }}
                                        </p>
                                    </div>
                                    <div class="w-12 h-12 bg-gradient-to-br from-rose-100 to-pink-100 rounded-full flex items-center justify-center">
                                        <span class="text-rose-600 font-semibold text-sm">
                                            {{ substr($appointment->service_name, 0, 2) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $appointment->service_name }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $appointment->customer_first_name }} {{ $appointment->customer_last_name }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($appointment->booking_time)->format('g:i A') }} • {{ $appointment->duration_minutes }} min
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900">LKR {{ number_format($appointment->total_price, 2) }}</p>
                                    <div class="mt-2 space-x-1">
                                        @if(\Carbon\Carbon::parse($appointment->booking_date)->isAfter(now()->addDay()))
                                            <x-ui.button 
                                                href="#" 
                                                variant="outline" 
                                                size="xs"
                                                class="border-rose-300 text-rose-600 hover:bg-rose-50"
                                            >
                                                Reschedule
                                            </x-ui.button>
                                        @endif
                                        <x-ui.button 
                                            href="#" 
                                            variant="ghost" 
                                            size="xs"
                                            class="text-rose-600 hover:bg-rose-50"
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
                        <svg class="w-16 h-16 text-rose-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No upcoming appointments</h3>
                        <p class="text-gray-500 mb-4">Book your next appointment to maintain your beautiful look!</p>
                        <x-ui.button href="{{ route('appointments.create') }}" variant="primary" class="bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600">
                            Book Now
                        </x-ui.button>
                    </div>
                @endif
            </x-ui.card>
        </div>

        <!-- Quick Actions & Account -->
        <div class="space-y-6">
            <!-- Quick Book -->
            <x-ui.card class="bg-gradient-to-br from-rose-50/80 to-pink-50/80 backdrop-blur-sm border-rose-200/50 shadow-lg">
                <h3 class="text-lg font-semibold bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent mb-4">Quick Book</h3>
                <p class="text-rose-700/80 mb-4">Ready for your next beauty session?</p>
                
                <div class="space-y-3">
                    <x-ui.button href="{{ route('appointments.create') }}" variant="primary" size="sm" class="w-full bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 shadow-lg">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        New Appointment
                    </x-ui.button>
                    
                    <x-ui.button href="{{ route('services') }}" variant="outline" size="sm" class="w-full border-rose-300 text-rose-600 hover:bg-rose-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Browse Services
                    </x-ui.button>
                </div>
            </x-ui.card>

            <!-- Account Menu -->
            <x-ui.card class="bg-gradient-to-br from-white/80 to-rose-50/50 backdrop-blur-sm border-rose-200/30 shadow-lg">
                <h3 class="text-lg font-semibold bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent mb-4">My Account</h3>
                
                <div class="space-y-2">
                    <a href="{{ route('profile.show') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-rose-50 transition-colors">
                        <svg class="w-4 h-4 mr-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Edit Profile
                    </a>
                    
                    <a href="{{ route('appointments.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-rose-50 transition-colors">
                        <svg class="w-4 h-4 mr-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2v12a2 2 0 002 2z"></path>
                        </svg>
                        My Appointments
                    </a>
                    
                    <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-rose-50 transition-colors">
                        <svg class="w-4 h-4 mr-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Preferences
                    </a>
                </div>
            </x-ui.card>
        </div>
    </div>
</div>