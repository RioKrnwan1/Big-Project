<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DrinkController;
use App\Http\Controllers\SpkController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\SubCriteriaController;
use App\Http\Controllers\UserController;

Route::get('/', function () { return redirect('/spk'); });

Route::resource('drinks', DrinkController::class);
Route::resource('criterias', CriteriaController::class);
Route::resource('subcriterias', SubCriteriaController::class);
Route::resource('users', UserController::class);

Route::get('/spk', [SpkController::class, 'index'])->name('spk.index');