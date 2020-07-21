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
Route::get('/dashboard', 'Admin\DashboardController@index')->name('home');
// Products
Route::post('products/search', 'Admin\ProductsController@searchProduct')->name('products.search');
Route::get('products/search', 'Admin\ProductsController@searchProduct')->name('products.search');
Route::get('products/export/csv', 'Admin\ProductsController@exportToExcel')->name('products.export.excel');
Route::get('products/export/pdf', 'Admin\ProductsController@exportToPDF')->name('products.export.pdf');
Route::resource('products', 'Admin\ProductsController');
Route::delete('products-delete-multiple', 'Admin\ProductsController@deleteMultiple')->name('products.delete-multiple');
// Categories
Route::resource('categories', 'Admin\CategoriesController');
Route::delete('categories-delete-multiple', 'Admin\CategoriesController@deleteMultiple')->name('categories.delete-multiple');

//Orders
Route::post('orders/search', 'Admin\OrdersController@searchProduct')->name('orders.search');
Route::get('orders/search', 'Admin\OrdersController@searchProduct')->name('orders.search');
Route::get('orders/export/csv', 'Admin\OrdersController@exportToExcel')->name('orders.export.excel');
Route::get('orders/export/pdf', 'Admin\OrdersController@exportToPDF')->name('orders.export.pdf');
Route::resource('orders', 'Admin\OrdersController');
Route::delete('orders-delete-multiple', 'Admin\OrdersController@deleteMultiple')->name('orders.delete-multiple');

//Customers
Route::post('customers/search', 'Admin\CustomersController@searchProduct')->name('customers.search');
Route::get('customers/search', 'Admin\CustomersController@searchProduct')->name('customers.search');
Route::get('customers/export/csv', 'Admin\CustomersController@exportToExcel')->name('customers.export.excel');
Route::get('customers/export/pdf', 'Admin\CustomersController@exportToPDF')->name('customers.export.pdf');
Route::resource('customers', 'Admin\CustomersController');
Route::delete('customers-delete-multiple', 'Admin\CustomersController@deleteMultiple')->name('customers.delete-multiple');
