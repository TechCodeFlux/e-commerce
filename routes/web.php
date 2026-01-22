<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Club\Auth\LoginController;
use App\Http\Controllers\Club\ClubDashboardController;
use App\Http\Controllers\Admin\DashboardController;


// use App\Http\Controllers\ClubMember\Auth\LoginController;
use App\Http\Controllers\Clubmember\ClubMemberDashboardController;

 Auth::routes();

// Admin //

Route::get('/', function () {return view('admin.auth.login');});
Route::prefix('admin')->name('admin.')->namespace('App\Http\Controllers\Admin')->group(function () {
    Auth::routes(['register' => false]);    
    //dashboard controller //
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('profile', [DashboardController::class, 'profile'])->name('profile');
Route::post('profile', [DashboardController::class, 'profile_update'])->name('profile_update');
    //admin club controller
    // Route::get('clubs', [ClubController::class, 'index'])->name('clubsindex'); //view clubs in table 
    // Route::get('clubsform', [ClubController::class, 'create'])->name('club'); //To add club data form 
    // Route::post('clubsadd', [ClubController::class, 'store'])->name('addclub'); //add club data to table
    // Route::post('clubsupdate', [ClubController::class, 'update'])->name('update'); //add club data update


    // Route::post('club', [DashboardController::class, 'club'])->name('club');
    // Route::get('club', [DashboardController::class, 'club'])->name('club');
    // Route::post('club', [DashboardController::class, 'store'])->name('club.store'); 
    // Route::get('club', [DashboardController::class, 'clubindex'])->name('club.index');
    
    // Route::delete('club/{club}', [DashboardController::class, 'destroy'])->name('club.destroy');
    // Route::get('club/{club}/edit', [DashboardController::class, 'edit'])->name('club.edit');
    // Route::get('addadmin', [DashboardController::class, 'addnew'])->name('addadmin.create');
    // Route::post('addadmin', [DashboardController::class, 'storeadmin'])->name('addadmin.store');

});

// Club Route //

Route::prefix('club')
    ->name('club.')
    ->middleware('web') 
    ->group(function () {

        // Login form
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

        // Login POST
        Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

        // Routes that require authentication for 'club' guard
        Route::middleware('auth:club')->group(function () {

            // Dashboard
            Route::get('/dashboard', [ClubDashboardController::class, 'index'])->name('dashboard');

            // Logout
            Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        });
});

// Club Member //

// Route::prefix('clubmember')
//     ->name('clubmember.')
//     ->middleware('web')
//     ->group(function () {

//         // Login
//         Route::get('/login', [LoginController::class, 'showLoginForm'])
//             ->name('login');

//         Route::post('/login', [LoginController::class, 'login'])
//             ->name('login.submit');

//         // Authenticated club member routes
//         Route::middleware('auth:clubmember')->group(function () {

//             Route::get('/dashboard',
//                 [ClubMemberDashboardController::class, 'index']
//             )->name('dashboard');

//             Route::post('/logout',
//                 [LoginController::class, 'logout']
//             )->name('logout');
//         });
//     });


