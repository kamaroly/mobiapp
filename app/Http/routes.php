<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: X-Authorization");
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 */

Route::get('/', function () {
	return view('welcome');
});

Route::group(['prefix' => 'api'], function () {
	Route::get('/auth/msisdn/{msisdn}', '\App\Http\Controllers\Auth\AuthController@registerMsisdn')
	->where('msisdn', '[0-9]+');

	Route::get('/auth/code/{msisdn}/{code}', '\App\Http\Controllers\Auth\AuthController@verifyCode')
	->where('msisdn', '[0-9]+');
});