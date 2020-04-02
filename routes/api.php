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
Route::post('login','UserController@login');
Route::post('register','UserController@register');
Route::get('usera','UserController@index');
Route::get('unauthorized', ['as' => 'unauthorized', 'uses' => 'UserController@unauthorized']);

Route::group(['middleware' => ['auth:api','token']], function(){
    Route::get('details', 'UserController@details');
    Route::get('category', 'CategoryController@index');
    });
