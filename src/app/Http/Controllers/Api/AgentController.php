<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AgentResource;
use App\Models\Agent;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index(Request $request)
    {
        $query = Agent::where('is_active', true)->withCount('properties');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('bio', 'like', "%{$search}%");
            });
        }

        $perPage = $request->get('per_page', 12);
        $agents = $query->paginate($perPage);

        return AgentResource::collection($agents);
    }

    public function show($id)
    {
        $agent = Agent::with('properties')->withCount('properties')->findOrFail($id);
        return new AgentResource($agent);
    }
}
