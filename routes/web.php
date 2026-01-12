<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevelopmentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\Admin\Auth\LoginController;
use Illuminate\Http\Request;



use App\Models\ClubMember;
use App\Http\Controllers\SampleController;

Route::get('/', function () {

    return view('auth.login');

     //return view('admin.club');
});

// Route::get('/insert', function () {
//     return view("clubm");
// })->name('insert');

//Route::POST('/store',[SampleController::class,'store'])->name('asda');
// Route::POST('/app',[SampleController::class,'store'])->name('app');




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->name('admin.')->namespace('App\Http\Controllers\Admin')->group(function () {
    Auth::routes(['register' => false]);
    


});


//Route::resource('admin',DevelopmentController::class);

Route::post('adminlogin', [LoginController::class, 'login'])->name('adminlogin');//adminlogin

Route::resource('club', ClubController::class);
// Route::get('/clubs', [ClubController::class, 'index'])->name('club.index');
// Route::post('/club', [ClubController::class, 'store'])->name('club.store');

Route::get('/admin.content', function () {
    return view('admin.content');
})->name('admin.content');