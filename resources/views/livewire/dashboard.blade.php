<div class="min-h-screen bg-gradient-to-br from-rose-50/50 via-white to-pink-50/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8 bg-gradient-to-r from-rose-50/80 to-pink-50/80 backdrop-blur-sm rounded-2xl shadow-lg border border-rose-200/50 p-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-4xl font-serif font-bold bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent">Salon Dashboard</h1>
                    <p class="mt-2 text-rose-700/80 text-lg">Welcome to your salon management dashboard.</p>
                </div>
                <div class="mt-4 sm:mt-0 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('admin.services') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 text-white rounded-xl transition-all duration-200 hover:scale-105 shadow-lg font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                        Services
                    </a>
                    <a href="{{ route('admin.customers') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-violet-500 to-purple-500 hover:from-violet-600 hover:to-purple-600 text-white rounded-xl transition-all duration-200 hover:scale-105 shadow-lg font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                        Customers
                    </a>
                    <a href="{{ route('admin.deals') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white rounded-xl transition-all duration-200 hover:scale-105 shadow-lg font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        Deals
                    </a>
                    <button wire:click="refresh" 
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white rounded-xl transition-all duration-200 hover:scale-105 shadow-lg font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Refresh Data
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="mb-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-gradient-to-br from-rose-50/80 to-pink-50/80 backdrop-blur-sm border border-rose-200/50 p-6 rounded-2xl shadow-lg">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-gradient-to-br from-rose-500 to-pink-500 shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-rose-600">Total Customers</h3>
                        <p class="text-2xl font-bold text-rose-900">{{ $stats['total_customers'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-violet-50/80 to-purple-50/80 backdrop-blur-sm border border-violet-200/50 p-6 rounded-2xl shadow-lg">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-gradient-to-br from-violet-500 to-purple-500 shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-violet-600">Total Bookings</h3>
                        <p class="text-2xl font-bold text-violet-900">{{ $stats['total_bookings'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-emerald-50/80 to-teal-50/80 backdrop-blur-sm border border-emerald-200/50 p-6 rounded-2xl shadow-lg">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-emerald-600">Pending Bookings</h3>
                        <p class="text-2xl font-bold text-emerald-900">{{ $stats['pending_bookings'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-amber-50/80 to-orange-50/80 backdrop-blur-sm border border-amber-200/50 p-6 rounded-2xl shadow-lg">
                <div class="flex items-center">
                    <div class="p-3 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-amber-600">Active Services</h3>
                        <p class="text-2xl font-bold text-amber-900">{{ $stats['visible_services'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="mb-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Service Categories Chart -->
            <div class="bg-gradient-to-br from-white/80 to-rose-50/50 backdrop-blur-sm border border-rose-200/30 p-6 rounded-2xl shadow-lg">
                <h3 class="text-lg font-semibold bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent mb-4">Services by Category</h3>
                <div class="h-64">
                    <canvas id="serviceCategoriesChart"></canvas>
                </div>
            </div>

            <!-- Booking Status Chart -->
            <div class="bg-gradient-to-br from-white/80 to-violet-50/50 backdrop-blur-sm border border-violet-200/30 p-6 rounded-2xl shadow-lg">
                <h3 class="text-lg font-semibold bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent mb-4">Booking Status Distribution</h3>
                <div class="h-64">
                    <canvas id="bookingStatusChart"></canvas>
                </div>
            </div>
        </div>

        <div class="mb-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Popular Services Chart -->
            <div class="bg-gradient-to-br from-white/80 to-emerald-50/50 backdrop-blur-sm border border-emerald-200/30 p-6 rounded-2xl shadow-lg">
                <h3 class="text-lg font-semibold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent mb-4">Most Popular Services</h3>
                <div class="h-64">
                    <canvas id="popularServicesChart"></canvas>
                </div>
            </div>

            <!-- Monthly Trend Chart -->
            <div class="bg-gradient-to-br from-white/80 to-amber-50/50 backdrop-blur-sm border border-amber-200/30 p-6 rounded-2xl shadow-lg">
                <h3 class="text-lg font-semibold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent mb-4">Booking Trends (6 Months)</h3>
                <div class="h-64">
                    <canvas id="monthlyTrendChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Service Categories Pie Chart
    const serviceCategoriesCtx = document.getElementById('serviceCategoriesChart').getContext('2d');
    new Chart(serviceCategoriesCtx, {
        type: 'doughnut',
        data: {
            labels: @json($chartData['serviceCategories']['labels'] ?? []),
            datasets: [{
                data: @json($chartData['serviceCategories']['data'] ?? []),
                backgroundColor: @json($chartData['serviceCategories']['colors'] ?? []),
                borderWidth: 2,
                borderColor: '#ffffff'
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
                        usePointStyle: true
                    }
                }
            }
        }
    });

    // Booking Status Pie Chart
    const bookingStatusCtx = document.getElementById('bookingStatusChart').getContext('2d');
    new Chart(bookingStatusCtx, {
        type: 'pie',
        data: {
            labels: @json($chartData['bookingStatuses']['labels'] ?? []),
            datasets: [{
                data: @json($chartData['bookingStatuses']['data'] ?? []),
                backgroundColor: @json($chartData['bookingStatuses']['colors'] ?? []),
                borderWidth: 2,
                borderColor: '#ffffff'
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
                        usePointStyle: true
                    }
                }
            }
        }
    });

    // Popular Services Bar Chart
    const popularServicesCtx = document.getElementById('popularServicesChart').getContext('2d');
    new Chart(popularServicesCtx, {
        type: 'bar',
        data: {
            labels: @json($chartData['popularServices']['labels'] ?? []),
            datasets: [{
                label: 'Bookings',
                data: @json($chartData['popularServices']['data'] ?? []),
                backgroundColor: 'rgba(244, 63, 94, 0.8)',
                borderColor: 'rgba(244, 63, 94, 1)',
                borderWidth: 1,
                borderRadius: 8
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
                    ticks: {
                        stepSize: 1
                    }
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    });

    // Monthly Trend Line Chart
    const monthlyTrendCtx = document.getElementById('monthlyTrendChart').getContext('2d');
    new Chart(monthlyTrendCtx, {
        type: 'line',
        data: {
            labels: @json($chartData['monthlyTrend']['labels'] ?? []),
            datasets: [{
                label: 'Bookings',
                data: @json($chartData['monthlyTrend']['data'] ?? []),
                borderColor: 'rgba(244, 63, 94, 1)',
                backgroundColor: 'rgba(244, 63, 94, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgba(244, 63, 94, 1)',
                pointBorderColor: '#ffffff',
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
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Listen for Livewire refresh events to update charts
    Livewire.on('refreshed', function() {
        location.reload();
    });
});
</script>
