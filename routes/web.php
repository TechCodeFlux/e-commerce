<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevelopmentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\Auth\LoginController;

use App\Models\ClubMember;
use App\Http\Controllers\SampleController;

Route::get('/', function () {

    return view('auth.login');
    
});

// Route::get('/insert', function () {
//     return view("clubm");
// })->name('insert');

//Route::POST('/store',[SampleController::class,'store'])->name('asda');
// Route::POST('/app',[SampleController::class,'store'])->name('app');




Auth::routes();

Route::get('/admin.content' ,function()
{return view('admin.content');});

Route::get('/adminlogin', [LoginController::class, 'login'])->name('adminlogin');//admin login



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->name('admin.')->namespace('App\Http\Controllers\Admin')->group(function () {
    Auth::routes(['register' => false]);


    

});
