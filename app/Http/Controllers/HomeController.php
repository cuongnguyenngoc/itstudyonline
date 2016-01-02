<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Video;
use App\Category;
use App\ProgrammingLanguage;
use App\Learninglevel;
use App\UserCreateCourse;
use App\Course;
use App\Rating;
use App\Lecture;
use App\Enroll;
use Auth;

class HomeController extends Controller
{

    public function __construct()
    {
        // $this->middleware('admin', ['except' => 'index']); // Đây là middleware dùng để phân quyền nó có tên là admin tương ứng với lớp isAdmin trong thư mục Http/Middleware
        // cái này là để phân quyền. nghĩa là khi thêm cái này vào constructor của Controller thì khi sử dụng các function duwoi thì người dùng phải có quyền admin.
    }

    public function index()
    {
        $categories = Category::all();
        $languages = ProgrammingLanguage::all();
        $levels = Learninglevel::all();
        $usercreatecourses = UserCreateCourse::where('isBoss',1)->get();
        return view('home.index',compact('categories','languages','levels','usercreatecourses'));
    }

    public function getCourse($id){

        $course = Course::find($id);
        $course->views += 1;
        $course->save();
        if(Auth::user() && Auth::user()->enroll(intval($id)) != null){
            $enroll = Auth::user()->enroll(intval($id));
        }else{
            $enroll = null;
        }
        return view('home.course',compact('course','enroll'));
    }

    public function test()
    {
        
        $course = Course::find(1);
        $course->lectureAndQuizMixed();
        
    }
}
