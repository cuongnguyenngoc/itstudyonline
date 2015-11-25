<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redirect;
use App\User;
use App\Course;
use App\UserCreateCourse;
use App\Lecture;
use App\ProgrammingLanguage;
use App\Learninglevel;
use App\Category;
use App\Video;
use App\Document;
use App\Thumbnail;
use App\Image;
use App\Introvideo;
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
                'image'=>'Image',
                'intro-video' => 'Introduction video'
            ),
            'COURSE SETTINGS' => array(
                'price-coupons'=>'Price & Coupons',
                // 'manage-masters'=>'Manage Masters'
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
                return Response::json(['status'=>false, 'message'=>'Error man','input'=>$request->input()]);
            }
            if($request->input('id') !=null && Course::find($request->input('id') != null))
                
                $course = Course::find($request->input('id'));
            else 
                $course = new Course;

            $course->cat_id = $request->input('cat_id');
            $course->lang_id = $request->input('lang_id');
            $course->level_id = $request->input('level_id');
            $course->course_name = $request->input('course_name');
            $course->description = $request->input('description');
                
            $course->save();
            return Response::json(['status'=>true, 'message'=>'You created successfully','course'=>$course]);
        }
        
    }


    public function create_detail_course($id){

        return View('master.create-course-detail');
    }

    public function doDocumentUpload(Request $request){
        $file = $request->file('file');
        //return Response::json(['doc' => $request->input('doc_id'), 'video' => $request->input('video_doc_id')]);
        $filename = uniqid() . $file->getClientOriginalName();
        $name = explode('.', $filename);     // seperate name by dot character
        $ext = strtolower(end($name));       // get extention part of name
        array_pop($name);                    // skip tail in name
        $imgname = implode("_", $name);         // combine all parts of name by underscore
        $name = str_replace(' ', '_', $imgname); // change space to uderscore _

        $document_file = './uploads/documents/' . $name . '.' . $ext; // remember this is relative path to file index.php

        // move file to uploads/videos folder
        $file->move('uploads/documents',$document_file);

        if($request->input('video_id') != null && Video::find($request->input('video_id')) != null){

            $video = Video::find($request->input('video_id'));
            File::delete($video->path);
            $thumbnails = $video->thumbnails;
            foreach($thumbnails as $thumbnail){
                File::delete($thumbnail->path);
                $thumbnail->delete();
            }
            $video->delete();
        }

        if($request->input('doc_id') != null && Document::find($request->input('doc_id')) != null){
            
            $document = Document::find($request->input('doc_id'));
            //Checking if user change video, it will delete video and its thumbnails which have saved in folder
            File::delete($document->path);
        }else{
            $document = new Document;
            
        }
        
        $document->doc_name = $imgname;
        $document->path = 'uploads/documents/'. $name . '.' . $ext;
        // $document->user_id = Auth::user()->id;
        $document->save();

        return Response::json(['doc' => $document]);
    }

    public function doVideoUpload(Request $request){
        $file = $request->file('file');
        //return Response::json(['doc' => $request->input('doc_video_id'), 'video' => $request->input('video_id')]);
        $filename = uniqid() . $file->getClientOriginalName();
        $name = explode('.', $filename);     // seperate name by dot character
        $ext = strtolower(end($name));       // get extention part of name
        array_pop($name);                    // skip tail in name
        $imgname = implode("_", $name);         // combine all parts of name by underscore
        $name = str_replace(' ', '_', $imgname); // change space to uderscore _

        $video_file = './uploads/videos/' . $name . '.' . $ext; // remember this is relative path to file index.php

        // move file to uploads/videos folder
        $file->move('uploads/videos',$video_file);

        if($request->input('doc_id') != null && Document::find($request->input('doc_id')) != null){
            $document = Document::find($request->input('doc_id'));
            File::delete($document->path);
            $document->delete();
        }else{
            $document = new Document;
        }

        if($request->input('video_id') != null && Video::find($request->input('video_id')) != null){
            
            $video = Video::find($request->input('video_id'));
            //Checking if user change video, it will delete video and its thumbnails which have saved in folder
            File::delete($video->path);
            $thumbs = $video->thumbnails;
            foreach($thumbs as $thumbnail){
                File::delete($thumbnail->path);
            }
        }else{
            $video = new Video;
        }
        
        $thumbnails = $video->thumbnails;
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

            if(sizeof($thumbnails) == 0){
                $video->thumbnails()->create([
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
        $video = Video::find($video->id);
        //Set thumbnail default for video dont have thumb_id yet
        if($video->thumb_id == null && sizeof($video->thumbnails) != 0){
            $video->thumb_id = $video->thumbnails->first()->id;
            $video->save();
        }

        $thumbnail = $video->thumbnail;

        return Response::json(['thumbnail' => $thumbnail, 'video' => $video]);
    }


    public function chooseThumbnail(Request $request){

        if($request->ajax()){
            if(Video::find($request->get('id')) != null){
                $video = Video::find($request->get('id'));
            }
            $thumbnails = $video->thumbnails;

            return Response::json(['thumbnails'=>$thumbnails]);
        }
    }

    public function updateThumbnail(Request $request){

        if($request->ajax()){

            $thumbnail = Thumbnail::find($request->get('thumb_id'));

            $video = $thumbnail->video;
            $video->thumb_id = $thumbnail->id;

            $video->save();
            $thumbnail = $video->thumbnail;

            return Response::json(['thumbnail'=>$thumbnail]);
        }
    }

    public function doUpdateCourse(Request $request){

        if($request->ajax()){

            if($request->input('course_id') != null && Course::find($request->input('course_id'))){
                $course = Course::find($request->input('course_id'));
                if($request->input('lec_id') != null && Lecture::find($request->input('lec_id')) != null){

                    $lecture = Lecture::find($request->input('lec_id'));
                }else{
                    
                    $lecture = $course->lectures()->create([
                                'course_id' => $course->id,
                                'user_id' => Auth::user()->id,
                                'lec_name' => $request->input('lec_name'),
                                'description' => $request->input('description'),
                                'order' => $request->input('order')
                            ]);
                    $lecture = Lecture::find($lecture->id);
                }
                
                if($request->input('video_id') != null 
                        && $request->input('doc_id') == null 
                        && $request->input('text') == null
                        && Video::find($request->input('video_id')) != null){

                    $video = Video::find($request->input('video_id'));
                    $video->lec_id = $lecture->id;
                    $video->save();
                }elseif($request->input('video_id') == null 
                        && $request->input('text') == null
                        && $request->input('doc_id') != null 
                        && Document::find($request->input('doc_id')) != null){
                    $document = Document::find($request->input('doc_id'));
                    $document->lec_id = $lecture->id;
                    $document->save();
                }elseif($request->input('text') != null
                        && $request->input('doc_id') == null 
                        && $request->input('video_id') == null){
                    $lecture->text = $request->input('text');
                    $lecture->save();
                }else{
                    return Response::json(['status'=>false,'message'=>'It have get a problem']);
                }

                return Response::json(['status'=>true,'lecture'=>$lecture, 'message'=>'Cool! You have created lecture successfully']);
            }else{
                return Response::json(['status'=>false,'message'=>'I can not find course_id, you need create course first']);
            }
        }
    }

    public function doUploadImage(Request $request){

        if($request->input('course_id') != null && Course::find($request->input('course_id'))){
            $course = Course::find($request->input('course_id'));

            $file = $request->file('file');
            //return Response::json(['doc' => $request->input('doc_id'), 'video' => $request->input('video_doc_id')]);
            $filename = uniqid() . $file->getClientOriginalName();
            $name = explode('.', $filename);     // seperate name by dot character
            $ext = strtolower(end($name));       // get extention part of name
            array_pop($name);                    // skip tail in name
            $imgname = implode("_", $name);         // combine all parts of name by underscore
            $name = str_replace(' ', '_', $imgname); // change space to uderscore _

            $img_file = './uploads/images/' . $name . '.' . $ext; // remember this is relative path to file index.php
            // move file to uploads/videos folder
            $file->move('uploads/images',$img_file);

            if($request->input('img_id') != null && Image::find($request->input('img_id')) != null){

                $image = Image::find($request->input('img_id'));
                //Checking if user change image, it will delete image hich have saved in folder
                File::delete($image->path);

                $image->img_name = $imgname;
                $image->path = 'uploads/images/'. $name . '.' . $ext;
                $image->save();
            }else{

                $image = $course->image()->create([
                            'course_id' => $course->id,
                            'img_name' => $imgname,
                            'path' => 'uploads/images/'. $name . '.' . $ext
                        ]);
                $image = Image::find($image->id);
            }

            return Response::json(['status' => true, 'image'=>$image, 'message'=>'Cool! You have uploaded image successfully']);
        }else{
            return Response::json(['status' => false, 'message'=>'I can not find course_id, you need create course first']);
        }
    }

    public function doUploadVideoIntro(Request $request){
        if($request->input('course_id') != null && Course::find($request->input('course_id'))){
            $course = Course::find($request->input('course_id'));

            $file = $request->file('file');
            //return Response::json(['doc' => $request->input('doc_id'), 'video' => $request->input('video_doc_id')]);
            $filename = uniqid() . $file->getClientOriginalName();
            $name = explode('.', $filename);     // seperate name by dot character
            $ext = strtolower(end($name));       // get extention part of name
            array_pop($name);                    // skip tail in name
            $imgname = implode("_", $name);         // combine all parts of name by underscore
            $name = str_replace(' ', '_', $imgname); // change space to uderscore _

            $video_file = './uploads/videos/' . $name . '.' . $ext; // remember this is relative path to file index.php
            // move file to uploads/videos folder
            $file->move('uploads/videos',$video_file);

            if($request->input('videointro_id') != null && Introvideo::find($request->input('videointro_id')) != null){

                $introvideo = Introvideo::find($request->input('videointro_id'));
                //Checking if user change video, it will delete video which have saved in folder
                File::delete($introvideo->path);

                $videointro->video_name = $imgname;
                $videointro->path = 'uploads/videos/'. $name . '.' . $ext;
                $videointro->save();
            }else{

                $videointro = $course->videointro()->create([
                            'course_id' => $course->id,
                            'video_name' => $imgname,
                            'path' => 'uploads/videos/'. $name . '.' . $ext
                        ]);
                $videointro = Introvideo::find($videointro->id);
            }

            return Response::json(['status' => true, 'videointro'=>$videointro, 'message'=>'Cool! You have uploaded Video successfully']);
        }else{
            return Response::json(['status' => false, 'message'=>'I can not find course_id, you need create course first']);
        }
    }

    public function doUpdatePrice(Request $request){

        if($request->ajax()){

            if($request->input('course_id') != null && Course::find($request->input('course_id'))){

                $course = Course::find($request->input('course_id'));
                $course->cost = $request->input('price');
                $course->save();

                return Response::json(['status' => true, 'course'=>$course, 'message'=>'Cool! You have updated price of course successfully']);
            }else{
                return Response::json(['status' => false, 'message'=>'I can not find course_id, you need create course first']);
            }
        }
    }

    public function doAddMasterCourse(Request $request){

        if($request->ajax()){
            if($request->input('email') != null && User::where('email',$request->input('email'))->first() != null){
                $user = User::where('email',$request->input('email'))->first();
                if($user->id != Auth::user()->id){
                    if($user->role->role_name == 'master'){
                        return Response::json(['status' => true, 'user'=>$user, 'message'=>'Cool! You have find master successfully']);
                    }else{
                        return Response::json(['status' => false, 'user'=>$user, 'message'=>'This user is not master, please try again']);
                    }
                }else{
                    return Response::json(['status' => false, 'message'=>'Dont add yourself']);
                }
            }else{
                return Response::json(['status' => false, 'message'=>'Something went wrong, buddy']);
            }
        }
    }

    public function doSubmitCourse(Request $request){

        if($request->ajax()){
            if($request->input('course_id') != null && Auth::user() != null){
                if($request->input('id') != null && UserCreateCourse::find($request->input('id')) != null){
                    $usercreatecourse = UserCreateCourse::find($request->input('id'));
                    $usercreatecourse->user_id = Auth::user()->id;
                    $usercreatecourse->course_id = $request->input('course_id');
                    $usercreatecourse->save();
                }else{
                    $usercreatecourse = Auth::user()->usercreatecourse()->create([
                        'user_id' => Auth::user()->id,
                        'course_id' => $request->input('course_id'),
                        'isBoss' => true
                    ]);
                }

                return Response::json(['status' => true, 'usercreatecourse'=>$usercreatecourse, 'message'=>'Cool! you have submited course successfully']);
            }else{
                return Response::json(['status' => false, 'message'=>'Something went wrong, buddy']);
            }
        }
    }
}
