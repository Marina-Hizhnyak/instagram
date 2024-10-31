<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomepageController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            // IDs of users followed by the authenticated user
            $followingIds = Auth::user()->following()->pluck('users.id');

            // Latest posts from followed users with pagination
            $latestPosts = Post::whereIn('user_id', $followingIds)
                ->with(['user', 'likes', 'comments'])
                ->orderByDesc('created_at')
                ->paginate(10); // Limit the number of posts per page

            // Top popular posts by likes (limited to 5, not paginated)
            $popularPosts = Post::with(['user', 'likes', 'comments'])
                ->withCount('likes')
                ->orderByDesc('likes_count')
                ->take(5) // Set a limit for popular posts
                ->get();

            // Pass both latest and popular posts to the view
            return view('homepage.index', [
                'latestPosts' => $latestPosts,
                'popularPosts' => $popularPosts,
            ]);
        } else {
            // Redirect to login page if the user is not authenticated
            return redirect()->route('login');
        }
    }
}
