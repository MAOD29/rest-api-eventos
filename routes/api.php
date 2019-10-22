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

Route::middleware('auth:api')->get('/user', function(Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::get('user/getbussiness','UserController@getAllBusinessForUser');
    Route::get('user/getevents','UserController@getAllEventsForUser');
    Route::get('gettypebussiness','BusinessController@getTypeOfBussines');

    
    //gracias a esto puedo usar route mode bulding ver destroy en este controller
    Route::apiResource('user', 'UserController');
    Route::apiResource('business', 'BusinessController')->middleware('auth:api');
    Route::apiResource('event', 'EventController')->middleware('auth:api');
    Route::post('login', 'LoginController@login');
    Route::post('register', 'LoginController@register');
   
});




