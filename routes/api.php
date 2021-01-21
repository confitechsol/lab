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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


Route::get('/getdata/{table_name}/{lab_token}', 'api\DataController@getData')->name('getData');
Route::post('/updatedata', 'api\DataController@updateData')->name('updateData');
Route::get('/transfer_15a_data', 'api\DataController@transfer_15a_data');
Route::get('/transfer_15a_data_to_glabal', 'api\DataController@transfer_15a_data_to_glabal');
