<div>
    <!-- Featured Services -->
    @if($popularServices && $popularServices->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-10 mb-16">
        @foreach($popularServices->take(3) as $index => $service)
            <a href="{{ route('service.show', $service) }}" 
               class="group bg-gradient-to-br from-white/95 to-rose-50/50 backdrop-blur-sm p-8 rounded-3xl shadow-lg hover:shadow-2xl border border-rose-200/30 h-full flex flex-col transition-all duration-500 transform hover:-translate-y-2 hover:scale-[1.02] relative overflow-hidden">
                <!-- Elegant background decoration -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-rose-100/40 to-pink-100/40 rounded-bl-3xl opacity-60"></div>
                <div class="absolute -top-4 -right-4 w-16 h-16 bg-gradient-to-br from-rose-200/30 to-pink-200/30 rounded-full"></div>
                
                @if($service->image)
                    <div class="relative w-32 h-32 rounded-2xl overflow-hidden mb-8 mx-auto shadow-xl z-10">
                        <img src="{{ asset($service->image) }}" alt="{{ $service->name }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <!-- Elegant fallback -->
                        <div class="hidden w-full h-full bg-gradient-to-br from-rose-500 via-pink-500 to-rose-600 items-center justify-center shadow-xl">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </div>
                    </div>
                @else
                    @php
                        $gradients = [
                            'bg-gradient-to-br from-rose-500 via-pink-500 to-rose-600',
                            'bg-gradient-to-br from-violet-500 via-purple-500 to-violet-600', 
                            'bg-gradient-to-br from-amber-500 via-orange-500 to-amber-600'
                        ];
                        $gradient = $gradients[$index % 3];
                    @endphp
                    <div class="relative w-32 h-32 {{ $gradient }} rounded-2xl flex items-center justify-center mb-8 mx-auto shadow-xl z-10 group-hover:shadow-2xl transition-all duration-500">
                        <svg class="w-12 h-12 text-white group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                @endif
                
                <div class="relative z-10 flex-grow flex flex-col">
                    <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-rose-700 bg-clip-text text-transparent mb-4 font-serif text-center group-hover:from-rose-600 group-hover:to-pink-600 transition-all duration-300">{{ $service->name }}</h3>
                    <p class="text-base text-rose-700/80 mb-8 leading-relaxed text-center flex-grow font-medium">{{ Str::limit($service->description, 120) }}</p>
                    
                    <div class="text-center mt-auto space-y-4">
                        <div class="bg-gradient-to-r from-rose-50 to-pink-50 backdrop-blur-sm border border-rose-200/50 rounded-2xl px-6 py-3">
                            <p class="text-rose-600 font-bold text-xl">Starting from Rs.{{ number_format((float)$service->price, 0) }}</p>
                        </div>
                        
                        <div class="group/btn inline-flex items-center bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <span>Learn More</span>
                            <svg class="w-4 h-4 ml-2 group-hover/btn:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    @else
    <!-- Static fallback services if no dynamic services -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-10 mb-16">
        <a href="{{ route('services') }}" class="group bg-gradient-to-br from-white/95 to-rose-50/50 backdrop-blur-sm p-8 rounded-3xl shadow-lg hover:shadow-2xl border border-rose-200/30 h-full flex flex-col transition-all duration-500 transform hover:-translate-y-2 hover:scale-[1.02] relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-rose-100/40 to-pink-100/40 rounded-bl-3xl opacity-60"></div>
            
            <div class="relative w-32 h-32 bg-gradient-to-br from-rose-500 via-pink-500 to-rose-600 rounded-2xl flex items-center justify-center mb-8 mx-auto shadow-xl z-10 group-hover:shadow-2xl transition-all duration-500">
                <svg class="w-12 h-12 text-white group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM7 21h10a2 2 0 002-2v-4a2 2 0 00-2-2H7"/>
                </svg>
            </div>
            
            <div class="relative z-10 flex-grow flex flex-col">
                <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-rose-700 bg-clip-text text-transparent mb-4 font-serif text-center group-hover:from-rose-600 group-hover:to-pink-600 transition-all duration-300">Premium Hair Styling</h3>
                <p class="text-base text-rose-700/80 mb-8 leading-relaxed text-center flex-grow font-medium">Professional cuts, styling, and treatments to transform your look with our expert stylists and luxury experience</p>
                
                <div class="text-center mt-auto space-y-4">
                    <div class="bg-gradient-to-r from-rose-50 to-pink-50 backdrop-blur-sm border border-rose-200/50 rounded-2xl px-6 py-3">
                        <p class="text-rose-600 font-bold text-xl">Starting from Rs.1,200</p>
                    </div>
                    
                    <div class="group/btn inline-flex items-center bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span>Learn More</span>
                        <svg class="w-4 h-4 ml-2 group-hover/btn:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </a>

        <a href="{{ route('services') }}" class="group bg-gradient-to-br from-white/95 to-violet-50/50 backdrop-blur-sm p-8 rounded-3xl shadow-lg hover:shadow-2xl border border-violet-200/30 h-full flex flex-col transition-all duration-500 transform hover:-translate-y-2 hover:scale-[1.02] relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-violet-100/40 to-purple-100/40 rounded-bl-3xl opacity-60"></div>
            
            <div class="relative w-32 h-32 bg-gradient-to-br from-violet-500 via-purple-500 to-violet-600 rounded-2xl flex items-center justify-center mb-8 mx-auto shadow-xl z-10 group-hover:shadow-2xl transition-all duration-500">
                <svg class="w-12 h-12 text-white group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16l4-2 4 2V5z"/>
                </svg>
            </div>
            
            <div class="relative z-10 flex-grow flex flex-col">
                <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-violet-700 bg-clip-text text-transparent mb-4 font-serif text-center group-hover:from-violet-600 group-hover:to-purple-600 transition-all duration-300">Luxury Hair Coloring</h3>
                <p class="text-base text-violet-700/80 mb-8 leading-relaxed text-center flex-grow font-medium">Premium coloring services including highlights, balayage, and complete color transformations with expert precision</p>
                
                <div class="text-center mt-auto space-y-4">
                    <div class="bg-gradient-to-r from-violet-50 to-purple-50 backdrop-blur-sm border border-violet-200/50 rounded-2xl px-6 py-3">
                        <p class="text-violet-600 font-bold text-xl">Starting from Rs.1,800</p>
                    </div>
                    
                    <div class="group/btn inline-flex items-center bg-gradient-to-r from-violet-500 to-purple-500 hover:from-violet-600 hover:to-purple-600 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span>Learn More</span>
                        <svg class="w-4 h-4 ml-2 group-hover/btn:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </a>

        <a href="{{ route('services') }}" class="group bg-gradient-to-br from-white/95 to-amber-50/50 backdrop-blur-sm p-8 rounded-3xl shadow-lg hover:shadow-2xl border border-amber-200/30 h-full flex flex-col transition-all duration-500 transform hover:-translate-y-2 hover:scale-[1.02] relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-100/40 to-orange-100/40 rounded-bl-3xl opacity-60"></div>
            
            <div class="relative w-32 h-32 bg-gradient-to-br from-amber-500 via-orange-500 to-amber-600 rounded-2xl flex items-center justify-center mb-8 mx-auto shadow-xl z-10 group-hover:shadow-2xl transition-all duration-500">
                <svg class="w-12 h-12 text-white group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
            
            <div class="relative z-10 flex-grow flex flex-col">
                <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-amber-700 bg-clip-text text-transparent mb-4 font-serif text-center group-hover:from-amber-600 group-hover:to-orange-600 transition-all duration-300">Rejuvenating Spa Treatments</h3>
                <p class="text-base text-amber-700/80 mb-8 leading-relaxed text-center flex-grow font-medium">Relaxing hair treatments, deep conditioning, and scalp therapy for ultimate hair health and wellness</p>
                
                <div class="text-center mt-auto space-y-4">
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 backdrop-blur-sm border border-amber-200/50 rounded-2xl px-6 py-3">
                        <p class="text-amber-600 font-bold text-xl">Starting from Rs.900</p>
                    </div>
                    
                    <div class="group/btn inline-flex items-center bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <span>Learn More</span>
                        <svg class="w-4 h-4 ml-2 group-hover/btn:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </div>
                </div>
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
</div>
