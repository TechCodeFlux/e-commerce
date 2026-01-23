<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ClubController;

// Club Controllers
use App\Http\Controllers\Club\Auth\LoginController as ClubLoginController;
use App\Http\Controllers\Club\ClubDashboardController;
use App\Http\Controllers\Club\MicrositeController;
use App\Http\Controllers\Club\CategoryController;
use App\Http\Controllers\Club\ProductController;
use App\Http\Controllers\Club\ClubMemberController;


/*
|--------------------------------------------------------------------------
| Default
|--------------------------------------------------------------------------
*/
// Route::get('/', function () {
//     return view('admin.auth.index');
// });





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

    // Club Management (Admin)
    Route::get('clubs', [ClubController::class, 'index'])->name('clubsindex');
    Route::get('clubsform', [ClubController::class, 'create'])->name('club');
    Route::get('clubsform/{club}', [ClubController::class, 'edit'])->name('editclub');
    Route::post('clubsadd', [ClubController::class, 'store'])->name('addclub');
    Route::put('clubsupdate/{club}', [ClubController::class, 'update'])->name('update');
    Route::get('get-states/{country}', [ClubController::class, 'getStates'])->name('get.states');
});

/*
|--------------------------------------------------------------------------
| CLUB ROUTES (SEPARATE LOGIN)
|--------------------------------------------------------------------------
*/
Route::prefix('club')->name('club.')->group(function () {

    // Club Auth
    Route::get('login', [ClubLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [ClubLoginController::class, 'login'])->name('login.submit');
    Route::post('logout', [ClubLoginController::class, 'logout'])->name('logout');

    // Protected Club Area
    // Route::middleware('auth:club')->group(function () {

    //     Route::get('dashboard', [ClubDashboardController::class, 'index'])
    //         ->name('dashboard');

        // Microsite
        // Route::get('microsite', [MicrositeController::class, 'index'])->name('microsite.index');
        // Route::get('microsite/create', [MicrositeController::class, 'create'])->name('microsite.create');
        // Route::post('microsite/store', [MicrositeController::class, 'store'])->name('microsite.store');
        // Route::get('microsite/edit/{id}', [MicrositeController::class, 'edit'])->name('microsite.edit');
        // Route::post('microsite/update/{id}', [MicrositeController::class, 'update'])->name('microsite.update');

        // // Category
        // Route::resource('categories', CategoryController::class);

        // // Product
        // Route::resource('products', ProductController::class);

        
    });

    Route::prefix('club')->name('club.')->group(function () {

    // Direct dashboard access
    Route::get('dashboard', [ClubDashboardController::class, 'index'])
        ->name('dashboard');

Route::prefix('club')
    ->name('club.')
    ->middleware('auth:club')
    ->group(function () {

        // Club Member CRUD
        Route::resource('members', ClubMemberController::class);
    });
    Route::get('clubs', [ClubController::class, 'index'])->name('clubindex'); //view clubs in table

});
