<?php

use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [HomepageController::class, 'index'])->name('home');

// Routes for authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index'); // Route to view profile
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route to view other users profiles
    Route::get('/users/{user}', [ProfileController::class, 'show'])->name('profile.show');

    // Routes for posts
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/my-posts', [PostController::class, 'myPosts'])->name('my.posts');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::patch('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Routes for likes
    Route::post('/posts/{post}/like', [LikeController::class, 'like'])->name('posts.like');
    Route::post('/posts/{post}/unlike', [LikeController::class, 'unlike'])->name('posts.unlike');

    // Routes for comments
    Route::post('/posts/{post}/comment', [CommentController::class, 'store'])->name('posts.comment.store');

    // Routes for following and unfollowing users
    Route::post('/follow/{user}', [FollowController::class, 'follow'])->name('follow');
    Route::post('/unfollow/{user}', [FollowController::class, 'unfollow'])->name('unfollow');

    // Route for search
    Route::get('/search', [SearchController::class, 'index'])->name('search');

    // Routes for messages
    Route::get('/chat/{user}', [MessageController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [MessageController::class, 'send'])->name('chat.send');
    Route::get('/chats', [MessageController::class, 'chatList'])->name('chat.list');
});

require __DIR__ . '/auth.php';
