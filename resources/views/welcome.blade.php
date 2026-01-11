@extends('layouts.app')

@section('title', 'Home - MedCLINIC')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-500 to-blue-600 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-6">Welcome to MedCLINIC</h1>
        <p class="text-xl mb-8 max-w-3xl mx-auto">Book your medical appointments easily with our online scheduling system. Find the right doctor and get instant queue numbers.</p>
        @guest
        <div class="space-x-4">
            <a href="{{ route('register') }}" class="bg-white text-blue-600 hover:bg-gray-100 px-6 py-3 rounded-lg font-semibold text-lg inline-block">Get Started</a>
            <a href="{{ route('login') }}" class="bg-transparent border-2 border-white hover:bg-blue-700 px-6 py-3 rounded-lg font-semibold text-lg inline-block">Login</a>
        </div>
        @endguest
        @auth
        <a href="/doctors" class="bg-white text-blue-600 hover:bg-gray-100 px-6 py-3 rounded-lg font-semibold text-lg inline-block">Book Appointment</a>
        @endauth
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Why Choose MedCLINIC?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6 rounded-lg bg-blue-50">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3">Easy Scheduling</h3>
                <p class="text-gray-600">Book appointments 24/7 with our easy-to-use online platform.</p>
            </div>
            
            <div class="text-center p-6 rounded-lg bg-blue-50">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3">Expert Doctors</h3>
                <p class="text-gray-600">Access to qualified medical professionals from various specialties.</p>
            </div>
            
            <div class="text-center p-6 rounded-lg bg-blue-50">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3">Queue Management</h3>
                <p class="text-gray-600">Get automatic queue numbers and real-time updates on your appointment.</p>
            </div>
        </div>
    </div>
</section>

<!-- About Us Section -->
<section id="about" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">About MedCLINIC</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h3 class="text-2xl font-semibold mb-4">Revolutionizing Healthcare Appointments</h3>
                <p class="text-gray-600 mb-4">MedCLINIC is a comprehensive platform designed to simplify the process of booking medical appointments. We bridge the gap between patients and healthcare providers through our innovative scheduling system.</p>
                <p class="text-gray-600 mb-4">Our mission is to make healthcare more accessible and efficient by eliminating long waiting times and providing transparent scheduling options.</p>
                <p class="text-gray-600">With automatic queue management and real-time updates, patients can better plan their visits and reduce time spent in waiting rooms.</p>
            </div>
            <div class="bg-white p-8 rounded-lg shadow-lg">
                <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Medical Team" class="rounded-lg w-full h-64 object-cover">
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">How It Works</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 font-bold text-xl">1</div>
                <h3 class="font-semibold mb-2">Create Account</h3>
                <p class="text-gray-600">Register with your basic information</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 font-bold text-xl">2</div>
                <h3 class="font-semibold mb-2">Find Doctor</h3>
                <p class="text-gray-600">Browse doctors by specialty</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 font-bold text-xl">3</div>
                <h3 class="font-semibold mb-2">Book Appointment</h3>
                <p class="text-gray-600">Select available time slot</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 font-bold text-xl">4</div>
                <h3 class="font-semibold mb-2">Get Queue Number</h3>
                <p class="text-gray-600">Receive automatic queue number</p>
            </div>
        </div>
    </div>
</section>

<section id="contact" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Contact & Visit Us</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 transition hover:shadow-md">
                <h3 class="text-xl font-bold mb-6 text-blue-600 uppercase tracking-wide text-sm">Direct Contact</h3>
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-4 shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Main Clinic</h4>
                            <p class="text-gray-600 text-sm">123 Medical Street, Healthcare City, HC 12345</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-4 shrink-0">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Phone Support</h4>
                            <p class="text-gray-600 text-sm">(123) 456-7890</p>
                            <p class="text-red-500 text-xs font-bold mt-1 uppercase">Emergency: 911-000</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center mr-4 shrink-0">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Email Address</h4>
                            <p class="text-gray-600 text-sm">info@medclinic.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 transition hover:shadow-md">
                <h3 class="text-xl font-bold mb-6 text-blue-600 uppercase tracking-wide text-sm">Operating Hours</h3>
                <ul class="space-y-4">
                    <li class="flex justify-between border-b border-gray-50 pb-2">
                        <span class="text-gray-600">Monday - Friday</span>
                        <span class="font-bold text-gray-900">08:00 - 20:00</span>
                    </li>
                    <li class="flex justify-between border-b border-gray-50 pb-2">
                        <span class="text-gray-600">Saturday</span>
                        <span class="font-bold text-gray-900">09:00 - 17:00</span>
                    </li>
                    <li class="flex justify-between border-b border-gray-50 pb-2">
                        <span class="text-gray-600">Sunday</span>
                        <span class="font-bold text-red-500 uppercase text-xs self-center">Closed</span>
                    </li>
                    <li class="mt-4 p-4 bg-yellow-50 rounded-2xl">
                        <p class="text-xs text-yellow-800 leading-relaxed">
                            <strong>Note:</strong> Public holiday hours may vary. Please check our Instagram for the latest updates.
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection