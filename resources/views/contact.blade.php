@extends('layouts.guest')

@section('title', 'Contact Us - Luxe Hair Studio')
@section('description', 'Get in touch with Luxe Hair Studio. Visit us, call, or send a message. We\'re here to answer your questions and help you book your perfect appointment.')

@section('content')
<!-- Hero Section -->
<div class="relative py-24 bg-gradient-to-br from-primary-50 via-white to-secondary-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl font-serif font-bold text-gray-900 mb-6">
            Get in <span class="text-primary-600">Touch</span>
        </h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            We'd love to hear from you. Send us a message and we'll respond as soon as possible.
        </p>
    </div>
</div>

<!-- Contact Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-16">
            <!-- Contact Form -->
            <div>
                <x-ui.card>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-6">Send us a Message</h2>
                    
                    <form class="space-y-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <x-ui.input 
                                    name="first_name" 
                                    label="First Name" 
                                    placeholder="Your first name"
                                    required 
                                />
                            </div>
                            <div>
                                <x-ui.input 
                                    name="last_name" 
                                    label="Last Name" 
                                    placeholder="Your last name"
                                    required 
                                />
                            </div>
                        </div>
                        
                        <div>
                            <x-ui.input 
                                name="email" 
                                type="email"
                                label="Email Address" 
                                placeholder="your.email@example.com"
                                required 
                            />
                        </div>
                        
                        <div>
                            <x-ui.input 
                                name="phone" 
                                type="tel"
                                label="Phone Number" 
                                placeholder="(123) 456-7890"
                            />
                        </div>
                        
                        <div>
                            <label for="service_interest" class="block text-sm font-medium text-gray-700 mb-2">
                                Service Interest
                            </label>
                            <select name="service_interest" id="service_interest" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <option value="">Select a service (optional)</option>
                                <option value="hair_cut">Hair Cut & Styling</option>
                                <option value="hair_color">Hair Coloring</option>
                                <option value="hair_treatment">Hair Treatments</option>
                                <option value="bridal">Bridal Services</option>
                                <option value="extensions">Hair Extensions</option>
                                <option value="facial">Facial Treatments</option>
                                <option value="massage">Massage Therapy</option>
                                <option value="nails">Nail Services</option>
                                <option value="makeup">Makeup Services</option>
                                <option value="consultation">Consultation</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                Message
                            </label>
                            <textarea 
                                name="message" 
                                id="message" 
                                rows="4"
                                placeholder="Tell us how we can help you..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                required
                            ></textarea>
                        </div>
                        
                        <x-ui.button type="submit" variant="primary" size="lg" class="w-full">
                            Send Message
                        </x-ui.button>
                    </form>
                </x-ui.card>
            </div>
            
            <!-- Contact Information -->
            <div class="mt-12 lg:mt-0">
                <div class="space-y-8">
                    <!-- Location -->
                    <x-ui.card>
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Visit Our Salon</h3>
                                <p class="text-gray-600">
                                    123 Luxury Lane<br>
                                    Beverly Hills, CA 90210<br>
                                    United States
                                </p>
                            </div>
                        </div>
                    </x-ui.card>
                    
                    <!-- Phone -->
                    <x-ui.card>
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-secondary-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Call Us</h3>
                                <p class="text-gray-600">
                                    <a href="tel:+1234567890" class="hover:text-primary-600 transition-colors">
                                        (123) 456-7890
                                    </a><br>
                                    <a href="tel:+1234567891" class="hover:text-primary-600 transition-colors">
                                        (123) 456-7891
                                    </a>
                                </p>
                            </div>
                        </div>
                    </x-ui.card>
                    
                    <!-- Email -->
                    <x-ui.card>
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Email Us</h3>
                                <p class="text-gray-600">
                                    <a href="mailto:info@luxehairstudio.com" class="hover:text-primary-600 transition-colors">
                                        info@luxehairstudio.com
                                    </a><br>
                                    <a href="mailto:appointments@luxehairstudio.com" class="hover:text-primary-600 transition-colors">
                                        appointments@luxehairstudio.com
                                    </a>
                                </p>
                            </div>
                        </div>
                    </x-ui.card>
                    
                    <!-- Hours -->
                    <x-ui.card>
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-secondary-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Business Hours</h3>
                                <div class="text-gray-600 space-y-1">
                                    <div class="flex justify-between">
                                        <span>Monday - Thursday</span>
                                        <span>9:00 AM - 8:00 PM</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Friday - Saturday</span>
                                        <span>9:00 AM - 9:00 PM</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Sunday</span>
                                        <span>10:00 AM - 6:00 PM</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-ui.card>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-serif font-bold text-gray-900 mb-4">Find Us</h2>
            <p class="text-lg text-gray-600">Located in the heart of Beverly Hills</p>
        </div>
        
        <!-- Map placeholder -->
        <div class="bg-gradient-to-br from-primary-100 to-secondary-100 rounded-lg h-96 flex items-center justify-center">
            <div class="text-center">
                <svg class="w-16 h-16 text-primary-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Interactive Map</h3>
                <p class="text-gray-600 mb-4">Google Maps integration would be displayed here</p>
                <x-ui.button 
                    href="https://maps.google.com/?q=123+Luxury+Lane,+Beverly+Hills,+CA+90210" 
                    target="_blank"
                    variant="primary"
                >
                    Open in Google Maps
                </x-ui.button>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-serif font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
            <p class="text-lg text-gray-600">Quick answers to common questions</p>
        </div>
        
        <div class="space-y-6">
            <x-ui.card>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">How far in advance should I book my appointment?</h3>
                <p class="text-gray-600">We recommend booking 1-2 weeks in advance for regular services and 3-4 weeks for special events or bridal services.</p>
            </x-ui.card>
            
            <x-ui.card>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">What's your cancellation policy?</h3>
                <p class="text-gray-600">We require 24-hour notice for cancellations. Late cancellations may incur a fee.</p>
            </x-ui.card>
            
            <x-ui.card>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Do you offer consultations?</h3>
                <p class="text-gray-600">Yes! We offer complimentary consultations for color services and paid consultations for complete style makeovers.</p>
            </x-ui.card>
            
            <x-ui.card>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">What payment methods do you accept?</h3>
                <p class="text-gray-600">We accept cash, all major credit cards, and contactless payments including Apple Pay and Google Pay.</p>
            </x-ui.card>
            
            <x-ui.card>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Do you offer parking?</h3>
                <p class="text-gray-600">Yes, we have complimentary valet parking available for all clients during business hours.</p>
            </x-ui.card>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-primary-600">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-serif font-bold text-white mb-6">
            Ready to Book Your Appointment?
        </h2>
        <p class="text-xl text-primary-100 mb-8">
            Don't wait - schedule your luxury salon experience today.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <x-ui.button 
                href="{{ route('appointments.create') }}" 
                variant="secondary" 
                size="lg"
                class="bg-white text-primary-600 hover:bg-gray-50"
            >
                Book Online
            </x-ui.button>
            
            <x-ui.button 
                href="tel:+1234567890" 
                variant="outline" 
                size="lg"
                class="border-white text-white hover:bg-white hover:text-primary-600"
            >
                Call Now
            </x-ui.button>
        </div>
    </div>
</section>
@endsection