@extends('layouts.guest')

@section('title', 'Our Team - Luxe Hair Studio')
@section('description', 'Meet our talented team of professional stylists and beauty experts at Luxe Hair Studio. Experienced, certified, and passionate about making you look and feel your best.')

@section('content')
<!-- Hero Section -->
<div class="relative py-24 bg-gradient-to-br from-primary-50 via-white to-secondary-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl font-serif font-bold text-gray-900 mb-6">
            Meet Our <span class="text-primary-600">Expert Team</span>
        </h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Our passionate team of certified professionals brings years of experience, 
            continuous education, and an eye for detail to every service.
        </p>
    </div>
</div>

<!-- Team Stats -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold text-primary-600 mb-2">50+</div>
                <div class="text-gray-600">Expert Stylists</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-primary-600 mb-2">15+</div>
                <div class="text-gray-600">Years Average Experience</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-primary-600 mb-2">100%</div>
                <div class="text-gray-600">Certified Professionals</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-primary-600 mb-2">10k+</div>
                <div class="text-gray-600">Satisfied Clients</div>
            </div>
        </div>
    </div>
</section>

<!-- Senior Stylists -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-serif font-bold text-gray-900 mb-4">Senior Stylists</h2>
            <p class="text-xl text-gray-600">Our master stylists with over 10 years of experience</p>
        </div>
        
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Senior Stylist 1 -->
            <x-ui.card class="text-center group hover:shadow-luxe-lg transition-all duration-300">
                <div class="relative mb-6">
                    <div class="w-48 h-48 mx-auto rounded-full overflow-hidden">
                        <img src="{{ asset('images/team/sarah-johnson.svg') }}" 
                             alt="Sarah Johnson - Senior Color Specialist" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="absolute top-4 right-1/4 bg-gradient-to-r from-primary-500 to-secondary-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                        Master Stylist
                    </div>
                </div>
                <h3 class="text-2xl font-semibold text-gray-900 mb-2">Sarah Johnson</h3>
                <p class="text-primary-600 font-medium mb-3">Senior Color Specialist</p>
                <p class="text-gray-600 mb-4">12+ years experience specializing in advanced color techniques, balayage, and hair transformations.</p>
                
                <div class="space-y-2 text-sm text-gray-600 mb-6">
                    <div class="flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Certified Colorist</span>
                    </div>
                    <div class="flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Balayage Expert</span>
                    </div>
                    <div class="flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Bridal Specialist</span>
                    </div>
                </div>
                
                <x-ui.button href="{{ route('appointments.create', ['stylist' => 'sarah-johnson']) }}" variant="primary" size="sm">
                    Book with Sarah
                </x-ui.button>
            </x-ui.card>
            
            <!-- Senior Stylist 2 -->
            <x-ui.card class="text-center group hover:shadow-luxe-lg transition-all duration-300">
                <div class="relative mb-6">
                    <div class="w-48 h-48 mx-auto rounded-full overflow-hidden">
                        <img src="{{ asset('images/team/michael-rodriguez.svg') }}" 
                             alt="Michael Rodriguez - Creative Director" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="absolute top-4 right-1/4 bg-gradient-to-r from-secondary-500 to-primary-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                        Master Stylist
                    </div>
                </div>
                <h3 class="text-2xl font-semibold text-gray-900 mb-2">Michael Rodriguez</h3>
                <p class="text-primary-600 font-medium mb-3">Creative Director</p>
                <p class="text-gray-600 mb-4">15+ years experience in cutting-edge styles, precision cuts, and hair artistry for fashion shows.</p>
                
                <div class="space-y-2 text-sm text-gray-600 mb-6">
                    <div class="flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Precision Cutting</span>
                    </div>
                    <div class="flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Editorial Styling</span>
                    </div>
                    <div class="flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Men's Grooming</span>
                    </div>
                </div>
                
                <x-ui.button href="{{ route('appointments.create', ['stylist' => 'michael-rodriguez']) }}" variant="primary" size="sm">
                    Book with Michael
                </x-ui.button>
            </x-ui.card>
            
            <!-- Senior Stylist 3 -->
            <x-ui.card class="text-center group hover:shadow-luxe-lg transition-all duration-300">
                <div class="relative mb-6">
                    <div class="w-48 h-48 mx-auto rounded-full overflow-hidden">
                        <img src="{{ asset('images/team/emma-thompson.svg') }}" 
                             alt="Emma Thompson - Texture Specialist" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="absolute top-4 right-1/4 bg-gradient-to-r from-primary-500 to-secondary-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                        Master Stylist
                    </div>
                </div>
                <h3 class="text-2xl font-semibold text-gray-900 mb-2">Emma Thompson</h3>
                <p class="text-primary-600 font-medium mb-3">Texture Specialist</p>
                <p class="text-gray-600 mb-4">14+ years specializing in curly hair, natural textures, and keratin treatments.</p>
                
                <div class="space-y-2 text-sm text-gray-600 mb-6">
                    <div class="flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Curly Hair Expert</span>
                    </div>
                    <div class="flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Keratin Treatments</span>
                    </div>
                    <div class="flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Natural Hair Care</span>
                    </div>
                </div>
                
                <x-ui.button href="{{ route('appointments.create', ['stylist' => 'emma-thompson']) }}" variant="primary" size="sm">
                    Book with Emma
                </x-ui.button>
            </x-ui.card>
        </div>
    </div>
</section>

<!-- Stylists -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-serif font-bold text-gray-900 mb-4">Our Talented Stylists</h2>
            <p class="text-xl text-gray-600">Experienced professionals dedicated to your beauty goals</p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Stylist 1 -->
            <x-ui.card class="text-center group hover:shadow-luxe-lg transition-all duration-300">
                <div class="w-32 h-32 mx-auto bg-gradient-to-br from-primary-50 to-primary-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-16 h-16 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-1">Jessica Chen</h3>
                <p class="text-primary-600 text-sm font-medium mb-2">Hair Stylist</p>
                <p class="text-gray-600 text-sm mb-4">Specializes in modern cuts and everyday styling.</p>
                <x-ui.button href="{{ route('appointments.create', ['stylist' => 'jessica-chen']) }}" variant="outline" size="sm">
                    Book Now
                </x-ui.button>
            </x-ui.card>
            
            <!-- Stylist 2 -->
            <x-ui.card class="text-center group hover:shadow-luxe-lg transition-all duration-300">
                <div class="w-32 h-32 mx-auto bg-gradient-to-br from-secondary-50 to-secondary-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-16 h-16 text-secondary-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-1">David Kim</h3>
                <p class="text-primary-600 text-sm font-medium mb-2">Color Specialist</p>
                <p class="text-gray-600 text-sm mb-4">Expert in highlights and color correction.</p>
                <x-ui.button href="{{ route('appointments.create', ['stylist' => 'david-kim']) }}" variant="outline" size="sm">
                    Book Now
                </x-ui.button>
            </x-ui.card>
            
            <!-- Stylist 3 -->
            <x-ui.card class="text-center group hover:shadow-luxe-lg transition-all duration-300">
                <div class="w-32 h-32 mx-auto bg-gradient-to-br from-primary-50 to-secondary-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-16 h-16 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-1">Lisa Garcia</h3>
                <p class="text-primary-600 text-sm font-medium mb-2">Extension Specialist</p>
                <p class="text-gray-600 text-sm mb-4">Professional hair extensions and volume work.</p>
                <x-ui.button href="{{ route('appointments.create', ['stylist' => 'lisa-garcia']) }}" variant="outline" size="sm">
                    Book Now
                </x-ui.button>
            </x-ui.card>
            
            <!-- Stylist 4 -->
            <x-ui.card class="text-center group hover:shadow-luxe-lg transition-all duration-300">
                <div class="w-32 h-32 mx-auto bg-gradient-to-br from-secondary-50 to-primary-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-16 h-16 text-secondary-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-1">Ryan Williams</h3>
                <p class="text-primary-600 text-sm font-medium mb-2">Men's Specialist</p>
                <p class="text-gray-600 text-sm mb-4">Expert in men's cuts and grooming services.</p>
                <x-ui.button href="{{ route('appointments.create', ['stylist' => 'ryan-williams']) }}" variant="outline" size="sm">
                    Book Now
                </x-ui.button>
            </x-ui.card>
        </div>
    </div>
</section>

<!-- Spa Team -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-serif font-bold text-gray-900 mb-4">Spa & Wellness Team</h2>
            <p class="text-xl text-gray-600">Certified therapists for your relaxation and wellness needs</p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Spa Therapist 1 -->
            <x-ui.card class="text-center group hover:shadow-luxe-lg transition-all duration-300">
                <div class="w-40 h-40 mx-auto bg-gradient-to-br from-primary-50 to-primary-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-20 h-20 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Maria Santos</h3>
                <p class="text-primary-600 font-medium mb-3">Licensed Massage Therapist</p>
                <p class="text-gray-600 text-sm mb-4">Certified in Swedish, deep tissue, and hot stone massage techniques.</p>
                <x-ui.button href="{{ route('appointments.create', ['stylist' => 'maria-santos']) }}" variant="outline" size="sm">
                    Book Session
                </x-ui.button>
            </x-ui.card>
            
            <!-- Spa Therapist 2 -->
            <x-ui.card class="text-center group hover:shadow-luxe-lg transition-all duration-300">
                <div class="w-40 h-40 mx-auto bg-gradient-to-br from-secondary-50 to-secondary-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-20 h-20 text-secondary-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Ashley Brown</h3>
                <p class="text-primary-600 font-medium mb-3">Licensed Esthetician</p>
                <p class="text-gray-600 text-sm mb-4">Specialist in facial treatments, skin analysis, and anti-aging therapies.</p>
                <x-ui.button href="{{ route('appointments.create', ['stylist' => 'ashley-brown']) }}" variant="outline" size="sm">
                    Book Facial
                </x-ui.button>
            </x-ui.card>
            
            <!-- Spa Therapist 3 -->
            <x-ui.card class="text-center group hover:shadow-luxe-lg transition-all duration-300">
                <div class="w-40 h-40 mx-auto bg-gradient-to-br from-primary-50 to-secondary-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-20 h-20 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Jennifer Lee</h3>
                <p class="text-primary-600 font-medium mb-3">Nail Technician</p>
                <p class="text-gray-600 text-sm mb-4">Expert in manicures, pedicures, gel applications, and nail art.</p>
                <x-ui.button href="{{ route('appointments.create', ['stylist' => 'jennifer-lee']) }}" variant="outline" size="sm">
                    Book Nails
                </x-ui.button>
            </x-ui.card>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-primary-600">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-serif font-bold text-white mb-6">
            Ready to Meet Our Team?
        </h2>
        <p class="text-xl text-primary-100 mb-8">
            Book your appointment with one of our talented professionals today.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <x-ui.button 
                href="{{ route('appointments.create') }}" 
                variant="secondary" 
                size="lg"
                class="bg-white text-primary-600 hover:bg-gray-50"
            >
                Book Appointment
            </x-ui.button>
            
            <x-ui.button 
                href="{{ route('contact') }}" 
                variant="outline" 
                size="lg"
                class="border-white text-white hover:bg-white hover:text-primary-600"
            >
                Contact Us
            </x-ui.button>
        </div>
    </div>
</section>
@endsection