<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/home', 'HomeController@index');

    Route::post('upload', ['as' => 'files.upload', 'uses' => 'HomeController@upload']);
    Route::get('usuario/{userId}/{userName}/download/{fileId}', ['as' => 'files.download', 'uses' => 'HomeController@download']);
    Route::get('usuario/{userId}/{userName}/remover/{fileId}', ['as' => 'files.destroy', 'uses' => 'HomeController@destroy']);    
});
