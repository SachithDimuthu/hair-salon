<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class DealController extends Controller
{
    /**
     * Display a listing of active deals.
     * Public endpoint - no authentication required
     */
    public function index(Request $request)
    {
        $query = Deal::query();

        // Apply filters
        if ($request->has('service_id')) {
            $query->byService($request->service_id);
        }

        if ($request->boolean('active_only', true)) {
            $query->active();
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $deals = $query->paginate($perPage);

        return response()->json([
            'data' => $deals->items(),
            'meta' => [
                'current_page' => $deals->currentPage(),
                'last_page' => $deals->lastPage(),
                'per_page' => $deals->perPage(),
                'total' => $deals->total(),
            ],
            'message' => 'Deals retrieved successfully'
        ]);
    }

    /**
     * Get cached public active deals list.
     * Optional caching layer for better performance.
     */
    public function publicDeals()
    {
        $deals = Cache::remember('deals.active', 300, function () {
            return Deal::active()
                ->orderBy('DiscountPercentage', 'desc')
                ->get();
        });

        return response()->json([
            'data' => $deals,
            'message' => 'Active deals retrieved successfully'
        ]);
    }

    /**
     * Display the specified deal.
     */
    public function show($id)
    {
        $deal = Deal::find($id);

        if (!$deal) {
            return response()->json([
                'message' => 'Deal not found'
            ], 404);
        }

        return response()->json([
            'data' => $deal,
            'message' => 'Deal retrieved successfully'
        ]);
    }

    /**
     * Store a newly created deal in storage.
     * Requires authentication
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'DealName' => 'required|string|max:255',
            'Description' => 'nullable|string',
            'DiscountPercentage' => 'required|numeric|min:0|max:100',
            'StartDate' => 'required|date',
            'EndDate' => 'required|date|after:StartDate',
            'IsActive' => 'boolean',
            'ServiceID' => 'nullable|string',
            'Terms' => 'nullable|string',
            'MaxUses' => 'nullable|integer|min:0',
            'CurrentUses' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $dealData = $validator->validated();
        
        // Set default values
        if (!isset($dealData['IsActive'])) {
            $dealData['IsActive'] = true;
        }
        if (!isset($dealData['CurrentUses'])) {
            $dealData['CurrentUses'] = 0;
        }

        $deal = Deal::create($dealData);

        // Clear cache
        Cache::forget('deals.active');

        return response()->json([
            'data' => $deal,
            'message' => 'Deal created successfully'
        ], 201);
    }

    /**
     * Update the specified deal in storage.
     * Requires authentication
     */
    public function update(Request $request, $id)
    {
        $deal = Deal::find($id);

        if (!$deal) {
            return response()->json([
                'message' => 'Deal not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'DealName' => 'sometimes|string|max:255',
            'Description' => 'nullable|string',
            'DiscountPercentage' => 'sometimes|numeric|min:0|max:100',
            'StartDate' => 'sometimes|date',
            'EndDate' => 'sometimes|date|after:StartDate',
            'IsActive' => 'boolean',
            'ServiceID' => 'nullable|string',
            'Terms' => 'nullable|string',
            'MaxUses' => 'nullable|integer|min:0',
            'CurrentUses' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $deal->update($validator->validated());

        // Clear cache
        Cache::forget('deals.active');

        return response()->json([
            'data' => $deal,
            'message' => 'Deal updated successfully'
        ]);
    }

    /**
     * Remove the specified deal from storage.
     * Requires authentication
     */
    public function destroy($id)
    {
        $deal = Deal::find($id);

        if (!$deal) {
            return response()->json([
                'message' => 'Deal not found'
            ], 404);
        }

        $deal->delete();

        // Clear cache
        Cache::forget('deals.active');

        return response()->json([
            'message' => 'Deal deleted successfully'
        ]);
    }

    /**
     * Check if a specific deal is available
     */
    public function checkAvailability($id)
    {
        $deal = Deal::find($id);

        if (!$deal) {
            return response()->json([
                'message' => 'Deal not found'
            ], 404);
        }

        $isAvailable = $deal->isAvailable();

        return response()->json([
            'data' => [
                'deal_id' => $id,
                'is_available' => $isAvailable,
                'reason' => !$isAvailable ? $this->getUnavailableReason($deal) : null
            ],
            'message' => $isAvailable ? 'Deal is available' : 'Deal is not available'
        ]);
    }

    /**
     * Get reason why deal is unavailable
     */
    private function getUnavailableReason(Deal $deal): string
    {
        if (!$deal->IsActive) {
            return 'Deal is inactive';
        }
        
        if (now()->lt($deal->StartDate)) {
            return 'Deal has not started yet';
        }
        
        if (now()->gt($deal->EndDate)) {
            return 'Deal has expired';
        }
        
        if ($deal->MaxUses && $deal->CurrentUses >= $deal->MaxUses) {
            return 'Deal has reached maximum uses';
        }
        
        return 'Deal is unavailable';
    }
}
