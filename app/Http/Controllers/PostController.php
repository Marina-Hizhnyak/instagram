<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $posts = Post::with(['user', 'likes', 'comments'])
            ->latest()
            ->paginate(12);
        // dd($posts);
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

    public function myPosts()
    {
        $posts = Post::where('user_id', auth()->id())->with(['likes', 'comments'])->get();

        return view('posts.my-posts', compact('posts'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $request->validate([
            'body' => 'nullable|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('img')) {
            $path = $request->file('img')->store('posts', 'public');
            $post->img_path = $path;
        }

        $post->body = $request->body;
        $post->save();

        return redirect()->route('my.posts')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        return redirect()->route('my.posts')->with('success', 'Post deleted successfully.');
    }
}
