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
Route::post('user/update-profile','UserController@updateProfile');
Route::get('user/changepassword','UserController@changepwd');
Route::post('user/changepass','UserController@changePassword');
Route::get('user/addphoto','UserController@addphoto');
Route::post('user/uploadphoto','UserController@uploadphoto');
Route::post('user/checkRightPassword','UserController@checkRightPassword');
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
Route::post('master/save-master-course','MasterController@doSaveMasterCourse');
Route::post('master/delete-master-course','MasterController@doDeleteMasterCourse');
Route::post('master/delete-course','MasterController@doDeleteCourse');
Route::get('master/edit-course/{id}','MasterController@doEditCourse');
Route::post('master/check-lecture-existed','MasterController@doCheckLectureExisted');
Route::post('master/check-course-existed','MasterController@doCheckCourseExisted');
Route::post('master/add-quiz','MasterController@addQuiz');
Route::post('master/delete-quiz','MasterController@deleteQuiz');
// End of master


// Disciple Area
Route::get('course/learning/{id}','DiscipleController@learnCourse');
Route::post('course/get-lecture','DiscipleController@getLecture');
Route::post('lecture/add-comment','DiscipleController@addComment');
Route::post('lecture/delete-comment','DiscipleController@deleteComment');
Route::post('lecture/mark-lecture','DiscipleController@markLecture');
Route::post('disciple/rating-course','DiscipleController@rateCourse');
Route::post('disciple/do-quiz','DiscipleController@doQuiz');
Route::get('disciple/watch-rank','DiscipleController@watchRank');
// End of disciple


// Forum Area
Route::get('forum','Forum\CategoryController@index');

Route::get('forum/course/{df}','Forum\CategoryController@indexOfEnroll');
Route::get('forum/topic/create/{df}', 'Forum\TopicController@createOfCouse');
Route::get('forum/course/{df}/{ce}','Forum\TopicController@showOfEnroll');
Route::get('forum/course/{df}/{ce}/edit','Forum\TopicController@editOfEnroll');
Route::get('forum/course/{df}/{ce}/delete','Forum\TopicController@destroyOfEnroll');

Route::get('forum/topic/create', 'Forum\TopicController@create');
Route::post('forum/topic/store', ['as'=>'forum.topic.create','uses'=>'Forum\TopicController@store']);
Route::get('forum/topic/{df}', 'Forum\TopicController@show');
Route::get('forum/topic/{df}/edit', 'Forum\TopicController@edit');
Route::get('forum/topic/{df}/delete', 'Forum\TopicController@destroy');

Route::get('forum/category/create', 'Forum\CategoryController@create');
Route::get("forum/category/{df}", 'Forum\CategoryController@show');
Route::post('forum/category/store', ['as'=>'forum.cate.create','uses'=>'Forum\CategoryController@store']);
Route::post('forum/reply/store', 'Forum\ReplyController@store');

Route::get('forum/manager','Forum\ManagerController@index');
// End of forum

// Admin area
Route::get('admin',[
	'as'    => 'admin',
	'uses' => 'AdminController@index'
	]);
//Route Managerment Roles 
Route::get('admin/roleManage',[
	'as'     => 'admin.roleManage' ,
	'uses'  =>	'AdminController@roleManage'
	]);
Route::get('admin/roleManage/{id}/{id_role}/update',[
	'as'    =>'admin.roleManage.update',
	'uses'  => 'AdminController@updateRole'
	]);
Route::get('admin/roleManage/{id}/delete',[
	'as'    =>'admin.roleManage.delete',
	'uses' => 'AdminController@deleteUser' 
	]);
Route::get('admin/roleManage/{id}/userInfomation',[
	'as'   =>'admin.roleManage.userInfomation',
	'uses' =>'AdminController@userInfomation'
	]);
Route::get('admin/roleManage/{id}/changeRole',[
	'as'   =>'admin.roleManage.changeRole',
	'uses' =>'AdminController@changeRole'
	]);

//Route Management Courses
Route::get('admin/courseManage',[
	'as'   =>'admin.courseManage',
	'uses' =>'AdminController@courseManage'
	]);
Route::get('admin/courseManage/{id}/delete',[
	'as'    => 'admin.courseManage.delete',
	'uses'  =>'AdminController@deleteCourse'
	]);
Route::get('admin/courseManage/{id}/courseInfomation',[
	'as'    => 'admin.courseManage.courseInfomation',
	'uses'  => 'AdminController@courseInfomation'  
	]);

//Route Control Course
Route::get('admin/courseControl',[
	'as'   =>'admin.courseControl',
	'uses' =>'AdminController@courseControl'
	]);
Route::get('admin/courseControl/{id}/acceptCourse',[
	'as'    =>'admin.courseControl.accept',
	'uses'  =>'AdminController@acceptCourse' 
	]);

//Route Management Forum
Route::get('admin/forumManage',[
	'as'    => 'admin.forumManage',
	'uses'  =>'AdminController@forumManage'
	]);
Route::get('admin/forumManage/{id}/delete',[
	'as'    =>'admin.forumManage.delete',
	'uses'  => 'AdminController@deleteComment'
	]);
// Management Category
Route::get('admin/categoryManage',[
    'as'    =>'admin.categoryManage',
    'uses'  =>'AdminController@categoryManage'
	]);
Route::post('admin/categoryManage/update',[
    'as'    => 'admin.category.update',
    'uses'  =>'AdminController@categoryUpdate' 
	]);
//Management Language
Route::get('admin/language',[
	'as'	=> 'admin.languageManage',
	'uses'	=> 'AdminController@languageManage'
	]);
Route::post('admin/language/update',[
	'as'	=> 'admin.language.update',
	'uses'	=> 'AdminController@languageUpdate'
	]);
Route::post('admin/checkLanguageExisted','AdminController@checkLanguageExisted');
Route::post('admin/checkCategoryExisted','AdminController@checkCategoryExisted');
// End of admin area