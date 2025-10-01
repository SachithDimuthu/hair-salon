<div class="relative" x-data="{ showSearch: @entangle('showResults') }">
    <!-- Search Input -->
    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
        <input wire:model.live="query"
               type="text"
               placeholder="Search services, pages..."
               class="block w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent bg-white"
               x-on:click.away="showSearch = false"
               x-on:keydown.escape="showSearch = false">
        
        <!-- Loading indicator -->
        <div wire:loading.delay class="absolute inset-y-0 right-0 pr-3 flex items-center">
            <div class="w-4 h-4 border-2 border-gray-300 border-t-rose-500 rounded-full animate-spin"></div>
        </div>
        
        @if($query && !$this->isLoading)
            <button wire:click="clearSearch" 
                    class="absolute inset-y-0 right-0 pr-3 flex items-center">
                <svg class="h-4 w-4 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        @endif
    </div>

    <!-- Search Results Dropdown -->
    <div x-show="showSearch && {{ count($results) > 0 ? 'true' : 'false' }}"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95"
         class="absolute z-50 w-full mt-2 bg-white rounded-lg shadow-lg border border-gray-200 py-2 max-h-80 overflow-y-auto">
        
        @if(count($results) > 0)
            @foreach($results as $index => $result)
                <a href="{{ $result['url'] }}" 
                   wire:click="selectResult('{{ $result['url'] }}')"
                   class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors duration-200 group">
                    
                    <!-- Icon -->
                    <div class="flex-shrink-0 mr-3">
                        <div class="w-8 h-8 rounded-lg bg-{{ $result['type'] === 'service' ? 'rose' : 'blue' }}-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-{{ $result['type'] === 'service' ? 'rose' : 'blue' }}-600" 
                                 fill="none" 
                                 stroke="currentColor" 
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" 
                                      stroke-linejoin="round" 
                                      stroke-width="2" 
                                      d="{{ $result['icon'] }}"/>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900 truncate group-hover:text-rose-600">
                                {{ $result['title'] }}
                            </p>
                            @if($result['type'] === 'service' && isset($result['price']))
                                <span class="text-sm font-semibold text-rose-600 ml-2">
                                    Rs.{{ number_format($result['price'], 0) }}
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-500 truncate">{{ $result['description'] }}</p>
                        @if($result['type'] === 'service' && isset($result['category']))
                            <span class="inline-block mt-1 px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded-full">
                                {{ $result['category'] }}
                            </span>
                        @endif
                    </div>
                    
                    <!-- Arrow -->
                    <div class="flex-shrink-0 ml-2">
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-rose-600" 
                             fill="none" 
                             stroke="currentColor" 
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" 
                                  stroke-linejoin="round" 
                                  stroke-width="2" 
                                  d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
            @endforeach
            
            <!-- View All Results -->
            @if(count($results) >= 8)
                <div class="border-t border-gray-100 mt-2 pt-2">
                    <a href="{{ route('services') }}?search={{ urlencode($query) }}" 
                       class="flex items-center justify-center px-4 py-2 text-sm text-rose-600 hover:text-rose-700 font-medium">
                        View all results
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            @endif
        @endif
    </div>

    <!-- No Results -->
    @if($showResults && strlen($query) >= 2 && count($results) === 0)
        <div x-show="showSearch"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="absolute z-50 w-full mt-2 bg-white rounded-lg shadow-lg border border-gray-200 py-6">
            <div class="text-center">
                <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <p class="mt-2 text-sm text-gray-600">No results found for "{{ $query }}"</p>
                <p class="text-xs text-gray-500 mt-1">Try searching for services, about us, or contact</p>
            </div>
        </div>
    @endif
</div>