<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Input;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $query = Campaign::with('inputs');

        if ($request->has('sort_by')) {
            $sortBy = $request->get('sort_by');
            $sortOrder = $request->get('sort_order', 'asc');
            $query->orderBy($sortBy, $sortOrder);
        }

        $campaigns = $query->paginate(10);

        return response()->json($campaigns);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'inputs' => 'required|array',
            'inputs.*.type' => 'required|string',
            'inputs.*.value' => 'required|string',
        ]);

        $campaign = Campaign::create(['user_id' => $request->user_id]);

        foreach ($request->inputs as $inputData) {
            $campaign->inputs()->create($inputData);
        }

        return response()->json($campaign->load('inputs'), 201);
    }
    public function search(Request $request)
{
    $query = Campaign::query();

    if ($request->has('email')) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('email', $request->email);
        });
    }

    if ($request->has('user_id')) {
        $query->where('user_id', $request->user_id);
    }

    $campaigns = $query->get();

    return response()->json(['data' => $campaigns]);
}
}

