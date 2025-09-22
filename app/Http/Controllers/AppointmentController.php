<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of customer's appointments.
     */
    public function index()
    {
        $user = Auth::user();
        $customer = $user->customer;

        $appointments = Appointment::with(['staff.user', 'service'])
            ->where('customer_id', $customer->id)
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(10);

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new appointment.
     */
    public function create()
    {
        $services = Service::where('is_active', true)->get();
        $staff = Staff::where('is_active', true)->with('user')->get();

        return view('appointments.create', compact('services', 'staff'));
    }

    /**
     * Store a newly created appointment in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $customer = $user->customer;

        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'staff_id' => 'required|exists:staff,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string|max:500',
        ]);

        // Check if the time slot is available
        $existingAppointment = Appointment::where('staff_id', $validated['staff_id'])
            ->where('appointment_date', $validated['appointment_date'])
            ->where('appointment_time', $validated['appointment_time'])
            ->first();

        if ($existingAppointment) {
            return back()->withErrors(['appointment_time' => 'This time slot is already booked.']);
        }

        $service = Service::find($validated['service_id']);

        Appointment::create([
            'customer_id' => $customer->id,
            'staff_id' => $validated['staff_id'],
            'service_id' => $validated['service_id'],
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'price' => $service->price,
            'status' => 'pending',
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment booked successfully!');
    }

    /**
     * Display the specified appointment.
     */
    public function show(Appointment $appointment)
    {
        $user = Auth::user();
        
        // Ensure customer can only view their own appointments
        if ($user->role === 'customer' && $appointment->customer_id !== $user->customer->id) {
            abort(403);
        }

        $appointment->load(['staff.user', 'service', 'customer.user']);

        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified appointment.
     */
    public function edit(Appointment $appointment)
    {
        $user = Auth::user();
        
        // Ensure customer can only edit their own pending appointments
        if ($user->role === 'customer') {
            if ($appointment->customer_id !== $user->customer->id || $appointment->status !== 'pending') {
                abort(403);
            }
        }

        $services = Service::where('is_active', true)->get();
        $staff = Staff::where('is_active', true)->with('user')->get();

        return view('appointments.edit', compact('appointment', 'services', 'staff'));
    }

    /**
     * Update the specified appointment in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $user = Auth::user();
        
        // Ensure customer can only update their own pending appointments
        if ($user->role === 'customer') {
            if ($appointment->customer_id !== $user->customer->id || $appointment->status !== 'pending') {
                abort(403);
            }
        }

        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'staff_id' => 'required|exists:staff,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string|max:500',
        ]);

        // Check if the new time slot is available (excluding current appointment)
        $existingAppointment = Appointment::where('staff_id', $validated['staff_id'])
            ->where('appointment_date', $validated['appointment_date'])
            ->where('appointment_time', $validated['appointment_time'])
            ->where('id', '!=', $appointment->id)
            ->first();

        if ($existingAppointment) {
            return back()->withErrors(['appointment_time' => 'This time slot is already booked.']);
        }

        $service = Service::find($validated['service_id']);

        $appointment->update([
            'staff_id' => $validated['staff_id'],
            'service_id' => $validated['service_id'],
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'price' => $service->price,
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment updated successfully!');
    }

    /**
     * Remove the specified appointment from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $user = Auth::user();
        
        // Ensure customer can only cancel their own pending appointments
        if ($user->role === 'customer') {
            if ($appointment->customer_id !== $user->customer->id || $appointment->status !== 'pending') {
                abort(403);
            }
        }

        $appointment->update(['status' => 'cancelled']);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment cancelled successfully!');
    }

    /**
     * Staff view of appointments
     */
    public function staffIndex()
    {
        $user = Auth::user();
        $staff = $user->staff;

        $appointments = Appointment::with(['customer.user', 'service'])
            ->where('staff_id', $staff->id)
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(10);

        return view('staff.appointments.index', compact('appointments'));
    }

    /**
     * Staff view of specific appointment
     */
    public function staffShow(Appointment $appointment)
    {
        $user = Auth::user();
        
        // Ensure staff can only view their own appointments (admin can view all)
        if ($user->role === 'staff' && $appointment->staff_id !== $user->staff->id) {
            abort(403);
        }

        $appointment->load(['customer.user', 'service']);

        return view('staff.appointments.show', compact('appointment'));
    }

    /**
     * Staff update of appointment status
     */
    public function staffUpdate(Request $request, Appointment $appointment)
    {
        $user = Auth::user();
        
        // Ensure staff can only update their own appointments (admin can update all)
        if ($user->role === 'staff' && $appointment->staff_id !== $user->staff->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,in_progress,completed,cancelled,no_show',
            'notes' => 'nullable|string|max:500',
        ]);

        $appointment->update($validated);

        return redirect()->route('staff.appointments.index')
            ->with('success', 'Appointment status updated successfully!');
    }
}
