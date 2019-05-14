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

Route::get('/test', 'Auth\RegisterController@test');

Route::get('/login', 'Auth\LoginController@index');
Route::get('/register', 'Auth\RegisterController@index');
Route::get('/doLogout', 'Auth\LoginController@doLogout');
Route::post('/doRegister', 'Auth\RegisterController@doRegister');
Route::post('/doLogin', 'Auth\LoginController@doLogin');

Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');
Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');

Route::middleware("auth")->group(function() {

  Route::prefix('kategori')->group(function(){
    Route::get('/', 'Admin\CategoriesController@index');
    Route::post('/','Admin\CategoriesController@store');
    Route::post('/{id}/update','Admin\CategoriesController@update');
    Route::get('/{id}/edit','Admin\CategoriesController@edit');
    Route::get('/{id}/delete','Admin\CategoriesController@destroy');
  });

  Route::prefix('rak')->group(function(){
    Route::get('/', 'Admin\ShelfsController@index');
    Route::get('/{id}/barang','Admin\ShelfsController@show');
    Route::post('/','Admin\ShelfsController@store');
    Route::post('/{id}/update','Admin\ShelfsController@update');
    Route::get('/{id}/edit','Admin\ShelfsController@edit');
    Route::get('/{id}/delete','Admin\ShelfsController@destroy');
  });

  Route::prefix('barang')->group(function(){
    Route::get('/', 'Admin\GoodsController@index');
    Route::post('/','Admin\GoodsController@store');
    Route::post('/{id}/update','Admin\GoodsController@update');
    Route::get('/{id}/edit','Admin\GoodsController@edit');
    Route::get('/{id}','Admin\GoodsController@show');
    Route::get('/{id}/delete','Admin\GoodsController@destroy');
  });

  Route::prefix('pinjam')->group(function(){
    Route::get('/', 'User\PinjamController@index');
    Route::post('/','User\PinjamController@store');
    Route::post('/{id}/update','User\PinjamController@update');
    Route::get('/{id}/edit','User\PinjamController@edit');
    Route::get('/{id}/delete','User\PinjamController@destroy');
  });

});
