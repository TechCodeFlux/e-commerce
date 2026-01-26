<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Club\Auth\LoginController;
use App\Http\Controllers\Club\ClubDashboardController;
// use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ClubController;
use App\Http\Controllers\Club\Auth\LoginController as ClubLoginController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\Auth\LoginController as ClubMemberLoginController;
use App\Http\Controllers\ClubMember\DashboardController;
use App\Http\Controllers\ClubMember\OrderController;






//arjun // club //
// Route::get('/', function () {return view('club.adduser');})->name('club.login');
Route::post('/', action: [ClubLoginController::class, 'login'])->name('club.login.submit');
Route::post('/logout', [ClubLoginController::class, 'logout'])->name('club.logout');

Route::prefix('club')->name('club.')->namespace('App\Http\Controllers\Club')->group(function () {
    Auth::routes(['register' => false]); 
//dashboard controller
Route::get('dashboard', [ClubDashboardController::class, 'index'])->name('dashboard');//dashboard

});

//pauljo
// Admin login
Route::get('/admin', function () {return view('admin.auth.login');})->name('admin.login');
Route::post('/admin', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
Route::prefix('admin')->name('admin.')->namespace('App\Http\Controllers\Admin')->group(function () {
    Auth::routes(['register' => false]);    
//dashboard controller
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');//dashboard
Route::get('profile', [DashboardController::class, 'profile'])->name('profile');//profile view
Route::post('profile', [DashboardController::class, 'profile_update'])->name('profile_update');//profile update
//admin club controller
Route::get('clubs', [ClubController::class, 'index'])->name('clubsindex'); //view clubs in table 
Route::get('clubsform', [ClubController::class, 'create'])->name('club'); //To add club data form(submit form)
Route::get('clubsform/{club}', [ClubController::class, 'edit'])->name('editclub'); //To add club data form for edit(update form) 
Route::post('clubsadd', [ClubController::class, 'store'])->name('addclub'); //add club data to table (submit form)
Route::put('clubsupdate/{club}', [ClubController::class, 'update'])->name('update'); //add club data (update form)
Route::get('/get-states/{country}', [ClubController::class, 'getStates'])->name('get.states');//get states based on country ID
Route::delete('/clubs/{club}', [ClubController::class, 'destroy'])
 ->name('deleteclub');
});



//aishwarya
Route::get('/clubmember', function () {return view('clubmember.auth.login');})->name('clubmember.login');
Route::post('/clubmember', [ClubMemberLoginController::class, 'login'])->name('clubmember.login.submit');
Route::prefix('clubmember')->name('clubmember.')->namespace('App\Http\Controllers\ClubMember')->group(function () {
    Auth::routes(['register' => false]); 
//dashboard controller
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');//dashboard
Route::get('/clubmember/dashboard', [DashboardController::class, 'index'])
    ->name('clubmember.dashboard');
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/order-history', [OrderController::class, 'orderHistory'])
     ->name('order.history');


});






