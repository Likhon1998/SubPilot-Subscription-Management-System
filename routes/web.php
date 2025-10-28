<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AuthController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {

    // Admin Login Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.post');

    // Admin Logout Route
    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('admin.login')->with('status', 'You have been logged out successfully.');
    })->name('admin.logout');
});

/*
|--------------------------------------------------------------------------
| Protected Admin Routes (Requires Login + Role)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.auth.dashboard');
    })->name('admin.dashboard');

    // Future routes go here (products, subscriptions, etc.)
});
