<div class="max-w-7xl mx-auto p-6">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Services</h2>
        <p class="text-lg text-gray-600">Discover our range of professional salon services</p>
    </div>

    <!-- Search and Filter Controls -->
    <div class="mb-6 space-y-4">
        <div class="flex flex-col md:flex-row gap-4 items-start md:items-center justify-between">
            <!-- Search Bar -->
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <input type="text" 
                           wire:model.live.debounce.300ms="searchTerm" 
                           placeholder="Search services..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Filter Toggle and Sort -->
            <div class="flex gap-2">
                <button wire:click="toggleFilters" 
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                    Filters
                    @if($showFilters)
                        <svg class="inline w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                    @else
                        <svg class="inline w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    @endif
                </button>

                <select wire:model.live="sortBy" class="px-3 py-2 text-sm border border-gray-300 rounded-md">
                    <option value="name">Sort by Name</option>
                    <option value="base_price">Sort by Price</option>
                    <option value="duration_minutes">Sort by Duration</option>
                </select>
            </div>
        </div>

        <!-- Filters Panel -->
        @if($showFilters)
            <div class="bg-gray-50 p-4 rounded-lg border">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Category Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select wire:model.live="selectedCategory" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Duration Filters -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Min Duration (minutes)</label>
                        <input type="number" wire:model.live="minDuration" placeholder="e.g., 30" 
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Max Duration (minutes)</label>
                        <input type="number" wire:model.live="maxDuration" placeholder="e.g., 120" 
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md">
                    </div>

                    <!-- Clear Filters -->
                    <div class="flex items-end">
                        <button wire:click="clearFilters" 
                                class="w-full px-4 py-2 text-sm text-red-600 border border-red-300 rounded-md hover:bg-red-50">
                            Clear Filters
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Active Filters Display -->
        @if($searchTerm || $selectedCategory || $minDuration || $maxDuration)
            <div class="flex flex-wrap gap-2">
                @if($searchTerm)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                        Search: "{{ $searchTerm }}"
                        <button wire:click="$set('searchTerm', '')" class="ml-1 text-blue-600 hover:text-blue-800">×</button>
                    </span>
                @endif
                @if($selectedCategory)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-800">
                        Category: {{ $categories->find($selectedCategory)->name ?? 'Unknown' }}
                        <button wire:click="$set('selectedCategory', '')" class="ml-1 text-green-600 hover:text-green-800">×</button>
                    </span>
                @endif
            </div>
        @endif
    </div>

    <!-- Services Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
        @forelse($services as $service)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200">
                @if($service->image)
                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" 
                         class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                        <svg class="h-16 w-16 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2M7 21V8a2 2 0 012-2h4a2 2 0 012 2v13"></path>
                        </svg>
                    </div>
                @endif

                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $service->name }}</h3>
                        <span class="text-lg font-bold text-indigo-600">${{ number_format($service->base_price, 2) }}</span>
                    </div>

                    @if($service->category)
                        <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded-full mb-2">
                            {{ $service->category->name }}
                        </span>
                    @endif

                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $service->description }}</p>

                    <div class="flex justify-between items-center text-sm text-gray-500 mb-3">
                        <span class="flex items-center">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $service->duration_minutes }} min
                        </span>
                        
                        @if($service->staff->count() > 0)
                            <span class="flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                {{ $service->staff->count() }} staff
                            </span>
                        @endif
                    </div>

                    @if($service->requires_consultation)
                        <div class="mb-3">
                            <span class="inline-flex items-center px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">
                                <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                Consultation Required
                            </span>
                        </div>
                    @endif

                    <div class="flex gap-2">
                        <button class="flex-1 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Book Now
                        </button>
                        <button class="px-4 py-2 text-indigo-600 border border-indigo-600 text-sm font-medium rounded-md hover:bg-indigo-50">
                            Details
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0012 15c-2.34 0-4.469-.785-6.172-2.109L4.5 11l1.328-1.891A7.962 7.962 0 0012 7c2.34 0 4.469.785 6.172 2.109L19.5 11l-1.328 1.891z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No services found</h3>
                <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter criteria.</p>
                @if($searchTerm || $selectedCategory || $minDuration || $maxDuration)
                    <button wire:click="clearFilters" 
                            class="mt-3 px-4 py-2 text-sm text-indigo-600 hover:text-indigo-800">
                        Clear all filters
                    </button>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($services->hasPages())
        <div class="mt-8">
            {{ $services->links() }}
        </div>
    @endif

    <!-- Results Summary -->
    <div class="mt-4 text-sm text-gray-600 text-center">
        Showing {{ $services->firstItem() ?? 0 }} to {{ $services->lastItem() ?? 0 }} of {{ $services->total() }} services
    </div>
</div>
