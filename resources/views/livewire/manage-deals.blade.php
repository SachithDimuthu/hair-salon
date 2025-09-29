<div class="max-w-7xl mx-auto p-6 space-y-6">
    <div class="bg-white rounded-2xl shadow-lg border border-rose-100/50 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-rose-500 to-pink-600 text-white p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold mb-2">Manage Deals</h2>
                    <p class="text-rose-100">Create and manage promotional offers</p>
                </div>
                <button wire:click="createDeal" 
                        class="bg-white/20 backdrop-blur-sm border border-white/30 text-white px-6 py-3 rounded-2xl hover:bg-white/30 focus:outline-none focus:ring-4 focus:ring-white/20 transition-all duration-200 hover:scale-105 font-semibold shadow-sm">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New Deal
                </button>
            </div>
        </div>

        <div class="p-6">
            <!-- Success/Error Messages -->
            @if($message)
                <div class="mb-6 p-4 rounded-2xl border-l-4 {{ $messageType === 'success' ? 'bg-green-50 border-green-400 text-green-700' : 'bg-red-50 border-red-400 text-red-700' }} shadow-sm">
                    <div class="flex items-center">
                        @if($messageType === 'success')
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @else
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @endif
                        <span class="font-medium">{{ $message }}</span>
                    </div>
                </div>
            @endif

            <!-- Search -->
            <div class="mb-6">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" wire:model.live="search" placeholder="Search deals by name or description..." 
                           class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-rose-100 focus:border-rose-500 transition-all duration-200 text-gray-900 placeholder-gray-500 bg-gray-50/50 hover:bg-white">
                </div>
            </div>

            <!-- Scroll Hint for Mobile -->
            <div class="block sm:hidden mb-4">
                <div class="flex items-center justify-center bg-blue-50 border border-blue-200 rounded-lg p-3">
                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                    </svg>
                    <span class="text-blue-700 text-sm font-medium">Scroll horizontally to view all columns</span>
                </div>
            </div>

            <!-- Deals Table -->
            <div class="overflow-x-auto overflow-hidden rounded-2xl border border-gray-200 shadow-sm bg-white">
                <div class="min-w-full">
                    <table class="w-full min-w-[1000px] divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider whitespace-nowrap">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider whitespace-nowrap">Deal Details</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider whitespace-nowrap">Service</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider whitespace-nowrap">Discount</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider whitespace-nowrap">Period</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider whitespace-nowrap">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider whitespace-nowrap">Actions</th>
                            </tr>
                        </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($deals as $deal)
                            <tr class="hover:bg-gradient-to-r hover:from-rose-50 hover:to-pink-50 transition-all duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">#{{ substr($deal->id, -8) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center min-w-[200px]">
                                        <div class="w-10 h-10 bg-gradient-to-br from-rose-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-sm mr-3 shadow-sm flex-shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="text-sm font-bold text-gray-900 truncate">{{ $deal->DealName }}</div>
                                            <div class="text-sm text-gray-500 truncate">{{ Str::limit($deal->Description ?? 'No description', 50) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        @if($deal->service)
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 text-rose-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                                </svg>
                                                {{ $deal->service->name }}
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic">No Service</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 shadow-sm border border-green-200/50">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                        {{ $deal->DiscountPercentage }}% OFF
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <div>
                                                <div>{{ \Carbon\Carbon::parse($deal->StartDate)->format('M d') }} - {{ \Carbon\Carbon::parse($deal->EndDate)->format('M d, Y') }}</div>
                                                <div class="text-xs text-gray-500">
                                                    @php
                                                        $daysLeft = \Carbon\Carbon::parse($deal->EndDate)->diffInDays(now(), false);
                                                    @endphp
                                                    @if($daysLeft < 0)
                                                        {{ abs($daysLeft) }} days left
                                                    @else
                                                        Expired
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button wire:click="toggleStatus('{{ $deal->id }}')"
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium transition-all duration-200 hover:scale-105 shadow-sm {{ $deal->IsActive ? 'bg-green-100 text-green-800 hover:bg-green-200 border border-green-200/50' : 'bg-red-100 text-red-800 hover:bg-red-200 border border-red-200/50' }}">
                                        <div class="w-2 h-2 rounded-full mr-2 {{ $deal->IsActive ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                        {{ $deal->IsActive ? 'Active' : 'Inactive' }}
                                    </button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2 min-w-[160px]">
                                        <button wire:click="editDeal('{{ $deal->id }}')" 
                                                class="text-rose-600 hover:text-rose-800 font-semibold hover:bg-rose-50 px-3 py-2 rounded-2xl transition-all duration-200 shadow-sm border border-rose-200/50 hover:border-rose-300 flex-shrink-0">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit
                                        </button>
                                        <button wire:click="deleteDeal('{{ $deal->id }}')" 
                                                onclick="return confirm('Are you sure you want to delete this deal? This action cannot be undone.')"
                                                class="text-red-600 hover:text-red-800 font-semibold hover:bg-red-50 px-3 py-2 rounded-2xl transition-all duration-200 shadow-sm border border-red-200/50 hover:border-red-300 flex-shrink-0">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        <p class="text-gray-500 text-lg font-medium">No deals found</p>
                                        <p class="text-gray-400 text-sm mt-1">Create your first promotional deal or try adjusting your search!</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex justify-center">
                {{ $deals->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg border border-gray-200 transform transition-all duration-300 max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-rose-500 to-pink-600 text-white p-6 rounded-t-2xl">
                    <div class="flex justify-between items-center">
                        <h3 class="text-2xl font-bold">
                            {{ $editingDealId ? 'Edit Deal' : 'Add New Deal' }}
                        </h3>
                        <button wire:click="closeModal" 
                                class="text-white/80 hover:text-white hover:bg-white/20 rounded-full p-2 transition-all duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <form wire:submit="saveDeal" class="space-y-4">
                        <!-- Deal Name -->
                        <div>
                            <label for="dealName" class="block text-sm font-bold text-gray-700 mb-2">Deal Name</label>
                            <input type="text" wire:model="dealName" id="dealName"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-200"
                                   placeholder="Enter deal name">
                            @error('dealName') 
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                            <textarea wire:model="description" id="description" rows="3"
                                      class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-200 resize-none"
                                      placeholder="Describe your promotional deal..."></textarea>
                            @error('description') 
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Service Selection -->
                        <div>
                            <label for="serviceId" class="block text-sm font-bold text-gray-700 mb-2">Service (Optional)</label>
                            <select wire:model="serviceId" id="serviceId"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-200 bg-white">
                                <option value="">Select a service...</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                            @error('serviceId') 
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Discount Percentage -->
                        <div>
                            <label for="discountPercentage" class="block text-sm font-bold text-gray-700 mb-2">Discount Percentage (%)</label>
                            <div class="relative">
                                <input type="number" wire:model="discountPercentage" id="discountPercentage" 
                                       step="0.01" min="0" max="100"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-200"
                                       placeholder="Enter discount percentage">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-gray-500 font-medium">%</span>
                                </div>
                            </div>
                            @error('discountPercentage') 
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Date Range -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Start Date -->
                            <div>
                                <label for="startDate" class="block text-sm font-bold text-gray-700 mb-2">Start Date</label>
                                <input type="date" wire:model="startDate" id="startDate"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-200">
                                @error('startDate') 
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- End Date -->
                            <div>
                                <label for="endDate" class="block text-sm font-bold text-gray-700 mb-2">End Date</label>
                                <input type="date" wire:model="endDate" id="endDate"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-200">
                                @error('endDate') 
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>
                        </div>

                        <!-- Is Active -->
                        <div class="bg-gray-50 p-4 rounded-xl">
                            <label class="flex items-center cursor-pointer">
                                <div class="flex items-center">
                                    <input type="checkbox" wire:model="isActive" 
                                           class="w-4 h-4 rounded border-gray-300 text-purple-600 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200">
                                    <div class="ml-3">
                                        <span class="text-sm font-bold text-gray-700">Deal is Active</span>
                                        <p class="text-xs text-gray-500">Enable this deal for customers to use</p>
                                    </div>
                                </div>
                                @error('isActive') 
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                @enderror
                            </label>
                        </div>

                        <!-- Modal Actions -->
                        <div class="flex justify-end space-x-3 pt-6 border-t border-gray-100">
                            <button type="button" wire:click="resetForm"
                                    class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-100 transition-all duration-200 font-semibold">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-xl hover:from-purple-700 hover:to-pink-700 focus:outline-none focus:ring-4 focus:ring-purple-200 transition-all duration-200 hover:scale-105 font-semibold shadow-md"
                                    wire:loading.attr="disabled">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <span wire:loading.remove>{{ $editingDealId ? 'Update Deal' : 'Create Deal' }}</span>
                                    <span wire:loading>Saving...</span>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
