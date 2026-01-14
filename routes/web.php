<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Club\ClubDashboardController;


//admin routes

Route::get('/admin', function () {return view('admin.auth.login');});

Route::prefix('admin')->name('admin.')->namespace('App\Http\Controllers\Admin')->group(function () {
    Auth::routes(['register' => false]);   

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

 });


//club routes

Route::get('/club', function () {return view('club.auth.login');});

Route::prefix('club')->name('club.')->namespace('App\Http\Controllers\Club')->group(function () {
    Auth::routes(['register' => false]);

    Route::get('dashboard', [ClubDashboardController::class, 'index'])->name('dashboard');
    
 });



//simple route example

// Route::get('/admin.content', function () {
//     return view('admin.content');
// })->name('admin.content');