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
        $usercreatecourses = UserCreateCourse::all();
        return view('home.index',compact('categories','languages','levels','usercreatecourses'));
    }

    public function getCourse($id){

        $course = Course::find($id);
        return view('home.course',compact('course'));
    }

    public function test()
    {
        $categorie = Category::find(1);
        foreach ($categorie->usercreatecourses as $key) {
            echo $key->course->image->path;
            echo "<br>";
        }
        
        echo "<br>";
        //return View('test',compact('thumbnails'));
    }
    public function manage(){
        return View('admin.manage');
    }
    public function awe(){
        $upload_dir = './uploads/videos/';
        // chuyển file về thư mục $upload_dir
        $video_file = "./uploads/videos/564b7796933eaBoa_Hancock_hugs_Luffy(One_Piece_3D2Y).mp4";
        //$file->move('../uploads/videos',$video_file);
    
        // lưu ảnh thumbnail
        $ffmpeg = 'public\\ffmpeg\\ffmpeg';
        $image_file = "./uploads/videos/Boa_Hancock_hugs_Luffy(One_Piece_3D2Y).jpg";
        $second = 5;
        $cmd = "$ffmpeg -itsoffset $second -i $video_file -vcodec mjpeg -vframes 1 -an -f rawvideo $image_file";
        exec($cmd);
        echo $video_file;
		echo "\n";
        echo "<p>".$image_file."</p>";
		echo "\n";
        echo exec($cmd);
    }
}
