@extends('layouts.guest')

@section('title', 'About Us')
@section('description', 'Learn about Luxe Hair Studio\'s story, mission, and commitment to providing exceptional beauty services in an elegant environment.')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent mb-4">
                    About Luxe Hair Studio
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Where luxury meets expertise to create extraordinary beauty experiences that inspire confidence 
                    and celebrate your unique style.
                </p>
            </div>

            <!-- Story Section -->
            <div class="grid lg:grid-cols-2 gap-12 items-center mb-20">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Story</h2>
                    <div class="space-y-4 text-gray-600">
                        <p>
                            Founded in 2018 in the heart of Kandy, Luxe Hair Studio began as a vision to bring international beauty standards 
                            to Sri Lanka while celebrating the natural beauty and rich cultural heritage of our island nation.
                        </p>
                        <p>
                            What started as a boutique salon in the historic city of Kandy has grown into Sri Lanka's premier destination 
                            for discerning clients who appreciate the finest in hair care, styling, and beauty services. Our journey has been 
                            guided by a deep respect for both traditional Sri Lankan beauty practices and modern international techniques.
                        </p>
                        <p>
                            Today, we're proud to be recognized as one of the leading luxury salons in Sri Lanka, known for our innovative 
                            fusion of global trends with local beauty traditions, personalized service, and the warm hospitality that 
                            reflects the true spirit of Sri Lankan culture.
                        </p>
                    </div>
                </div>
                <div class="relative">
                    <div class="w-full h-96 rounded-2xl overflow-hidden shadow-lg">
                        <img src="{{ asset('images/Services/Hair_spa.jpg') }}" alt="Luxe Hair Studio - Hair Spa Services" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent flex items-end justify-center">
                            <div class="text-center pb-8">
                                <p class="text-white font-semibold text-2xl mb-2">Luxe Hair Studio</p>
                                <p class="text-white/90 text-lg">Established 2018</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mission & Values -->
            <div class="bg-gradient-to-r from-rose-50 to-pink-50 rounded-2xl p-12 mb-20">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Mission & Values</h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        We believe every person deserves to feel beautiful and confident while honoring Sri Lanka's rich 
                        traditions of beauty and wellness in a luxurious, welcoming environment.
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-rose-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Excellence</h3>
                        <p class="text-gray-600">Delivering exceptional results through skill, precision, and attention to detail.</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-rose-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Care</h3>
                        <p class="text-gray-600">Treating every client with genuine warmth, respect, and personalized attention.</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-rose-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Innovation</h3>
                        <p class="text-gray-600">Staying ahead of trends with cutting-edge techniques and premium products.</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-rose-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Wellness</h3>
                        <p class="text-gray-600">Creating a peaceful sanctuary that nurtures both beauty and well-being.</p>
                    </div>
                </div>
            </div>

            <!-- Experience Section -->
            <div class="mb-20">
                <div class="max-w-4xl mx-auto">
                    <div class="space-y-8">
                        <!-- Section Header -->
                        <div class="text-center">
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">The Luxe Experience</h2>
                            <div class="w-16 h-1 bg-gradient-to-r from-rose-500 to-pink-600 rounded-full mx-auto mb-6"></div>
                        </div>
                        
                        <!-- Content Blocks -->
                        <div class="space-y-6">
                            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                                <h3 class="text-xl font-semibold text-gray-900 mb-3">Warm Sri Lankan Hospitality</h3>
                                <p class="text-gray-600 leading-relaxed">
                                    From the moment you step through our doors, you'll experience the legendary warmth of Sri Lankan hospitality 
                                    combined with world-class luxury. Our salon reflects the perfect blend of contemporary elegance and 
                                    traditional Lankan charm that makes you feel truly welcomed.
                                </p>
                            </div>
                            
                            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                                <h3 class="text-xl font-semibold text-gray-900 mb-3">Thoughtfully Designed Luxury</h3>
                                <p class="text-gray-600 leading-relaxed">
                                    Every detail has been thoughtfully designed—from our premium international product lines and modern equipment 
                                    to our comfortable spaces inspired by Sri Lanka's natural beauty. We believe your beauty journey should reflect 
                                    both global standards and local cultural appreciation.
                                </p>
                            </div>
                            
                            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                                <h3 class="text-xl font-semibold text-gray-900 mb-3">International Expertise, Local Care</h3>
                                <p class="text-gray-600 leading-relaxed">
                                    Whether you're preparing for a special celebration, wedding, or simply treating yourself, our team brings together 
                                    international expertise with genuine Sri Lankan care to create an unforgettable experience.
                                </p>
                            </div>
                        </div>
                        
                        <!-- Call-to-Action -->
                        <div class="text-center pt-4">
                            <a href="{{ route('book-service') }}" 
                               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-rose-500 to-pink-600 text-white rounded-lg font-semibold hover:from-rose-600 hover:to-pink-700 transition-all duration-200 hover:scale-105 shadow-md">
                                <span>Experience Luxury Today</span>
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="bg-gradient-to-r from-rose-600 to-pink-600 rounded-2xl p-12 text-white text-center mb-20">
                <h2 class="text-3xl font-bold mb-12">Our Journey in Numbers</h2>
                <div class="grid md:grid-cols-4 gap-8">
                    <div>
                        <div class="text-4xl font-bold mb-2">6+</div>
                        <div class="text-rose-100">Years of Excellence</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold mb-2">5000+</div>
                        <div class="text-rose-100">Happy Clients</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold mb-2">15+</div>
                        <div class="text-rose-100">Premium Services</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold mb-2">6</div>
                        <div class="text-rose-100">Expert Stylists</div>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Experience Luxury Beauty</h2>
                <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                    Join thousands of satisfied clients across Sri Lanka who have discovered their most beautiful selves at Luxe Hair Studio.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('book-service') }}" 
                       class="px-8 py-4 bg-gradient-to-r from-rose-500 to-pink-600 text-white rounded-2xl font-semibold hover:from-rose-600 hover:to-pink-700 transition-all duration-200 hover:scale-105 shadow-lg">
                        Book Your Appointment
                    </a>
                    <a href="{{ route('services') }}" 
                       class="px-8 py-4 border-2 border-rose-500 text-rose-600 rounded-2xl font-semibold hover:bg-rose-50 transition-all duration-200">
                        View Services
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection