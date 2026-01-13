<?php

use Illuminate\Support\Facades\Route;

<<<<<<< Updated upstream
Route::get('/', function () {
    return view('welcome');
});
=======



Route::get('/', function () {return view('auth.login');});

Route::prefix('admin')->name('admin.')->namespace('App\Http\Controllers\Admin')->group(function () {
    Auth::routes(['register' => false]);    });

    Route::get('admin.dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');




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

// Route::get('/admin.content', function () {
//     return view('admin.content');
// })->name('admin.content');
>>>>>>> Stashed changes
