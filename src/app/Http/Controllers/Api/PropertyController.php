<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of properties with filters
     */
    public function index(Request $request)
    {
        $query = Property::with(['city', 'district', 'agent']);

        // Filter by listing type (sale/rent)
        if ($request->has('listing_type')) {
            $query->where('listing_type', $request->listing_type);
        }

        // Filter by type (house/apartment/commercial/land)
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        } else {
            // Default: only show available properties
            $query->where('status', 'available');
        }

        // Filter by city
        if ($request->has('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        // Filter by district
        if ($request->has('district_id')) {
            $query->where('district_id', $request->district_id);
        }

        // Filter by price range
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by bedrooms
        if ($request->has('bedrooms')) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }

        // Filter by energy class
        if ($request->has('energy_class')) {
            $query->where('energy_class', $request->energy_class);
        }

        // Search by title or description
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginate
        $perPage = $request->get('per_page', 12);
        $properties = $query->paginate($perPage);

        return PropertyResource::collection($properties);
    }

    /**
     * Display the specified property
     */
    public function show($id)
    {
        $property = Property::with(['city', 'district', 'agent'])
            ->findOrFail($id);

        return new PropertyResource($property);
    }

    /**
     * Get featured properties
     */
    public function featured(Request $request)
    {
        $limit = $request->get('limit', 6);
        
        $properties = Property::with(['city', 'district', 'agent'])
            ->where('is_featured', true)
            ->where('status', 'available')
            ->latest()
            ->limit($limit)
            ->get();

        return PropertyResource::collection($properties);
    }

    /**
     * Advanced search
     */
    public function search(Request $request)
    {
        return $this->index($request);
    }

    /**
     * Get similar properties
     */
    public function similar($id, Request $request)
    {
        $property = Property::findOrFail($id);
        $limit = $request->get('limit', 4);

        $similar = Property::with(['city', 'district', 'agent'])
            ->where('id', '!=', $id)
            ->where('type', $property->type)
            ->where('listing_type', $property->listing_type)
            ->where('status', 'available')
            ->where(function($query) use ($property) {
                $query->where('city_id', $property->city_id)
                      ->orWhereBetween('price', [
                          $property->price * 0.7,
                          $property->price * 1.3
                      ]);
            })
            ->limit($limit)
            ->get();

        return PropertyResource::collection($similar);
    }
}
