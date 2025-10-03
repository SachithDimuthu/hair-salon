<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class CustomerDashboard extends Component
{
    public $stats = [];
    public $upcomingAppointments;
    public $recentOrders;

    protected $listeners = ['bookingCreated' => 'refreshData'];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $user = Auth::user();
        
        // Get real booking data for the authenticated customer
        $userBookings = Booking::where('customer_id', $user->id)->get();
        $upcomingBookings = $userBookings->where('booking_date', '>=', now()->format('Y-m-d'))
                                       ->where('status', '!=', 'cancelled')
                                       ->sortBy('booking_date');
        
        // Calculate real customer statistics
        $this->stats = [
            'total_appointments' => $userBookings->count(),
            'upcoming_appointments' => $upcomingBookings->count(),
            'total_orders' => $userBookings->where('status', 'completed')->count(),
            'total_spent' => $userBookings->where('status', 'completed')->sum('total_price'),
        ];
        
        // Get upcoming appointments with service relationships
        $this->upcomingAppointments = $upcomingBookings->take(5);
        $this->recentOrders = $userBookings->where('status', 'completed')
                                   ->sortByDesc('booking_date')
                                   ->take(5);
    }

    public function refreshData()
    {
        $this->loadData();
        $this->dispatch('dashboardUpdated');
    }

    public function render()
    {
        return view('livewire.customer-dashboard');
    }
}