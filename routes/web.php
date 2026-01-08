<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\ClubController;

use App\Models\Club;


route::get('/clublogin',[ClubController::class,'clublogin'])->name('clublogin');

route::post('/check',[ClubController::class,'check'])->name('check');
Route::get('/list', function () {
    return view('list');
})->name('list');   