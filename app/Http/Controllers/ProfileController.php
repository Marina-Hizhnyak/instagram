<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    // Method to show the current user account
    public function show(User $user)
    {
        // Load the user and their posts
        $posts = $user->posts()->latest()->get();

        return view('profile.show', compact('user', 'posts'));
    }
    // Method to delete the current user account
    public function destroy(Request $request): RedirectResponse
    {
        // Retrieve the current user
        $user = $request->user();

        // Log out the user
        Auth::logout();

        // Delete the user account
        $user->delete();

        // Invalidate the session and regenerate token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the homepage
        return Redirect::to('/');
    }

    // Display the profile of the currently authenticated user
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    // Show the form to edit the profile
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // Update the user profile with validated data
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate profile data
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:500',
            'profile_photo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $user->name = $request->input('name');
        $user->bio = $request->input('bio');

        // Check and handle profile photo upload
        if ($request->file('profile_photo') instanceof \Illuminate\Http\UploadedFile) {
            // Delete the old profile photo if it exists
            if ($user->profile_photo) {
                Storage::delete($user->profile_photo);
            }

            // Store the new profile photo
            $path = $request->file('profile_photo')->store('photos', 'public');
            $user->profile_photo = $path;
        }

        try {
            // Save user profile updates
            $user->save();
        } catch (\Exception $e) {
            // Log error if saving fails
            Log::error('Error saving user: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to update profile.']);
        }

        // Redirect to profile index with success message
        return redirect()->route('profile.index')->with('status', 'Profile updated successfully!');
    }
}
