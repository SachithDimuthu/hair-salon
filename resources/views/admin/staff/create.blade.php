@extends('layouts.app')

@section('title', 'Add New Staff Member')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-serif font-bold text-gray-900">Add New Staff Member</h1>
            <p class="text-gray-600 mt-1">Create a new team member account</p>
        </div>
        <x-ui.button href="{{ route('admin.staff.index') }}" variant="ghost">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Staff
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

    <form action="{{ route('admin.staff.store') }}" method="POST" class="space-y-6">
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
            </div>
        </x-ui.card>

        <!-- Professional Information -->
        <x-ui.card>
            <h3 class="text-xl font-semibold text-gray-900 mb-6">Professional Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700 mb-2">
                        Position <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="position" 
                        id="position"
                        class="block w-full border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500"
                        required
                    >
                        <option value="">Select position</option>
                        <option value="stylist" {{ old('position') === 'stylist' ? 'selected' : '' }}>Stylist</option>
                        <option value="colorist" {{ old('position') === 'colorist' ? 'selected' : '' }}>Colorist</option>
                        <option value="manager" {{ old('position') === 'manager' ? 'selected' : '' }}>Manager</option>
                        <option value="receptionist" {{ old('position') === 'receptionist' ? 'selected' : '' }}>Receptionist</option>
                        <option value="assistant" {{ old('position') === 'assistant' ? 'selected' : '' }}>Assistant</option>
                    </select>
                </div>

                <div>
                    <label for="hire_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Hire Date <span class="text-red-500">*</span>
                    </label>
                    <x-ui.input 
                        type="date" 
                        name="hire_date" 
                        id="hire_date"
                        value="{{ old('hire_date', now()->format('Y-m-d')) }}"
                        required
                        max="{{ now()->format('Y-m-d') }}"
                    />
                </div>

                <div>
                    <label for="hourly_rate" class="block text-sm font-medium text-gray-700 mb-2">
                        Hourly Rate ($)
                    </label>
                    <x-ui.input 
                        type="number" 
                        name="hourly_rate" 
                        id="hourly_rate"
                        value="{{ old('hourly_rate') }}"
                        min="0"
                        step="0.01"
                        placeholder="Enter hourly rate"
                    />
                    <p class="text-sm text-gray-500 mt-1">Base hourly rate for this position</p>
                </div>

                <div>
                    <label for="commission_rate" class="block text-sm font-medium text-gray-700 mb-2">
                        Commission Rate (%)
                    </label>
                    <x-ui.input 
                        type="number" 
                        name="commission_rate" 
                        id="commission_rate"
                        value="{{ old('commission_rate') }}"
                        min="0"
                        max="100"
                        step="0.1"
                        placeholder="Enter commission rate"
                    />
                    <p class="text-sm text-gray-500 mt-1">Percentage of service revenue earned as commission</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Specializations
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                name="specializations[]" 
                                value="Hair Cutting"
                                class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            >
                            <span class="ml-2 text-sm text-gray-700">Hair Cutting</span>
                        </label>
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                name="specializations[]" 
                                value="Hair Styling"
                                class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            >
                            <span class="ml-2 text-sm text-gray-700">Hair Styling</span>
                        </label>
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                name="specializations[]" 
                                value="Hair Coloring"
                                class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            >
                            <span class="ml-2 text-sm text-gray-700">Hair Coloring</span>
                        </label>
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                name="specializations[]" 
                                value="Chemical Services"
                                class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            >
                            <span class="ml-2 text-sm text-gray-700">Chemical Services</span>
                        </label>
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                name="specializations[]" 
                                value="Nail Care"
                                class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            >
                            <span class="ml-2 text-sm text-gray-700">Nail Care</span>
                        </label>
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                name="specializations[]" 
                                value="Facial Treatments"
                                class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            >
                            <span class="ml-2 text-sm text-gray-700">Facial Treatments</span>
                        </label>
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                name="specializations[]" 
                                value="Massage Therapy"
                                class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            >
                            <span class="ml-2 text-sm text-gray-700">Massage Therapy</span>
                        </label>
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                name="specializations[]" 
                                value="Makeup Artist"
                                class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            >
                            <span class="ml-2 text-sm text-gray-700">Makeup Artist</span>
                        </label>
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                name="specializations[]" 
                                value="Bridal Services"
                                class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            >
                            <span class="ml-2 text-sm text-gray-700">Bridal Services</span>
                        </label>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                        Bio / Description (Optional)
                    </label>
                    <textarea 
                        name="bio" 
                        id="bio" 
                        rows="3"
                        class="block w-full border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500"
                        placeholder="Brief description of skills, experience, and specialties..."
                    >{{ old('bio') }}</textarea>
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

                <div class="md:col-span-2">
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="is_active" 
                            value="1"
                            {{ old('is_active', true) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                        >
                        <span class="ml-2 text-sm text-gray-700">Active staff member (can login and take appointments)</span>
                    </label>
                </div>
            </div>

            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-sm text-blue-700">
                        <p class="font-medium">Staff Account Setup:</p>
                        <ul class="mt-1 list-disc list-inside space-y-1">
                            <li>A staff account will be created with access to staff dashboard</li>
                            <li>They can view and manage their appointments</li>
                            <li>Staff role permissions will be applied automatically</li>
                            <li>They will receive login credentials via email notification</li>
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
                Create Staff Member
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

// Auto-generate name from first and last name
function updateFullName() {
    const firstName = document.getElementById('first_name').value;
    const lastName = document.getElementById('last_name').value;
    const emailField = document.getElementById('email');
    
    // Auto-suggest email if empty
    if (!emailField.value && firstName && lastName) {
        const suggestedEmail = (firstName + '.' + lastName + '@luxehair.com').toLowerCase();
        emailField.placeholder = suggestedEmail;
    }
}

document.getElementById('first_name').addEventListener('input', updateFullName);
document.getElementById('last_name').addEventListener('input', updateFullName);
</script>
@endsection