<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserMatch;
use Illuminate\Http\Request;

class UserMatchController extends Controller
{
    public function index()
    {
        return UserMatch::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'matched_user_id' => 'required|exists:users,id',
            'status' => 'in:proposed,accepted,declined',
            'matchmaker_note' => 'string',
            'matched_at' => 'date',
        ]);

        $userMatch = UserMatch::create($request->all());

        return $userMatch;
    }

    public function show(UserMatch $match)
    {
        return $match;
    }

    public function update(Request $request, UserMatch $match)
    {
        $request->validate([
            'status' => 'in:proposed,accepted,declined',
            'matchmaker_note' => 'string',
            'matched_at' => 'date',
        ]);

        $match->update($request->all());

        return $match;
    }

    public function destroy(UserMatch $match)
    {
        $match->delete();

        return response()->json(null, 204);
    }
}