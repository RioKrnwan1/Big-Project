<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DrinkController;
use App\Http\Controllers\SpkController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\SubCriteriaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComparisonController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (require authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () { return redirect('/spk'); });
    
    // Profile routes
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    
    Route::resource('drinks', DrinkController::class);
    Route::resource('criterias', CriteriaController::class);
    Route::resource('subcriterias', SubCriteriaController::class);
    Route::resource('users', UserController::class);
    Route::resource('comparisons', ComparisonController::class);
    
    Route::get('/spk', [SpkController::class, 'index'])->name('spk.index');
});