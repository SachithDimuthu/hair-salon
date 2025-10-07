<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Show the homepage
     */
    public function index()
    {
        try {
            $featuredServices = Service::where('Visibility', true)
                ->orderBy('Price', 'desc')
                ->take(6)
                ->get();
        } catch (\Exception $e) {
            // If MongoDB fails or is empty, use empty collection
            Log::error('Failed to fetch featured services: ' . $e->getMessage());
            $featuredServices = collect([]);
        }

        return view('welcome', compact('featuredServices'));
    }

    /**
     * Show public services catalog
     */
    public function services()
    {
        try {
            $services = Service::where('Visibility', true)
                ->orderBy('ServiceName')
                ->get();
        } catch (\Exception $e) {
            // If MongoDB fails or is empty, use empty collection
            Log::error('Failed to fetch services: ' . $e->getMessage());
            $services = collect([]);
        }

        return view('public.services', compact('services'));
    }

    /**
     * Show staff directory
     */
    public function staff()
    {
        $staff = Staff::with('user')
            ->where('is_active', true)
            ->orderBy('hire_date', 'desc')
            ->get();

        return view('public.staff', compact('staff'));
    }

    /**
     * Show contact information
     */
    public function contact()
    {
        return view('public.contact');
    }

    /**
     * Show about us page
     */
    public function about()
    {
        return view('public.about');
    }
}
