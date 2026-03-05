<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\ClubMemberController;
use App\Http\Controllers\Admin\ClubController;
//for dashboard
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Club\ClubDashboardController;
//category controller
use App\Http\Controllers\Admin\CategoryController;
//for option
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\OptionValueController;
use App\Http\Controllers\Admin\MicrositeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\VarientController;
//arjun
Route::get('/', function () {return view('club.auth.login');})->name('club.login');
// Route::post('/', [ClubLoginController::class, 'login'])->name('club.login.submit');
// Route::post('/logout', [ClubLoginController::class, 'logout'])->name('club.logout');

Route::prefix('club')->name('club.')->namespace('App\Http\Controllers\Club')->group(function () {
    Auth::routes(['register' => false]); 
//     //dashboard controller
    //Route::get('dashboard', [ClubDashboardController::class, 'index'])->name('dashboard');//dashboard
//     //club controller
//     // Route::get('clubmembers', [ClubMemberController::class, 'index'])->name('clubmembersindex'); //view club members in table
//     // Route::get('clubmembersform', [ClubMemberController::class, 'create'])->name('addclubmember'); //To add club member data form(submit form)
//     // Route::post('clubmembersadd', [ClubMemberController::class, 'store'])->name('storeclubmember'); //add club member data to table (submit form)
//     // // Route::put('clubmembersupdate/{club}', [ClubMemberController::class, 'update'])->name('update'); //add club member data (update form)
//     // Route::get('/get-states/{country}', [ClubController::class, 'getStates'])->name('get.states');//get states based on country ID

});
//pauljo
// Admin login
// Route::get('/admin', function () {return view('admin.auth.login');})->name('admin.login');
// Route::post('/admin', [AdminLoginController::class, 'login'])->name('admin.login.submit');
// Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

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
    //Club dashboard
    Route::get('/clubs/{club}/dashboard', [ClubController::class, 'dashboard'])->name('clubs.dashboard');//dashboard for each club
    Route::delete('clubs/{club}', [ClubController::class, 'destroy'])->name('clubs.destroy');//delete club
    //Category-----------------------------------------------------------------------------------------------------------------------------------------------------------------------
    Route::get('category_management/add_category_index', [CategoryController::class, 'add_category_index'])->name('category_management.add_category_index');
    Route::post('category_management/add_category', [CategoryController::class, 'store'])->name('category_management.add_category');
    Route::get('category_management/show_category', [CategoryController::class, 'show'])->name('category_management.show_category');
    Route::get('category_management/show_single/{id}', [CategoryController::class, 'single_show'])->name('category_management.show_single');
    Route::delete('category_management/destroy_category/{id}', [CategoryController::class, 'destroy'])->name('category_management.destroy_category');
    Route::get('category_management/add_category_index/{id}', [CategoryController::class, 'edit_category_index'])->name('category_management.edit_category_index');
    Route::put('category_management/edit_category/{id}', [CategoryController::class, 'update'])->name('category_management.edit_category');
    Route::post('category_management/change-status', [CategoryController::class, 'changeStatus'])->name('category_management.change-status');
     //admin dashboard contain clubmember details------------------------------------------------------------------------------------------------------
    Route::get('/clubs/{club}/dashboard', [ClubController::class, 'dashboard'])->name('clubs.dashboard');//dashboard for each club   
    Route::get('club/members/{club}', [ClubMemberController::class, 'index'])->name('clubmember.viewmembers');//display members
    Route::get('club/addmember/{id}',[ClubMemberController::class,'addmember'])->name('clubmember.addmember');//add club members
    Route::post('club/storemember/{id}',[ClubMemberController::class,'storemember'])->name('clubmember.storemember');//store club members
    Route::get('club/editmember/{id}',[ClubMemberController::class,'editmember'])->name('clubmember.editmember');
    Route::post('club/updatemember/{id}',[ClubMemberController::class,'updatemember'])->name('clubmember.updatemember');
    Route::delete('club/deletemember/{id}',[ClubMemberController::class,'deletemember'])->name('clubmember.deletemember');
    Route::get('club/profile/{id}',[ClubController::class,'profile'])->name('club.profile');
    Route::post('club/editprofile/{id}',[ClubController::class,'editprofile'])->name('club.editprofile');
    Route::get('club/member/profile/{id}',[ClubMemberController::class,'profile'])->name('clubmember.profile');
    Route::post('club/member/updateprofile/{id}',[ClubMemberController::class,'update'])->name('clubmember.updateprofile');
    Route::post('club/member/editimage/{id}',[ClubMemberController::class,'editImage'])->name('clubmember.editimage');

    Route::get('club/member/profile/{id}',[ClubMemberController::class,'profile'])->name('clubmember.profile');
    Route::post('club/member/updateprofile/{id}',[ClubMemberController::class,'update'])->name('clubmember.updateprofile');
    Route::post('club/member/editimage/{id}',[ClubMemberController::class,'editImage'])->name('clubmember.editimage');
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
    //microsite
    Route::get('show_microsites/{club}', [MicrositeController::class, 'index'])->name('show_microsites');//view microsites
    Route::get('add_microsites/{id}', [MicrositeController::class, 'create'])->name('add_microsites');//add microsite form
    Route::post('microsite_store', [MicrositeController::class, 'store'])->name('microsite_store');//store microsite data
    Route::post('microsite_change_status', [MicrositeController::class, 'changeStatus'])->name('microsite_change_status');//change status of microsite
    Route::post('delete_microsite', [MicrositeController::class, 'destroy'])->name('delete_microsite');//delete microsite
    Route::get('edit_microsite/{id}',[MicrositeController::class,'edit'])->name('editmicrosite');//edit microsite form
    Route::put('microsite_update/{microsite}', [MicrositeController::class, 'update'])->name('microsite_update');//update microsite data
    Route::get('microsite_show/{microsite}', [MicrositeController::class, 'show'])->name('microsite_show');//show microsite details modal
    //microsite link
    Route::get('/microsite-access/{microsite}',[MicrositeController::class, 'access'])->name('microsite.access');
    //PRODUCT-----------------------------------------------------------------------------------------------------------------------------------------------------------------------
    Route::get('product_management/form_products_index', [ProductController::class, 'form_products_index'])->name('product_management.form_products_index');
    Route::post('product_management/add_products', [ProductController::class, 'store'])->name('product_management.add_products');
    Route::get('product_management/show_products', [ProductController::class, 'show'])->name('product_management.show_products');
    Route::get('product_management/show_single/{id}', [ProductController::class, 'single_show'])->name('product_management.show_single');
    Route::delete('product_management/destroy_products/{id}', [ProductController::class, 'destroy'])->name('product_management.destroy_products');
    Route::get('product_management/form_products_index/{id}', [ProductController::class, 'edit_product_index'])->name('product_management.edit_products_index');
    Route::put('product_management/edit_product/{id}', [ProductController::class, 'update'])->name('product_management.edit_product');
    Route::post('product_management/change-status', [ProductController::class, 'changeStatus'])->name('product_management.change-status');
    //VARIENTS-----------------------------------------------------------------------------------------------------------------------------------------------------------------------
    Route::get('varient_management/form_varient_index', [VarientController::class, 'form_varient_index'])->name('varient_management.form_varient_index');
    Route::get('varient_management/generate_varient', [VarientController::class, 'generate_varient'])->name('varient_management.generate_varient');
    Route::get('varient_management/edit_varient_generator/{id}', [VarientController::class, 'edit_varient_generator'])->name('varient_management.edit_varient_generator');
    Route::post('varient_management/add_varient',[VarientController::class, 'store'])->name('varient_management.add_varient');
    Route::get('varient_management/form_varient_index/{id}', [VarientController::class, 'edit_varient_index'])->name('varient_management.edit_varient_index');
    Route::put('varient_management/edit_varient/{id}', [VarientController::class, 'update'])->name('varient_management.edit_varient');
    Route::delete('varient_management/destroy_varient/{id}', [VarientController::class, 'destroy'])->name('varient_management.destroy_varient');
    Route::get('varient_management/show_varient', [VarientController::class, 'show'])->name('varient_management.show_varient');
    Route::get('varient_management/show_single/{id}', [VarientController::class, 'single_show'])->name('varient_management.show_single');
    Route::post('varient_management/change-status', [VarientController::class, 'changeStatus'])->name('varient_management.change-status');
    Route::post('varient/get-option-values',[VarientController::class, 'getOptionValues'])->name('varient_management.get_option_values');
});



//aishwarya
Route::get('/clubmember', function () {return view('clubmember.auth.login');})->name('clubmember.login');
// Route::post('/clubmember', [ClubMemberLoginController::class, 'login'])->name('clubmember.login.submit');


Route::prefix('clubmember')->name('clubmember.')->namespace('App\Http\Controllers\ClubMember')->group(function () {
    Auth::routes(['register' => false]); 
    //dashboard controller
    Route::get('dashboard', [ClubDashboardController::class, 'index'])->name('dashboard');//dashboard

});

