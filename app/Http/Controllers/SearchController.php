<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        // Get the search query
        $query = $request->input('query');

        // Search users by name
        $users = User::where('name', 'LIKE', "%{$query}%")->get();

        // Search posts by content
        $posts = Post::where('body', 'LIKE', "%{$query}%")->get();

        return view('search.index', compact('users', 'posts', 'query'));
    }
}
