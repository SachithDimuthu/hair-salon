<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Main dashboard route - redirects to role-specific dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        return match($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'staff' => redirect()->route('staff.dashboard'),
            'customer' => redirect()->route('customer.dashboard'),
            default => redirect()->route('home')
        };
    }

    /**
     * Admin dashboard
     */
    public function admin()
    {
        // Real-time booking analytics
        $stats = [
            // Booking Statistics
            'total_bookings' => Booking::count(),
            'todays_bookings' => Booking::today()->count(),
            'pending_bookings' => Booking::byStatus('pending')->count(),
            'confirmed_bookings' => Booking::byStatus('confirmed')->count(),
            'completed_bookings' => Booking::byStatus('completed')->count(),
            
            // Revenue Statistics
            'monthly_revenue' => Booking::thisMonth()
                ->whereIn('status', ['confirmed', 'completed'])
                ->sum('total_price'),
            'today_revenue' => Booking::getTodayRevenue(),
            'avg_booking_value' => Booking::whereIn('status', ['confirmed', 'completed'])
                ->avg('total_price') ?? 0,
            
            // Service Statistics
            'total_services' => Service::count(),
            'active_services' => Service::where('Visibility', true)->count(),
            
            // Customer Statistics
            'unique_customers' => Booking::distinct('customer_email')->count(),
            'new_customers_today' => Booking::whereDate('created_at', today())
                ->distinct('customer_email')
                ->count(),
        ];

        // Recent bookings for management table
        $recentBookings = Booking::with(['customer'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Booking status distribution for charts
        $bookingStatusDistribution = Booking::getStatusDistribution();

        // Most popular services based on actual bookings
        $popularServices = Booking::getPopularServices(5);

        // Booking trends for the last 6 months
        $bookingTrends = Booking::getMonthlyTrends(6);

        // Today's upcoming bookings
        $todaysBookings = Booking::today()
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('booking_time')
            ->get();

        return view('dashboard.admin', compact(
            'stats', 
            'recentBookings', 
            'bookingStatusDistribution',
            'popularServices',
            'bookingTrends',
            'todaysBookings'
        ));
    }

    /**
     * Staff dashboard
     */
    public function staff()
    {
        $user = Auth::user();

        $stats = [
            'todays_bookings' => Booking::today()->count(),
            'pending_bookings' => Booking::byStatus('pending')->count(),
            'completed_bookings' => Booking::byStatus('completed')->count(),
            'monthly_revenue' => Booking::getMonthlyRevenue(),
        ];

        $todaysBookings = Booking::today()
            ->orderBy('booking_time')
            ->get();

        return view('dashboard.staff', compact('stats', 'todaysBookings'));
    }

    /**
     * Customer dashboard
     */
    public function customer()
    {
        $user = Auth::user();

        $stats = [
            'total_bookings' => Booking::where('customer_email', $user->email)->count(),
            'upcoming_bookings' => Booking::where('customer_email', $user->email)
                ->where('booking_date', '>=', today())
                ->count(),
            'total_spent' => Booking::where('customer_email', $user->email)
                ->whereIn('status', ['confirmed', 'completed'])
                ->sum('total_price'),
        ];

        $upcomingBookings = Booking::where('customer_email', $user->email)
            ->where('booking_date', '>=', today())
            ->orderBy('booking_date')
            ->orderBy('booking_time')
            ->take(3)
            ->get();

        return view('dashboard.customer', compact('stats', 'upcomingBookings'));
    }
}
