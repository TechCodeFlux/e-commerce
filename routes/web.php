<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevelopmentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClubController;

Route::get('/', function () {
    return view('adminlogin');
});


Route::resource('admin',DevelopmentController::class);

Route::post('admin', [AdminController::class, 'login']);

Route::resource('club', ClubController::class);
Route::get('/clubs', [ClubController::class, 'index'])->name('club.index');
Route::post('/club', [ClubController::class, 'store'])->name('club.store');
