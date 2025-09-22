@extends('admin.layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.services.index') }}" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $service->name }}</h1>
                    <p class="text-gray-600 mt-1">Service Details</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.services.edit', $service) }}" class="x-ui.button bg-primary-600 hover:bg-primary-700 text-white">
                    Edit Service
                </a>
                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this service?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="x-ui.button bg-red-600 hover:bg-red-700 text-white">
                        Delete Service
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Service Information -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Service Information</h3>
                    </div>
                    <div class="px-6 py-5">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Service Name</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $service->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Category</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $service->category->name ?? 'No Category' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Slug</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $service->slug }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Sort Order</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $service->sort_order }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Base Price</dt>
                                <dd class="mt-1 text-sm text-gray-900">${{ number_format($service->base_price, 2) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Duration</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $service->duration_minutes }} minutes</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    @if($service->is_active)
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
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Consultation Required</dt>
                                <dd class="mt-1">
                                    @if($service->requires_consultation)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Yes
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                            No
                                        </span>
                                    @endif
                                </dd>
                            </div>
                        </dl>

                        <!-- Description -->
                        @if($service->description)
                            <div class="mt-6">
                                <dt class="text-sm font-medium text-gray-500 mb-2">Description</dt>
                                <dd class="text-sm text-gray-900 whitespace-pre-line">{{ $service->description }}</dd>
                            </div>
                        @endif

                        <!-- Timestamps -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $service->created_at->format('M d, Y \a\t g:i A') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $service->updated_at->format('M d, Y \a\t g:i A') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Staff Assignments -->
                <div class="bg-white shadow rounded-lg mt-8">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Staff Assignments</h3>
                    </div>
                    <div class="px-6 py-5">
                        @if($service->staff->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($service->staff as $staffMember)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                                                    <span class="text-primary-600 font-medium text-sm">
                                                        {{ substr($staffMember->first_name, 0, 1) }}{{ substr($staffMember->last_name, 0, 1) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $staffMember->first_name }} {{ $staffMember->last_name }}
                                                </p>
                                                <p class="text-sm text-gray-500">{{ ucfirst($staffMember->position) }}</p>
                                                @if($staffMember->pivot->price_override)
                                                    <p class="text-sm text-green-600 font-medium">
                                                        Custom Price: ${{ number_format($staffMember->pivot->price_override, 2) }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">No staff members are currently assigned to this service.</p>
                        @endif
                    </div>
                </div>

                <!-- Appointment History -->
                <div class="bg-white shadow rounded-lg mt-8">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Appointments</h3>
                    </div>
                    <div class="px-6 py-5">
                        <p class="text-gray-500 text-sm">Appointment history will be available once the appointment system is fully implemented.</p>
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
                                <div class="text-sm text-gray-500">Total Bookings</div>
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
                        <form action="{{ route('admin.services.toggleStatus', $service) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            @if($service->is_active)
                                <button type="submit" class="w-full x-ui.button bg-red-600 hover:bg-red-700 text-white">
                                    Deactivate Service
                                </button>
                            @else
                                <button type="submit" class="w-full x-ui.button bg-green-600 hover:bg-green-700 text-white">
                                    Activate Service
                                </button>
                            @endif
                        </form>
                        <button class="w-full x-ui.button bg-primary-600 hover:bg-primary-700 text-white">
                            Assign Staff
                        </button>
                        <button class="w-full x-ui.button bg-gray-600 hover:bg-gray-700 text-white">
                            View Bookings
                        </button>
                    </div>
                </div>

                <!-- Category Information -->
                @if($service->category)
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-5 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Category Info</h3>
                        </div>
                        <div class="px-6 py-5">
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">Name</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $service->category->name }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">Type</span>
                                    <span class="text-sm text-gray-900">{{ ucfirst($service->category->type) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">Status</span>
                                    @if($service->category->is_active)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                            Inactive
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection