<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevelopmentController;

Route::get('/', function () {
    return view('development');
});


Route::resource('development',DevelopmentController::class);
