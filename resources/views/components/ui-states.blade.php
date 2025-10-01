<!-- Loading spinner component -->
<div class="flex items-center justify-center p-8" wire:loading.delay>
    <div class="relative">
        <div class="w-12 h-12 rounded-full border-4 border-gray-200"></div>
        <div class="w-12 h-12 rounded-full border-4 border-rose-500 border-t-transparent animate-spin absolute top-0 left-0"></div>
    </div>
    <span class="ml-3 text-gray-600 font-medium">Loading...</span>
</div>

<!-- Loading overlay for forms -->
<div wire:loading.delay class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 shadow-2xl flex items-center space-x-4">
        <div class="relative">
            <div class="w-8 h-8 rounded-full border-4 border-gray-200"></div>
            <div class="w-8 h-8 rounded-full border-4 border-rose-500 border-t-transparent animate-spin absolute top-0 left-0"></div>
        </div>
        <span class="text-gray-700 font-medium">Processing...</span>
    </div>
</div>

<!-- Skeleton loading for service cards -->
<div class="animate-pulse">
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
        <div class="w-16 h-16 bg-gray-200 rounded-xl mb-6 mx-auto"></div>
        <div class="h-6 bg-gray-200 rounded mb-4"></div>
        <div class="h-4 bg-gray-200 rounded mb-2"></div>
        <div class="h-4 bg-gray-200 rounded mb-4 w-3/4"></div>
        <div class="h-8 bg-gray-200 rounded"></div>
    </div>
</div>

<!-- Error state component -->
<div class="bg-red-50 border border-red-200 rounded-xl p-6 mb-6" x-show="errorMessage" x-cloak>
    <div class="flex items-start">
        <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <h4 class="text-red-800 font-semibold mb-1">Something went wrong</h4>
            <p class="text-red-700 text-sm" x-text="errorMessage"></p>
        </div>
        <button @click="errorMessage = ''" class="ml-auto text-red-500 hover:text-red-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>

<!-- Success state component -->
<div class="bg-green-50 border border-green-200 rounded-xl p-6 mb-6" x-show="successMessage" x-cloak>
    <div class="flex items-start">
        <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <h4 class="text-green-800 font-semibold mb-1">Success!</h4>
            <p class="text-green-700 text-sm" x-text="successMessage"></p>
        </div>
        <button @click="successMessage = ''" class="ml-auto text-green-500 hover:text-green-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>

<!-- Empty state component -->
<div class="text-center py-16">
    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
        </svg>
    </div>
    <h3 class="text-xl font-semibold text-gray-900 mb-2">No results found</h3>
    <p class="text-gray-600 mb-6">Try adjusting your search or filters to find what you're looking for.</p>
</div>