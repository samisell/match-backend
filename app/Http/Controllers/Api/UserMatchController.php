<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserMatch;
use Illuminate\Http\Request;

class UserMatchController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $matches = UserMatch::where('user_id', $userId)
            ->orWhere('matched_user_id', $userId)
            ->with(['user.photos', 'matchedUser.photos'])
            ->get();

        // Transform the matches so "matched_user" is always the OTHER person
        return $matches->map(function ($match) use ($userId) {
            $matchedUser = $match->user_id === $userId ? $match->matchedUser : $match->user;
            
            // Add a temporary property for the frontend
            $match->matched_user = $matchedUser;
            return $match;
        });
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

        $user = \App\Models\User::find($request->user_id);
        $matchedUser = \App\Models\User::find($request->matched_user_id);

        if ($user && $matchedUser) {
            $user->notify(new \App\Notifications\DynamicNotification('user_match', [
                'matched_user_name' => $matchedUser->name,
                'match_link' => config('app.url') . '/matches/' . $userMatch->id,
            ]));
            
            $matchedUser->notify(new \App\Notifications\DynamicNotification('user_match', [
                'matched_user_name' => $user->name,
                'match_link' => config('app.url') . '/matches/' . $userMatch->id,
            ]));
        }

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