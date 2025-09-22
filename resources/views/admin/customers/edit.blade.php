@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-serif font-bold text-gray-900">Edit Customer</h1>
            <p class="text-gray-600 mt-1">Update {{ $customer->first_name }} {{ $customer->last_name }}'s information</p>
        </div>
        <x-ui.button href="{{ route('admin.customers.show', $customer) }}" variant="ghost">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Details
        </x-ui.button>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            <h4 class="font-medium mb-2">Please correct the following errors:</h4>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.customers.update', $customer) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Personal Information -->
        <x-ui.card>
            <h3 class="text-xl font-semibold text-gray-900 mb-6">Personal Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                        First Name <span class="text-red-500">*</span>
                    </label>
                    <x-ui.input 
                        type="text" 
                        name="first_name" 
                        id="first_name"
                        value="{{ old('first_name', $customer->first_name) }}"
                        required
                        placeholder="Enter first name"
                    />
                </div>

                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Last Name <span class="text-red-500">*</span>
                    </label>
                    <x-ui.input 
                        type="text" 
                        name="last_name" 
                        id="last_name"
                        value="{{ old('last_name', $customer->last_name) }}"
                        required
                        placeholder="Enter last name"
                    />
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <x-ui.input 
                        type="email" 
                        name="email" 
                        id="email"
                        value="{{ old('email', $customer->user->email) }}"
                        required
                        placeholder="Enter email address"
                    />
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Phone Number <span class="text-red-500">*</span>
                    </label>
                    <x-ui.input 
                        type="tel" 
                        name="phone" 
                        id="phone"
                        value="{{ old('phone', $customer->phone) }}"
                        required
                        placeholder="(555) 123-4567"
                    />
                </div>

                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">
                        Date of Birth
                    </label>
                    <x-ui.input 
                        type="date" 
                        name="date_of_birth" 
                        id="date_of_birth"
                        value="{{ old('date_of_birth', $customer->date_of_birth?->format('Y-m-d')) }}"
                        max="{{ now()->subYears(13)->format('Y-m-d') }}"
                    />
                </div>

                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Address
                    </label>
                    <textarea 
                        name="address" 
                        id="address" 
                        rows="3"
                        class="block w-full border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500"
                        placeholder="Enter full address (optional)"
                    >{{ old('address', $customer->address) }}</textarea>
                </div>
            </div>
        </x-ui.card>

        <!-- Account Information -->
        <x-ui.card>
            <h3 class="text-xl font-semibold text-gray-900 mb-6">Account Information</h3>
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-sm text-blue-700">
                        <p class="font-medium">Account Details:</p>
                        <ul class="mt-1 space-y-1">
                            <li><strong>Email:</strong> {{ $customer->user->email }}</li>
                            <li><strong>Member Since:</strong> {{ $customer->created_at->format('F j, Y') }}</li>
                            <li><strong>Last Login:</strong> {{ $customer->user->updated_at->format('F j, Y g:i A') }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-yellow-500 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <div class="text-sm text-yellow-700">
                        <p class="font-medium">Password Reset:</p>
                        <p class="mt-1">
                            To change the customer's password, you'll need to use the password reset feature or have them reset it through the login page.
                        </p>
                    </div>
                </div>
            </div>
        </x-ui.card>

        <!-- Customer Stats -->
        <x-ui.card class="bg-gray-50">
            <h3 class="text-xl font-semibold text-gray-900 mb-6">Customer Statistics</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $customer->appointments()->count() }}</div>
                    <div class="text-sm text-gray-600">Total Appointments</div>
                </div>
                
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $customer->orders()->count() }}</div>
                    <div class="text-sm text-gray-600">Total Orders</div>
                </div>
                
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600">
                        ${{ number_format($customer->orders()->sum('total_amount'), 2) }}
                    </div>
                    <div class="text-sm text-gray-600">Total Spent</div>
                </div>
            </div>
        </x-ui.card>

        <!-- Action Buttons -->
        <div class="flex justify-between pt-6">
            <div class="flex space-x-3">
                <x-ui.button type="button" onclick="history.back()" variant="outline">
                    Cancel
                </x-ui.button>
                
                <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <x-ui.button 
                        type="submit" 
                        variant="outline"
                        onclick="return confirm('Are you sure you want to delete this customer? This action cannot be undone and will remove all their data.')"
                        class="text-red-600 border-red-300 hover:bg-red-50"
                    >
                        Delete Customer
                    </x-ui.button>
                </form>
            </div>
            
            <x-ui.button type="submit" variant="primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Update Customer
            </x-ui.button>
        </div>
    </form>
</div>

<script>
// Auto-format phone number
document.getElementById('phone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length >= 6) {
        value = value.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
    } else if (value.length >= 3) {
        value = value.replace(/(\d{3})(\d{0,3})/, '($1) $2');
    }
    e.target.value = value;
});
</script>
@endsection