<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::with(['user', 'appointments.service', 'orders'])
            ->withCount(['appointments', 'orders'])
            ->withSum('orders', 'total_amount')
            ->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:500',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create user first
        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'customer',
        ]);

        // Create customer profile
        Customer::create([
            'user_id' => $user->id,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone' => $validated['phone'],
            'date_of_birth' => $validated['date_of_birth'],
            'address' => $validated['address'],
        ]);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $customer->load([
            'user',
            'appointments.service',
            'appointments.staff',
            'orders.orderItems.service'
        ]);

        $stats = [
            'total_appointments' => $customer->appointments()->count(),
            'completed_appointments' => $customer->appointments()->where('status', 'completed')->count(),
            'total_spent' => $customer->orders()->sum('total_amount'),
            'avg_order_value' => $customer->orders()->avg('total_amount') ?? 0,
        ];

        return view('admin.customers.show', compact('customer', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $customer->user_id,
            'phone' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:500',
        ]);

        // Update user
        $customer->user->update([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
        ]);

        // Update customer profile
        $customer->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone' => $validated['phone'],
            'date_of_birth' => $validated['date_of_birth'],
            'address' => $validated['address'],
        ]);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        // Check if customer has any pending appointments
        $pendingAppointments = $customer->appointments()->whereIn('status', ['pending', 'confirmed'])->count();
        
        if ($pendingAppointments > 0) {
            return redirect()->route('admin.customers.index')
                ->with('error', 'Cannot delete customer with pending appointments.');
        }

        // Delete user and customer (cascade will handle relationships)
        $customer->user->delete();
        
        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully!');
    }
}
