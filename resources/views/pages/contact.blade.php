@extends('layouts.guest')

@section('content')
    @section('title', 'Contact Us')
    @section('description', 'Get in touch with Luxe Hair Studio. Book an appointment, ask questions, or visit us at our convenient location.')

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent mb-4">
                    Contact Us
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Ready to transform your look? We'd love to hear from you. Get in touch to book your appointment 
                    or learn more about our services.
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div class="bg-white rounded-2xl shadow-lg p-8 border border-rose-100/50">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Send us a Message</h2>
                    <form action="#" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-2">First Name</label>
                                <input type="text" 
                                       id="first_name" 
                                       name="first_name" 
                                       required
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-rose-500 focus:ring-0 transition-colors">
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-2">Last Name</label>
                                <input type="text" 
                                       id="last_name" 
                                       name="last_name" 
                                       required
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-rose-500 focus:ring-0 transition-colors">
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-rose-500 focus:ring-0 transition-colors">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-rose-500 focus:ring-0 transition-colors">
                        </div>

                        <div>
                            <label for="service" class="block text-sm font-semibold text-gray-700 mb-2">Service Interest</label>
                            <select id="service" 
                                    name="service"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-rose-500 focus:ring-0 transition-colors">
                                <option value="">Select a service</option>
                                <option value="haircut">Haircut & Styling</option>
                                <option value="color">Hair Color</option>
                                <option value="highlights">Highlights & Lowlights</option>
                                <option value="treatment">Hair Treatment</option>
                                <option value="bridal">Bridal Services</option>
                                <option value="nails">Nail Services</option>
                                <option value="consultation">Consultation</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Message</label>
                            <textarea id="message" 
                                      name="message" 
                                      rows="4"
                                      placeholder="Tell us about your hair goals, preferred appointment times, or any questions you have..."
                                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-rose-500 focus:ring-0 transition-colors resize-none"></textarea>
                        </div>

                        <button type="submit" 
                                class="w-full px-8 py-4 bg-gradient-to-r from-rose-500 to-pink-600 text-white rounded-xl font-semibold hover:from-rose-600 hover:to-pink-700 transition-all duration-200 hover:scale-105 shadow-lg">
                            Send Message
                        </button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="space-y-8">
                    <!-- Contact Details -->
                    <div class="bg-gradient-to-br from-rose-50 to-pink-50 rounded-2xl p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Get in Touch</h2>
                        <div class="space-y-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-rose-500 to-pink-600 rounded-2xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Visit Our Salon</h3>
                                    <p class="text-gray-600">123 Main Street<br>Kandy, Sri Lanka</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-rose-500 to-pink-600 rounded-2xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Call Us</h3>
                                    <p class="text-gray-600">+94 71 234 5678<br>Main Line</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-rose-500 to-pink-600 rounded-2xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Email Us</h3>
                                    <p class="text-gray-600">info@luxehairstudio.lk<br>bookings@luxehairstudio.lk</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hours -->
                    <div class="bg-white rounded-2xl shadow-lg p-8 border border-rose-100/50">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Hours of Operation</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Monday - Saturday</span>
                                <span class="font-semibold text-gray-900">9:00 AM - 7:00 PM</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Sunday</span>
                                <span class="font-semibold text-gray-900">10:00 AM - 5:00 PM</span>
                            </div>
                        </div>
                        <div class="mt-6 p-4 bg-rose-50 rounded-xl">
                            <p class="text-sm text-rose-700">
                                <strong>Note:</strong> Extended hours available by appointment. 
                                Walk-ins welcome based on availability.
                            </p>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-gradient-to-r from-rose-500 to-pink-600 rounded-2xl p-8 text-white">
                        <h3 class="text-xl font-bold mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            <a href="{{ route('book-service') }}" 
                               class="flex items-center space-x-3 p-3 bg-white/20 rounded-xl hover:bg-white/30 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                <span>Book Online Appointment</span>
                            </a>
                            <a href="{{ route('services') }}" 
                               class="flex items-center space-x-3 p-3 bg-white/20 rounded-xl hover:bg-white/30 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <span>View Our Services</span>
                            </a>
                            <a href="{{ route('about') }}" 
                               class="flex items-center space-x-3 p-3 bg-white/20 rounded-xl hover:bg-white/30 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>About Our Salon</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map Section -->
            <div class="mt-16">
                <div class="bg-white rounded-2xl shadow-lg p-8 border border-rose-100/50">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Find Us</h2>
                    <div class="w-full h-96 bg-gradient-to-br from-rose-100 to-pink-100 rounded-xl flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-rose-500 to-pink-600 rounded-2xl mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Interactive Map</h3>
                            <p class="text-gray-600 mb-4">123 Beauty Lane, Luxury District</p>
                            <p class="text-sm text-gray-500">Map integration coming soon</p>
                        </div>
                    </div>
                    <div class="mt-6 text-center">
                        <p class="text-gray-600 mb-4">
                            Convenient parking available. Located in the heart of the Luxury District with easy access to public transportation.
                        </p>
                        <a href="#" 
                           class="inline-flex items-center space-x-2 text-rose-600 hover:text-rose-700 font-semibold">
                            <span>Get Directions</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection