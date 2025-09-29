@extends('layouts.guest')

@section('title', 'About Us - Luxe Hair Studio')
@section('description', 'Learn about Luxe Hair Studio\'s story, mission, and commitment to excellence. Discover what makes us the premier destination for luxury hair care and spa services.')

@section('content')
<!-- Hero Section -->
<div class="relative py-24 bg-gradient-to-br from-primary-50 via-white to-secondary-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl font-serif font-bold text-gray-900 mb-6">
            About <span class="text-primary-600">Luxe Hair Studio</span>
        </h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Where passion meets artistry, and every client leaves feeling beautiful, confident, and renewed.
        </p>
    </div>
</div>

<!-- Our Story Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
            <div>
                <h2 class="text-4xl font-serif font-bold text-gray-900 mb-6">Our Story</h2>
                <div class="space-y-4 text-lg text-gray-600">
                    <p>
                        Founded in 2013, Luxe Hair Studio began with a simple vision: to create a sanctuary where 
                        beauty, artistry, and exceptional service converge. What started as a dream has evolved into 
                        one of Beverly Hills' most prestigious salon destinations.
                    </p>
                    <p>
                        Our founder, Isabella Martinez, envisioned a space that would revolutionize the traditional 
                        salon experience. With over 20 years in the beauty industry, she assembled a team of the 
                        most talented stylists and beauty professionals to bring this vision to life.
                    </p>
                    <p>
                        Today, Luxe Hair Studio stands as a testament to our commitment to excellence, innovation, 
                        and the belief that every client deserves to feel extraordinary.
                    </p>
                </div>
            </div>
            
            <div class="mt-12 lg:mt-0">
                <div class="bg-gradient-to-br from-primary-100 to-secondary-100 rounded-2xl aspect-square flex items-center justify-center">
                    <div class="text-center">
                        <svg class="w-32 h-32 text-primary-600 mx-auto mb-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">10+ Years</h3>
                        <p class="text-lg text-gray-600">of Excellence</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Values -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-serif font-bold text-gray-900 mb-4">Our Mission & Values</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Everything we do is guided by our core values and commitment to excellence.
            </p>
        </div>
        
        <div class="grid lg:grid-cols-3 gap-8 mb-16">
            <!-- Excellence -->
            <x-ui.card class="text-center group hover:shadow-luxe-lg transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-primary-100 to-primary-200 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Excellence</h3>
                <p class="text-gray-600">
                    We strive for perfection in every service, using only the finest products and techniques 
                    to deliver results that exceed expectations.
                </p>
            </x-ui.card>
            
            <!-- Innovation -->
            <x-ui.card class="text-center group hover:shadow-luxe-lg transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-secondary-100 to-secondary-200 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Innovation</h3>
                <p class="text-gray-600">
                    We continuously evolve and adopt the latest trends, techniques, and technologies 
                    to stay at the forefront of the beauty industry.
                </p>
            </x-ui.card>
            
            <!-- Care -->
            <x-ui.card class="text-center group hover:shadow-luxe-lg transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Genuine Care</h3>
                <p class="text-gray-600">
                    Every client is treated like family. We listen, understand, and create personalized 
                    experiences that make you feel valued and beautiful.
                </p>
            </x-ui.card>
        </div>
        
        <!-- Mission Statement -->
        <x-ui.card class="bg-gradient-to-r from-primary-50 to-secondary-50 border-none">
            <div class="text-center">
                <h3 class="text-2xl font-serif font-bold text-gray-900 mb-4">Our Mission</h3>
                <p class="text-lg text-gray-700 max-w-4xl mx-auto leading-relaxed">
                    "To empower every individual through transformative beauty experiences that enhance not just 
                    their appearance, but their confidence and well-being. We are committed to creating a luxurious, 
                    welcoming environment where artistry meets innovation, and every client leaves feeling like 
                    the best version of themselves."
                </p>
            </div>
        </x-ui.card>
    </div>
</section>

<!-- Awards & Recognition -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-serif font-bold text-gray-900 mb-4">Awards & Recognition</h2>
            <p class="text-xl text-gray-600">Our commitment to excellence has been recognized by industry leaders</p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <x-ui.card class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-primary-100 to-primary-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Salon of the Year</h3>
                <p class="text-sm text-gray-600">Beauty Industry Awards 2023</p>
            </x-ui.card>
            
            <x-ui.card class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-secondary-100 to-secondary-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-secondary-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Best Customer Service</h3>
                <p class="text-sm text-gray-600">LA Beauty Awards 2023</p>
            </x-ui.card>
            
            <x-ui.card class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Top Rated Salon</h3>
                <p class="text-sm text-gray-600">Yelp & Google Reviews</p>
            </x-ui.card>
            
            <x-ui.card class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-secondary-100 to-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-secondary-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Eco-Friendly Salon</h3>
                <p class="text-sm text-gray-600">Green Beauty Certification</p>
            </x-ui.card>
        </div>
    </div>
</section>

<!-- Our Commitment -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
            <div class="mb-12 lg:mb-0">
                <div class="bg-gradient-to-br from-primary-100 to-secondary-100 rounded-2xl aspect-square flex items-center justify-center">
                    <div class="text-center">
                        <svg class="w-32 h-32 text-primary-600 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Our Promise</h3>
                        <p class="text-lg text-gray-600">To You</p>
                    </div>
                </div>
            </div>
            
            <div>
                <h2 class="text-4xl font-serif font-bold text-gray-900 mb-6">Our Commitment to You</h2>
                
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Personalized Experience</h3>
                            <p class="text-gray-600">Every service is tailored to your unique needs, preferences, and lifestyle.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Continuous Education</h3>
                            <p class="text-gray-600">Our team regularly attends workshops and training to stay current with trends and techniques.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Sustainable Practices</h3>
                            <p class="text-gray-600">We're committed to environmentally responsible practices and eco-friendly products.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Client Satisfaction</h3>
                            <p class="text-gray-600">Your happiness is our priority. We stand behind every service with a satisfaction guarantee.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Community Impact -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-serif font-bold text-gray-900 mb-4">Giving Back</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                We believe in supporting our community and making a positive impact beyond our salon doors.
            </p>
        </div>
        
        <div class="grid lg:grid-cols-3 gap-8">
            <x-ui.card class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-primary-100 to-primary-200 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Charity Partnerships</h3>
                <p class="text-gray-600">
                    We partner with local charities to provide beauty services for special events and fundraisers.
                </p>
            </x-ui.card>
            
            <x-ui.card class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-secondary-100 to-secondary-200 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Education Programs</h3>
                <p class="text-gray-600">
                    We support beauty education through scholarships and mentorship programs for aspiring stylists.
                </p>
            </x-ui.card>
            
            <x-ui.card class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9-9a9 9 0 00-9 9m0 0a9 9 0 019-9"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Environmental Impact</h3>
                <p class="text-gray-600">
                    Our eco-friendly practices include recycling programs and partnerships with sustainable product brands.
                </p>
            </x-ui.card>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-primary-600">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-serif font-bold text-white mb-6">
            Experience the Luxe Difference
        </h2>
        <p class="text-xl text-primary-100 mb-8">
            Join thousands of satisfied clients who have made Luxe Hair Studio their beauty destination.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <x-ui.button 
                href="{{ route('appointments.create') }}" 
                variant="secondary" 
                size="lg"
                class="bg-white text-primary-600 hover:bg-gray-50"
            >
                Book Your First Visit
            </x-ui.button>
            
            <x-ui.button 
                href="{{ route('services') }}" 
                variant="outline" 
                size="lg"
                class="border-white text-white hover:bg-white hover:text-primary-600"
            >
                View Our Services
            </x-ui.button>
        </div>
    </div>
</section>
@endsection