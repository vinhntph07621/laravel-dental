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

Route::post('/login','AuthController@login');
Route::post('/signup','AuthController@signup');

Route::middleware('auth:api')->group(function (){
    Route::get('/service', 'ServiceController@list');
    Route::post('/service', 'ServiceController@create');
    Route::put('/service/{service}', 'ServiceController@update');
    Route::delete('/service/{service}', 'ServiceController@delete');

    Route::get('/price-list', 'PriceListController@list');
    Route::post('/price-list', 'PriceListController@create');
    Route::put('/price-list/{priceList}', 'PriceListController@update');
    Route::delete('/price-list/{priceList}', 'PriceListController@delete');
    Route::get('/logout','AuthController@logout');
});







// Route::group([
//     'prefix' => 'auth'
// ], function (){
    

//     Route::group([
//         'middleware' => 'auth:api'
//     ], function() {
//         Route::get('/logout','AuthController@logout');
//         Route::get('/user','AuthController@user');

//     });
// });