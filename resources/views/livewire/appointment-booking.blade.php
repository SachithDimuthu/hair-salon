<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Book an Appointment</h2>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit="bookAppointment" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Customer Information -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-900">Customer Information</h3>
                
                <div>
                    <label for="customer_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" id="customer_name" wire:model="customer_name" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('customer_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="customer_email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="customer_email" wire:model="customer_email" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('customer_email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="customer_phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="tel" id="customer_phone" wire:model="customer_phone" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('customer_phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Appointment Details -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-900">Appointment Details</h3>
                
                <div>
                    <label for="service_id" class="block text-sm font-medium text-gray-700">Service</label>
                    <select id="service_id" wire:model.live="service_id" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select a service</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }} - ${{ $service->base_price }}</option>
                        @endforeach
                    </select>
                    @error('service_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                @if($selected_service)
                    <div class="p-3 bg-gray-50 rounded-md">
                        <p class="text-sm text-gray-600">{{ $selected_service->description }}</p>
                        <p class="text-sm text-gray-600">Duration: {{ $selected_service->duration_minutes }} minutes</p>
                        <p class="text-sm font-semibold text-gray-900">Price: ${{ $selected_service->base_price }}</p>
                    </div>
                @endif

                <div>
                    <label for="staff_id" class="block text-sm font-medium text-gray-700">Preferred Staff</label>
                    <select id="staff_id" wire:model.live="staff_id" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select staff member</option>
                        @foreach($staff_members as $staff)
                            <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                        @endforeach
                    </select>
                    @error('staff_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="appointment_date" class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" id="appointment_date" wire:model.live="appointment_date" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('appointment_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                @if(count($available_times) > 0)
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-700">Available Times</label>
                        <select id="start_time" wire:model="start_time" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select a time</option>
                            @foreach($available_times as $time)
                                <option value="{{ $time }}">{{ Carbon\Carbon::createFromFormat('H:i', $time)->format('g:i A') }}</option>
                            @endforeach
                        </select>
                        @error('start_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                @elseif($appointment_date && $staff_id && $service_id)
                    <div class="p-3 bg-yellow-50 border border-yellow-200 rounded-md">
                        <p class="text-sm text-yellow-800">No available times for the selected date and staff member.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Notes -->
        <div>
            <label for="notes" class="block text-sm font-medium text-gray-700">Additional Notes</label>
            <textarea id="notes" wire:model="notes" rows="3" 
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
            @error('notes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Total Amount -->
        @if($total_amount > 0)
            <div class="p-4 bg-gray-50 rounded-md">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-semibold text-gray-900">Total Amount:</span>
                    <span class="text-2xl font-bold text-indigo-600">${{ number_format($total_amount, 2) }}</span>
                </div>
            </div>
        @endif

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" 
                    class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50"
                    wire:loading.attr="disabled">
                <span wire:loading.remove>Book Appointment</span>
                <span wire:loading>Booking...</span>
            </button>
        </div>
    </form>
</div>
