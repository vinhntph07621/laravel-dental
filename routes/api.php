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
Route::post('/login/admin','AuthController@loginAdmin');
Route::post('/signup','UserController@signup');

Route::get('/price-list', 'PriceListController@index');
Route::get('/detail-price', 'DetailPriceController@index');

Route::post('reset-password', 'ResetPasswordController@sendMail');
Route::put('reset-password/{token}', 'ResetPasswordController@reset');

Route::get('/doctors','DoctorController@index');
Route::get('/doctors/{id}','DoctorController@show');
Route::get('/doctor/special','DoctorController@getSpecial');

Route::get('/services', 'ServiceController@index');
Route::post('/contacts','ContactController@store');

Route::middleware('auth:api')->group(function (){
    Route::get('/auth', 'AuthController@user');

    Route::get('/dashboards/count','DashboardController@index');
    Route::get('/dashboards/booking-current/doctor','DashboardController@getBookingCurrentByDoctor');
    Route::get('/dashboards/booking-current/admin','DashboardController@getBookingCurrentByAdmin');
    Route::get('/dashboards/booking-current/admin/complete','DashboardController@getBookingCurrentByAdminComplete');
    Route::get('/dashboards/booking-current/doctor/complete','DashboardController@getBookingCurrentByDoctorComplete');

    Route::get('/notifications','NotificationController@index');

    Route::get('/appointments', 'AppointmentController@index');
    Route::put('/appointments/{appointment}', 'AppointmentController@updateStatus');
    Route::get('/appointments/detail/{id}', 'AppointmentController@getDetail');
    Route::get('/appointments/service/{appointmentId}', 'AppointmentController@getDetailService');
    Route::get('/appointment', 'AppointmentController@show');
    Route::put('/appointments/update/{appointment}', 'AppointmentController@updateByUser');
    Route::post('/appointments', 'AppointmentController@store');
    Route::post('/appointments/no-user', 'AppointmentController@storeNoUser');
    Route::put('/appointments/edit/{appointment}', 'AppointmentController@edit');

    Route::get('/medical-records','MedicalRecordController@index');
    Route::get('/medical-records/doctor','MedicalRecordController@getListByDoctor');
    Route::get('/medical-records/user','MedicalRecordController@getListByUser');
    Route::get('/medical-records/{id}','MedicalRecordController@getDetail');

    Route::get('/re-examinations','ReExaminationController@index');
    Route::post('/re-examinations','ReExaminationController@store');
    Route::get('/re-examinations/number-bookings/{numberBookingId}','ReExaminationController@getListByNumberBooking');
    Route::get('/re-examinations/detail/{id}','ReExaminationController@getDetail');
    Route::get('/re-examinations/show/user','ReExaminationController@getByUser');
    Route::get('/re-examinations/show/doctor','ReExaminationController@getByDoctor');
    Route::get('/re-examinations/{reExaminationId}','ReExaminationController@show');
    Route::put('/re-examinations/{reExamination}','ReExaminationController@update');
    Route::delete('/re-examinations/{reExamination}','ReExaminationController@destroy');

    Route::get('/number-bookings','NumberBookingController@index');
    Route::get('/number-bookings/detail/{id}','NumberBookingController@getDetail');
    Route::get('/number-bookings/complete','NumberBookingController@getListComplete');
    Route::get('/number-bookings/admin/pending','NumberBookingController@getListPendingAdmin');
    Route::get('/number-bookings/doctor/pending','NumberBookingController@getListPending');
    Route::get('/number-bookings/doctor','NumberBookingController@getListByDoctor');
    Route::put('/number-bookings/{numberBooking}','NumberBookingController@confirm');

    Route::post('/doctors','DoctorController@store');
    Route::put('/doctors/{doctor}','DoctorController@update');
    Route::put('/doctors/block/{doctor}','DoctorController@blockDoctor');
    Route::delete('/doctors/{user}','DoctorController@delete');

    Route::get('/receptionists','ReceptionistController@index');
    Route::post('/receptionists','ReceptionistController@store');
    Route::put('/receptionists/{receptionist}','ReceptionistController@update');
    Route::get('/receptionists/detail/{id}','ReceptionistController@getDetail');

    Route::get('/nurses','NurseController@index');
    Route::get('/nurses/detail/{id}','NurseController@getDetail');
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
    Route::get('/users/in-active', 'UserController@inActive');
    Route::put('/users/block/{userId}', 'UserController@block');
    Route::get('/user', 'AuthController@user');
    Route::post('/users', 'UserController@store');
    Route::put('/users/{user}', 'UserController@update');
    Route::put('/users/password/update', 'UserController@updatePassword');

    Route::get('/contacts','ContactController@index');
    Route::get('/contacts/{id}','ContactController@getDetail');
    Route::put('/contacts/{contact}','ContactController@update');
    Route::delete('/contacts/{contact}','ContactController@destroy');

});
