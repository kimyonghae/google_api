<?php

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

Route::post('/insertUser', 'GSuiteAdminController@insertUser');
Route::post('/deleteUser', 'GSuiteAdminController@deleteUser');

Route::post('/sendMessage', 'GmailController@sendMessage');
Route::get('/listMessages', 'GmailController@listMessages');
Route::get('/getMessage', 'GmailController@getMessage');

Route::get('/test', 'TestController@test');

