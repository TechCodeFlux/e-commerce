<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Club\Auth\LoginController as ClubLoginController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ClubController;

use App\Http\Controllers\Club\ClubDashboardController;
use App\Http\Controllers\Club\ClubMemberController;

/*
|--------------------------------------------------------------------------
| CLUB LOGIN
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('club.auth.login'))->name('club.login');
Route::post('/', [ClubLoginController::class, 'login'])->name('club.login.submit');
Route::post('/logout', [ClubLoginController::class, 'logout'])->name('club.logout');

Route::prefix('club')->name('club.')->namespace('App\Http\Controllers\Club')->group(function () {
    Auth::routes(['register' => false]); 
    //dashboard controller
    Route::get('dashboard', [ClubDashboardController::class, 'index'])->name('dashboard');//dashboard
    //club controller
    Route::get('clubmembers', [ClubMemberController::class, 'index'])->name('clubmembersindex'); //view club members in table
    Route::get('clubmembersform', [ClubMemberController::class, 'create'])->name('addclubmember'); //To add club member data form(submit form)
    Route::post('clubmembersadd', [ClubMemberController::class, 'store'])->name('storeclubmember'); //add club member data to table (submit form)
    // Route::put('clubmembersupdate/{club}', [ClubMemberController::class, 'update'])->name('update'); //add club member data (update form)

    Route::get('/get-states/{country}', [ClubController::class, 'getStates'])->name('get.states');//get states based on country ID

});
//pauljo
// Admin login
// Route::get('/admin', function () {return view('admin.auth.login');})->name('admin.login');
// Route::post('/admin', [AdminLoginController::class, 'login'])->name('admin.login.submit');
// Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    Auth::routes(['register' => false]);

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('profile', [DashboardController::class, 'profile_update'])->name('profile_update');

    Route::get('clubs', [ClubController::class, 'index'])->name('clubsindex');
    Route::get('clubsform', [ClubController::class, 'create'])->name('club');
    Route::get('clubsform/{club}', [ClubController::class, 'edit'])->name('editclub');
    Route::post('clubsadd', [ClubController::class, 'store'])->name('addclub');
    Route::put('clubsupdate/{club}', [ClubController::class, 'update'])->name('update');
    Route::get('get-states/{country}', [ClubController::class, 'getStates'])->name('get.states');
});
