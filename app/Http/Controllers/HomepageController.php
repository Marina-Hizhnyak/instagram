<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomepageController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $followingIds = Auth::user()->following()->pluck('users.id');

            // Retrieve the latest posts from followed users
            $latestPosts = Post::whereIn('user_id', $followingIds)
                ->with(['user', 'likes', 'comments'])
                ->orderByDesc('created_at')
                ->paginate(10);

            // Retrieve popular posts by like count
            $popularPosts = Post::with(['user', 'likes', 'comments'])
                ->withCount('likes')
                ->orderByDesc('likes_count')
                ->take(5)
                ->get();

            // Retrieve users for stories (e.g., only users that the current user is following)
            $storyUsers = User::whereIn('id', $followingIds)->take(10)->get();

            return view('homepage.index', [
                'latestPosts' => $latestPosts,
                'popularPosts' => $popularPosts,
                'storyUsers' => $storyUsers,
            ]);
        } else {
            return redirect()->route('login');
        }
    }
}
