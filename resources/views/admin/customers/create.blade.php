@extends('layouts.app')

@section('title', 'Add New Customer')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-serif font-bold text-gray-900">Add New Customer</h1>
            <p class="text-gray-600 mt-1">Create a new customer account</p>
        </div>
        <x-ui.button href="{{ route('admin.customers.index') }}" variant="ghost">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Customers
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

    <form action="{{ route('admin.customers.store') }}" method="POST" class="space-y-6">
        @csrf
        
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
                        value="{{ old('first_name') }}"
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
                        value="{{ old('last_name') }}"
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
                        value="{{ old('email') }}"
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
                        value="{{ old('phone') }}"
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
                        value="{{ old('date_of_birth') }}"
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
                    >{{ old('address') }}</textarea>
                </div>
            </div>
        </x-ui.card>

        <!-- Account Information -->
        <x-ui.card>
            <h3 class="text-xl font-semibold text-gray-900 mb-6">Account Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <x-ui.input 
                        type="password" 
                        name="password" 
                        id="password"
                        required
                        placeholder="Enter secure password"
                    />
                    <p class="text-sm text-gray-500 mt-1">Minimum 8 characters</p>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirm Password <span class="text-red-500">*</span>
                    </label>
                    <x-ui.input 
                        type="password" 
                        name="password_confirmation" 
                        id="password_confirmation"
                        required
                        placeholder="Confirm password"
                    />
                </div>
            </div>

            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-sm text-blue-700">
                        <p class="font-medium">Account Setup:</p>
                        <ul class="mt-1 list-disc list-inside space-y-1">
                            <li>A customer account will be created automatically</li>
                            <li>The customer will receive an email notification</li>
                            <li>They can log in immediately using their email and password</li>
                            <li>Customer role permissions will be applied automatically</li>
                        </ul>
                    </div>
                </div>
            </div>
        </x-ui.card>

        <!-- Action Buttons -->
        <div class="flex justify-between pt-6">
            <x-ui.button type="button" onclick="history.back()" variant="outline">
                Cancel
            </x-ui.button>
            <x-ui.button type="submit" variant="primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Create Customer
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

// Password strength indicator
document.getElementById('password').addEventListener('input', function(e) {
    const password = e.target.value;
    const strength = calculatePasswordStrength(password);
    // You can add visual feedback here
});

function calculatePasswordStrength(password) {
    let strength = 0;
    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    return strength;
}
</script>
@endsection