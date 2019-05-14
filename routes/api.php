<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'Auth\LoginController@login');
Route::post('/register', 'Auth\RegisterController@register');
Route::get('/logout', 'Auth\LoginController@logout');

  Route::group(['middleware' => 'auth:api'], function () {

  Route::prefix('v1')->group(function(){
    Route::apiResource("barang", "API\V1\GoodsController");
    Route::apiResource("kategori", "API\V1\CategoriesController");
    Route::apiResource("peminjaman", "API\V1\PeminjamanController");
  });

});
