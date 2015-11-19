<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redirect;
use App\Course;
use App\ProgrammingLanguage;
use App\Learninglevel;
use App\Category;
use App\Video;
use App\Thumbnail;
use Validator;
use Response;
use File;

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
        $name = explode('.', $filename);     // seperate name by dot character
        $ext = strtolower(end($name));       // get extention part of name
        array_pop($name);                    // skip tail in name
        $imgname = implode("_", $name);         // combine all parts of name by underscore
        $name = str_replace(' ', '_', $imgname); // change space to uderscore _

        $video_file = './uploads/videos/' . $name . '.' . $ext; // remember this is relative path to file index.php

        // move file to uploads/videos folder
        $file->move('uploads/videos',$video_file);
        if($request->input('video_id') == null){
            $video = new Video;
        }else{
            $video = Video::findOrFail($request->input('video_id'));
            //Checking if user change video, it will delete video and its thumbnails which have saved in folder
            File::delete($video->path);
            $thumbnails = $video->thumbnails;
            foreach($thumbnails as $thumbnail){
                File::delete($thumbnail->path);
            }
            
        }
        
        $video->video_name = $name;
        $video->path = 'uploads/videos/'. $name . '.' . $ext;
        $video->type = 'upload';
        $video->user_id = Auth::user()->id;
        $video->save();

        // Save thumbnail
        $ffmpeg = 'ffmpeg\\ffmpeg'; // remember this is relative path to file index.php
        for($i = 1; $i <= 5; $i++){
            $second = $i * 5;
            $image_file = './uploads/thumbnails/' . $name . $i . '.jpg'; // remember this is relative path to file index.php
            $cmd = "$ffmpeg -itsoffset -$second -i $video_file -vcodec mjpeg -vframes 1 -an -f rawvideo $image_file";
            exec($cmd);

            if($request->input('video_id') == null){
                $thumbnail = $video->thumbnails()->create([
                    'video_id' => $video->id,
                    'img_name' => $imgname,
                    'path' => 'uploads/thumbnails/' . $name . $i . '.' . 'jpg'
                ]);
            }else{

                $thumbnails[$i-1]->img_name = $imgname;
                $thumbnails[$i-1]->path = 'uploads/thumbnails/' . $name . $i . '.' . 'jpg';
                $thumbnails[$i-1]->save();
            }            
            
        }
        //Set thumbnail default for video dont have thumb_id yet
        if($video->thumb_id == null)
            $video->thumb_id = $video->thumbnails->first()->id;

        $video->save();
        $thumbnail = $video->thumbnail;

        return Response::json(['thumbnail' => $thumbnail, 'video' => $video]);
    }


    public function chooseThumbnail(Request $request){

        if($request->ajax()){

            $video = Video::findOrFail($request->get('id'));
            $thumbnails = $video->thumbnails;

            return Response::json(['thumbnails'=>$thumbnails]);
        }
    }

    public function updateThumbnail(Request $request){

        if($request->ajax()){

            $thumbnail = Thumbnail::findOrFail($request->get('thumb_id'));

            $video = $thumbnail->video;
            $video->thumb_id = $thumbnail->id;

            $video->save();
            $thumbnail = $video->thumbnail;

            return Response::json(['thumbnail'=>$thumbnail]);
        }
    }
}
