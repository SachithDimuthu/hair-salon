<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-gradient-to-r from-rose-500 to-pink-600 border border-transparent rounded-2xl font-semibold text-sm text-white tracking-wide hover:from-rose-600 hover:to-pink-700 focus:from-rose-600 focus:to-pink-700 active:from-rose-700 active:to-pink-800 focus:outline-none focus:ring-4 focus:ring-rose-200 disabled:opacity-75 disabled:cursor-not-allowed transition-all duration-200 hover:scale-105 shadow-lg']) }}>
    {{ $slot }}
</button>
