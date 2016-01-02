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
use App\Question;
use App\Answer;
use Validator;
use Response;
use File;

class MasterController extends Controller
{
    public function __construct(){
        $this->middleware('master');
    }


    public function addQuiz(Request $request){
        if($request->ajax()){
            if($request->input('course_id') != null && Course::find($request->input('course_id'))){
                $course = Course::find($request->input('course_id'));
                if($request->input('lec_id') != null && Lecture::find($request->input('lec_id'))){
                    $quiz = Lecture::find($request->input('lec_id'));
                    $quiz->lec_name = $request->input('lec_name');
                    $quiz->type = "Quiz";
                    $quiz->save();
                }else{
                    $quiz = $course->lectures()->create([
                        'user_id' => Auth::user()->id,
                        'lec_name' => $request->input('lec_name'),
                        'oldOrder' => $request->input('oldOrder'),
                        'type' => "Quiz"
                    ]);

                    $quiz = Lecture::find($quiz->id);
                }

                if($request->input('que_id') != null && Question::find($request->input('que_id'))){
                    $question = Question::find($request->input('que_id'));
                    $question->content = $request->input('content');
                    $question->save();
                    if($question->answers()->count() > 1){
                        $i = 0;
                        foreach($request->input('answers') as $answer){
                            if($answer[0] === 'false'){
                                $answer[0] = 0;
                            }else{
                                $answer[0] = 1;
                            }

                            $question->answers[$i]->isRight = $answer[0];
                            $question->answers[$i]->content = $answer[1];
                            $question->answers[$i]->save();
                            $i++;  
                        }
                    }else{
                        foreach($request->input('answers') as $answer){
                            if($answer[0] === 'false'){
                                $answer[0] = 0;
                            }else{
                                $answer[0] = 1;
                            }
                            $question->answers()->create([
                                'isRight' => $answer[0],
                                'content' => $answer[1]
                            ]);
                        }
                    }
                }else{
                    $question = $quiz->questions()->create([
                        'content' => $request->input('content')
                    ]);

                    $question = Question::find($question->id);

                    foreach($request->input('answers') as $answer){
                        if($answer[0] === 'false'){
                            $answer[0] = 0;
                        }else{
                            $answer[0] = 1;
                        }
                        $question->answers()->create([
                            'isRight' => $answer[0],
                            'content' => $answer[1]
                        ]);
                    }
                }

                $order = 1;
                foreach($course->lectures()->where('type','Quiz')->orderBy('oldOrder','asc')->get() as $quiz){
                    $quiz->order = $order;
                    $quiz->save();
                    $order++;
                }

                $position = 1;
                foreach ($course->lectures()->orderBy('oldOrder','asc')->get() as $lecture) {
                    $lecture->position = $position;
                    $lecture->save();
                    $position++;
                }

                return Response::json(['status' => true, 'quiz' => $quiz, 'question' => $question, 'message'=>'Cool! You have published quiz successfully']);
            }
            
        }else{
            return Response::json(['status' => false, 'message'=>'Oh no! something went wrong, buddy']);
        }
    }

    public function deleteQuiz(Request $request){

        if($request->ajax()){
            if($request->input('quiz_id') != null && Lecture::find($request->input('quiz_id'))){

                $quiz = Lecture::find($request->input('quiz_id'));
                $quiz->delete();

            }
            return Response::json(['status' => true, 'message'=>'Cool! You have deleted quiz successfully']);
        }else{
            return Response::json(['status' => false, 'message'=>'Oh no! something went wrong, buddy']);
        }
    }

    public function manage(){

        $usercreatecourses = Auth::user()->usercreatecourses;
        $url = "master/manage";
        return View('master.manage',compact('usercreatecourses','url'));
    }

    public function getCreateCourse(){

        $courseItems = array(
            'COURSE CONTENT' => array(
                'course-basics'=>'Course basics',
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
        $url = "master/create-course";
        $course = new Course;
        $languages = ProgrammingLanguage::lists('lang_name','id')->all();
        $categories = Category::lists('cat_name','id')->all();
        $levels = Learninglevel::lists('level_name','id')->all();

        return View('master.create-course', compact('courseItems','languages','categories','levels','course','url'));
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
                return Response::json(['status'=>false, 'message'=>'Error man']);
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

    public function deleteLecture(Request $request){

        if($request->ajax()){
            if($request->input('course_id') != null && Course::find($request->input('course_id'))){

                if($request->input('lec_id') != null && Lecture::find($request->input('lec_id'))){

                    $lecture = Lecture::find($request->input('lec_id'));
                    $lecture->delete();

                }else{
                    if($request->input('video_id') != null && Video::find($request->input('video_id'))){
                        $video = Video::find($request->input('video_id'));
                        File::delete($video->path);
                        $video->delete();
                    }

                    if($request->input('doc_id') != null && Document::find($request->input('doc_id'))){
                        $document = Document::find($request->input('doc_id'));
                        File::delete($document->path);
                        $document->delete();
                    }
                    
                }
                $course = Course::find($request->input('course_id'));
                $lectures = $course->lectures()->where('type','<>','Quiz')->get();
            }
            return Response::json(['status' => true, 'lectures'=>$lectures, 'course'=>$course, 'message'=>'Cool! You have deleted lecture successfully']);
        }else{
            return Response::json(['status' => false, 'message'=>'Oh no! something went wrong, buddy']);
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
                    $lecture->lec_name = $request->input('lec_name');
                    $lecture->description = $request->input('description');
                    $lecture->save();
                }else{
                    
                    $lecture = $course->lectures()->create([
                                'course_id' => $course->id,
                                'user_id' => Auth::user()->id,
                                'lec_name' => $request->input('lec_name'),
                                'description' => $request->input('description'),
                                'oldOrder' => $request->input('oldOrder')
                            ]);
                    $lecture = Lecture::find($lecture->id);
                }
                
                if($request->input('video_id') != null 
                        // && $request->input('doc_id') == null 
                        // && $request->input('text') == null
                        && Video::find($request->input('video_id')) != null){

                    $video = Video::find($request->input('video_id'));
                    $video->lec_id = $lecture->id;
                    $video->save();
                    $lecture->type = "Video";
                    $lecture->text = null;
                    $lecture->save();
                }elseif($request->input('video_id') == null 
                        && $request->input('text') == null
                        && $request->input('doc_id') != null 
                        && Document::find($request->input('doc_id')) != null){
                    $document = Document::find($request->input('doc_id'));
                    $document->lec_id = $lecture->id;
                    $document->save();
                    $lecture->type = "Document";
                    $lecture->text = null;
                    $lecture->save();
                }elseif($request->input('text') != null
                        && $request->input('doc_id') == null 
                        && $request->input('video_id') == null){
                    $lecture->text = $request->input('text');
                    $lecture->type = "Text";
                    if($lecture->video){
                        $lecture->video->delete();
                    }
                    if($lecture->document){
                        $lecture->document->delete();
                    }
                    
                    $lecture->save();
                }else{
                    return Response::json(['status'=>false,'message'=>'It have get a problem']);
                }
                $lectures = $course->lectures()->where('type','<>','Quiz')->orderBy('oldOrder','asc')->get();
                $order = 1;
                foreach($lectures as $lecture){
                    $lecture->order = $order;
                    $lecture->save();
                    $order++;
                }

                $position = 1;
                foreach ($course->lectures()->orderBy('oldOrder','asc')->get() as $lecture) {
                    $lecture->position = $position;
                    $lecture->save();
                    $position++;
                }
                return Response::json(['status'=>true,'lecture'=>$lecture, 'lectures' => $lectures, 'course' => $course, 'message'=>'Cool! You have created lecture successfully']);
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

                $videointro = Introvideo::find($request->input('videointro_id'));
                //Checking if user change video, it will delete video which have saved in folder
                File::delete($videointro->path);

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
                    return Response::json(['status' => false, 'message'=>'Come on, guy! Dont add yourself']);
                }
            }
            return Response::json(['status' => false, 'message'=>'This email is not exist in itstudyonline, buddy']);

        }
    }

    public function doSaveMasterCourse(Request $request){

        if($request->ajax()){
            if($request->input('course_id') != null && Course::find($request->input('course_id')) != null){
                $course = Course::find($request->input('course_id'));
                if($request->input('masters') != null){
                    $usercreatecourses = array();
                    foreach ($request->input('masters') as $master) {
                        if($master[2] === 'false'){
                            $master[2] = 0;
                        }else{
                            $master[2] = 1;
                        }
                        if($master[3] === 'false'){
                            $master[3] = 0;
                        }else{
                            $master[3] = 1;
                        }

                        if($master[0] != null && UserCreateCourse::find($master[0]) != null){
                            $usercreatecourse = UserCreateCourse::find($master[0]);
                            $usercreatecourse->can_edit_lec = $master[2];
                            $usercreatecourse->can_delete = $master[3];
                            $usercreatecourse->revenue = $master[4];
                            $usercreatecourse->save();
                        }else{
                            $usercreatecourse = $course->usercreatecourses()->create([
                                'user_id' => $master[1],
                                'isBoss' => false,
                                'can_edit_lec' => $master[2],
                                'can_delete' => $master[3],
                                'revenue' => $master[4]
                            ]);

                            $usercreatecourse = UserCreateCourse::find($usercreatecourse->id);
                        }
                        $usercreatecourses[] = $usercreatecourse;
                    }
                    return Response::json(['status' => true, 'usercreatecourses'=>$usercreatecourses, 'message'=>'Cool! you have added masters successfully']);
                }else{
                    return Response::json(['status' => false,'message'=>'Something went wrong']);
                }
                return Response::json(['status' => false,'message'=>'Something oh no wrong']);
            }
            return Response::json(['status' => false,'course_id'=>$request->input('course_id'),'course'=>Course::find($request->input('course_id')),'message'=>'Something no wrong']);
        }
    }

    public function doDeleteMasterCourse(Request $request){

        if($request->ajax()){
            if($request->input('course_id') != null && Course::find($request->input('course_id')) != null){
                $course = Course::find($request->input('course_id'));
                if($request->input('master_id') != null && $course->usercreatecourse($request->input('master_id')) != null){
                    $master = $course->usercreatecourse($request->input('master_id'));
                    $boss = $course->bosscreatecourse();
                    $boss->revenue += $master->revenue;
                    $boss->save();
                    $master->delete();
                }
                return Response::json(['status' => true, 'boss'=>$boss, 'message'=>'Cool! you have deleted master successfully']);
            }
            return Response::json(['status' => false,'course_id'=>$request->input('course_id'),'course'=>Course::find($request->input('course_id')),'message'=>'Something no wrong']);
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
                    $usercreatecourse = Auth::user()->usercreatecourses()->create([
                        'user_id' => Auth::user()->id,
                        'course_id' => $request->input('course_id'),
                        'isBoss' => true,
                        'can_edit_lec' => true,
                        'can_delete' => true
                    ]);

                }
                // Refactor order for lectures
                $lectures = $usercreatecourse->course->lectures()->where('type','<>','Quiz')->orderBy('oldOrder','asc')->get();
                $order = 1;
                foreach($lectures as $lecture){
                    $lecture->order = $order;
                    $lecture->save();
                    $order++;
                }

                $quizs = $usercreatecourse->course->lectures()->where('type','Quiz')->orderBy('oldOrder','asc')->get();
                $orderForQuiz = 1;
                foreach($quizs as $quiz){
                    $quiz->order = $orderForQuiz;
                    $quiz->save();
                    $orderForQuiz++;
                }

                $position = 1;
                foreach ($usercreatecourse->course->lectures()->orderBy('oldOrder','asc')->get() as $lecture) {
                    $lecture->position = $position;
                    $lecture->save();
                    $position++;
                }
                return Response::json(['status' => true, 'usercreatecourse'=>$usercreatecourse, 'message'=>'Cool! you have submited course successfully']);
            }else{
                return Response::json(['status' => false, 'message'=>'Something went wrong, buddy']);
            }
        }
    }

    public function doDeleteCourse(Request $request){

        if($request->ajax()){
            if($request->input('course_id') != null && Course::find($request->input('course_id'))){
                
                $course = Course::find($request->input('course_id'));
                $course->delete();
                $usercreatecourses = Auth::user()->usercreatecourses;
                foreach ($usercreatecourses as $value) {
                    $value->course;
                    $value->course->image;
                    $value->course->enrolls;
                }
                return Response::json(['status' => true,'usercreatecourses'=>$usercreatecourses, 'message'=>'Cool! you have deleted course successfully']);
            }else{
                return Response::json(['status' => false, 'message'=>'Something went wrong, buddy']);
            }
        }
    }

    public function doEditCourse($course_id){

        if(Course::find($course_id) != null){

            $course = Course::find($course_id);

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
                    'manage-masters'=>'Manage Masters'
                )
            );
            $url = "master/edit-course";

            $languages = ProgrammingLanguage::lists('lang_name','id')->all();
            $categories = Category::lists('cat_name','id')->all();
            $levels = Learninglevel::lists('level_name','id')->all();

            return View('master.create-course', compact('courseItems','languages','categories','levels','course','url'));
        }
    }

    public function doCheckLectureExisted(Request $request){
        $input['lec_name'] = $request->get('lec_name');

        if($request->ajax()){

            $validator = Validator::make($input,[
                            'lec_name' => 'unique:lectures'
                        ]);
            if($validator->fails())
                return Response::json(FALSE);
            else 
                return Response::json(TRUE);
        }
    }

    public function doCheckCourseExisted(Request $request){
        $input['course_name'] = $request->get('course_name');

        if($request->ajax()){

            $validator = Validator::make($input,[
                            'course_name' => 'unique:courses'
                        ]);
            if($validator->fails())
                return Response::json(FALSE);
            else 
                return Response::json(TRUE);
        }
    }

}
