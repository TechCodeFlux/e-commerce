
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\LoginController;

//for login
use App\Http\Controllers\Club\Auth\LoginController as ClubLoginController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;

//dashboard
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ClubController;
use App\Http\Controllers\ClubMember\ClubmemberDasboardController;

// admin (done by pauljo)

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
});

Route::get('/clubmember', function () {return view('clubmember.dashboard');});

Route::prefix('clubmember')->name('clubmember.')->namespace('App\Http\Controllers\ClubMember')->group(function () {
    Auth::routes(['register' => false]); 

    Route::get('viewproduct', [ClubmemberDasboardController::class, 'viewproduct'])->name('viewproduct');

    Route::get('addcart/{id}', [ClubmemberDasboardController::class, 'addcart'])->name('addcart');

    Route::get('viewcart', [ClubmemberDasboardController::class, 'viewcart'])->name('viewcart');

    Route::get('delete/{id}',[ClubmemberDasboardController::class,'delete'])->name('delete');

    // booking the product

    Route::get('booking/{id}',[ClubmemberDasboardController::class,'booking'])->name('booking');
    
});

// Route::prefix('club')->name('club.')->namespace('App\Http\Controllers\Club')->group(function () {
//     Auth::routes(['register' => false]);    

//     Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
// });
// Auth::routes();

// Route::prefix('club')->name('club.')->namespace('App\Http\Controllers\Club')->group(function () {
//     Auth::routes(['register' => false]);});


// Route::get('/', function () {return view('adminlogin');});
// Route::post('adminlogin', [LoginController::class, 'login'])->name('adminlogin');
// Route::post('/club', [ClubController::class, 'store'])->name('store');
// Route::resource('admin',DevelopmentController::class);
// Route::post('admin', [AdminController::class, 'login']);
// Route::resource('club', ClubController::class);
// Route::get('/clubs', [ClubController::class, 'index'])->name('index');
// Route::post('/club', [ClubController::class, 'store'])->name('club.store'); 
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
