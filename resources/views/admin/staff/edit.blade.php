@extends('admin.layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.staff.show', $staff) }}" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit Staff Member</h1>
                    <p class="text-gray-600 mt-1">Update staff member information</p>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('admin.staff.update', $staff) }}" method="POST" class="divide-y divide-gray-200">
                @csrf
                @method('PUT')
                
                <!-- Personal Information -->
                <div class="px-6 py-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Personal Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                            <input type="text" 
                                   id="first_name" 
                                   name="first_name" 
                                   value="{{ old('first_name', $staff->first_name) }}"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('first_name') border-red-500 @enderror"
                                   required>
                            @error('first_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                            <input type="text" 
                                   id="last_name" 
                                   name="last_name" 
                                   value="{{ old('last_name', $staff->last_name) }}"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('last_name') border-red-500 @enderror"
                                   required>
                            @error('last_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $staff->user->email ?? '') }}"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror"
                                   required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                            <input type="text" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone', $staff->phone) }}"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('phone') border-red-500 @enderror"
                                   placeholder="(555) 123-4567">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Job Information -->
                <div class="px-6 py-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Job Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="employee_id" class="block text-sm font-medium text-gray-700 mb-2">Employee ID</label>
                            <input type="text" 
                                   id="employee_id" 
                                   name="employee_id" 
                                   value="{{ old('employee_id', $staff->employee_id) }}"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50 text-gray-500"
                                   readonly>
                            <p class="mt-1 text-sm text-gray-500">Employee ID cannot be changed</p>
                        </div>

                        <div>
                            <label for="position" class="block text-sm font-medium text-gray-700 mb-2">Position</label>
                            <select id="position" 
                                    name="position" 
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('position') border-red-500 @enderror"
                                    required>
                                <option value="">Select Position</option>
                                <option value="stylist" {{ old('position', $staff->position) == 'stylist' ? 'selected' : '' }}>Stylist</option>
                                <option value="colorist" {{ old('position', $staff->position) == 'colorist' ? 'selected' : '' }}>Colorist</option>
                                <option value="manager" {{ old('position', $staff->position) == 'manager' ? 'selected' : '' }}>Manager</option>
                                <option value="receptionist" {{ old('position', $staff->position) == 'receptionist' ? 'selected' : '' }}>Receptionist</option>
                                <option value="assistant" {{ old('position', $staff->position) == 'assistant' ? 'selected' : '' }}>Assistant</option>
                            </select>
                            @error('position')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="hire_date" class="block text-sm font-medium text-gray-700 mb-2">Hire Date</label>
                            <input type="date" 
                                   id="hire_date" 
                                   name="hire_date" 
                                   value="{{ old('hire_date', $staff->hire_date ? $staff->hire_date->format('Y-m-d') : '') }}"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('hire_date') border-red-500 @enderror">
                            @error('hire_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1"
                                       {{ old('is_active', $staff->is_active) ? 'checked' : '' }}
                                       class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 text-sm text-gray-700">Active Employee</label>
                            </div>
                        </div>
                    </div>

                    <!-- Specializations -->
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Specializations</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @php
                                $allSpecializations = [
                                    'Hair Cutting', 'Hair Styling', 'Hair Coloring', 'Highlights', 
                                    'Balayage', 'Perms', 'Keratin Treatments', 'Hair Extensions',
                                    'Wedding Styling', 'Men\'s Cuts', 'Beard Grooming', 'Eyebrow Shaping'
                                ];
                                $currentSpecializations = old('specializations', $staff->specializations ?? []);
                            @endphp
                            
                            @foreach($allSpecializations as $specialization)
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           id="spec_{{ $loop->index }}" 
                                           name="specializations[]" 
                                           value="{{ $specialization }}"
                                           {{ in_array($specialization, $currentSpecializations) ? 'checked' : '' }}
                                           class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                    <label for="spec_{{ $loop->index }}" class="ml-2 text-sm text-gray-700">{{ $specialization }}</label>
                                </div>
                            @endforeach
                        </div>
                        @error('specializations')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Compensation -->
                <div class="px-6 py-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Compensation</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="commission_rate" class="block text-sm font-medium text-gray-700 mb-2">Commission Rate (%)</label>
                            <input type="number" 
                                   id="commission_rate" 
                                   name="commission_rate" 
                                   value="{{ old('commission_rate', $staff->commission_rate) }}"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('commission_rate') border-red-500 @enderror"
                                   min="0" 
                                   max="100" 
                                   step="0.01"
                                   placeholder="25.00">
                            @error('commission_rate')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="hourly_rate" class="block text-sm font-medium text-gray-700 mb-2">Hourly Rate ($)</label>
                            <input type="number" 
                                   id="hourly_rate" 
                                   name="hourly_rate" 
                                   value="{{ old('hourly_rate', $staff->hourly_rate) }}"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('hourly_rate') border-red-500 @enderror"
                                   min="0" 
                                   step="0.01"
                                   placeholder="15.00">
                            @error('hourly_rate')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                    <a href="{{ route('admin.staff.show', $staff) }}" class="x-ui.button bg-gray-600 hover:bg-gray-700 text-white">
                        Cancel
                    </a>
                    <button type="submit" class="x-ui.button bg-primary-600 hover:bg-primary-700 text-white">
                        Update Staff Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection