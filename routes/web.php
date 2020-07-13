<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

// Route::get('/home', 'DashboardController@index');
Route::get('/dashboard', 'DashboardController@index')->name('home');
// Products
Route::resource('products', 'ProductsController');
Route::delete('products-delete-multiple', 'ProductsController@deleteMultiple')->name('products.delete-multiple');
// Categories
Route::resource('categories', 'CategoriesController');
Route::delete('categories-delete-multiple', 'CategoriesController@deleteMultiple')->name('categories.delete-multiple');
