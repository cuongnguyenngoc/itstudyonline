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
Route::get('awe','HomeController@awe');
// End of Test

// Home route
Route::get('course/{id}','HomeController@getCourse');

// Authentication Area
Route::post('checkEmailExist','Auth\AuthController@checkEmailExisted');
Route::post('register','Auth\AuthController@postRegister');
Route::post('login','Auth\AuthController@postLogin');
Route::get('logout','Auth\AuthController@getLogout');
// End of Authenciation

//User Area
Route::get('user/editprofile',[
	'as'=> 'user.editprofile',
	'uses'=> 'Usercontroller@editprofile'
	]);
Route::post('user/update','UserController@update');
Route::get('user/changepassword','UserController@changepwd');
Route::post('user/changepass','UserController@change');
Route::get('user/addphoto','UserController@addphoto');
Route::post('user/uploadphoto','UserController@uploadphoto');
// End of User Area

// Master Area
Route::get('master/manage','MasterController@manage');
Route::get('master/create-course/','MasterController@getCreateCourse');
Route::post('master/create-course', ['as'=>'master.course.create','uses'=>'MasterController@postCreateCourse']);
// Route::model('id','App\Course');
Route::post('master/course/update/{course}', ['as'=>'master.course.update','uses'=>'MasterController@updateCourse']);
Route::post('create-course','MasterController@create_course');
Route::post('course/delete-lecture','MasterController@deleteLecture');
Route::get('course-manage/create-course-detail/{id}','MasterController@create_detail_course');
Route::post('video/do-upload','MasterController@doVideoUpload');
Route::post('video/choose-thumbnail','MasterController@chooseThumbnail');
Route::post('video/update-thumbnail','MasterController@updateThumbnail');
Route::post('document/do-upload','MasterController@doDocumentUpload');
Route::post('master/update-course','MasterController@doUpdateCourse');
Route::post('master/upload-image','MasterController@doUploadImage');
Route::post('master/upload-video-intro','MasterController@doUploadVideoIntro');
Route::post('master/update-price-course','MasterController@doUpdatePrice');
Route::post('master/submit-course','MasterController@doSubmitCourse');
Route::post('master/add-master-course','MasterController@doAddMasterCourse');
Route::post('master/delete-course','MasterController@doDeleteCourse');
Route::get('master/edit-course/{id}','MasterController@doEditCourse');
// End of master


// Disciple Area
Route::get('course/learning/{id}','DiscipleController@learnCourse');
Route::post('course/get-lecture','DiscipleController@getLecture');
Route::post('lecture/add-comment','DiscipleController@addComment');
Route::post('lecture/delete-comment','DiscipleController@deleteComment');
Route::post('lecture/mark-lecture','DiscipleController@markLecture');
// End of disciple
