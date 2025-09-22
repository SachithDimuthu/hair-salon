@extends('admin.layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.services.show', $service) }}" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit Service</h1>
                    <p class="text-gray-600 mt-1">Update service information</p>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="bg-white shadow rounded-lg">
            <form action="{{ route('admin.services.update', $service) }}" method="POST" class="divide-y divide-gray-200">
                @csrf
                @method('PUT')
                
                <!-- Basic Information -->
                <div class="px-6 py-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Basic Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Service Name</label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $service->name) }}"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-500 @enderror"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                            <select id="category_id" 
                                    name="category_id" 
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('category_id') border-red-500 @enderror"
                                    required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $service->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                            <input type="number" 
                                   id="sort_order" 
                                   name="sort_order" 
                                   value="{{ old('sort_order', $service->sort_order) }}"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('sort_order') border-red-500 @enderror"
                                   min="0">
                            @error('sort_order')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="4"
                                      class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('description') border-red-500 @enderror"
                                      placeholder="Detailed description of the service">{{ old('description', $service->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pricing & Duration -->
                <div class="px-6 py-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Pricing & Duration</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="base_price" class="block text-sm font-medium text-gray-700 mb-2">Base Price ($)</label>
                            <input type="number" 
                                   id="base_price" 
                                   name="base_price" 
                                   value="{{ old('base_price', $service->base_price) }}"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('base_price') border-red-500 @enderror"
                                   min="0" 
                                   step="0.01"
                                   required>
                            @error('base_price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="duration_minutes" class="block text-sm font-medium text-gray-700 mb-2">Duration (minutes)</label>
                            <input type="number" 
                                   id="duration_minutes" 
                                   name="duration_minutes" 
                                   value="{{ old('duration_minutes', $service->duration_minutes) }}"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('duration_minutes') border-red-500 @enderror"
                                   min="1" 
                                   max="600"
                                   required>
                            @error('duration_minutes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Service Options -->
                <div class="px-6 py-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Service Options</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="requires_consultation" 
                                   name="requires_consultation" 
                                   value="1"
                                   {{ old('requires_consultation', $service->requires_consultation) ? 'checked' : '' }}
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="requires_consultation" class="ml-2 text-sm text-gray-700">
                                Requires Consultation
                            </label>
                        </div>
                        <p class="text-sm text-gray-500 ml-6">Check this if the service requires a consultation before booking</p>

                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', $service->is_active) ? 'checked' : '' }}
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 text-sm text-gray-700">
                                Active Service
                            </label>
                        </div>
                        <p class="text-sm text-gray-500 ml-6">Only active services are available for booking</p>
                    </div>
                </div>

                <!-- Current Information -->
                <div class="px-6 py-6 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Current Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Current Slug</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $service->slug }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $service->created_at->format('M d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $service->updated_at->format('M d, Y') }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                    <a href="{{ route('admin.services.show', $service) }}" class="x-ui.button bg-gray-600 hover:bg-gray-700 text-white">
                        Cancel
                    </a>
                    <button type="submit" class="x-ui.button bg-primary-600 hover:bg-primary-700 text-white">
                        Update Service
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection