@extends('admin.layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Services Management</h1>
                <p class="text-gray-600 mt-1">Manage salon services, pricing, and categories</p>
            </div>
            <a href="{{ route('admin.services.create') }}" class="x-ui.button bg-primary-600 hover:bg-primary-700 text-white">
                Add New Service
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <form method="GET" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-64">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search services..." 
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                </div>
                
                <div class="min-w-48">
                    <select name="category_id" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="min-w-32">
                    <select name="status" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="min-w-32">
                    <input type="number" 
                           name="min_price" 
                           value="{{ request('min_price') }}"
                           placeholder="Min Price" 
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                           step="0.01">
                </div>

                <div class="min-w-32">
                    <input type="number" 
                           name="max_price" 
                           value="{{ request('max_price') }}"
                           placeholder="Max Price" 
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                           step="0.01">
                </div>

                <button type="submit" class="x-ui.button bg-gray-600 hover:bg-gray-700 text-white">
                    Filter
                </button>
                
                @if(request()->hasAny(['search', 'category_id', 'status', 'min_price', 'max_price']))
                    <a href="{{ route('admin.services.index') }}" class="x-ui.button bg-gray-400 hover:bg-gray-500 text-white">
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <!-- Services Grid -->
        @if($services->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                @foreach($services as $service)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                        <!-- Service Header -->
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $service->name }}</h3>
                                    <p class="text-sm text-primary-600 font-medium">{{ $service->category->name ?? 'No Category' }}</p>
                                </div>
                                
                                <!-- Status Badge -->
                                @if($service->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                @endif
                            </div>

                            <!-- Description -->
                            @if($service->description)
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                    {{ Str::limit($service->description, 80) }}
                                </p>
                            @endif

                            <!-- Service Details -->
                            <div class="grid grid-cols-2 gap-4 mb-4 text-center">
                                <div>
                                    <div class="text-lg font-bold text-primary-600">${{ number_format($service->base_price, 2) }}</div>
                                    <div class="text-xs text-gray-500">Price</div>
                                </div>
                                <div>
                                    <div class="text-lg font-bold text-gray-900">{{ $service->duration_minutes }}min</div>
                                    <div class="text-xs text-gray-500">Duration</div>
                                </div>
                            </div>

                            <!-- Additional Info -->
                            <div class="flex items-center justify-between mb-4">
                                @if($service->requires_consultation)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        Consultation Required
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                        Direct Booking
                                    </span>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.services.show', $service) }}" 
                                   class="flex-1 text-center py-2 px-3 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    View
                                </a>
                                <a href="{{ route('admin.services.edit', $service) }}" 
                                   class="flex-1 text-center py-2 px-3 border border-primary-300 rounded-md text-sm font-medium text-primary-700 hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    Edit
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 rounded-lg shadow-sm">
                <div class="flex-1 flex justify-between sm:hidden">
                    @if($services->onFirstPage())
                        <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white cursor-default">
                            Previous
                        </span>
                    @else
                        <a href="{{ $services->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Previous
                        </a>
                    @endif

                    @if($services->hasMorePages())
                        <a href="{{ $services->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Next
                        </a>
                    @else
                        <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white cursor-default">
                            Next
                        </span>
                    @endif
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing <span class="font-medium">{{ $services->firstItem() }}</span> to <span class="font-medium">{{ $services->lastItem() }}</span> of <span class="font-medium">{{ $services->total() }}</span> results
                        </p>
                    </div>
                    <div>
                        {{ $services->links() }}
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No services found</h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if(request()->hasAny(['search', 'category_id', 'status', 'min_price', 'max_price']))
                        Try adjusting your search criteria.
                    @else
                        Get started by creating your first service.
                    @endif
                </p>
                <div class="mt-6">
                    @if(request()->hasAny(['search', 'category_id', 'status', 'min_price', 'max_price']))
                        <a href="{{ route('admin.services.index') }}" class="x-ui.button bg-gray-600 hover:bg-gray-700 text-white">
                            Clear Filters
                        </a>
                    @else
                        <a href="{{ route('admin.services.create') }}" class="x-ui.button bg-primary-600 hover:bg-primary-700 text-white">
                            Add First Service
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection