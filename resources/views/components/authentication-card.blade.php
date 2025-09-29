<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-rose-50 via-pink-50 to-white">
    <div class="mb-8">
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white/80 backdrop-blur-sm shadow-2xl overflow-hidden sm:rounded-2xl border border-rose-100/50 transform transition-all duration-300 hover:shadow-3xl">
        {{ $slot }}
    </div>
    
    <!-- Decorative elements -->
    <div class="absolute top-20 left-20 w-32 h-32 bg-rose-200/20 rounded-full blur-2xl animate-pulse"></div>
    <div class="absolute bottom-20 right-20 w-40 h-40 bg-pink-200/20 rounded-full blur-2xl animate-pulse delay-1000"></div>
</div>
