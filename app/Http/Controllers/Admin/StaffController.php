<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    /**
     * Display a listing of the staff.
     */
    public function index()
    {
        $staff = Staff::with('user')
            ->orderBy('hire_date', 'desc')
            ->paginate(10);

        return view('admin.staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new staff member.
     */
    public function create()
    {
        return view('admin.staff.create');
    }

    /**
     * Store a newly created staff member in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'max:20'],
            'position' => ['required', 'in:stylist,colorist,manager,receptionist,assistant'],
            'specializations' => ['array'],
            'specializations.*' => ['string'],
            'hire_date' => ['required', 'date'],
            'hourly_rate' => ['nullable', 'numeric', 'min:0'],
            'commission_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'bio' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        // Create user account
        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'staff',
        ]);

        // Generate unique employee ID
        $employeeId = 'EMP' . str_pad(Staff::count() + 1, 4, '0', STR_PAD_LEFT);

        // Create staff record
        Staff::create([
            'user_id' => $user->id,
            'employee_id' => $employeeId,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'position' => $validated['position'],
            'specializations' => $validated['specializations'] ?? [],
            'hire_date' => $validated['hire_date'],
            'hourly_rate' => $validated['hourly_rate'],
            'commission_rate' => $validated['commission_rate'],
            'bio' => $validated['bio'],
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff member created successfully.');
    }

    /**
     * Display the specified staff member.
     */
    public function show(Staff $staff)
    {
        $staff->load('user');
        
        return view('admin.staff.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified staff member.
     */
    public function edit(Staff $staff)
    {
        $staff->load('user');
        return view('admin.staff.edit', compact('staff'));
    }

    /**
     * Update the specified staff member in storage.
     */
    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($staff->user->id ?? 'NULL'),
            'phone' => 'nullable|string|max:20',
            'position' => 'required|in:stylist,colorist,manager,receptionist,assistant',
            'specializations' => 'nullable|array',
            'specializations.*' => 'string',
            'hire_date' => 'nullable|date',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'hourly_rate' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        DB::transaction(function () use ($validated, $staff) {
            // Update user account if exists
            if ($staff->user) {
                $staff->user->update([
                    'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                    'email' => $validated['email'],
                ]);
            } else {
                // Create user account if doesn't exist
                $user = User::create([
                    'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                    'email' => $validated['email'],
                    'password' => Hash::make('password123'), // Default password
                    'role' => 'staff',
                ]);
                $validated['user_id'] = $user->id;
            }

            // Update staff record
            $staff->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'position' => $validated['position'],
                'specializations' => $validated['specializations'] ?? [],
                'hire_date' => $validated['hire_date'],
                'commission_rate' => $validated['commission_rate'],
                'hourly_rate' => $validated['hourly_rate'],
                'is_active' => $validated['is_active'] ?? false,
                'user_id' => $validated['user_id'] ?? $staff->user_id,
            ]);
        });

        return redirect()->route('admin.staff.show', $staff)
            ->with('success', 'Staff member updated successfully!');
    }

    /**
     * Remove the specified staff member from storage.
     */
    public function destroy(Staff $staff)
    {
        DB::transaction(function () use ($staff) {
            // Delete associated user account if exists
            if ($staff->user) {
                $staff->user->delete();
            }
            
            // Delete staff record
            $staff->delete();
        });

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff member deleted successfully!');
    }
}
