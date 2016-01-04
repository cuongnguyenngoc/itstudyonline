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

    public function index()
    {
        $categories = Category::all();
        $languages = ProgrammingLanguage::all();
        $levels = Learninglevel::all();
        $usercreatecourses = UserCreateCourse::where('isBoss',1)->get();
        return view('home.index',compact('categories','languages','levels','usercreatecourses'));
    }

    public function getCourse($id){
        $id = urldecode($id);
        if(Course::find($id)!=null){
            $course = Course::find($id);
            $course->views += 1;
            $course->save();
            if(Auth::user() && Auth::user()->enroll(intval($id)) != null){
                $enroll = Auth::user()->enroll(intval($id));
            }else{
                $enroll = null;
            }
            return view('home.course',compact('course','enroll'));
        }else{
            return view('errors.404');
        }
    }

    public function search(Request $request)
    {
        $query = urldecode($request->get('query'));
        $categories = Category::all();
        $languages = ProgrammingLanguage::all();
        $levels = Learninglevel::all();
        $courses = Course::whereRaw('course_name like ? and isPublic = 1',['%'.$query.'%'])->paginate(4);
        return view('home.search-course',compact('query','courses','categories','languages','levels'));
    }

    public function back(){
        return back();
    }
}
