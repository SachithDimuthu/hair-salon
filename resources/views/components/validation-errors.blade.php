@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'bg-red-50 border border-red-200 rounded-2xl p-4 shadow-sm']) }}>
        <div class="flex items-center mb-2">
            <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="font-bold text-red-700">{{ __('Whoops! Something went wrong.') }}</div>
        </div>

        <ul class="mt-2 space-y-1 text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li class="flex items-start">
                    <span class="inline-block w-1 h-1 bg-red-400 rounded-full mt-2 mr-2 flex-shrink-0"></span>
                    {{ $error }}
                </li>
            @endforeach
        </ul>
    </div>
@endif
