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
Route::get('/doctor/special','DoctorController@getSpecial');

Route::get('/services', 'ServiceController@index');

Route::post('/contacts','ContactController@store');



Route::middleware('auth:api')->group(function (){
    Route::get('/auth', 'AuthController@user');
    Route::get('/dashboard','DashboardController@index');
    
    Route::get('/appointments', 'AppointmentController@index');
    Route::put('/appointments/{appointment}', 'AppointmentController@updateStatus');
    Route::get('/appointments/detail/{id}', 'AppointmentController@getDetail');
    Route::get('/appointments/service/{appointmentId}', 'AppointmentController@getDetailService');
    Route::get('/appointment', 'AppointmentController@show');
    Route::put('/appointments/update/{appointment}', 'AppointmentController@updateByUser');
    Route::post('/appointments', 'AppointmentController@store');
    Route::put('/appointments/edit/{appointment}', 'AppointmentController@edit');

    Route::get('/medical-records','MedicalRecordController@index');

    Route::get('/re-examinations','ReExaminationController@index');
    Route::post('/re-examinations','ReExaminationController@store');
    Route::get('/re-examinations/detail/{id}','ReExaminationController@getDetail');
    Route::get('/re-examinations/show/user','ReExaminationController@getByUser');
    Route::get('/re-examinations/{reExaminationId}','ReExaminationController@show');
    Route::put('/re-examinations/{reExamination}','ReExaminationController@update');
    Route::delete('/re-examinations/{reExamination}','ReExaminationController@destroy');

    Route::get('/number-bookings','NumberBookingController@index');
    Route::get('/number-bookings/detail/{id}','NumberBookingController@getDetail');
    Route::get('/number-bookings/doctor/pending','NumberBookingController@getListPending');
    Route::get('/number-bookings/doctor','NumberBookingController@getListByDoctor');
    Route::put('/number-bookings/{numberBooking}','NumberBookingController@confirm');
    
    Route::post('/doctors','DoctorController@store'); 
    Route::put('/doctors/{doctor}','DoctorController@update'); 
    Route::put('/doctors/block/{doctor}','DoctorController@blockDoctor');
    Route::delete('/doctors/{user}','DoctorController@delete');

    
    Route::get('/nurses','NurseController@index'); 
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
    Route::put('/users/{user}', 'UserController@update');
    Route::put('/users/password/update', 'UserController@updatePassword');

    Route::get('/permissions', 'PermissionController@index');
    Route::post('/permissions', 'PermissionController@store');
    Route::put('/permissions/{per}', 'PermissionController@update');
    Route::delete('/permissions/{per}', 'PermissionController@destroy');

    Route::get('/contacts','ContactController@index');
    Route::put('/contacts/{contact}','ContactController@update');
    Route::delete('/contacts/{contact}','ContactController@destroy');
    
});