<div class="max-w-7xl mx-auto p-6 space-y-6">
    <div class="bg-white rounded-2xl shadow-lg border border-rose-100/50 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-rose-500 to-pink-600 text-white p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold mb-2">Manage Customers</h2>
                    <p class="text-rose-100">Oversee customer accounts and information</p>
                </div>
                <button wire:click="createCustomer" 
                        class="bg-white/20 backdrop-blur-sm border border-white/30 text-white px-6 py-3 rounded-2xl hover:bg-white/30 focus:outline-none focus:ring-4 focus:ring-white/20 transition-all duration-200 hover:scale-105 font-semibold shadow-sm">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New Customer
                </button>
            </div>
        </div>

        <div class="p-6">
            <!-- Success/Error Messages -->
            @if($message)
                <div class="mb-6 p-4 rounded-xl border-l-4 {{ $messageType === 'success' ? 'bg-green-50 border-green-400 text-green-700' : 'bg-red-50 border-red-400 text-red-700' }}">
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
                    <input type="text" wire:model.live="search" placeholder="Search customers by name or email..." 
                           class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-rose-100 focus:border-rose-500 transition-all duration-200 text-gray-900 placeholder-gray-500 bg-gray-50/50 hover:bg-white">
                </div>
            </div>

            <!-- Customers Table -->
            <div class="overflow-hidden rounded-2xl border border-gray-200 shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Joined</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($customers as $customer)
                            <tr class="hover:bg-gradient-to-r hover:from-rose-50 hover:to-pink-50 transition-all duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">#{{ $customer->CustomerID }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-rose-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-sm mr-3 shadow-sm">
                                            {{ strtoupper(substr($customer->CustomerName, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray-900">{{ $customer->CustomerName }}</div>
                                            <div class="text-sm text-gray-500">{{ $customer->Email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        @if($customer->PhoneNumber)
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 text-rose-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                </svg>
                                                {{ $customer->PhoneNumber }}
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic">No phone</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $customer->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $customer->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <button wire:click="editCustomer({{ $customer->CustomerID }})" 
                                            class="text-rose-600 hover:text-rose-800 font-semibold hover:bg-rose-50 px-3 py-2 rounded-xl transition-all duration-200 shadow-sm border border-rose-200/50 hover:border-rose-300">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </button>
                                    <button wire:click="deleteCustomer({{ $customer->CustomerID }})" 
                                            onclick="return confirm('Are you sure you want to delete this customer? This action cannot be undone.')"
                                            class="text-red-600 hover:text-red-800 font-semibold hover:bg-red-50 px-3 py-2 rounded-xl transition-all duration-200 shadow-sm border border-red-200/50 hover:border-red-300">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <p class="text-gray-500 text-lg font-medium">No customers found</p>
                                        <p class="text-gray-400 text-sm mt-1">Try adjusting your search or add a new customer</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex justify-center">
                {{ $customers->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md border border-gray-200 transform transition-all duration-300">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-rose-500 to-pink-600 text-white p-6 rounded-t-2xl">
                    <div class="flex justify-between items-center">
                        <h3 class="text-2xl font-bold">
                            {{ $editingCustomerId ? 'Edit Customer' : 'Add New Customer' }}
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
                <div class="p-6 space-y-6">
                    <form wire:submit="saveCustomer" class="space-y-4">
                        <!-- Customer Name -->
                        <div>
                            <label for="customerName" class="block text-sm font-bold text-gray-700 mb-2">Customer Name</label>
                            <input type="text" wire:model="customerName" id="customerName" 
                                   class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-rose-100 focus:border-rose-500 transition-all duration-200 bg-gray-50/50 hover:bg-white"
                                   placeholder="Enter customer name">
                            @error('customerName') 
                                <span class="text-red-500 text-sm mt-1 block flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                            <input type="email" wire:model="email" id="email" 
                                   class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-rose-100 focus:border-rose-500 transition-all duration-200 bg-gray-50/50 hover:bg-white"
                                   placeholder="Enter email address">
                            @error('email') 
                                <span class="text-red-500 text-sm mt-1 block flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>

                        <!-- Password -->
                        @if(!$editingCustomerId)
                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                            <input type="password" wire:model="password" id="password" 
                                   class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-rose-100 focus:border-rose-500 transition-all duration-200 bg-gray-50/50 hover:bg-white"
                                   placeholder="Enter password">
                            @error('password') 
                                <span class="text-red-500 text-sm mt-1 block flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>
                        @endif

                        <!-- Phone Number -->
                        <div>
                            <label for="phoneNumber" class="block text-sm font-bold text-gray-700 mb-2">Phone Number</label>
                            <input type="text" wire:model="phoneNumber" id="phoneNumber" 
                                   class="w-full px-4 py-3 border border-gray-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-rose-100 focus:border-rose-500 transition-all duration-200 bg-gray-50/50 hover:bg-white"
                                   placeholder="Enter phone number (optional)">
                            @error('phoneNumber') 
                                <span class="text-red-500 text-sm mt-1 block flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>

                        <!-- Modal Actions -->
                        <div class="flex justify-end space-x-3 pt-6 border-t border-gray-100">
                            <button type="button" wire:click="closeModal" 
                                    class="px-6 py-3 bg-gray-100 text-gray-700 rounded-2xl hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-100 transition-all duration-200 font-semibold">
                                Cancel
                            </button>
                            <button type="submit" 
                                    wire:loading.attr="disabled"
                                    class="px-6 py-3 bg-gradient-to-r from-rose-500 to-pink-600 text-white rounded-2xl hover:from-rose-600 hover:to-pink-700 focus:outline-none focus:ring-4 focus:ring-rose-200 transition-all duration-200 hover:scale-105 font-semibold shadow-lg disabled:opacity-75 disabled:cursor-not-allowed">
                                <span wire:loading.remove>{{ $editingCustomerId ? 'Update Customer' : 'Add Customer' }}</span>
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
