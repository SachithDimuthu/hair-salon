@extends('layouts.app')

@section('title', 'Manage Staff')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-serif font-bold text-gray-900">Staff Management</h1>
            <p class="text-gray-600 mt-1">Manage your salon team members and their information</p>
        </div>
        <x-ui.button href="{{ route('admin.staff.create') }}" variant="primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add New Staff Member
        </x-ui.button>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Search and Filters -->
    <x-ui.card>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Search Staff</h3>
        </div>
        
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <x-ui.input 
                type="text" 
                name="search" 
                placeholder="Search by name or specialization..." 
                value="{{ request('search') }}"
            />
            
            <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 focus:border-primary-500 focus:ring-primary-500">
                <option value="">All Staff</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            
            <select name="sort" class="border border-gray-300 rounded-lg px-3 py-2 focus:border-primary-500 focus:ring-primary-500">
                <option value="">Sort By</option>
                <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name</option>
                <option value="hire_date" {{ request('sort') === 'hire_date' ? 'selected' : '' }}>Hire Date</option>
                <option value="specialization" {{ request('sort') === 'specialization' ? 'selected' : '' }}>Specialization</option>
                <option value="commission" {{ request('sort') === 'commission' ? 'selected' : '' }}>Commission Rate</option>
            </select>
            
            <div class="flex space-x-2">
                <x-ui.button type="submit" variant="outline" size="sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Search
                </x-ui.button>
                <x-ui.button href="{{ route('admin.staff.index') }}" variant="ghost" size="sm">
                    Clear
                </x-ui.button>
            </div>
        </form>
    </x-ui.card>

    <!-- Staff Grid -->
    @if($staff->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($staff as $member)
                <x-ui.card class="hover:shadow-lg transition-shadow">
                    <div class="text-center">
                        <!-- Avatar -->
                        <div class="w-20 h-20 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-primary-600 font-bold text-xl">
                                {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                            </span>
                        </div>

                        <!-- Basic Info -->
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">
                            {{ $member->first_name }} {{ $member->last_name }}
                        </h3>
                        <p class="text-primary-600 font-medium mb-2">{{ ucfirst($member->position) }}</p>

                        <!-- Status Badge -->
                        <div class="mb-4">
                            @if($member->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Inactive
                                </span>
                            @endif
                        </div>

                        <!-- Specializations -->
                        @if($member->specializations && count($member->specializations) > 0)
                            <div class="mb-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach(array_slice($member->specializations, 0, 2) as $specialization)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-primary-100 text-primary-800">
                                            {{ $specialization }}
                                        </span>
                                    @endforeach
                                    @if(count($member->specializations) > 2)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                            +{{ count($member->specializations) - 2 }} more
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Stats -->
                        <div class="grid grid-cols-2 gap-4 mb-4 text-center">
                            <div>
                                <div class="text-lg font-bold text-gray-900">{{ $member->employee_id }}</div>
                                <div class="text-xs text-gray-500">Employee ID</div>
                            </div>
                            <div>
                                <div class="text-lg font-bold text-green-600">
                                    @if($member->commission_rate)
                                        {{ number_format($member->commission_rate) }}%
                                    @else
                                        --
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500">Commission</div>
                            </div>
                        </div>

                        <!-- Contact Info -->
                        <div class="space-y-2 mb-4 text-sm text-gray-600">
                            <div class="flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="truncate">{{ $member->user->email }}</span>
                            </div>
                            <div class="flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span>{{ $member->phone }}</span>
                            </div>
                            <div class="flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>Since {{ $member->hire_date->format('M Y') }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-2">
                            <x-ui.button 
                                href="{{ route('admin.staff.show', $member) }}" 
                                variant="outline" 
                                size="xs"
                                class="flex-1"
                            >
                                View
                            </x-ui.button>
                            <x-ui.button 
                                href="{{ route('admin.staff.edit', $member) }}" 
                                variant="ghost" 
                                size="xs"
                                class="flex-1"
                            >
                                Edit
                            </x-ui.button>
                        </div>
                    </div>
                </x-ui.card>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $staff->appends(request()->query())->links() }}
        </div>
    @else
        <x-ui.card class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No staff members found</h3>
            <p class="text-gray-500 mb-6">
                @if(request()->hasAny(['search', 'status', 'sort']))
                    No staff members match your search criteria. Try adjusting your filters.
                @else
                    Get started by adding your first team member to the salon.
                @endif
            </p>
            <x-ui.button href="{{ route('admin.staff.create') }}" variant="primary">
                Add First Staff Member
            </x-ui.button>
        </x-ui.card>
    @endif

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <x-ui.card class="bg-gradient-to-r from-blue-50 to-blue-100 border-blue-200">
            <div class="text-center">
                <div class="text-3xl font-bold text-blue-600">{{ $staff->total() }}</div>
                <div class="text-blue-600 font-medium">Total Staff</div>
            </div>
        </x-ui.card>

        <x-ui.card class="bg-gradient-to-r from-green-50 to-green-100 border-green-200">
            <div class="text-center">
                <div class="text-3xl font-bold text-green-600">
                    {{ $staff->where('is_active', true)->count() }}
                </div>
                <div class="text-green-600 font-medium">Active Staff</div>
            </div>
        </x-ui.card>

        <x-ui.card class="bg-gradient-to-r from-purple-50 to-purple-100 border-purple-200">
            <div class="text-center">
                <div class="text-3xl font-bold text-purple-600">
                    {{ $staff->where('hire_date', '>=', now()->startOfMonth())->count() }}
                </div>
                <div class="text-purple-600 font-medium">New This Month</div>
            </div>
        </x-ui.card>

        <x-ui.card class="bg-gradient-to-r from-yellow-50 to-yellow-100 border-yellow-200">
            <div class="text-center">
                <div class="text-3xl font-bold text-yellow-600">
                    {{ number_format($staff->avg('commission_rate'), 1) }}%
                </div>
                <div class="text-yellow-600 font-medium">Avg Commission</div>
            </div>
        </x-ui.card>
    </div>
</div>
@endsection