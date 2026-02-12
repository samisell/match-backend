<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function show(User $user)
    {
        return $user;
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'string|min:8|confirmed',
            'age' => 'integer',
            'location' => 'string|max:255',
            'occupation' => 'string|max:255',
            'education' => 'string|max:255',
            'quote' => 'string',
            'profile_summary' => 'string',
            'interests' => 'array',
        ]);

        $user->update($request->all());

        return $user;
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }
}