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
Route::group(['prefix' => '', 'namespace' => 'API', 'as' => 'api.'], function () {//Route::resource('city', 'CityController');
	Route::resource('city', 'CityController');
	Route::match(['get'],'city/subCity/{id}', 'CityController@getSubCity')->name('city.subCity');	

	Route::resource('category', 'ProductCategoryController');
	Route::match(['get'],'category/subCategory/{id}', 'ProductCategoryController@getSubCategory')->name('category.subCategory');
});
