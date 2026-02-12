<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserPreference;
use Illuminate\Http\Request;

class UserPreferenceController extends Controller
{
    public function index()
    {
        return UserPreference::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'age_min' => 'required|integer',
            'age_max' => 'required|integer',
            'location_radius_km' => 'required|integer',
            'desired_interests' => 'array',
        ]);

        $userPreference = UserPreference::create($request->all());

        return $userPreference;
    }

    public function show(UserPreference $preference)
    {
        return $preference;
    }

    public function update(Request $request, UserPreference $preference)
    {
        $request->validate([
            'age_min' => 'integer',
            'age_max' => 'integer',
            'location_radius_km' => 'integer',
            'desired_interests' => 'array',
        ]);

        $preference->update($request->all());

        return $preference;
    }

    public function destroy(UserPreference $preference)
    {
        $preference->delete();

        return response()->json(null, 204);
    }
}