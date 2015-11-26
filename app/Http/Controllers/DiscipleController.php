<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Course;
use App\Lecture;
use App\Comment;
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
    	$enroll = $course->enrolls()->create([
    		'user_id' => Auth::user()->id,
    		'tution' => $course->cost
    	]);

    	$lecture1 = $course->lectures()->where('order',1)->first();
        return view('disciple.learn-course',compact('course','lecture1','enroll'));
    }

    public function getLecture(Request $request){
    	if($request->ajax()){

            if($request->input('lec_id') != null && Lecture::find($request->input('lec_id'))){

                $lecture = Lecture::find($request->input('lec_id'));
                if($lecture->type == 'Video')
                	$lecture->video;
                else if($lecture->type == 'Document')
                	$lecture->document;
                $lecture->comments;
                for($i=0; $i < $lecture->comments->count(); $i++) {
                	$lecture->comments[$i]->user;
                	$lecture->comments[$i]->user->image;
                }
                return Response::json(['status' => true, 'user' => Auth::user(), 'lecture'=>$lecture, 'message'=>'Cool! You get lecture here']);
            }else{
                return Response::json(['status' => false, 'message'=>'I can not find lec_id, check again buddy']);
            }
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
}
