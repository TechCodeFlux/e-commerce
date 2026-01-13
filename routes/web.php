<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevelopmentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClubController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;

// Auth::routes();


Route::get('/', function () {return view('admin.auth.login');});

Route::prefix('admin')->name('admin.')->namespace('App\Http\Controllers\Admin')->group(function () {
    Auth::routes(['register' => false]);    

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [DashboardController::class, 'profile'])->name('profile');
});

Route::prefix('club')->name('club.')->namespace('App\Http\Controllers\Club')->group(function () {
    Auth::routes(['register' => false]);    

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
// Auth::routes();

// Route::prefix('club')->name('club.')->namespace('App\Http\Controllers\Club')->group(function () {
//     Auth::routes(['register' => false]);});


// Route::get('/', function () {return view('adminlogin');});
// Route::post('adminlogin', [LoginController::class, 'login'])->name('adminlogin');
// Route::post('/club', [ClubController::class, 'store'])->name('store');
// Route::resource('admin',DevelopmentController::class);
// Route::post('admin', [AdminController::class, 'login']);
// Route::resource('club', ClubController::class);
// Route::get('/clubs', [ClubController::class, 'index'])->name('index');
// Route::post('/club', [ClubController::class, 'store'])->name('club.store');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
