<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



Route::get('/service', 'ServiceController@list');
Route::post('/service', 'ServiceController@create');
Route::put('/service/{service}', 'ServiceController@update');
Route::delete('/service/{service}', 'ServiceController@delete');

Route::get('/price-list', 'PriceListController@list');
Route::post('/price-list', 'PriceListController@create');
Route::put('/price-list/{service}', 'PriceListController@update');
Route::delete('/price-list/{service}', 'PriceListController@delete');
