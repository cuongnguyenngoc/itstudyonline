<?php

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

 Route::get('/app', function() {
     return view('app');
 });
Route::get('/','HomeController@index');

/*---------------------------------------master ----------------------------------------*/
Route::get('master/getCates', "MasterController@getAllCategories");
Route::get('master/regis-course',array('uses'=>'MasterController@index'));
Route::post('master/regis-process',array('uses'=> 'MasterController@regisProcess'));