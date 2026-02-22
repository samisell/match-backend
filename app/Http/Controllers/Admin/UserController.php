<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Import the User model
use App\Models\Tag; // Import the Tag model
use Illuminate\Support\Facades\Log; // Import the Log facade
use App\Helpers\EmailHelper; // Import the EmailHelper

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::with('tags')->get();
        $allTags = Tag::all()->pluck('name')->toArray();
        return view('admin.users.index', compact('users', 'allTags'));
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $allTags = Tag::all()->pluck('name')->toArray();
        return view('admin.users.edit', compact('user', 'allTags'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        Log::info('User update initiated for user ID: ' . $user->id);
        Log::info('Request data: ', $request->all());

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'is_admin' => 'boolean',
            'matched' => 'boolean',
            'tags' => 'nullable|string', // Validate tags as a string
        ]);

        Log::info('Validated data: ', $validatedData);

        $userBeforeUpdate = $user->toArray();
        Log::info('User data before update: ', $userBeforeUpdate);

        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'is_admin' => $request->has('is_admin'), // Use request->has for checkboxes
            'matched' => $request->has('matched'),   // Use request->has for checkboxes
        ]);

        $userAfterUpdate = $user->fresh()->toArray(); // Get fresh data after update
        Log::info('User data after update: ', $userAfterUpdate);

        // Handle tags
        $tagsInput = $request->input('tags');
        Log::info('Tags input: ' . ($tagsInput ?? 'null'));

        $tags = array_filter(array_map('trim', explode(',', $tagsInput)));
        $tagIds = [];
        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $tagIds[] = $tag->id;
        }
        Log::info('Processed tag IDs: ', $tagIds);

        $user->tags()->sync($tagIds);
        Log::info('Tags synced for user ID: ' . $user->id);

        // Send email notification for user update
        EmailHelper::sendDynamicEmail(
            'user_updated',
            $user->email,
            [
                'user_name' => $user->name,
                'app_name' => config('app.name'),
                'user_profile_link' => route('admin.users.show', $user->id)
            ]
        );

        return redirect()->route('admin.users.show', $user->id)->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        Log::info('User deletion initiated for user ID: ' . $user->id);

        $userName = $user->name;
        $userEmail = $user->email;

        $user->delete();
        Log::info('User deleted successfully: ' . $user->id);

        // Send email notification for user deletion
        EmailHelper::sendDynamicEmail(
            'user_deleted',
            $userEmail,
            [
                'user_name' => $userName,
                'app_name' => config('app.name'),
            ]
        );

        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully.');
    }
}