<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Course;
use App\Lecture;
use App\Comment;
use App\Enroll;
use Response;
use Auth;

class DiscipleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Đây là middleware dùng để phân quyền nó có tên là disciple tương ứng với lớp isAdmin trong thư mục Http/Middleware
        // cái này là để phân quyền. nghĩa là khi thêm cái này vào constructor của Controller thì khi sử dụng các function duwoi thì người dùng phải có quyền admin.
    }

    public function getCourse($id){

        $course = Course::find($id);
        return view('home.course',compact('course'));
    }

    public function learnCourse($id)
    {

        $course = Course::find($id);

        if(Auth::user()->enrolls->count() == 0){
            
            $enroll = $course->enrolls()->create([
                'user_id' => Auth::user()->id,
                'tution' => $course->cost
            ]);

            $enroll = Enroll::find($enroll->id);
        }else{
            $enroll = Auth::user()->enroll(intval($id));
        }

        $beforeLearningLecture = $enroll->course->lectures()->where('id',$enroll->lectureSaved)->first();
        if($beforeLearningLecture){
            $lecture1 = $beforeLearningLecture;
        }else{
            $lecture1 = $enroll->course->lectures()->where('order',1)->first();            
        }

    	$previousLecture1 = $course->lectures()->where('order',($lecture1->order - 1))->first();
        $nextLecture1 = $course->lectures()->where('order',($lecture1->order + 1))->first();

        return view('disciple.learn-course',compact('lecture1','previousLecture1','nextLecture1','enroll'));
    }

    public function getLecture(Request $request){

    	if($request->ajax()){
            if($request->input('enroll_id') != null && Enroll::find($request->input('enroll_id'))){
                $enroll = Enroll::find($request->input('enroll_id'));

                if($request->input('lec_id') != null){

                    
                    $lecture = $enroll->course->lectures()->where('id',intval($request->input('lec_id')))->first();
                    $previousLecture = $enroll->course->lectures()->where('order',($lecture->order - 1))->first();
                    $nextLecture = $enroll->course->lectures()->where('order',($lecture->order + 1))->first();

                    // When user click on lecture, it will be saved into Enrolls table in database to save learning process for later
                    $enroll->lectureSaved = $lecture->id;
                    $enroll->save();

                    if($lecture->type == 'Video')
                    	$lecture->video;
                    else if($lecture->type == 'Document')
                    	$lecture->document;
                    $lecture->comments;
                    for($i=0; $i < $lecture->comments->count(); $i++) {
                    	$lecture->comments[$i]->user;
                    	$lecture->comments[$i]->user->image;
                    }
                    return Response::json([
                            'status' => true, 
                            'user' => Auth::user(), 
                            'lecture'=> $lecture, 
                            'previousLecture' => $previousLecture, 
                            'nextLecture' => $nextLecture,
                            'message'=>'Cool! You get lecture here'
                        ]);
                }else{
                    return Response::json(['status' => false, 'message'=>'I can not find lec_id, check again buddy']);
                }
            }
        }else{
            return Response::json(['status' => false, 'message'=>'I can not find course_id, check again buddy']);
        }
    }

    public function addComment(Request $request){
    	if($request->ajax()){

            if($request->input('lec_id') != null && Lecture::find($request->input('lec_id'))){

                $lecture = Lecture::find($request->input('lec_id'));
                if($request->input('comment_id') != null && Comment::find($request->input('comment_id'))){
                	$comment = Comment::find($request->input('comment_id'));
                	$comment->content = $request->input('content');
                	$comment->save();
                }else{
                	$comment = $lecture->comments()->create([
                		'user_id' => Auth::user()->id,
                		'content' => $request->input('content')
                	]);
                	$comment = Comment::find($comment->id);
                }
                $user = $comment->user;
                $user->image;
                $comment->lecture;
                return Response::json(['status' => true, 'user' => $user, 'comment'=>$comment, 'message'=>'Cool! You posted comment here']);
            }else{
                return Response::json(['status' => false, 'message'=>'I can not find lec_id, check again buddy']);
            }
        }
    }

    public function deleteComment(Request $request){
    	if($request->ajax()){

            $lecture = Lecture::find($request->input('lec_id'));
            if($request->input('comment_id') != null && Comment::find($request->input('comment_id'))){
            	$comment = Comment::find($request->input('comment_id'));
            	$comment->delete();
            }
            return Response::json(['status' => true, 'comment'=>$comment, 'message'=>'Cool! You delete comment successfully']);
        }
    }

    public function markLecture(Request $request){
        if($request->ajax()){
            if($request->input('enroll_id') != null && Enroll::find($request->input('enroll_id'))){
                $enroll = Enroll::find($request->input('enroll_id'));

                // Mark Lecture which has been user marked
                $lecture = $enroll->course->lectures()->where('id',intval($request->input('lec_id')))->first();
                $lecture->isMarked = true;
                $lecture->save();

                // Save learning process
                $numberLectures = $enroll->course->lectures()->count(); // Remember we use $enroll->course->lectures() instead of using ...->lectures when call other func such as count, where...
                $numberLectureMarked = $enroll->course->lectures()->where('isMarked',1)->count();
                $percentProcess = ($numberLectureMarked / $numberLectures) * 100;
                $enroll->process = $percentProcess;
                $enroll->save();

                $enroll = Enroll::find($enroll->id); // Refresh $enroll

                return Response::json(['status' => true, 'enroll'=>$enroll, 'message'=>'Cool! You mark lecture successfully']);
            }else{
                return Response::json(['status' => false, 'message'=>'I can not find enroll_id, check again buddy']);
            }
            
        }
    }
}
