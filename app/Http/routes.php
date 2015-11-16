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

Route::get('/','HomeController@index');

// Test Area
Route::get('test','HomeController@test');
Route::get('admin/manage','HomeController@manage');



// Authentication Area
Route::post('checkEmailExist','Auth\AuthController@checkEmailExisted');
Route::post('register','Auth\AuthController@postRegister');
Route::post('login','Auth\AuthController@postLogin');
Route::get('logout','Auth\AuthController@getLogout');

// Master Area
Route::get('master/manage','MasterController@manage');
Route::get('master/create-course/','MasterController@getCreateCourse');
Route::post('master/create-course', ['as'=>'master.course.create','uses'=>'MasterController@postCreateCourse']);
Route::model('id','App\Course');
Route::post('master/course/update/{course}', ['as'=>'master.course.update','uses'=>'MasterController@updateCourse']);
Route::post('create-course','MasterController@create_course');
Route::get('course-manage/create-course-detail/{id}','MasterController@create_detail_course');
Route::post('video/do-upload','MasterController@doVideoUpload');