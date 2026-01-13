<?php

use App\Http\Controllers\Auth\AddProductsController;
use App\Http\Controllers\Club\Auth\ProductController;
use App\Http\Controllers\IndexPageController;
use Illuminate\Support\Facades\Route;
use App\Models\ClubMember;
use App\Http\Controllers\SampleController;
use Illuminate\Container\Attributes\Auth;
/*Route::get('/', function () {
     return view('admin.club');
});*/

Route::get('/', function () { 
     return view('club.dashboard');
})->name('/');


Route::get('/club/add_products_index',[ProductController::class,'add_products_index'])->name('club.add_products_index');

Route::post('/club/add_products',[ProductController::class,'store'])->name('club.add_products');

Route::get('/club/show_products',[ProductController::class,'show'])->name('club.show_products');

Route::post('/club/destroy_products/{id}',[ProductController::class,'destroy'])->name('club.destroy_products');





// Route::get('/insert', function () {
//     return view("clubm");
// })->name('insert');

//Route::POST('/store',[SampleController::class,'store'])->name('asda');
// Route::POST('/app',[SampleController::class,'store'])->name('app');
//Auth::routes();
// Auth::routes(['register' => false]);





//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::prefix('admin')->name('admin.')->namespace('App\Http\Controllers\Admin')->group(function () {
//});
