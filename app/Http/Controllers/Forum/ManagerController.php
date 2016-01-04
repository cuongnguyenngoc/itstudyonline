<?php

namespace App\Http\Controllers\Forum;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\CategoryForum;
use App\TopicForum;
use Illuminate\Support\Facades\Auth;
class ManagerController extends Controller{
	
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(){
        $post= TopicForum::where('topic_by','=',  Auth::user()->id)->get();
        $reply = \App\ReplyForum::where('rep_by','=',  Auth::user()->id)->get();
        $topics = $post->merge($reply);
        return view('forum.manager',  compact('topics'));
    }
}