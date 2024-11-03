<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a new comment on a post
     */

    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment = $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);

        return response()->json([
            'success' => true,
            'comment' => [
                'user_name' => $comment->user->name,
                'content' => $comment->content,
                'created_at' => $comment->created_at->diffForHumans(),
            ],
        ]);
    }
}
