<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Service;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $stats = [
            'total_customers' => Customer::count(),
            'total_staff' => Staff::where('is_active', true)->count(),
            'total_services' => Service::where('is_active', true)->count(),
            'total_appointments' => Appointment::count(),
            'todays_appointments' => Appointment::whereDate('appointment_date', today())->count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
            'monthly_revenue' => Order::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total_amount'),
            'weekly_revenue' => Order::whereBetween('created_at', [
                now()->startOfWeek(), 
                now()->endOfWeek()
            ])->sum('total_amount'),
            'new_customers_this_month' => Customer::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'vip_customers' => Customer::where('total_spent', '>', 1000)->count(), // VIP customers with $1000+ spent
            'active_staff' => Staff::where('is_active', true)->count(),
            'completed_appointments_today' => Appointment::whereDate('appointment_date', today())
                ->where('status', 'completed')
                ->count(),
            'avg_appointment_value' => Order::avg('total_amount') ?? 0,
        ];

        $recentAppointments = Appointment::with(['customer', 'staff', 'service'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Additional analytics data
        $topServices = Service::withCount('appointmentServices')
            ->where('is_active', true)
            ->orderBy('appointment_services_count', 'desc')
            ->take(5)
            ->get();

        $topStaff = Staff::withCount('appointments')
            ->where('is_active', true)
            ->orderBy('appointments_count', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.admin', compact('stats', 'recentAppointments', 'topServices', 'topStaff'));
    }

    /**
     * Staff dashboard
     */
    public function staff()
    {
        $user = Auth::user();
        $staffRecord = $user->staff;

        $stats = [
            'todays_appointments' => Appointment::where('staff_id', $staffRecord->id)
                ->whereDate('appointment_date', today())
                ->count(),
            'pending_appointments' => Appointment::where('staff_id', $staffRecord->id)
                ->where('status', 'pending')
                ->count(),
            'completed_appointments' => Appointment::where('staff_id', $staffRecord->id)
                ->where('status', 'completed')
                ->count(),
            'monthly_revenue' => Order::whereHas('appointments', function($query) use ($staffRecord) {
                $query->where('staff_id', $staffRecord->id);
            })
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total_amount'),
        ];

        $appointments = Appointment::with(['customer', 'service'])
            ->where('staff_id', $staffRecord->id)
            ->whereDate('appointment_date', today())
            ->orderBy('appointment_time')
            ->get();

        return view('dashboard.staff', compact('stats', 'appointments'));
    }

    /**
     * Customer dashboard
     */
    public function customer()
    {
        $user = Auth::user();
        $customerRecord = $user->customer;

        $stats = [
            'total_appointments' => Appointment::where('customer_id', $customerRecord->id)->count(),
            'upcoming_appointments' => Appointment::where('customer_id', $customerRecord->id)
                ->where('appointment_date', '>=', today())
                ->count(),
            'total_orders' => Order::where('customer_id', $customerRecord->id)->count(),
            'total_spent' => Order::where('customer_id', $customerRecord->id)->sum('total_amount'),
        ];

        $upcomingAppointments = Appointment::with(['staff', 'service'])
            ->where('customer_id', $customerRecord->id)
            ->where('appointment_date', '>=', today())
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->take(3)
            ->get();

        $recentOrders = Order::with('orderItems.service')
            ->where('customer_id', $customerRecord->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('dashboard.customer', compact('stats', 'upcomingAppointments', 'recentOrders'));
    }
}
