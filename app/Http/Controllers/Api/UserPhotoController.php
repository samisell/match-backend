<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserPhotoController extends Controller
{
    public function index(Request $request)
    {
        return UserPhoto::where('user_id', $request->user()->id)->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'photo' => 'required|image|max:2048',
            'caption' => 'string|max:255',
            'is_primary' => 'boolean',
        ]);

        $path = $request->file('photo')->store('photos', 'public');

        $userPhoto = UserPhoto::create([
            'user_id' => $request->user_id,
            'image_url' => $path,
            'caption' => $request->caption,
            'is_primary' => $request->is_primary,
        ]);

        return $userPhoto;
    }

    public function show(UserPhoto $photo)
    {
        return $photo;
    }

    public function update(Request $request, UserPhoto $photo)
    {
        $request->validate([
            'caption' => 'string|max:255',
            'is_primary' => 'boolean',
        ]);

        $photo->update($request->all());

        return $photo;
    }

    public function destroy(UserPhoto $photo)
    {
        Storage::disk('public')->delete($photo->image_url);
        $photo->delete();

        return response()->json(null, 204);
    }
}