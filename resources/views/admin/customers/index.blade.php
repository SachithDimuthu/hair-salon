@extends('layouts.app')

@section('title', 'Manage Customers')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-serif font-bold text-gray-900">Customer Management</h1>
            <p class="text-gray-600 mt-1">Manage customer accounts and view their appointment history</p>
        </div>
        <x-ui.button href="{{ route('admin.customers.create') }}" variant="primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add New Customer
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
            <h3 class="text-lg font-semibold text-gray-900">Search Customers</h3>
        </div>
        
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <x-ui.input 
                type="text" 
                name="search" 
                placeholder="Search by name or email..." 
                value="{{ request('search') }}"
            />
            
            <select name="sort" class="border border-gray-300 rounded-lg px-3 py-2 focus:border-primary-500 focus:ring-primary-500">
                <option value="">Sort By</option>
                <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name</option>
                <option value="email" {{ request('sort') === 'email' ? 'selected' : '' }}>Email</option>
                <option value="appointments" {{ request('sort') === 'appointments' ? 'selected' : '' }}>Total Appointments</option>
                <option value="spent" {{ request('sort') === 'spent' ? 'selected' : '' }}>Total Spent</option>
                <option value="recent" {{ request('sort') === 'recent' ? 'selected' : '' }}>Recently Added</option>
            </select>
            
            <select name="filter" class="border border-gray-300 rounded-lg px-3 py-2 focus:border-primary-500 focus:ring-primary-500">
                <option value="">All Customers</option>
                <option value="active" {{ request('filter') === 'active' ? 'selected' : '' }}>Active (Has Appointments)</option>
                <option value="vip" {{ request('filter') === 'vip' ? 'selected' : '' }}>VIP ($1000+ Spent)</option>
                <option value="new" {{ request('filter') === 'new' ? 'selected' : '' }}>New (This Month)</option>
            </select>
            
            <div class="flex space-x-2">
                <x-ui.button type="submit" variant="outline" size="sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Search
                </x-ui.button>
                <x-ui.button href="{{ route('admin.customers.index') }}" variant="ghost" size="sm">
                    Clear
                </x-ui.button>
            </div>
        </form>
    </x-ui.card>

    <!-- Customers Table -->
    @if($customers->count() > 0)
        <x-ui.card>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Appointments</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Orders</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Spent</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member Since</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($customers as $customer)
                            <tr class="hover:bg-gray-50">
                                <!-- Customer Info -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-full flex items-center justify-center">
                                            <span class="text-primary-600 font-semibold text-sm">
                                                {{ substr($customer->first_name, 0, 1) }}{{ substr($customer->last_name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $customer->first_name }} {{ $customer->last_name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                ID: #{{ $customer->id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Contact -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $customer->user->email }}</div>
                                    <div class="text-sm text-gray-500">{{ $customer->phone }}</div>
                                </td>

                                <!-- Appointments -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-2xl font-bold text-primary-600">{{ $customer->appointments_count }}</div>
                                    <div class="text-xs text-gray-500">Total</div>
                                </td>

                                <!-- Orders -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-2xl font-bold text-secondary-600">{{ $customer->orders_count }}</div>
                                    <div class="text-xs text-gray-500">Orders</div>
                                </td>

                                <!-- Total Spent -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-lg font-bold text-green-600">
                                        ${{ number_format($customer->orders_sum_total_amount ?? 0, 2) }}
                                    </div>
                                    @if(($customer->orders_sum_total_amount ?? 0) >= 1000)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            VIP
                                        </span>
                                    @endif
                                </td>

                                <!-- Member Since -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $customer->created_at->format('M j, Y') }}
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <x-ui.button 
                                            href="{{ route('admin.customers.show', $customer) }}" 
                                            variant="ghost" 
                                            size="xs"
                                        >
                                            View
                                        </x-ui.button>
                                        <x-ui.button 
                                            href="{{ route('admin.customers.edit', $customer) }}" 
                                            variant="ghost" 
                                            size="xs"
                                        >
                                            Edit
                                        </x-ui.button>
                                        <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <x-ui.button 
                                                type="submit" 
                                                variant="ghost" 
                                                size="xs"
                                                onclick="return confirm('Are you sure you want to delete this customer? This action cannot be undone.')"
                                                class="text-red-600 hover:text-red-700"
                                            >
                                                Delete
                                            </x-ui.button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $customers->appends(request()->query())->links() }}
            </div>
        </x-ui.card>
    @else
        <x-ui.card class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No customers found</h3>
            <p class="text-gray-500 mb-6">
                @if(request()->hasAny(['search', 'sort', 'filter']))
                    No customers match your search criteria. Try adjusting your filters.
                @else
                    Get started by adding your first customer to the system.
                @endif
            </p>
            <x-ui.button href="{{ route('admin.customers.create') }}" variant="primary">
                Add First Customer
            </x-ui.button>
        </x-ui.card>
    @endif

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <x-ui.card class="bg-gradient-to-r from-blue-50 to-blue-100 border-blue-200">
            <div class="text-center">
                <div class="text-3xl font-bold text-blue-600">{{ $customers->total() }}</div>
                <div class="text-blue-600 font-medium">Total Customers</div>
            </div>
        </x-ui.card>

        <x-ui.card class="bg-gradient-to-r from-green-50 to-green-100 border-green-200">
            <div class="text-center">
                <div class="text-3xl font-bold text-green-600">
                    {{ $customers->where('orders_sum_total_amount', '>=', 1000)->count() }}
                </div>
                <div class="text-green-600 font-medium">VIP Customers</div>
            </div>
        </x-ui.card>

        <x-ui.card class="bg-gradient-to-r from-purple-50 to-purple-100 border-purple-200">
            <div class="text-center">
                <div class="text-3xl font-bold text-purple-600">
                    {{ $customers->where('created_at', '>=', now()->startOfMonth())->count() }}
                </div>
                <div class="text-purple-600 font-medium">New This Month</div>
            </div>
        </x-ui.card>

        <x-ui.card class="bg-gradient-to-r from-yellow-50 to-yellow-100 border-yellow-200">
            <div class="text-center">
                <div class="text-3xl font-bold text-yellow-600">
                    ${{ number_format($customers->sum('orders_sum_total_amount'), 2) }}
                </div>
                <div class="text-yellow-600 font-medium">Total Revenue</div>
            </div>
        </x-ui.card>
    </div>
</div>
@endsection