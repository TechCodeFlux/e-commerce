<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Admin\ClubController;
//for dashboard
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Club\ClubDashboardController;
//for login
use App\Http\Controllers\Club\Auth\LoginController as ClubLoginController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
//for add user
use App\Http\Controllers\Club\ClubMemberController;

// use App\Http\Controllers\Admin\Auth\LoginController as ClubMemberLoginController;

//arjun
Route::get('/', function () {return view('club.auth.login');})->name('club.login');
Route::post('/', [ClubLoginController::class, 'login'])->name('club.login.submit');
Route::post('/logout', [ClubLoginController::class, 'logout'])->name('club.logout');

Route::prefix('club')->name('club.')->namespace('App\Http\Controllers\Club')->group(function () {
    Auth::routes(['register' => false]); 
    //dashboard controller
    Route::get('dashboard', [ClubDashboardController::class, 'index'])->name('dashboard');//dashboard
    //club controller
    Route::get('clubmembers', [ClubMemberController::class, 'index'])->name('clubmembersindex'); //view club members in table
    Route::get('clubmembersform', [ClubMemberController::class, 'create'])->name('clubmember'); //To add club member data form(submit form) 

});
//pauljo
                                                                                                                                                                                                                                                                                                               


//aishwarya
Route::get('/clubmember', function () {return view('clubmember.auth.login');})->name('clubmember.login');
// Route::post('/clubmember', [ClubMemberLoginController::class, 'login'])->name('clubmember.login.submit');


Route::prefix('clubmember')->name('clubmember.')->namespace('App\Http\Controllers\ClubMember')->group(function () {
    Auth::routes(['register' => false]); 
    //dashboard controller
    Route::get('dashboard', [ClubDashboardController::class, 'index'])->name('dashboard');//dashboard

});

