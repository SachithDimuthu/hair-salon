<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Staff;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the homepage
     */
    public function index()
    {
        $featuredServices = Service::where('is_active', true)
            ->orderBy('price', 'desc')
            ->take(6)
            ->get();

        return view('welcome', compact('featuredServices'));
    }

    /**
     * Show public services catalog
     */
    public function services()
    {
        $services = Service::with('category')
            ->where('is_active', true)
            ->orderBy('category_id')
            ->orderBy('name')
            ->get();

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
