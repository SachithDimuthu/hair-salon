@extends('layouts.app')

@section('title', 'Loyalty Program')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-rose-50 to-pink-50 rounded-lg shadow-sm border p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-serif font-bold text-gray-900">Loyalty Rewards</h1>
                <p class="text-gray-600 mt-1">Earn points with every visit and unlock exclusive rewards</p>
            </div>
            <div class="text-center">
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <p class="text-2xl font-bold text-rose-600">0</p>
                    <p class="text-sm text-gray-500">Points</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Loyalty Status -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Current Status -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Status</h3>
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold">Bronze Member</p>
                    <p class="text-sm text-gray-500">Welcome to our loyalty program!</p>
                </div>
            </div>
        </div>

        <!-- Next Reward -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Next Reward</h3>
            <div class="text-center">
                <p class="text-sm text-gray-500 mb-2">100 points needed for</p>
                <p class="font-semibold text-rose-600">10% Discount Voucher</p>
                <div class="mt-4 bg-gray-200 rounded-full h-2">
                    <div class="bg-rose-600 h-2 rounded-full" style="width: 0%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-1">0 / 100 points</p>
            </div>
        </div>
    </div>

    <!-- How to Earn Points -->
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">How to Earn Points</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center p-4 bg-rose-50 rounded-lg">
                <svg class="mx-auto h-8 w-8 text-rose-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="font-semibold">Book Appointments</p>
                <p class="text-sm text-gray-600">1 point per LKR 100 spent</p>
            </div>
            <div class="text-center p-4 bg-rose-50 rounded-lg">
                <svg class="mx-auto h-8 w-8 text-rose-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <p class="font-semibold">Refer Friends</p>
                <p class="text-sm text-gray-600">50 points per referral</p>
            </div>
            <div class="text-center p-4 bg-rose-50 rounded-lg">
                <svg class="mx-auto h-8 w-8 text-rose-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
                <p class="font-semibold">Leave Reviews</p>
                <p class="text-sm text-gray-600">25 points per review</p>
            </div>
        </div>
    </div>

    <!-- Rewards Catalog -->
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Available Rewards</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="border rounded-lg p-4 text-center">
                <p class="font-semibold">10% Off Voucher</p>
                <p class="text-rose-600 font-bold">100 Points</p>
                <p class="text-sm text-gray-500 mt-1">Valid for any service</p>
                <button disabled class="mt-3 w-full bg-gray-300 text-gray-500 px-4 py-2 rounded-md text-sm">
                    Need 100 more points
                </button>
            </div>
            <div class="border rounded-lg p-4 text-center">
                <p class="font-semibold">Free Hair Wash</p>
                <p class="text-rose-600 font-bold">150 Points</p>
                <p class="text-sm text-gray-500 mt-1">Complimentary service</p>
                <button disabled class="mt-3 w-full bg-gray-300 text-gray-500 px-4 py-2 rounded-md text-sm">
                    Need 150 more points
                </button>
            </div>
            <div class="border rounded-lg p-4 text-center">
                <p class="font-semibold">20% Off Voucher</p>
                <p class="text-rose-600 font-bold">250 Points</p>
                <p class="text-sm text-gray-500 mt-1">Valid for premium services</p>
                <button disabled class="mt-3 w-full bg-gray-300 text-gray-500 px-4 py-2 rounded-md text-sm">
                    Need 250 more points
                </button>
            </div>
        </div>
    </div>
</div>
@endsection