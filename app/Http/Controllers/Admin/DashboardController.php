<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tag; // Import the Tag model
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter');
        $tagFilter = $request->query('tag');
        $users = collect(); // Initialize as an empty collection

        if ($filter === 'matched') {
            $users = User::where('matched', true)->get();
        } elseif ($filter === 'unmatched') {
            $users = User::where('matched', false)->get();
        } elseif ($tagFilter) {
            $tag = Tag::where('name', $tagFilter)->first();
            if ($tag) {
                $users = $tag->taggables()->get();
            } else {
                $users = collect(); // No users if tag not found
            }
        } else {
            $users = User::all();
        }

        $allTags = Tag::all(); // Get all tags for the sidebar

        return view('admin.dashboard', compact('users', 'allTags'));
    }
}