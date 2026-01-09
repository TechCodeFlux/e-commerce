<?php

use Illuminate\Support\Facades\Route;

use App\Models\ClubMember;
use App\Http\Controllers\SampleController;

Route::get('/', function () {
     return view('admin.club');
});

// Route::get('/insert', function () {
//     return view("clubm");
// })->name('insert');

//Route::POST('/store',[SampleController::class,'store'])->name('asda');
// Route::POST('/app',[SampleController::class,'store'])->name('app');



