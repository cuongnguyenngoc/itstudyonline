<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Image;
use App\MoneyManager;
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
            $image->path = '/uploads/users/'. $name . '.' . $ext;
            $image->save();
        }else{

            $image = Auth::user()->image()->create([
                        'img_name' => $imgname,
                        'path' => '/uploads/users/'. $name . '.' . $ext
                    ]);
            $image = Image::find($image->id);
        }

        return Response::json(['status' => true, 'image'=>$image, 'message'=>'Cool! You have uploaded image successfully']);    
    }
     public function rechargeMoney(){
        $currentMoney = Auth::user()->balance;
        return View('user.rechargeMoney')->with('balance', $currentMoney);
    }
    public function rechargeAction(Request $request){
        $card_num = $request->input("card_num");
        $card_type = $request->input("card_type");
        $card_seri = $request->input("card_seri");
        /*
        viettel : 1 -- 50k
        mobi : 2 --200k
        vina 3 -- 500k
        */
        $currentMoney = Auth::user()->balance;
        if(strlen($card_num) >= 2){
            // $money = 0;
            // if($card_type == 1){
            //     $money = 50;
            // } elseif($card_type == 2){
            //     $money = 200;
            // }
            // else{
            //     $money = 500;
            // }
            // $userId = Auth::user()->id;
            // $chargeMo = new MoneyManager;
            // $chargeMo->card_type  = $card_type;
            // $chargeMo->card_id = $card_num;
            // $chargeMo->user_id = $userId;
            // $chargeMo = $chargeMo->save();
            // if(null != $chargeMo){
            //     $user =  User::find($userId);
            //     $currentMoney += $money;
            //     $user->balance =  $currentMoney;
            //     $user->save();
            // }
            $money = MoneyManager::create([
                'user_id' => Auth::user()->id,
                'card_type' => $card_type,
                'card_id' => $card_num,
                'card_seri' => $card_seri
                ]);
            $money = MoneyManager::find($money->id);
            if($money!=null){
                Auth::user()->balance += $money->card_id;
                Auth::user()->save();
            }
            return Response::json(['message' => 'Nạp thẻ thành công', 'balance' =>$currentMoney, 'input' => $request->input()]);

        }
        else{
            return  Response::json(['message' => 'Nạp thẻ thất bại', 'balance' =>$currentMoney,'input' => $request->input()]);
        }

    }
}

