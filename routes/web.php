<?php

use App\Http\Controllers\Auth\AddProductsController;
use App\Http\Controllers\Club\Auth\ProductController;
use App\Http\Controllers\IndexPageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevelopmentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClubController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;

<<<<<<< HEAD
<<<<<<< Updated upstream
Route::get('/', function () {
    return view('welcome');
});
=======



Route::get('/', function () {return view('auth.login');});

Route::prefix('admin')->name('admin.')->namespace('App\Http\Controllers\Admin')->group(function () {
    Auth::routes(['register' => false]);    });

    Route::get('admin.dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');




=======
// Auth::routes();


Route::get('/', function () {return view('admin.auth.login');});

Route::prefix('admin')->name('admin.')->namespace('App\Http\Controllers\Admin')->group(function () {
    Auth::routes(['register' => false]);    

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('profile', [DashboardController::class, 'profile_update'])->name('profile_update');
    Route::post('club', [DashboardController::class, 'club'])->name('club');
});

Route::prefix('club')->name('club.')->namespace('App\Http\Controllers\Club')->group(function () {
    Auth::routes(['register' => false]);    

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
>>>>>>> 9d47c1514a82c65dce22a043bb628e5b23338a2d
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
<<<<<<< HEAD

// Route::get('/admin.content', function () {
//     return view('admin.content');
// })->name('admin.content');
>>>>>>> Stashed changes
=======
>>>>>>> 9d47c1514a82c65dce22a043bb628e5b23338a2d
