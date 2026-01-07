<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevelopmentController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('AdminLogin');
});


// Route::resource('admin',DevelopmentController::class);

Route::post('admin', [AdminController::class, 'login']);