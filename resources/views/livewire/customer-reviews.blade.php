<div class="max-w-6xl mx-auto p-6">
    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Customer Reviews</h2>
        <p class="text-lg text-gray-600">Manage and display customer feedback</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="flex items-center">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="h-5 w-5 {{ $i <= floor($averageRating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.719c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @endfor
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Average Rating</dt>
                        <dd class="text-2xl font-bold text-gray-900">{{ $averageRating }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Reviews</dt>
                        <dd class="text-2xl font-bold text-gray-900">{{ $totalReviews }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">5 Star Reviews</dt>
                        <dd class="text-2xl font-bold text-gray-900">{{ $ratingDistribution[5]['count'] ?? 0 }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Satisfaction Rate</dt>
                        <dd class="text-2xl font-bold text-gray-900">{{ $totalReviews > 0 ? round((($ratingDistribution[4]['count'] ?? 0) + ($ratingDistribution[5]['count'] ?? 0)) / $totalReviews * 100) : 0 }}%</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Rating Distribution -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Rating Distribution</h3>
        <div class="space-y-3">
            @for($i = 5; $i >= 1; $i--)
                <div class="flex items-center">
                    <div class="flex items-center w-20">
                        <span class="text-sm text-gray-600">{{ $i }}</span>
                        <svg class="h-4 w-4 text-yellow-400 ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.719c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 mx-4">
                        <div class="bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $ratingDistribution[$i]['percentage'] ?? 0 }}%"></div>
                        </div>
                    </div>
                    <span class="text-sm text-gray-600 w-16">{{ $ratingDistribution[$i]['count'] ?? 0 }} ({{ $ratingDistribution[$i]['percentage'] ?? 0 }}%)</span>
                </div>
            @endfor
        </div>
    </div>

    <!-- Search and Filter Controls -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex flex-col md:flex-row gap-4 items-start md:items-end justify-between">
            <div class="flex flex-col md:flex-row gap-4 flex-1">
                <!-- Search -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search Reviews</label>
                    <input type="text" wire:model.live.debounce.300ms="searchTerm" 
                           placeholder="Search by customer name, title, or comment..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>

                <!-- Rating Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                    <select wire:model.live="selectedRating" class="px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">All Ratings</option>
                        @for($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Service Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Service</label>
                    <select wire:model.live="selectedService" class="px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">All Services</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2">
                <button wire:click="clearFilters" 
                        class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50">
                    Clear Filters
                </button>
                <button wire:click="showAddReviewForm" 
                        class="px-4 py-2 text-sm text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                    Add Review
                </button>
            </div>
        </div>
    </div>

    <!-- Reviews List -->
    <div class="space-y-6">
        @forelse($reviews as $review)
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-semibold text-gray-900">
                                {{ $review->title ?: 'Customer Review' }}
                            </h3>
                            <div class="flex items-center space-x-2">
                                @if(!$review->is_approved)
                                    <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Pending Approval</span>
                                @endif
                                <button wire:click="editReview({{ $review->id }})" 
                                        class="text-indigo-600 hover:text-indigo-800 text-sm">
                                    Edit
                                </button>
                                <button wire:click="toggleApproval({{ $review->id }})" 
                                        class="text-{{ $review->is_approved ? 'orange' : 'green' }}-600 hover:text-{{ $review->is_approved ? 'orange' : 'green' }}-800 text-sm">
                                    {{ $review->is_approved ? 'Unapprove' : 'Approve' }}
                                </button>
                                <button wire:click="deleteReview({{ $review->id }})" 
                                        onclick="return confirm('Are you sure you want to delete this review?')"
                                        class="text-red-600 hover:text-red-800 text-sm">
                                    Delete
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center mb-3">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="h-4 w-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.719c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                            </div>
                            <span class="ml-2 text-sm text-gray-600">by {{ $review->customer_name }}</span>
                            <span class="ml-2 text-sm text-gray-400">•</span>
                            <span class="ml-2 text-sm text-gray-400">{{ $review->created_at->format('M j, Y') }}</span>
                            @if($review->service)
                                <span class="ml-2 text-sm text-gray-400">•</span>
                                <span class="ml-2 text-sm text-indigo-600">{{ $review->service->name }}</span>
                            @endif
                        </div>

                        <p class="text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-white rounded-lg shadow">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No reviews found</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by adding the first review.</p>
                <button wire:click="showAddReviewForm" 
                        class="mt-3 px-4 py-2 text-sm text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                    Add Review
                </button>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($reviews->hasPages())
        <div class="mt-8">
            {{ $reviews->links() }}
        </div>
    @endif

    <!-- Review Form Modal -->
    @if($showReviewForm)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-full max-w-lg shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        {{ $editingReview ? 'Edit Review' : 'Add New Review' }}
                    </h3>
                    
                    <form wire:submit="saveReview" class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Customer Name</label>
                                <input type="text" wire:model="customer_name" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('customer_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" wire:model="customer_email" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('customer_email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Title (Optional)</label>
                            <input type="text" wire:model="title" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Rating</label>
                                <select wire:model="rating" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @for($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                                @error('rating') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Service (Optional)</label>
                                <select wire:model="service_id" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Service</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>
                                @error('service_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Comment</label>
                            <textarea wire:model="comment" rows="4" 
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                            @error('comment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" wire:click="closeReviewForm" 
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700">
                                {{ $editingReview ? 'Update Review' : 'Add Review' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
