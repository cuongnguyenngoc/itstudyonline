<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Video;
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
        return view('home.index');
    }

    public function test()
    {
        $video  = new Video;
        $thumbnails = $video->thumbnails;
        $video->video_name = 'wtf name';
        $video->path = 'uploads/videos/';
        $video->type = 'upload';
        $video->user_id = Auth::user()->id;
        $video->save();

        echo sizeof($thumbnails);
    	for($i = 1; $i <= 5; $i++){

            if(sizeof($thumbnails) == 0){
                $video->thumbnails()->create([
                    'video_id' => $video->id,
                    'img_name' => 'idiot'.$i,
                    'path' => 'uploads/thumbnails/'. $i . '.' . 'jpg'
                ]);
                echo 'wtf'.$i;
            }else{

                $thumbnails[$i-1]->img_name = 'idiot1'.$i;
                $thumbnails[$i-1]->path = 'uploads/thumbnails/' . $i . '.' . 'jpg';
                $thumbnails[$i-1]->save();
            }            
            
        }
        echo "<br>";
        $video = Video::find($video->id);
        echo count($video->thumbnails);
        if($video->thumb_id == null && sizeof($video->thumbnails) != 0){
            $video->thumb_id = $video->thumbnails->first()->id;
            $video->save();
            echo $video->id;
            echo "<br>";
            echo $video->thumb_id;
        }else{
            $video->thumb_id = 1;
        }

        //return View('test',compact('thumbnails'));
    }
    public function manage(){
        return View('admin.manage');
    }
    public function fuck(){
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
