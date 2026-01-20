<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Http\Resources\DistrictResource;
use App\Models\City;
use App\Models\District;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::where('is_active', true)
            ->withCount('properties')
            ->orderBy('name')
            ->get();

        return CityResource::collection($cities);
    }

    public function show($id)
    {
        $city = City::with('districts')
            ->withCount('properties')
            ->findOrFail($id);

        return new CityResource($city);
    }

    public function districts($id)
    {
        $districts = District::where('city_id', $id)
            ->where('is_active', true)
            ->withCount('properties')
            ->orderBy('name')
            ->get();

        return DistrictResource::collection($districts);
    }
}
