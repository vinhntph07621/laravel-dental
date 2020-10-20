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
Route::post('/signup','UserController@signup');

Route::get('/doctors','DoctorController@index');
Route::post('/doctors','DoctorController@store');

Route::post('/appointments', 'AppointmentController@store');

Route::middleware('auth:api')->group(function (){
    Route::get('/services', 'ServiceController@index');
    Route::post('/services', 'ServiceController@store');
    Route::put('/services/{service}', 'ServiceController@update');
    Route::delete('/services/{service}', 'ServiceController@destroy');

    Route::get('/roles', 'RoleController@index');
    Route::post('/roles', 'RoleController@store');
    Route::put('/roles/{role}', 'RoleController@update');
    Route::delete('/roles/{role}', 'RoleController@destroy');

    Route::get('/price-list', 'PriceListController@index');
    Route::post('/price-list', 'PriceListController@store');
    Route::put('/price-list/{priceList}', 'PriceListController@update');
    Route::delete('/price-list/{priceList}', 'PriceListController@destroy');
    Route::get('/logout','AuthController@logout');

    Route::get('/detail-price', 'DetailPriceController@list');
    Route::post('/detail-price', 'DetailPriceController@create');
    Route::put('/detail-price/{detailPrice}', 'DetailPriceController@update');
    Route::delete('/detail-price/{detailPrice}', 'DetailPriceController@delete');

    

    Route::get('/users', 'UserController@index');

    Route::post('/employee','EmployeeController@store');

    Route::get('/permissions', 'PermissionController@index');
    Route::post('/permissions', 'PermissionController@store');
    Route::put('/permissions/{per}', 'PermissionController@update');
    Route::delete('/permissions/{per}', 'PermissionController@destroy');

    
    
});