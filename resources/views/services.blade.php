@extends('layouts.guest')

@section('title', 'Our Services - Luxe Hair St                <x-ui.card class="group hover:shadow-luxe-lg transition-all duration-300">
                    <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-lg p-6 mb-4">
                        <img src="{{ asset('images/services/hair-extensions.svg') }}" 
                             alt="Hair Extensions" 
                             class="w-16 h-16 mx-auto">
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Hair Extensions</h3>
                    <p class="text-gray-600 mb-4">Premium quality extensions for length and volume using the latest application techniques.</p>
                    <div class="text-primary-600 font-semibold">Starting from $120</div>
                </x-ui.card>ection('description', 'Explore our comprehensive range of premium salon services including hair cuts, coloring, spa treatments, and more at Luxe Hair Studio.')

@section('content')
<!-- Hero Section -->
<div class="relative py-24 bg-gradient-to-br from-primary-50 via-white to-secondary-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl font-serif font-bold text-gray-900 mb-6">
            Our <span class="text-primary-600">Services</span>
        </h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            From precision cuts to luxurious spa treatments, discover our full range of premium services 
            designed to enhance your natural beauty and boost your confidence.
        </p>
    </div>
</div>

<!-- Services Grid -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Hair Services -->
        <div class="mb-20">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-serif font-bold text-gray-900 mb-4">Hair Services</h2>
                <p class="text-lg text-gray-600">Professional hair care and styling services</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <x-ui.card class="group hover:shadow-luxe-lg transition-all duration-300">
                    <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-lg p-6 mb-4">
                        <img src="{{ asset('images/services/hair-cutting.svg') }}" 
                             alt="Hair Cuts & Styling" 
                             class="w-16 h-16 mx-auto">
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Hair Cuts & Styling</h3>
                    <p class="text-gray-600 mb-4">Expert cuts tailored to your face shape and lifestyle. From classic to contemporary styles.</p>
                    <div class="text-primary-600 font-semibold">Starting from $45</div>
                </x-ui.card>
                
                <x-ui.card class="group hover:shadow-luxe-lg transition-all duration-300">
                    <div class="bg-gradient-to-br from-secondary-50 to-secondary-100 rounded-lg p-6 mb-4">
                        <img src="{{ asset('images/services/hair-coloring.svg') }}" 
                             alt="Hair Coloring" 
                             class="w-16 h-16 mx-auto">
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Hair Coloring</h3>
                    <p class="text-gray-600 mb-4">Full color services including highlights, lowlights, balayage, and complete color transformations.</p>
                    <div class="text-primary-600 font-semibold">Starting from $85</div>
                </x-ui.card>
                
                <x-ui.card class="group hover:shadow-luxe-lg transition-all duration-300">
                    <div class="bg-gradient-to-br from-primary-50 to-secondary-50 rounded-lg p-6 mb-4">
                        <img src="{{ asset('images/services/hair-treatments.svg') }}" 
                             alt="Hair Treatments" 
                             class="w-16 h-16 mx-auto">
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Hair Treatments</h3>
                    <p class="text-gray-600 mb-4">Deep conditioning, keratin treatments, and scalp therapies to restore hair health.</p>
                    <div class="text-primary-600 font-semibold">Starting from $35</div>
                </x-ui.card>
                
                <x-ui.card class="group hover:shadow-luxe-lg transition-all duration-300">
                    <div class="bg-gradient-to-br from-secondary-50 to-primary-50 rounded-lg p-6 mb-4">
                        <img src="{{ asset('images/services/bridal-services.svg') }}" 
                             alt="Bridal Services" 
                             class="w-16 h-16 mx-auto">
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Bridal Services</h3>
                    <p class="text-gray-600 mb-4">Complete bridal packages including trial runs and wedding day styling services.</p>
                    <div class="text-primary-600 font-semibold">Starting from $150</div>
                </x-ui.card>
                
                <x-ui.card class="group hover:shadow-luxe-lg transition-all duration-300">
                    <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-lg p-6 mb-4">
                        <svg class="w-12 h-12 text-primary-600 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Extensions</h3>
                    <p class="text-gray-600 mb-4">Premium hair extensions using the finest quality human hair for natural-looking length and volume.</p>
                    <div class="text-primary-600 font-semibold">Starting from $200</div>
                </x-ui.card>
                
                <x-ui.card class="group hover:shadow-luxe-lg transition-all duration-300">
                    <div class="bg-gradient-to-br from-secondary-50 to-secondary-100 rounded-lg p-6 mb-4">
                        <svg class="w-12 h-12 text-secondary-600 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Blowouts & Styling</h3>
                    <p class="text-gray-600 mb-4">Professional blowouts and special occasion styling for events and everyday glamour.</p>
                    <div class="text-primary-600 font-semibold">Starting from $35</div>
                </x-ui.card>
            </div>
        </div>
        
        <!-- Spa Services -->
        <div class="mb-20">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-serif font-bold text-gray-900 mb-4">Spa & Wellness</h2>
                <p class="text-lg text-gray-600">Relaxation and rejuvenation treatments</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <x-ui.card class="group hover:shadow-luxe-lg transition-all duration-300">
                    <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-lg p-6 mb-4">
                        <svg class="w-12 h-12 text-primary-600 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Facial Treatments</h3>
                    <p class="text-gray-600 mb-4">Customized facials to cleanse, exfoliate, and nourish your skin for a healthy glow.</p>
                    <div class="text-primary-600 font-semibold">Starting from $75</div>
                </x-ui.card>
                
                <x-ui.card class="group hover:shadow-luxe-lg transition-all duration-300">
                    <div class="bg-gradient-to-br from-secondary-50 to-secondary-100 rounded-lg p-6 mb-4">
                        <svg class="w-12 h-12 text-secondary-600 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Massage Therapy</h3>
                    <p class="text-gray-600 mb-4">Relaxing massages including Swedish, deep tissue, and hot stone treatments.</p>
                    <div class="text-primary-600 font-semibold">Starting from $90</div>
                </x-ui.card>
                
                <x-ui.card class="group hover:shadow-luxe-lg transition-all duration-300">
                    <div class="bg-gradient-to-br from-primary-50 to-secondary-50 rounded-lg p-6 mb-4">
                        <svg class="w-12 h-12 text-primary-600 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Manicure & Pedicure</h3>
                    <p class="text-gray-600 mb-4">Complete nail care services including classic and gel manicures and luxury pedicures.</p>
                    <div class="text-primary-600 font-semibold">Starting from $25</div>
                </x-ui.card>
            </div>
        </div>
        
        <!-- Specialty Services -->
        <div>
            <div class="text-center mb-12">
                <h2 class="text-3xl font-serif font-bold text-gray-900 mb-4">Specialty Services</h2>
                <p class="text-lg text-gray-600">Unique treatments and specialized services</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <x-ui.card class="group hover:shadow-luxe-lg transition-all duration-300">
                    <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-lg p-6 mb-4">
                        <svg class="w-12 h-12 text-primary-600 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Makeup Services</h3>
                    <p class="text-gray-600 mb-4">Professional makeup application for special events, photoshoots, and everyday looks.</p>
                    <div class="text-primary-600 font-semibold">Starting from $50</div>
                </x-ui.card>
                
                <x-ui.card class="group hover:shadow-luxe-lg transition-all duration-300">
                    <div class="bg-gradient-to-br from-secondary-50 to-secondary-100 rounded-lg p-6 mb-4">
                        <svg class="w-12 h-12 text-secondary-600 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Eyebrow & Lash Services</h3>
                    <p class="text-gray-600 mb-4">Eyebrow shaping, tinting, lash extensions, and lash lifts to enhance your natural features.</p>
                    <div class="text-primary-600 font-semibold">Starting from $20</div>
                </x-ui.card>
                
                <x-ui.card class="group hover:shadow-luxe-lg transition-all duration-300">
                    <div class="bg-gradient-to-br from-primary-50 to-secondary-50 rounded-lg p-6 mb-4">
                        <svg class="w-12 h-12 text-primary-600 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Consultation Services</h3>
                    <p class="text-gray-600 mb-4">Personal style consultations to help you discover your perfect look and maintenance routine.</p>
                    <div class="text-primary-600 font-semibold">Starting from $30</div>
                </x-ui.card>
            </div>
        </div>
    </div>
</section>

<!-- Packages Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-serif font-bold text-gray-900 mb-4">Popular Packages</h2>
            <p class="text-lg text-gray-600">Save more with our curated service packages</p>
        </div>
        
        <div class="grid lg:grid-cols-3 gap-8">
            <x-ui.card class="relative overflow-hidden">
                <div class="absolute top-4 right-4 bg-secondary-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                    Save 15%
                </div>
                <h3 class="text-2xl font-semibold text-gray-900 mb-3">Complete Makeover</h3>
                <p class="text-gray-600 mb-6">Cut, color, styling, and makeup application for a complete transformation.</p>
                <div class="space-y-2 mb-6">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Cut & Style</span>
                        <span class="line-through text-gray-400">$65</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Full Color</span>
                        <span class="line-through text-gray-400">$120</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Makeup</span>
                        <span class="line-through text-gray-400">$50</span>
                    </div>
                    <hr class="my-2">
                    <div class="flex justify-between font-semibold text-lg">
                        <span>Package Price</span>
                        <span class="text-primary-600">$199</span>
                    </div>
                </div>
                <x-ui.button href="{{ route('appointments.create') }}" variant="primary" size="lg" class="w-full">
                    Book Package
                </x-ui.button>
            </x-ui.card>
            
            <x-ui.card class="relative overflow-hidden">
                <div class="absolute top-4 right-4 bg-secondary-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                    Save 20%
                </div>
                <h3 class="text-2xl font-semibold text-gray-900 mb-3">Spa Day Retreat</h3>
                <p class="text-gray-600 mb-6">Full day of relaxation with facial, massage, and nail services.</p>
                <div class="space-y-2 mb-6">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Facial Treatment</span>
                        <span class="line-through text-gray-400">$85</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">60min Massage</span>
                        <span class="line-through text-gray-400">$110</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Mani & Pedi</span>
                        <span class="line-through text-gray-400">$55</span>
                    </div>
                    <hr class="my-2">
                    <div class="flex justify-between font-semibold text-lg">
                        <span>Package Price</span>
                        <span class="text-primary-600">$199</span>
                    </div>
                </div>
                <x-ui.button href="{{ route('appointments.create') }}" variant="primary" size="lg" class="w-full">
                    Book Package
                </x-ui.button>
            </x-ui.card>
            
            <x-ui.card class="relative overflow-hidden">
                <div class="absolute top-4 right-4 bg-secondary-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                    Save 25%
                </div>
                <h3 class="text-2xl font-semibold text-gray-900 mb-3">Bridal Beauty</h3>
                <p class="text-gray-600 mb-6">Complete bridal package with trial and wedding day services.</p>
                <div class="space-y-2 mb-6">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Hair Trial</span>
                        <span class="line-through text-gray-400">$75</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Makeup Trial</span>
                        <span class="line-through text-gray-400">$65</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Wedding Day</span>
                        <span class="line-through text-gray-400">$200</span>
                    </div>
                    <hr class="my-2">
                    <div class="flex justify-between font-semibold text-lg">
                        <span>Package Price</span>
                        <span class="text-primary-600">$255</span>
                    </div>
                </div>
                <x-ui.button href="{{ route('appointments.create') }}" variant="primary" size="lg" class="w-full">
                    Book Package
                </x-ui.button>
            </x-ui.card>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-primary-600">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-serif font-bold text-white mb-6">
            Book Your Service Today
        </h2>
        <p class="text-xl text-primary-100 mb-8">
            Ready to experience the luxury you deserve? Schedule your appointment now.
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
                Have Questions?
            </x-ui.button>
        </div>
    </div>
</section>
@endsection