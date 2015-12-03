<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Response;
use Auth;
use DB;
use Validator;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function editprofile(){
        // $user = user::find($id);
        // return View('user.editprofile', compact('user'));
        return view('user.editprofile');
    }
    public function login(){
        return view('login');
    }

    public function update(Request $request){
        // $user = $User::find($id);
        // $user->update($request->all());

        $validator = Validator::make($request->all(),[
                'fullname' => 'required'
            ]);
        if($validator->fails()){
                //return Redirect::back()->withErrors($validator);
                return Response::json(['status'=>false, 'message'=>'Error man','input'=>$request->input()]);
            }
        $data = $request->all();
        $id = Auth::user()->id;
        $newDate = date("Y/m/d", strtotime($data["birth"]));
        DB::table('users')
        ->where('id', $id)    
        ->update(array('fullname' => $data["fullname"], 'address'=>$data["address"],
            'birth'=>$newDate, 'biography'=>$data["biography"]

            ));
        echo "update success";
    
}

    public function changepwd(){
        return view('user.changepassword');
    }
    public function change(Request $request){
        if($request->ajax()){
            $validator = Validator::make($request->all(),[
                'currentpassword' => 'required',
                'newpassword' => 'required',
                'confirm' => 'required',
            ]);
            if($validator->fails()){
                return Response::json(['status'=>false, 'message'=>'Error man','input'=>$request->input()]);
            }

        $data = $request->all();
        $id = Auth::user()->id;
        DB::table('users')
        ->where('id', $id)    
        ->update(array('password' => bcrypt($data["newpassword"])));
        echo "thay doi thanh cong";
        }



    }
    public function addphoto(){
        return view('user.addphoto');
    }
    
    public function uploadphoto(Request $request){
        if($request->input('user_id') != null ){
            $user = User::find($request->input('user_id'));

            $file = $request->file('file');
            //return Response::json(['doc' => $request->input('doc_id'), 'video' => $request->input('video_doc_id')]);
            $filename = uniqid() . $file->getClientOriginalName();
            $name = explode('.', $filename);     // seperate name by dot character
            $ext = strtolower(end($name));       // get extention part of name
            array_pop($name);                    // skip tail in name
            $imgname = implode("_", $name);         // combine all parts of name by underscore
            $name = str_replace(' ', '_', $imgname); // change space to uderscore _

            $img_file = './images/user/' . $name . '.' . $ext; // remember this is relative path to file index.php
            // move file to uploads/videos folder
            $file->move('images/user',$img_file);

            if($request->input('img_id') != null && Image::find($request->input('img_id')) != null){

                $image = Image::find($request->input('img_id'));
                //Checking if user change image, it will delete image which have saved in folder
                File::delete($image->path);

                $image->img_name = $imgname;
                $image->path = 'images/user/'. $name . '.' . $ext;
                $image->save();
            }else{

                $image = $user->image()->create([
                            'user_id' => $user->id,
                            'img_name' => $imgname,
                            'path' => 'images/user/'. $name . '.' . $ext
                        ]);
                $image = Image::find($image->id);
            }

            return Response::json(['status' => true, 'image'=>$image, 'message'=>'Cool! You have uploaded image successfully']);
        }
    
    }
}

