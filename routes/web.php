<?php

use App\Http\Controllers\Auth\AddProductsController;
use App\Http\Controllers\IndexPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/addproducts_index',[AddProductsController::class,'addproductsindex'])->name('addproducts_index');

Route::post('/addproducts',[AddProductsController::class,'addproducts'])->name('addproducts');

Route::get('/edit_product_index/{product}',[AddProductsController::class,'editproductindex'])->name('edit_product_index');

Route::post('/editproduct/{product}',[AddProductsController::class,'editproduct'])->name('editproduct');

Route::delete('/deleteproduct/{product}', [AddProductsController::class, 'deleteproduct'])->name('deleteproduct');

Route::get('/index',[IndexPageController::class,'index'])->name('index');




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
