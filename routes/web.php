<?php

use App\Http\Controllers\ClubController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('club');
});

Route::resource('club',ClubController::class);