<div class="max-w-7xl mx-auto p-6 space-y-6">
    <!-- Main Container Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-rose-100/50 overflow-hidden transition-all duration-300 hover:shadow-xl">
        <!-- Header -->
        <div class="bg-gradient-to-r from-rose-500 to-pink-600 px-6 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold text-white mb-2">Manage Services</h2>
                    <p class="text-rose-100">Create and manage salon services and pricing</p>
                </div>
                <div class="space-x-3">
                    <button wire:click="createService" 
                            class="bg-white/20 backdrop-blur-sm border border-white/30 text-white px-6 py-3 rounded-2xl font-semibold hover:bg-white/30 focus:outline-none focus:ring-4 focus:ring-white/20 transition-all duration-200 hover:scale-105 shadow-sm">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add New Service
                    </button>
                </div>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <!-- Success/Error Messages -->
            @if($message)
                <div class="p-4 rounded-2xl border-l-4 {{ $messageType === 'success' ? 'bg-green-50 border-green-400 text-green-800' : 'bg-red-50 border-red-400 text-red-800' }} transition-all duration-300 shadow-sm">
                    <div class="flex items-center">
                        @if($messageType === 'success')
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        @else
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                        <span class="font-medium">{{ $message }}</span>
                    </div>
                </div>
            @endif

            <!-- Search -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" wire:model.live="search" 
                       placeholder="Search services by name or description..." 
                       class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-rose-100 focus:border-rose-500 transition-all duration-200 text-gray-900 placeholder-gray-500 bg-gray-50/50 hover:bg-white">
            </div>

            <!-- Services Table -->
            <div class="bg-gray-50/50 rounded-2xl overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Photo</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Duration</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Visibility</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($services as $service)
                                <tr class="hover:bg-gradient-to-r hover:from-rose-50 hover:to-pink-50 transition-all duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ substr($service->_id, -8) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($service->image)
                                            <img src="{{ asset($service->image) }}" alt="{{ $service->name }}" 
                                                 class="w-12 h-12 object-cover rounded-2xl shadow-sm">
                                        @else
                                            <div class="w-12 h-12 bg-gradient-to-br from-rose-100 to-pink-100 rounded-2xl flex items-center justify-center shadow-sm">
                                                <svg class="w-6 h-6 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $service->name }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($service->description, 40) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gradient-to-r from-rose-100 to-pink-100 text-rose-800">
                                            {{ $service->category ?? 'Uncategorized' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                        {{ (is_array($service->durations) && count($service->durations) > 0 && isset($service->durations[0]['minutes'])) ? $service->durations[0]['minutes'] : '60' }} min
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                                        Rs.{{ number_format((float)$service->base_price, 0) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button wire:click="toggleVisibility('{{ $service->_id }}')"
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium transition-all duration-200 hover:scale-105 shadow-sm {{ $service->visibility ? 'bg-green-100 text-green-800 hover:bg-green-200 border border-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200 border border-red-200' }}">
                                            @if($service->visibility)
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                                </svg>
                                                Visible
                                            @else
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd"/>
                                                    <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"/>
                                                </svg>
                                                Hidden
                                            @endif
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <button wire:click="editService('{{ $service->_id }}')" 
                                                class="inline-flex items-center px-3 py-2 rounded-2xl text-rose-600 hover:text-rose-800 hover:bg-rose-50 border border-rose-200/50 hover:border-rose-300 transition-all duration-200 hover:scale-105 shadow-sm font-semibold">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit
                                        </button>
                                        <button wire:click="deleteService('{{ $service->_id }}')" 
                                                onclick="return confirm('Are you sure you want to delete this service? This action cannot be undone.')"
                                                class="inline-flex items-center px-3 py-2 rounded-2xl text-red-600 hover:text-red-800 hover:bg-red-50 border border-red-200/50 hover:border-red-300 transition-all duration-200 hover:scale-105 shadow-sm font-semibold">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                            <p class="text-gray-500 text-lg font-medium">No services found</p>
                                            <p class="text-gray-400 text-sm mt-1">Try adjusting your search criteria or add a new service</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $services->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-screen overflow-y-auto border border-gray-200">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-rose-500 to-pink-600 px-6 py-6 rounded-t-2xl">
                    <div class="flex justify-between items-center">
                        <h3 class="text-2xl font-bold text-white">
                            {{ $editingServiceId ? 'Edit Service' : 'Add New Service' }}
                        </h3>
                        <button wire:click="resetForm" class="text-white/80 hover:text-white hover:bg-white/20 rounded-full p-2 transition-all duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <form wire:submit="saveService" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Service Name -->
                            <div class="md:col-span-2">
                                <label for="serviceName" class="block text-sm font-bold text-gray-700 mb-2">Service Name</label>
                                <input type="text" wire:model="serviceName" id="serviceName"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-rose-100 focus:border-rose-500 transition-all duration-200 bg-gray-50/50 hover:bg-white"
                                       placeholder="Enter service name">
                                @error('serviceName') 
                                    <span class="text-red-500 text-sm mt-1 block flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </span> 
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                                <textarea wire:model="description" id="description" rows="3"
                                          class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-rose-100 focus:border-rose-500 transition-all duration-200 bg-gray-50/50 hover:bg-white resize-none"
                                          placeholder="Describe the service"></textarea>
                                @error('description') 
                                    <span class="text-red-500 text-sm mt-1 block flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </span> 
                                @enderror
                            </div>

                            <!-- Price -->
                            <div>
                                <label for="price" class="block text-sm font-bold text-gray-700 mb-2">Price (£)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-gray-500 font-medium">£</span>
                                    </div>
                                    <input type="number" wire:model="price" id="price" step="0.01" min="0"
                                           class="w-full pl-8 pr-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-rose-100 focus:border-rose-500 transition-all duration-200 bg-gray-50/50 hover:bg-white"
                                           placeholder="0.00">
                                </div>
                                @error('price') 
                                    <span class="text-red-500 text-sm mt-1 block flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </span> 
                                @enderror
                            </div>

                            <!-- Duration -->
                            <div>
                                <label for="duration" class="block text-sm font-bold text-gray-700 mb-2">Duration (minutes)</label>
                                <div class="relative">
                                    <input type="number" wire:model="duration" id="duration" min="15" step="15"
                                           class="w-full px-4 pr-12 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-rose-100 focus:border-rose-500 transition-all duration-200 bg-gray-50/50 hover:bg-white"
                                           placeholder="60">
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <span class="text-gray-500">min</span>
                                    </div>
                                </div>
                                @error('duration') 
                                    <span class="text-red-500 text-sm mt-1 block flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </span> 
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-sm font-bold text-gray-700 mb-2">Category</label>
                                <select wire:model="category" id="category"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-rose-100 focus:border-rose-500 transition-all duration-200 bg-gray-50/50 hover:bg-white">
                                    <option value="">Select Category</option>
                                    <option value="Hair Services">Hair Services</option>
                                    <option value="Nail Services">Nail Services</option>
                                    <option value="Spa Services">Spa Services</option>
                                    <option value="Special Occasions">Special Occasions</option>
                                </select>
                                @error('category') 
                                    <span class="text-red-500 text-sm mt-1 block flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </span> 
                                @enderror
                            </div>

                            <!-- Visibility -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-3">Visibility</label>
                                <div class="flex items-center space-x-3">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" wire:model="visibility" class="sr-only">
                                        <div class="relative">
                                            <div class="block bg-gray-200 w-14 h-8 rounded-full transition-colors duration-200 {{ $visibility ? 'bg-gradient-to-r from-rose-500 to-pink-600' : '' }}"></div>
                                            <div class="absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition-transform duration-200 shadow-sm {{ $visibility ? 'transform translate-x-6' : '' }}"></div>
                                        </div>
                                        <span class="ml-3 text-sm font-medium text-gray-700">{{ $visibility ? 'Visible to customers' : 'Hidden from customers' }}</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Service Photo -->
                            <div class="md:col-span-2">
                                <label for="servicePhoto" class="block text-sm font-bold text-gray-700 mb-2">Service Photo</label>
                                <div class="border-2 border-dashed border-gray-200 rounded-2xl p-8 text-center hover:border-rose-300 transition-colors duration-200 bg-gray-50/30">
                                    <input type="file" wire:model="servicePhoto" id="servicePhoto" accept="image/*" class="hidden">
                                    <label for="servicePhoto" class="cursor-pointer">
                                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-sm text-gray-600 font-medium">Click to upload a service photo</p>
                                        <p class="text-xs text-gray-400 mt-1">JPG, PNG or GIF (max. 5MB)</p>
                                    </label>
                                </div>
                                @error('servicePhoto') 
                                    <span class="text-red-500 text-sm mt-1 block flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </span> 
                                @enderror
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex justify-end space-x-3 pt-6 border-t border-gray-100">
                            <button type="button" wire:click="resetForm" 
                                    class="px-6 py-3 bg-gray-100 text-gray-700 rounded-2xl hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-100 transition-all duration-200 font-semibold">
                                Cancel
                            </button>
                            <button type="submit" 
                                    wire:loading.attr="disabled"
                                    class="px-6 py-3 bg-gradient-to-r from-rose-500 to-pink-600 text-white rounded-2xl hover:from-rose-600 hover:to-pink-700 focus:outline-none focus:ring-4 focus:ring-rose-200 transition-all duration-200 font-semibold hover:scale-105 shadow-lg disabled:opacity-75 disabled:cursor-not-allowed">
                                <span wire:loading.remove>{{ $editingServiceId ? 'Update Service' : 'Create Service' }}</span>
                                <span wire:loading class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Saving...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
