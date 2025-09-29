<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Deal;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $stats = [];
    public $recentCustomers;
    public $popularServices;
    public $activeDeals;
    public $recentBookings;
    public $chartData = [];

    public function mount()
    {
        $this->loadStats();
        $this->loadRecentData();
        $this->prepareChartData();
    }

    private function loadStats()
    {
        $this->stats = [
            'total_customers' => Customer::count(),
            'total_services' => Service::count(),
            'visible_services' => Service::where('visibility', true)->count(),
            'active_deals' => Deal::where('IsActive', true)->count(),
            'total_bookings' => DB::table('customer_service')->count(),
            'pending_bookings' => DB::table('customer_service')->where('Status', 'booked')->count(),
        ];
    }

    private function loadRecentData()
    {
        // Recent customers (last 10)
        $this->recentCustomers = Customer::latest()->take(5)->get();

        // Popular services (most booked) - Manual calculation for MongoDB compatibility
        $services = Service::where('visibility', true)->get();
        $this->popularServices = $services->map(function ($service) {
            // Count bookings from the customer_service pivot table
            $bookingsCount = DB::table('customer_service')
                ->where('ServiceID', $service->_id)
                ->count();
            
            $service->bookings_count = $bookingsCount;
            return $service;
        })->sortByDesc('bookings_count')->take(5);

        // Active deals - Load deals and manually get service names
        $activeDeals = Deal::where('IsActive', true)
            ->where('StartDate', '<=', now())
            ->where('EndDate', '>=', now())
            ->take(5)
            ->get();
            
        $this->activeDeals = $activeDeals->map(function ($deal) {
            $service = Service::find($deal->ServiceID);
            $deal->service_name = $service ? $service->name : 'Unknown Service';
            return $deal;
        });

        // Recent bookings - Manual approach for MongoDB compatibility
        $recentBookingsData = DB::table('customer_service')
            ->join('customers', 'customer_service.CustomerID', '=', 'customers.CustomerID')
            ->select(
                'customers.CustomerName',
                'customer_service.ServiceID',
                'customer_service.BookedAt',
                'customer_service.Status'
            )
            ->orderBy('customer_service.BookedAt', 'desc')
            ->take(10)
            ->get();

        // Get service names from MongoDB
        $this->recentBookings = $recentBookingsData->map(function ($booking) {
            $service = Service::find($booking->ServiceID);
            $booking->ServiceName = $service ? $service->name : 'Unknown Service';
            return $booking;
        });
    }

    private function prepareChartData()
    {
        // Service categories chart data
        $serviceCategories = Service::where('visibility', true)
            ->get()
            ->groupBy('category')
            ->map(function ($group) {
                return $group->count();
            });

        $this->chartData['serviceCategories'] = [
            'labels' => $serviceCategories->keys()->toArray(),
            'data' => $serviceCategories->values()->toArray(),
            'colors' => ['#f43f5e', '#ec4899', '#d946ef', '#a855f7', '#8b5cf6', '#6366f1']
        ];

        // Bookings status chart data
        $bookingStatuses = DB::table('customer_service')
            ->select('Status', DB::raw('count(*) as count'))
            ->groupBy('Status')
            ->get();

        $this->chartData['bookingStatuses'] = [
            'labels' => $bookingStatuses->pluck('Status')->toArray(),
            'data' => $bookingStatuses->pluck('count')->toArray(),
            'colors' => ['#10b981', '#f59e0b', '#ef4444', '#6b7280']
        ];

        // Popular services chart data (top 6)
        $popularServicesData = $this->popularServices->take(6);
        $this->chartData['popularServices'] = [
            'labels' => $popularServicesData->pluck('name')->toArray(),
            'data' => $popularServicesData->pluck('bookings_count')->toArray(),
            'colors' => ['#f43f5e', '#ec4899', '#d946ef', '#a855f7', '#8b5cf6', '#6366f1']
        ];

        // Monthly bookings trend (last 6 months)
        $monthlyBookings = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = DB::table('customer_service')
                ->whereYear('BookedAt', $date->year)
                ->whereMonth('BookedAt', $date->month)
                ->count();
            
            $monthlyBookings[] = [
                'month' => $date->format('M Y'),
                'count' => $count
            ];
        }

        $this->chartData['monthlyTrend'] = [
            'labels' => collect($monthlyBookings)->pluck('month')->toArray(),
            'data' => collect($monthlyBookings)->pluck('count')->toArray(),
            'color' => '#f43f5e'
        ];
    }

    public function refresh()
    {
        $this->loadStats();
        $this->loadRecentData();
        $this->prepareChartData();
        session()->flash('message', 'Dashboard refreshed successfully!');
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
