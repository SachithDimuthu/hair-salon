<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    /**
     * Display a listing of the services with filtering.
     */
    public function index(Request $request)
    {
        $query = Service::query();

        // Apply filters
        if ($request->has('category')) {
            $query->byCategory($request->category);
        }

        if ($request->has('q')) {
            $query->search($request->q);
        }

        if ($request->has('tags')) {
            $tags = is_array($request->tags) ? $request->tags : explode(',', $request->tags);
            $query->withTags($tags);
        }

        if ($request->has('active')) {
            if ($request->boolean('active')) {
                $query->active();
            }
        }

        if ($request->has('visibility')) {
            $query->where('visibility', $request->visibility);
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $services = $query->paginate($perPage);

        return response()->json([
            'data' => $services->items(),
            'meta' => [
                'current_page' => $services->currentPage(),
                'last_page' => $services->lastPage(),
                'per_page' => $services->perPage(),
                'total' => $services->total(),
            ],
            'message' => 'Services retrieved successfully'
        ]);
    }

    /**
     * Get cached public active services list.
     * Optional caching layer for public services.
     */
    public function publicServices()
    {
        // Optional: Cache public active services for 5 minutes
        $services = Cache::remember('services.public', 300, function () {
            return Service::active()
                ->public()
                ->orderBy('ServiceName')
                ->get();
        });

        return response()->json([
            'data' => $services,
            'message' => 'Public services retrieved successfully'
        ]);
    }

    /**
     * Store a newly created service in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9-]+$/',
                Rule::unique('services', 'slug')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'durations' => 'nullable|array',
            'durations.*.variant' => 'required_with:durations|string|max:100',
            'durations.*.minutes' => 'required_with:durations|integer|min:1',
            'durations.*.price' => 'required_with:durations|numeric|min:0',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'active' => 'boolean',
            'staff_ids' => 'nullable|array',
            'staff_ids.*' => 'string',
            'addon_ids' => 'nullable|array',
            'addon_ids.*' => 'string',
            'visibility' => 'required|in:public,internal',
            'rating' => 'nullable|numeric|between:0,5',
            'booking_constraints.min_notice_minutes' => 'nullable|integer|min:0',
            'booking_constraints.max_future_days' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $service = Service::create($request->all());

        // Clear cache for public services if needed
        Cache::forget('services.public');

        return response()->json([
            'data' => $service,
            'message' => 'Service created successfully'
        ], 201);
    }

    /**
     * Display the specified service.
     */
    public function show(Service $service)
    {
        return response()->json([
            'data' => $service,
            'message' => 'Service retrieved successfully'
        ]);
    }

    /**
     * Update the specified service in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9-]+$/',
                Rule::unique('services', 'slug')->ignore($service->id)->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'durations' => 'nullable|array',
            'durations.*.variant' => 'required_with:durations|string|max:100',
            'durations.*.minutes' => 'required_with:durations|integer|min:1',
            'durations.*.price' => 'required_with:durations|numeric|min:0',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'active' => 'boolean',
            'staff_ids' => 'nullable|array',
            'staff_ids.*' => 'string',
            'addon_ids' => 'nullable|array',
            'addon_ids.*' => 'string',
            'visibility' => 'required|in:public,internal',
            'rating' => 'nullable|numeric|between:0,5',
            'booking_constraints.min_notice_minutes' => 'nullable|integer|min:0',
            'booking_constraints.max_future_days' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $service->update($request->all());

        // Clear cache for public services if needed
        Cache::forget('services.public');

        return response()->json([
            'data' => $service,
            'message' => 'Service updated successfully'
        ]);
    }

    /**
     * Remove the specified service from storage (soft delete).
     */
    public function destroy(Service $service)
    {
        $service->delete(); // This will soft delete due to SoftDeletes trait

        // Clear cache for public services if needed
        Cache::forget('services.public');

        return response()->json([
            'message' => 'Service deleted successfully'
        ]);
    }

    /**
     * Get aggregate statistics for services grouped by category.
     * MySQL compatible version using Eloquent aggregation.
     */
    public function aggregateStats()
    {
        try {
            $stats = Service::selectRaw('
                    category,
                    COUNT(*) as count,
                    AVG(base_price) as avgPrice,
                    AVG(rating) as avgRating,
                    SUM(base_price) as totalRevenue
                ')
                ->whereNull('deleted_at')
                ->groupBy('category')
                ->orderBy('count', 'desc')
                ->get()
                ->map(function ($stat) {
                    return [
                        '_id' => $stat->category,
                        'count' => (int) $stat->count,
                        'avgPrice' => round((float) $stat->avgPrice, 2),
                        'avgRating' => $stat->avgRating ? round((float) $stat->avgRating, 1) : null,
                        'totalRevenue' => round((float) $stat->totalRevenue, 2),
                    ];
                });
            
            return response()->json([
                'data' => $stats->toArray(),
                'message' => 'Service statistics retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving statistics: ' . $e->getMessage()
            ], 500);
        }
    }
}
