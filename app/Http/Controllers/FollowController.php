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
        // Check if the user is not already following this user
        if (!Auth::user()->following->contains($user->id)) {
            Auth::user()->following()->attach($user->id);
        }

        return redirect()->back()->with('status', 'You are now following ' . $user->name);
    }

    /**
     * Method to unfollow a user.
     */
    public function unfollow(User $user)
    {
        // Check if the user is currently following this user
        if (Auth::user()->following->contains($user->id)) {
            Auth::user()->following()->detach($user->id);
        }

        return redirect()->back()->with('status', 'You have unfollowed ' . $user->name);
    }
}
