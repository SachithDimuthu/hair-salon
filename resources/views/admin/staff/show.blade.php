@extends('admin.layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.staff.index') }}" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $staff->first_name }} {{ $staff->last_name }}</h1>
                    <p class="text-gray-600 mt-1">Staff Details</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.staff.edit', $staff) }}" class="x-ui.button bg-primary-600 hover:bg-primary-700 text-white">
                    Edit Staff
                </a>
                <form action="{{ route('admin.staff.destroy', $staff) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this staff member?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="x-ui.button bg-red-600 hover:bg-red-700 text-white">
                        Delete Staff
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Staff Information -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Staff Information</h3>
                    </div>
                    <div class="px-6 py-5">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Employee ID</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $staff->employee_id }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Position</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($staff->position) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $staff->user->email ?? 'Not assigned' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $staff->phone ?? 'Not provided' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Hire Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $staff->hire_date ? $staff->hire_date->format('M d, Y') : 'Not set' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    @if($staff->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Inactive
                                        </span>
                                    @endif
                                </dd>
                            </div>
                        </dl>

                        <!-- Specializations -->
                        @if($staff->specializations && count($staff->specializations) > 0)
                            <div class="mt-6">
                                <dt class="text-sm font-medium text-gray-500 mb-2">Specializations</dt>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($staff->specializations as $specialization)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-100 text-primary-800">
                                            {{ $specialization }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Commission & Pay Information -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h4 class="text-md font-medium text-gray-900 mb-4">Compensation</h4>
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @if($staff->commission_rate)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Commission Rate</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ number_format($staff->commission_rate) }}%</dd>
                                    </div>
                                @endif
                                @if($staff->hourly_rate)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Hourly Rate</dt>
                                        <dd class="mt-1 text-sm text-gray-900">${{ number_format($staff->hourly_rate, 2) }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Appointment History -->
                <div class="bg-white shadow rounded-lg mt-8">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Appointments</h3>
                    </div>
                    <div class="px-6 py-5">
                        <p class="text-gray-500 text-sm">Appointment history will be available once the appointment system is implemented.</p>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Stats -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Performance Stats</h3>
                    </div>
                    <div class="px-6 py-5">
                        <div class="space-y-6">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-primary-600">0</div>
                                <div class="text-sm text-gray-500">Total Appointments</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600">$0.00</div>
                                <div class="text-sm text-gray-500">Total Revenue</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600">0.0</div>
                                <div class="text-sm text-gray-500">Avg Rating</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Quick Actions</h3>
                    </div>
                    <div class="px-6 py-5 space-y-3">
                        <button class="w-full x-ui.button bg-primary-600 hover:bg-primary-700 text-white">
                            Schedule Appointment
                        </button>
                        <button class="w-full x-ui.button bg-gray-600 hover:bg-gray-700 text-white">
                            View Schedule
                        </button>
                        <button class="w-full x-ui.button bg-green-600 hover:bg-green-700 text-white">
                            Process Payment
                        </button>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Account</h3>
                    </div>
                    <div class="px-6 py-5">
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">User Account</span>
                                @if($staff->user)
                                    <span class="text-sm font-medium text-green-600">Linked</span>
                                @else
                                    <span class="text-sm font-medium text-red-600">Not Linked</span>
                                @endif
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">Created</span>
                                <span class="text-sm text-gray-900">{{ $staff->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">Last Updated</span>
                                <span class="text-sm text-gray-900">{{ $staff->updated_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection