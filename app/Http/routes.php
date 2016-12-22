<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('products', 'ProductsController@index');
Route::get('search', 'ProductsController@search');
Route::get('product/{alias}', 'ProductsController@productByAlias');
Route::get('/', 'PagesController@index');
Route::get('/contacts', 'PagesController@contacts');
Route::post('/contacts', 'PagesController@contacts');
Route::post('/storeComment', 'ProductsController@storeComment');
Route::post('/minus', 'ProductsController@minus');
Route::post('/plus', 'ProductsController@plus');
Route::post('/storeMail', 'ProductsController@storeMail');
Route::post('/cart/add/{id}', 'CartController@add');
Route::get('/cart/delete/{id}', 'CartController@delete');
Route::get('/cart', 'CartController@index');
Route::get('/cart/checkout', ['middleware' => 'auth','uses' => 'CartController@checkout']);
Route::post('/cart/checkout', ['middleware' => 'auth','uses' => 'CartController@checkout']);
Route::post('/cart/addAjax', 'CartController@addAjax');
Route::post('/cart/actionAjax', 'CartController@actionAjax');
Route::get('/category/{alias}', 'ProductsController@showByAlias');







// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'AdminController@index'); // localhost/admin/
    Route::get('/order', 'AdminController@showOrders'); 
    Route::get('/product', 'AdminController@showProducts'); 
    Route::get('/category', 'AdminController@showCategory'); 
    Route::post('/storeCategory', 'AdminController@storeCategory');
    Route::post('/storeProduct', 'AdminController@storeNewProduct');
    Route::post('/storeAttrGroup', 'AdminController@storeAttrGroup');
    Route::post('/storeAttribute', 'AdminController@storeAttribute');
    Route::post('/storeAttrValue', 'AdminController@storeAttrValue');
    Route::post('/storeCount', 'AdminController@storeCount');
    Route::post('/storeAttributeAttrValuesGroup', 'AdminController@storeAttributeAttrValuesGroup');
    Route::post('/storeProductAttributes', 'AdminController@storeProductAttributes');
});



