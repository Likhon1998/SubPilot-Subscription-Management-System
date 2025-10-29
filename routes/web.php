<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CheckoutController;



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{id}', [HomeController::class, 'productDetails'])->name('product.details');

Route::get('/checkout/{product}', [CheckoutController::class, 'showCheckoutForm'])->name('checkout.form');
Route::post('/checkout/submit', [CheckoutController::class, 'submitCustomerInfo'])->name('checkout.submit');
Route::get('/checkout/otp/{customer}', [CheckoutController::class, 'showOtpForm'])->name('checkout.otp.form');
Route::post('/checkout/otp/verify', [CheckoutController::class, 'verifyOtp'])->name('checkout.otp.verify');
Route::get('/checkout/payment/{customer}', [CheckoutController::class, 'showPayment'])->name('checkout.payment');
Route::post('/checkout/payment/process', [CheckoutController::class, 'processPayment'])->name('checkout.payment.process');



Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('admin.login')->with('status', 'You have been logged out successfully.');
    })->name('admin.logout');
});



Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', function () {return view('admin.auth.dashboard');
        })->name('dashboard');

        Route::get('/checkouts', [CheckoutController::class, 'index'])->name('checkouts.index');

        Route::resource('products', ProductController::class);
        Route::resource('items', ItemController::class);
    });
