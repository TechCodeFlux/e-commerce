
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\LoginController;

//for login
// use App\Http\Controllers\Club\Auth\LoginController as ClubLoginController;
// use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;

//dashboard
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ClubController;
use App\Http\Controllers\Clubmember\ClubmemberDashboardController;
use App\Http\Controllers\Club\ClubDashboardController;

use App\Http\Controllers\Admin\ClubMemberController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\OptionValueController;
use App\Http\Controllers\Admin\CategoryController;



// admin (done by pauljo)

// Route::get('/admin', function () {return view('admin.auth.login');})->name('admin.login');
// Route::post('/admin', [AdminLoginController::class, 'login'])->name('admin.login.submit');

Route::prefix('admin')->name('admin.')->namespace('App\Http\Controllers\Admin')->group(function () {
    Auth::routes(['register' => false]);    
    //dashboard controller
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');//dashboard
    Route::get('profile', [DashboardController::class, 'profile'])->name('profile');//profile view
    Route::post('profile', [DashboardController::class, 'profile_update'])->name('profile_update');//profile update
    //admin club controller
    Route::get('clubs', [ClubController::class, 'index'])->name('clubsindex'); //view clubs in table 
    Route::get('clubsform', [ClubController::class, 'create'])->name('club'); //To add club data form(submit form)
    Route::get('clubsform/{club}', [ClubController::class, 'edit'])->name('editclub'); //To add club data form for edit(update form) 
    Route::post('clubsadd', [ClubController::class, 'store'])->name('addclub'); //add club data to table (submit form)
    Route::put('clubsupdate/{club}', [ClubController::class, 'update'])->name('update'); //add club data (update form)
    Route::get('/get-states/{country}', [ClubController::class, 'getStates'])->name('get.states');//get states based on country ID
    Route::delete('clubs/{club}', [ClubController::class, 'destroy'])->name('clubs.destroy');//delete club

    //admin dashboard contain clubmember details------------------------------------------------------------------------------------------------------

    Route::get('/clubs/{club}/dashboard', [ClubController::class, 'dashboard'])->name('clubs.dashboard');//dashboard for each club   
    Route::get('club/members/{club}', [ClubMemberController::class, 'viewmembers'])->name('clubmember.viewmembers');//display members
    Route::get('club/addmember/{id}',[ClubMemberController::class,'addmember'])->name('clubmember.addmember');//add club members
    Route::post('club/storemember/{id}',[ClubMemberController::class,'storemember'])->name('clubmember.storemember');//store club members
    Route::get('club/editmember/{id}',[ClubMemberController::class,'editmember'])->name('clubmember.editmember');
    Route::post('club/updatemember/{id}',[ClubMemberController::class,'updatemember'])->name('clubmember.updatemember');
    Route::delete('club/deletemember/{id}',[ClubMemberController::class,'deletemember'])->name('clubmember.deletemember');
     //profile
    Route::get('club/profile/{id}',[ClubController::class,'profile'])->name('club.profile');
    Route::post('club/editprofile/{id}',[ClubController::class,'editprofile'])->name('club.editprofile');
    
     //option
    Route::get('show_option', [OptionController::class, 'index'])->name('show_option');//view options
    Route::get('add_option', [OptionController::class, 'create'])->name('add_option');//add options
    Route::post('addoption', [OptionController::class, 'store'])->name('addoption'); //add option data to table (submit form)
    Route::post('option_change_status', [OptionController::class, 'changeStatus'])->name('option_change_status');
    Route::get('edit_option/{id}', [OptionController::class, 'edit'])->name('editoption'); //edit option form
    Route::put('update_option/{id}', [OptionController::class, 'update'])->name('updateoption'); //update option data to table (submit form)
    Route::delete('delete_option/{id}', [OptionController::class, 'destroy'])->name('deleteoption'); //delete option

     //option value
    Route::get('show_option_value', [OptionValueController::class, 'index'])->name('show_option_value');//view options
    Route::get('add_option_value', [OptionValueController::class, 'create'])->name('add_option_value');//add options 
    Route::post('addoptionvalue', [OptionValueController::class, 'store'])->name('addoptionvalue'); //add option value data to table (submit form)
    Route::post('option_value_change_status', [OptionValueController::class, 'changeStatus'])->name('option_value_change_status');
    Route::get('edit_option_values/{id}',[OptionValueController::class,'edit'])->name('editoptionvalue');
    Route::put('update_option_value/{id}', [OptionValueController::class, 'update'])->name('updateoptionvalue'); //update option value data to table (submit form)
    Route::delete('delete_option_value/{id}', [OptionValueController::class, 'destroy'])->name('deleteoptionvalue'); //delete option value



    
});




// clubmember


Route::get('/clubmember', function () {return view('clubmember.dashboard');});

Route::prefix('clubmember')->name('clubmember.')->namespace('App\Http\Controllers\ClubMember')->group(function () {
    Auth::routes(['register' => false]); 

    Route::get('viewproduct', [ClubmemberDashboardController::class, 'viewproduct'])->name('viewproduct');

    Route::get('addcart/{id}', [ClubmemberDashboardController::class, 'addcart'])->name('addcart');

    Route::get('viewcart', [ClubmemberDashboardController::class, 'viewcart'])->name('viewcart');

    Route::get('delete/{id}',[ClubmemberDashboardController::class,'delete'])->name('delete');

    // booking the product

    Route::get('booking/{id}',[ClubmemberDashboardController::class,'booking'])->name('booking');

    Route::post('placeorder',[ClubmemberDashboardController::class,'placeorder'])->name('placeorder');

    Route::get('vieworder',[ClubmemberDashboardController::class,'vieworder'])->name('vieworder');
    
});



// club
// Route::get('/club', function () {return view('club.auth.login');})->name('club.login');
// Route::post('/club', [ClubLoginController::class, 'login'])->name('club.login.submit');
// Route::post('/club/logout', [ClubLoginController::class, 'logout'])->name('club.logout');

Route::prefix('club')->name('club.')->namespace('App\Http\Controllers\Club')->group(function () {
    Auth::routes(['register' => false]);   

     Route::get('/', [ClubDashboardController::class, 'index'])->name('dashboard');

     Route::get('vieworder',[ClubDashboardController::class,'vieworder'])->name('vieworder');

     Route::post('change-status', [ClubDashboardController::class, 'changeStatus'])->name('change-status');
     
 });
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
