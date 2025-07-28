<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication routes
Auth::routes();

// Logout confirmation page
Route::get('/logout-confirm', function () {
    return view('auth.logout');
})->name('logout.confirm')->middleware('auth');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // User dashboard
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    
    // Admin routes
    Route::middleware(['admin'])->group(function () {
        // Products management
        Route::resource('products', ProductController::class);
        
        // Categories management
        Route::resource('categories', CategoryController::class);
    });
});
