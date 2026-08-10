<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Public documentation for the auth system.
Route::view('docs', 'docs')->name('docs');

/*
|--------------------------------------------------------------------------
| Guest-only routes
|--------------------------------------------------------------------------
| The "guest" middleware bounces already-authenticated users to the
| dashboard, so a logged-in user can never see the login form.
*/
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store'])
        ->middleware('throttle:6,1');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:10,1');
});

/*
|--------------------------------------------------------------------------
| Authenticated-only routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    /*
    | Products — frontend only for now.
    |
    | These are plain view routes with hard-coded rows in the Blade files.
    | Swap the group for a controller once the model exists:
    |   Route::resource('products', ProductController::class);
    */
    Route::view('products', 'products.index')->name('products.index');
    Route::view('products/create', 'products.create')->name('products.create');

    // Placeholder target for the add form, so submitting it doesn't 405.
    Route::post('products', fn () => back()->with('status', 'Form submitted — no controller wired up yet.'))
        ->name('products.store');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
