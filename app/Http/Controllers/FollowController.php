<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    /**
     * Method to follow a user.
     */
    public function follow(User $user)
    {
        if (!Auth::user()->following->contains($user->id)) {
            Auth::user()->following()->attach($user->id);
        }

        return response()->json(['success' => true, 'message' => 'Followed successfully.']);
    }
    /**
     * Method to unfollow a user.
     */
    public function unfollow(User $user)
    {
        if (Auth::user()->following->contains($user->id)) {
            Auth::user()->following()->detach($user->id);
        }

        return response()->json(['success' => true, 'message' => 'Unfollowed successfully.']);
    }
}
