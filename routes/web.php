<?php

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

Route::get('/login', 'Auth\LoginController@index');
Route::get('/register', 'Auth\RegisterController@index');
Route::get('/doLogout', 'Auth\LoginController@doLogout');
Route::post('/doRegister', 'Auth\RegisterController@doRegister');
Route::post('/doLogin', 'Auth\LoginController@doLogin');

Route::get('/kategori', 'Admin\CategoriesController@index');

Route::prefix('kategori')->group(function(){
  Route::get('/', 'Admin\CategoriesController@index');
  Route::post('/','Admin\CategoriesController@store');
  Route::post('/{id}/update','Admin\CategoriesController@update');
  Route::get('/{id}/edit','Admin\CategoriesController@edit');
  Route::get('/{id}/delete','Admin\CategoriesController@destroy');
});
