<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'likes', 'comments'])
            ->latest()
            ->paginate(12);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'body' => 'nullable|string|max:255',
        ]);

        $path = $request->file('img')->store('posts', 'public');

        Post::create([
            'user_id' => auth()->id(),
            'img_path' => $path,
            'body' => $request->caption,
        ]);

        return redirect()->route('posts.index');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }
}
