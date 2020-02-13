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
Route::middleware('auth:api')->namespace('API')->group(function(){
  Route::get('websites/all', 'WebsiteController@all');
  Route::apiResource('websites', 'WebsiteController')->except(['update', 'destroy']);
  Route::get('category/{id}/website', 'CategoryController@website');
  Route::apiResource('category', 'CategoryController')->except(['update', 'destroy']);
  Route::get('brands/{id}/website', 'BrandController@website');
  Route::apiResource('brands', 'BrandController')->except(['update', 'destroy']);
  Route::apiResource('products', 'ProductController')->except(['update', 'destroy']);
  Route::apiResource('process', 'ProcessController')->except(['update', 'destroy']);
});
