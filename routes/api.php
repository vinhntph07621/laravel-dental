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

Route::get('/price-list', 'PriceListController@index');
Route::get('/detail-price', 'DetailPriceController@index');

Route::get('/doctors','DoctorController@index'); 
Route::get('/doctors/{id}','DoctorController@show');

Route::get('/services', 'ServiceController@index');

Route::get('/contacts','ContactController@index');
Route::post('/contacts','ContactController@store');
Route::put('/contacts/{contact}','ContactController@update');
Route::put('/contacts/{contact}','ContactController@destroy');


Route::middleware('auth:api')->group(function (){
    Route::get('/auth', 'AuthController@user');
    Route::get('/user-show', 'AuthController@show');
    
    Route::get('/appointments', 'AppointmentController@index');
    Route::put('/appointments/{appointment}', 'AppointmentController@update');
    Route::get('/appointments/detail/{id}', 'AppointmentController@getDetail');
    Route::get('/appointment', 'AppointmentController@show');
    Route::post('/appointments', 'AppointmentController@store');
    
    Route::post('/doctors','DoctorController@store'); 
    Route::delete('/doctors/{user}','DoctorController@delete');
    
    Route::get('/nurses','DoctorController@index'); 
    Route::post('/nurses','NurseController@store');
    
    Route::post('/services', 'ServiceController@store');
    Route::put('/services/{service}', 'ServiceController@update');
    Route::delete('/services/{service}', 'ServiceController@destroy');
    
    Route::get('/roles', 'RoleController@index');
    Route::post('/roles', 'RoleController@store');
    
    Route::put('/roles/{role}', 'RoleController@update');
    Route::delete('/roles/{role}', 'RoleController@destroy');

    Route::post('/price-list', 'PriceListController@store');
    Route::put('/price-list/{priceList}', 'PriceListController@update');
    Route::delete('/price-list/{priceList}', 'PriceListController@destroy');
    Route::get('/logout','AuthController@logout');

    Route::post('/detail-price', 'DetailPriceController@store');
    Route::put('/detail-price/{detailPrice}', 'DetailPriceController@update');
    Route::delete('/detail-price/{detailPrice}', 'DetailPriceController@delete');

    Route::get('/users', 'UserController@index');
    Route::get('/user', 'AuthController@user');
    Route::put('/user/{user}', 'UserController@update');

    Route::get('/permissions', 'PermissionController@index');
    Route::post('/permissions', 'PermissionController@store');
    Route::put('/permissions/{per}', 'PermissionController@update');
    Route::delete('/permissions/{per}', 'PermissionController@destroy');
    
});