<?php

use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Dashboard для авторизованных пользователей
Route::get('/dashboard', function () {
    return view('dashboard'); // Здесь можно передать данные, если нужно
})->middleware(['auth', 'verified'])->name('dashboard');

// Главная страница
Route::get('/', function () {
    if (Auth::check()) {
        // Если пользователь авторизован, перенаправляем на Dashboard
        return redirect()->route('dashboard');
    } else {
        // Если не авторизован, перенаправляем на страницу входа
        return redirect()->route('login');
    }
})->name('home');

// Маршруты для авторизованных пользователей
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Добавляем маршруты для постов (только для авторизованных пользователей)
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
});

// Удаляем дубликат маршрута для главной страницы
// Route::get('/', [HomepageController::class, 'index']);

require __DIR__ . '/auth.php';
