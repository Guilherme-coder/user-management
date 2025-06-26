<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'edit', 'update', 'show']);
    Route::post('users/{user}/profiles', [UserController::class, 'syncProfiles'])->name('users.syncProfiles');
});

Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::resource('profiles', ProfileController::class);
    Route::post('profiles/{profile}/users', [ProfileController::class, 'syncUsers'])->name('profiles.syncUsers');
});

require __DIR__.'/auth.php';
