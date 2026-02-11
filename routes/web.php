<?php

use App\Http\Controllers\Admin\Auth\CategoryController;
use App\Http\Controllers\Admin\Auth\ExController;
use App\Http\Controllers\Admin\Auth\OptionController;
use App\Http\Controllers\Admin\Auth\ProductController;
use App\Http\Controllers\Admin\Auth\VarientController;
use App\Http\Controllers\IndexPageController;
use App\Models\Varient;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::prefix('admin')->name('admin.')->namespace('App\Http\Controllers\Admin')->group(function () {
Auth::routes(['register' => false]);

Route::get('product_management/form_products_index', [ProductController::class, 'form_products_index'])->name('product_management.form_products_index');

Route::post('product_management/add_products', [ProductController::class, 'store'])->name('product_management.add_products');

Route::get('product_management/show_products', [ProductController::class, 'show'])->name('product_management.show_products');

Route::get('product_management/show_single/{id}', [ProductController::class, 'single_show'])->name('product_management.show_single');

Route::delete('product_management/destroy_products/{id}', [ProductController::class, 'destroy'])->name('product_management.destroy_products');

Route::get('product_management/form_products_index/{id}', [ProductController::class, 'edit_product_index'])->name('product_management.edit_products_index');

Route::put('product_management/edit_product/{id}', [ProductController::class, 'update'])->name('product_management.edit_product');

Route::post('product_management/change-status', [ProductController::class, 'changeStatus'])->name('product_management.change-status');



//Category-----------------------------------------------------------------------------------------------------------------------------------------------------------------------

Route::get('category_management/add_category_index', [CategoryController::class, 'add_category_index'])->name('category_management.add_category_index');

Route::post('category_management/add_category', [CategoryController::class, 'store'])->name('category_management.add_category');

Route::get('category_management/show_category', [CategoryController::class, 'show'])->name('category_management.show_category');

Route::get('category_management/show_single/{id}', [CategoryController::class, 'single_show'])->name('category_management.show_single');

Route::delete('category_management/destroy_category/{id}', [CategoryController::class, 'destroy'])->name('category_management.destroy_category');

Route::get('category_management/add_category_index/{id}', [CategoryController::class, 'edit_category_index'])->name('category_management.edit_category_index');

Route::put('category_management/edit_category/{id}', [CategoryController::class, 'update'])->name('category_management.edit_category');

Route::post('category_management/change-status', [CategoryController::class, 'changeStatus'])->name('category_management.change-status');




//OPTIONS-----------------------------------------------------------------------------------------------------------------------------------------------------------------------

Route::get('option_management/form_option_index', [OptionController::class, 'form_option_index'])->name('option_management.form_option_index');

Route::post('option_management/add_option', [OptionController::class, 'store'])->name('option_management.add_option');


Route::get('option_management/show_option', [OptionController::class, 'show'])->name('option_management.show_option');


Route::get('option_management/form_option_index/{id}', [OptionController::class, 'edit_option_index'])->name('option_management.edit_option_index');

Route::put('option_management/edit_option/{id}', [OptionController::class, 'update'])->name('option_management.edit_option');


Route::delete('option_management/destroy_option/{id}', [OptionController::class, 'destroy'])->name('option_management.destroy_option');

Route::get('option_management/show_single/{id}', [OptionController::class, 'single_show'])->name('option_management.show_single');

Route::post('option_management/change-status', [OptionController::class, 'changeStatus'])->name('option_management.change-status');


 
  //VARIENTS-----------------------------------------------------------------------------------------------------------------------------------------------------------------------

Route::get('varient_management/form_varient_index', [VarientController::class, 'form_varient_index'])->name('varient_management.form_varient_index');

Route::get('varient_management/generate_varient', [VarientController::class, 'generate_varient'])->name('varient_management.generate_varient');

Route::post('varient_management/add_varient',[VarientController::class, 'store'])->name('varient_management.add_varient');


Route::get('varient_management/form_varient_index/{id}', [VarientController::class, 'edit_varient_index'])->name('varient_management.edit_varient_index');

Route::put('varient_management/edit_varient/{id}', [VarientController::class, 'update'])->name('varient_management.edit_varient');


Route::delete('varient_management/destroy_varient/{id}', [VarientController::class, 'destroy'])->name('varient_management.destroy_varient');


Route::get('varient_management/show_varient', [VarientController::class, 'show'])->name('varient_management.show_varient');

Route::get('varient_management/show_single/{id}', [VarientController::class, 'single_show'])->name('varient_management.show_single');


Route::post('varient_management/change-status', [VarientController::class, 'changeStatus'])->name('varient_management.change-status');

// Route::post('varient_management/add_varient', [VarientController::class, 'add_varient'])->name('varient_management.add_varient');
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


// Route::get('/admin.content', function () {
//     return view('admin.content');
// })->name('admin.content');

