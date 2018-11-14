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
Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');

Route::group(['middleware' => ['jwt_verify']], function() {
		Route::get('user', 'UserController@getAuthenticatedUser');
		Route::post('logout', 'UserController@logout');
		
		//add new driver
		Route::post('addDriver','DriverController@addDriver');

		//send Ride request to drivers
		Route::post('sendRideRequest','RideController@sendRideRequest');

		//Accept Ride request by driver
		Route::post('acceptRideRequest','RideController@acceptRideRequest');

		//Drop user 
		Route::post('dropUserDestination','RideController@dropUserDestination');

		//get
		Route::get('getRideStatus','RideController@getRideStatus');

});
