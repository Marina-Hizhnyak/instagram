<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Method to like a post
     */
    public function like(Post $post)
    {
        if (!$post->likes()->where('user_id', Auth::id())->exists()) {
            $post->likes()->create([
                'user_id' => Auth::id(),
            ]);
        }

        return response()->json(['likes' => $post->likes()->count()]);
    }

    /**
     * Method to unlike a post
     */
    public function unlike(Post $post)
    {
        $post->likes()->where('user_id', Auth::id())->delete();

        return response()->json(['likes' => $post->likes()->count()]);
    }
}
