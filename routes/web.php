<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ThreatController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;

// ==== Public Routes (tanpa login) ====
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==== Protected Routes (butuh login) ====
Route::middleware('auth')->group(function () {

    // Dashboard & Postingan
    Route::get('/dashboard', [ThreatController::class, 'index'])->name('dashboard');
    Route::post('/threat', [ThreatController::class, 'store'])->name('threat.store');

    // Like & Komentar
    Route::post('/threat/{id}/like', [LikeController::class, 'toggle'])->name('threat.like');
    Route::post('/threat/{id}/comment', [CommentController::class, 'store'])->name('threat.comment');

    // Chat antar user
    Route::get('/chat', [ChatController::class, 'users'])->name('chat.users');
    Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat.show');
    Route::get('/chat/{user}/fetch', [ChatController::class, 'fetch'])->name('chat.fetch'); // <-- DITAMBAHKAN
    Route::post('/chat/{user}', [ChatController::class, 'send'])->name('chat.send');

    // Profil User
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::get('/profile/edit', [AuthController::class, 'editProfile'])->name('profile.edit'); // <-- DIPINDAHKAN & URL diperbaiki
    Route::patch('/profile', [AuthController::class, 'updateProfile'])->name('profile.update'); // <-- DIPINDAHKAN & dijadikan satu
    Route::get('/profile/{user}', [AuthController::class, 'showPublicProfile'])->name('profile.public');
    
    Route::get('/api/search-users', function (\Illuminate\Http\Request $request) {
    $q = $request->query('q');
    return \App\Models\User::where('name', 'like', "%$q%")
        ->select('id', 'name')
        ->limit(5)
        ->get();
})->middleware('auth');

});