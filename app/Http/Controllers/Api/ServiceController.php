<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the services.
     */
    public function index()
    {
        $services = Service::with('category')
            ->where('is_active', true)
            ->orderBy('category_id')
            ->orderBy('name')
            ->get();

        return response()->json([
            'data' => $services,
            'message' => 'Services retrieved successfully'
        ]);
    }

    /**
     * Store a newly created service in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:15',
            'is_active' => 'boolean',
        ]);

        $service = Service::create($validated);

        return response()->json([
            'data' => $service->load('category'),
            'message' => 'Service created successfully'
        ], 201);
    }

    /**
     * Display the specified service.
     */
    public function show(Service $service)
    {
        return response()->json([
            'data' => $service->load('category'),
            'message' => 'Service retrieved successfully'
        ]);
    }

    /**
     * Update the specified service in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:15',
            'is_active' => 'boolean',
        ]);

        $service->update($validated);

        return response()->json([
            'data' => $service->load('category'),
            'message' => 'Service updated successfully'
        ]);
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroy(Service $service)
    {
        // Check if service has appointments
        if ($service->appointments()->count() > 0) {
            return response()->json([
                'message' => 'Cannot delete service with existing appointments. Deactivate instead.'
            ], 422);
        }

        $service->delete();

        return response()->json([
            'message' => 'Service deleted successfully'
        ]);
    }
}
