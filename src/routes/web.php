<?php

use Illuminate\Support\Facades\Route;

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





Route::get('/event','EventCalender@index');

Route::get('/','FrontendController@index');


Route::get('/new-appointment/{doctorId}/{date}','FrontendController@show')->name('create.appointment');



Route::group(['middleware'=>['auth','patient']],function(){

	Route::post('/book/appointment','FrontendController@store')->name('booking.appointment');

	Route::get('/my-booking','FrontendController@myBookings')->name('my.booking');

	Route::get('/user-profile','ProfileController@index');
	Route::post('/user-profile','ProfileController@store')->name('profile.store');
	Route::post('/profile-pic','ProfileController@profilePic')->name('profile.pic');
	Route::get('/my-prescription','FrontendController@myPrescription')->name('my.prescription');


});


Route::get('/dashboard','DashboardController@index');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::group(['middleware'=>['auth','admin']],function(){
	Route::resource('doctor','DoctorController');
	Route::get('/patients','PatientlistController@index')->name('patient');
	Route::get('/patients/all','PatientlistController@allTimeAppointment')->name('all.appointments');
	Route::get('/status/update/{id}','PatientlistController@toggleStatus')->name('update.status');
	Route::resource('department','DepartmentController');


});

Route::group(['middleware'=>['auth','doctor']],function(){

	Route::resource('appointment','AppointmentController');
	Route::post('/appointment/check','AppointmentController@check')->name('appointment.check');
	Route::post('/appointment/update','AppointmentController@updateTime')->name('update');

	Route::get('patient-today','PrescriptionController@index')->name('patients.today');

	Route::post('/prescription','PrescriptionController@store')->name('prescription');

	Route::get('/prescription/{userId}/{date}','PrescriptionController@show')->name('prescription.show');
	Route::get('/prescribed-patients','PrescriptionController@patientsFromPrescription')->name('prescribed.patients');


});
