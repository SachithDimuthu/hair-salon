<div>
    <!-- Featured Services -->
    @if($popularServices && $popularServices->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 mb-16">
        @foreach($popularServices->take(3) as $index => $service)
            <a href="{{ route('service.show', $service) }}" 
               class="group bg-white/90 backdrop-blur-sm p-8 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 h-full flex flex-col">
                @if($service->image)
                    <div class="w-16 h-16 rounded-xl overflow-hidden mb-6 mx-auto shadow-md">
                        <img src="{{ asset($service->image) }}" alt="{{ $service->name }}" 
                             class="w-full h-full object-cover">
                    </div>
                @else
                    @php
                        $gradients = [
                            'bg-gradient-to-br from-rose-500 to-rose-600',
                            'bg-gradient-to-br from-purple-500 to-purple-600', 
                            'bg-gradient-to-br from-amber-500 to-amber-600'
                        ];
                        $gradient = $gradients[$index % 3];
                    @endphp
                    <div class="w-16 h-16 {{ $gradient }} rounded-xl flex items-center justify-center mb-6 mx-auto shadow-md">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8M7 7h10a2 2 0 012 2v8a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2z"/>
                        </svg>
                    </div>
                @endif
                
                <h3 class="text-2xl font-bold text-gray-800 mb-4 font-serif text-center group-hover:text-rose-600 transition-colors">{{ $service->name }}</h3>
                <p class="text-base text-gray-600 mb-6 leading-relaxed text-center flex-grow">{{ Str::limit($service->description, 120) }}</p>
                <div class="text-center mt-auto">
                    <p class="text-rose-600 font-semibold text-lg mb-2">Starting from Rs.{{ number_format((float)$service->base_price, 0) }}</p>
                    <span class="inline-flex items-center text-rose-600 hover:text-rose-700 font-semibold group transition-colors duration-200">
                        Learn More
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </span>
                </div>
            </a>
        @endforeach
    </div>
    @else
    <!-- Static fallback services if no dynamic services -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 mb-16">
        <a href="{{ route('services') }}" class="group bg-white/90 backdrop-blur-sm p-8 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 h-full flex flex-col">
            <div class="w-16 h-16 bg-gradient-to-br from-rose-500 to-rose-600 rounded-xl flex items-center justify-center mb-6 mx-auto shadow-md">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM7 21h10a2 2 0 002-2v-4a2 2 0 00-2-2H7"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-4 font-serif text-center group-hover:text-rose-600 transition-colors">Hair Styling</h3>
            <p class="text-base text-gray-600 mb-6 leading-relaxed text-center flex-grow">Professional cuts, styling, and treatments to transform your look with our expert stylists</p>
            <div class="text-center mt-auto">
                <p class="text-rose-600 font-semibold text-lg mb-2">Starting from Rs.1,200</p>
                <span class="inline-flex items-center text-rose-600 hover:text-rose-700 font-semibold group transition-colors duration-200">
                    Learn More
                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </span>
            </div>
        </a>

        <a href="{{ route('services') }}" class="group bg-white/90 backdrop-blur-sm p-8 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 h-full flex flex-col">
            <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mb-6 mx-auto shadow-md">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16l4-2 4 2V5z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-4 font-serif text-center group-hover:text-rose-600 transition-colors">Hair Coloring</h3>
            <p class="text-base text-gray-600 mb-6 leading-relaxed text-center flex-grow">Premium coloring services including highlights, balayage, and complete color transformations</p>
            <div class="text-center mt-auto">
                <p class="text-rose-600 font-semibold text-lg mb-2">Starting from Rs.1,800</p>
                <span class="inline-flex items-center text-rose-600 hover:text-rose-700 font-semibold group transition-colors duration-200">
                    Learn More
                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </span>
            </div>
        </a>

        <a href="{{ route('services') }}" class="group bg-white/90 backdrop-blur-sm p-8 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 h-full flex flex-col">
            <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center mb-6 mx-auto shadow-md">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-4 font-serif text-center group-hover:text-rose-600 transition-colors">Spa Treatments</h3>
            <p class="text-base text-gray-600 mb-6 leading-relaxed text-center flex-grow">Relaxing hair treatments, deep conditioning, and scalp therapy for ultimate hair health</p>
            <div class="text-center mt-auto">
                <p class="text-rose-600 font-semibold text-lg mb-2">Starting from Rs.900</p>
                <span class="inline-flex items-center text-rose-600 hover:text-rose-700 font-semibold group transition-colors duration-200">
                    Learn More
                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </span>
            </div>
        </a>
    </div>
    @endif

    <!-- Latest Deals Carousel -->
    @if($deals && $deals->count() > 0)
    <div class="mt-24 bg-gray-50 rounded-2xl shadow-lg p-8 md:p-12 border border-gray-200 overflow-hidden relative">
        <!-- Simple background decoration -->
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-rose-500 to-pink-500 rounded-t-2xl"></div>
        
        <div class="relative z-10">
            <div class="text-center mb-12">
                <div class="inline-flex items-center bg-rose-100 border border-rose-200 rounded-full px-6 py-2 mb-4">
                    <svg class="w-5 h-5 text-rose-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <span class="text-rose-700 text-sm font-semibold tracking-wide">EXCLUSIVE OFFERS</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 font-serif">Latest Deals & Promotions</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed">Discover our handpicked exclusive offers and limited-time promotions</p>
            </div>
        
            <!-- Deals Carousel -->
            <div class="relative" x-data="{ currentSlide: 0, totalSlides: {{ ceil($deals->count() / 3) }} }">
                <div class="overflow-hidden rounded-2xl">
                    <div class="flex transition-transform duration-700 ease-out" 
                         :style="`transform: translateX(-${currentSlide * 100}%)`">
                        @foreach($deals->chunk(3) as $dealChunk)
                        <div class="w-full flex-shrink-0">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                @foreach($dealChunk as $deal)
                                <div class="group bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 border border-gray-200 relative overflow-hidden">
                                    <!-- Simple card decoration -->
                                    <div class="absolute top-0 right-0 w-16 h-16 bg-gradient-to-br from-rose-100 to-pink-100 rounded-bl-2xl"></div>
                                    
                                    <div class="relative z-10">
                                        <!-- Header with discount badge -->
                                        <div class="flex items-start justify-between mb-6">
                                            <div class="flex items-center space-x-4">
                                                <div class="relative">
                                                    <div class="w-16 h-16 bg-gradient-to-br from-rose-500 to-pink-600 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                                        {{ $deal->DiscountPercentage }}%
                                                    </div>
                                                </div>
                                                <div>
                                                    <h3 class="text-xl font-bold text-gray-800 mb-1 group-hover:text-rose-600 transition-colors duration-300">{{ $deal->DealName }}</h3>
                                                    @if($deal->service)
                                                    <div class="flex items-center text-gray-600 text-sm">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                                        </svg>
                                                        {{ $deal->service->name }}
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="bg-gray-100 text-gray-700 text-xs font-medium px-3 py-2 rounded-full border border-gray-200">
                                                <div class="flex items-center space-x-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span>Until {{ $deal->EndDate->format('M d') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Description -->
                                        <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                                            {{ $deal->Description ?? 'Experience our premium services with this exclusive limited-time offer designed especially for our valued clients!' }}
                                        </p>
                                        
                                        <!-- Footer with savings and CTA -->
                                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                            <div class="flex items-center space-x-2">
                                                <span class="text-rose-600 font-bold text-lg">Save {{ $deal->DiscountPercentage }}%</span>
                                            </div>
                                            <a href="{{ route('book-service') }}" 
                                               class="bg-gradient-to-r from-rose-500 to-pink-600 hover:from-rose-600 hover:to-pink-700 text-white px-6 py-3 rounded-lg text-sm font-semibold transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105 flex items-center space-x-2">
                                                <span>Book Now</span>
                                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Navigation arrows -->
                @if(ceil($deals->count() / 3) > 1)
                <button @click="currentSlide = currentSlide > 0 ? currentSlide - 1 : totalSlides - 1" 
                        class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/10 backdrop-blur-lg border border-white/20 text-white p-4 rounded-full hover:bg-white/20 transition-all duration-300 shadow-xl hover:shadow-2xl group z-20">
                    <svg class="w-6 h-6 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button @click="currentSlide = currentSlide < totalSlides - 1 ? currentSlide + 1 : 0" 
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/10 backdrop-blur-lg border border-white/20 text-white p-4 rounded-full hover:bg-white/20 transition-all duration-300 shadow-xl hover:shadow-2xl group z-20">
                    <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                @endif
                
                <!-- Dots indicator -->
                @if(ceil($deals->count() / 3) > 1)
                <div class="flex justify-center mt-12 space-x-3">
                    @for($i = 0; $i < ceil($deals->count() / 3); $i++)
                    <button @click="currentSlide = {{ $i }}" 
                            class="transition-all duration-300 rounded-full border-2"
                            :class="currentSlide === {{ $i }} ? 'w-8 h-3 bg-white border-white' : 'w-3 h-3 bg-white/30 border-white/50 hover:bg-white/50'">
                    </button>
                    @endfor
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Popular Services Section -->
    @if($popularServices && $popularServices->count() > 0)
    <div class="mt-24 bg-white rounded-2xl shadow-lg p-8 md:p-12 border border-gray-200 relative overflow-hidden">
        <!-- Simple background decoration -->
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-rose-500 to-pink-500 rounded-t-2xl"></div>
        
        <div class="relative z-10">
            <div class="text-center mb-12">
                <div class="inline-flex items-center bg-rose-100 border border-rose-200 rounded-full px-6 py-2 mb-4">
                    <svg class="w-5 h-5 text-rose-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="text-rose-700 text-sm font-semibold tracking-wide">MOST LOVED</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 font-serif">Most Popular Services</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed">Discover our most beloved treatments and services, handpicked by our valued clients</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10">
                @foreach($popularServices as $service)
                <div class="group bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 border border-gray-200 h-full flex flex-col relative overflow-hidden">
                    <!-- Simple card decoration -->
                    <div class="absolute top-0 right-0 w-16 h-16 bg-gradient-to-br from-rose-100 to-pink-100 rounded-bl-2xl"></div>
                    
                    <div class="relative z-10 flex-grow">
                        @if($service->image)
                        <div class="mb-6 overflow-hidden rounded-lg relative">
                            <img src="{{ asset('storage/service-photos/' . basename($service->image)) }}" 
                                 alt="{{ $service->name }}" 
                                 class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300 rounded-lg"
                                 onError="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                            <!-- Fallback icon (hidden by default) -->
                            <div class="hidden w-full h-48 bg-gradient-to-br from-rose-500 to-pink-600 rounded-lg items-center justify-center">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                </svg>
                            </div>
                        </div>
                        @else
                        <div class="flex items-center justify-center mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-rose-500 to-pink-600 rounded-xl flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                </svg>
                            </div>
                        </div>
                        @endif
                        
                        <div class="flex-grow">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-xl font-bold text-gray-800 group-hover:text-rose-700 transition-colors duration-300">{{ $service->name }}</h4>
                                @if($service->rating)
                                <div class="flex items-center space-x-1 bg-gradient-to-r from-yellow-50 to-orange-50 px-3 py-1 rounded-full border border-yellow-200">
                                    <svg class="w-4 h-4 text-yellow-500 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="text-sm text-yellow-700 font-semibold">{{ number_format($service->rating, 1) }}</span>
                                </div>
                                @endif
                            </div>
                            
                            <p class="text-base text-gray-600 leading-relaxed mb-6 flex-grow">
                                {{ Str::limit($service->description, 120) }}
                            </p>
                            
                            <div class="flex items-center justify-between mb-6">
                                <div class="text-2xl font-bold text-rose-600">
                                    From Rs.{{ number_format($service->base_price, 0) }}
                                </div>
                                <span class="text-xs text-gray-500 bg-gradient-to-r from-gray-100 to-gray-200 px-3 py-2 rounded-full border border-gray-300 font-medium">
                                    {{ ucfirst($service->category) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="mt-auto pt-6 border-t border-gray-200/50">
                            <a href="{{ route('book-service') }}" 
                               class="group/book w-full bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 text-white py-4 rounded-xl text-base font-semibold transition-all duration-300 shadow-lg hover:shadow-rose-500/25 text-center block transform hover:scale-105 relative overflow-hidden">
                                <span class="relative z-10 flex items-center justify-center space-x-2">
                                    <span>Book This Service</span>
                                    <svg class="w-5 h-5 group-hover/book:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </span>
                                <div class="absolute inset-0 bg-gradient-to-r from-rose-600 to-pink-600 opacity-0 group-hover/book:opacity-100 transition-opacity duration-300"></div>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="text-center mt-16">
                <a href="{{ route('book-service') }}" 
                   class="group inline-flex items-center px-10 py-4 bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 text-white rounded-2xl text-lg font-bold transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-2 relative overflow-hidden">
                    <span class="relative z-10 flex items-center space-x-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>View All Services & Book Appointment</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-rose-600 to-pink-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
            </div>
        </div>
    </div>
    @endif
</div>
