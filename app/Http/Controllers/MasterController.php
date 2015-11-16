<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redirect;
use App\Course;
use App\ProgrammingLanguage;
use App\Learninglevel;
use App\Category;
use App\Video;
use Validator;
use Response;

class MasterController extends Controller
{
    public function __construct(){
    	$this->middleware('master');
    }

    public function manage(){
    	return View('master.manage');
    }

    public function getCreateCourse(){

    	$courseItems = array(
    		'COURSE CONTENT' => array(
    			'course-goals'=>'Course goals',
    			'curriculum'=>'Curriculum'
    		),
    		'COURSE INFO' => array(
    			'basics'=>'Basics',
    			'course-summary'=>'Course Summary', 
    			'image'=>'Image',
    			'promo-video'=>'Promo Video'
    		),
    		'COURSE SETTINGS' => array(
    			'price-coupons'=>'Price & Coupons',
    			'manage-masters'=>'Manage Masters',
    			'danger-zone'=>'Danger Zone'
    		)
    	);
    	$course = new Course;
    	$languages = ProgrammingLanguage::lists('lang_name','id')->all();
    	$categories = Category::lists('cat_name','id')->all();
    	$levels = Learninglevel::lists('level_name','id')->all();

    	return View('master.create-course', compact('courseItems','languages','categories','levels','course'));
    }

    public function postCreateCourse(Request $request){

    	if($request->ajax()){
    		//validate the Request through the validation Rules
	    	$validator = Validator::make($request->all(),[
	    		'cat_id' => 'required',
	    		'lang_id' => 'required',
	    		'level_id' => 'required',
	    		'course_name' => 'required|min:10',
	    		'description' => 'required|min:10'
	    	]);

	    	if($validator->fails()){
	    		//return Redirect::back()->withErrors($validator);
	    		return Response::json(['message'=>'Error man','input'=>$request->input()]);
	    	}
	    	if($request->input('id')==null)
	    		$course = new Course;
	    	else 
	    		$course = Course::find($request->input('id'));

	    	$course->cat_id = $request->input('cat_id');
	    	$course->lang_id = $request->input('lang_id');
	    	$course->level_id = $request->input('level_id');
	    	$course->course_name = $request->input('course_name');
	    	$course->description = $request->input('description');
	    	$course->id = $request->input('id');
	    		
	    	$course->save();
	    	return Response::json(['message'=>'You created successfully','course'=>$course]);
    	}
    	
    }

    public function updateCourse(){
    	print_r($course);
    }

    public function create_detail_course($id){

    	return View('master.create-course-detail');
    }

    public function doVideoUpload(Request $request){
    	$file = $request->file('file');
    	$filename = uniqid() . $file->getClientOriginalName();
    	$file->move('galery/video',$filename);

    	$video = new Video;
    	$video->video_name = $filename;
    	$video->path = 'galery/video/'.$filename;
    	$video->type = 'upload';
    	$video->save();
    }
}
