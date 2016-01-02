<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Image;
use Response;
use Auth;
use DB;
use Validator;
use File;
use Hash;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function checkRightPassword(Request $request){

        if($request->ajax()){

            if(!Hash::check($request->get('currentpassword'), Auth::user()->password))
                return Response::json(FALSE);
            else 
                return Response::json(TRUE);
        }
    }

    public function editprofile(){
        return view('user.editprofile');
    }
    public function login(){
        return view('login');
    }

    public function updateProfile(Request $request){

        $validator = Validator::make($request->all(),[
                'fullname' => 'required',
                'address' => 'required',
                'birth' => 'required',
                'biography' => 'required'
            ]);
        if($validator->fails()){
            //return Redirect::back()->withErrors($validator);
            return Response::json(['status'=>false, 'message'=>'Error man','input'=>$request->input()]);
        }
        Auth::user()->birth = date("Y-m-d", strtotime($request->get("birth")));
        Auth::user()->fullname = $request->get('fullname');
        Auth::user()->address = $request->get('address');
        Auth::user()->biography = $request->get('biography');
        Auth::user()->save();
        return Response::json(['status'=>true, 'message'=>'You have updated your profile successfully']);
    }

    public function changepwd(){
        return view('user.changepassword');
    }
    public function changePassword(Request $request){
        if($request->ajax()){
            $validator = Validator::make($request->all(),[
                'currentpassword' => 'required',
                'newpassword' => 'required',
                'confirm' => 'required',
            ]);
            if($validator->fails()){
                return Response::json(['status'=>false, 'message'=>'Error man','input'=>$request->input()]);
            }
            Auth::user()->password = Hash::make($request->get('newpassword'));
            Auth::user()->save();
            return Response::json(['status'=>true, 'message'=>'You have changed password successfully']);
        }

    }
    public function addphoto(){
        return view('user.addphoto');
    }
    
    public function uploadphoto(Request $request){

        $file = $request->file('file');
        //return Response::json(['doc' => $request->input('doc_id'), 'video' => $request->input('video_doc_id')]);
        $filename = uniqid() . $file->getClientOriginalName();
        $name = explode('.', $filename);     // seperate name by dot character
        $ext = strtolower(end($name));       // get extention part of name
        array_pop($name);                    // skip tail in name
        $imgname = implode("_", $name);         // combine all parts of name by underscore
        $name = str_replace(' ', '_', $imgname); // change space to uderscore _

        $img_file = './uploads/users/' . $name . '.' . $ext; // remember this is relative path to file index.php
        // move file to uploads/videos folder
        $file->move('uploads/users',$img_file);

        if($request->input('img_id') != null && Image::find($request->input('img_id')) != null){

            $image = Image::find($request->input('img_id'));
            //Checking if user change image, it will delete image which have saved in folder
            File::delete($image->path);

            $image->img_name = $imgname;
            $image->path = 'uploads/users/'. $name . '.' . $ext;
            $image->save();
        }else{

            $image = Auth::user()->image()->create([
                        'img_name' => $imgname,
                        'path' => 'uploads/users/'. $name . '.' . $ext
                    ]);
            $image = Image::find($image->id);
        }

        return Response::json(['status' => true, 'image'=>$image, 'message'=>'Cool! You have uploaded image successfully']);    
    }
}

