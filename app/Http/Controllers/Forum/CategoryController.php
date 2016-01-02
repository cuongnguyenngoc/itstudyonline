<?php

namespace App\Http\Controllers\Forum;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\CategoryForum;
use App\TopicForum;
use App\Enroll;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
       $this->middleware('auth', ['except' => ['index','show']]);
    }

    public function index() {

        $items = CategoryForum::all();
        $topics = [];
        $paginate = TopicForum::where("topic_cat", "<>", 0)->orderBy('topic_date', 'desc')->paginate(10);
        foreach ($paginate as $topic) {
            $temp = [];
            $temp['topicName'] = $topic->topic_subject; //ten topic
            $temp['cateName'] = $topic->CategoryForum()->first()->cat_name; // ten category
            $temp['count'] = $topic->replyForums()->count(); // so luot reply cho topic
            $temp['excerp'] = substr($topic->PostForum()->first()->post_content, 0, 500);
            $temp['date'] = \Carbon\Carbon::parse($topic->topic_date)->format("M d,Y - H:i"); // ngay dang cua topic
            $topics[] = $temp;
        }

        $cateName = 'Select Category';
        return View('forum.showAll', compact('items', 'topics', 'cateName', 'paginate'));
    }

    public function indexOfEnroll($id) {
        //check
        if (!Auth::check())
            return redirect("/");
        $enroll = Enroll::where("id", "=", $id)->where("user_id", "=", Auth::user()->id)->get();
        if ($enroll->count() == 0)
            return redirect("/");
        
        $topics = [];
        $paginate = TopicForum::where("enroll_id", '=', $id)->orderBy('topic_date', 'desc')->paginate(10);
        foreach ($paginate as $topic) {
            $temp = [];
            $temp['enroll_id'] = $id;
            $temp['topicName'] = $topic->topic_subject; //ten topic
            $temp['count'] = $topic->replyForums()->count(); // so luot reply cho topic
            $temp['excerp'] = substr($topic->PostForum()->first()->post_content, 0, 500);
            $temp['date'] = \Carbon\Carbon::parse($topic->topic_date)->format("M d,Y - H:i"); // ngay dang cua topic
            $topics[] = $temp;
        }
        return View('forum.showEnroll', compact('items', 'topics','id', 'paginate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if (Auth::check())
            return View('forum.create-category');
        else
            return redirect('/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if ($request->ajax()) {
            //validate 
            if (strcmp($request->input('cat_name'), "") == 0) {
                return Response::json(['message' => 'required', 'input' => $request->input()]);
            } else if (!is_null(CategoryForum::where('cat_name', '=', $request->input("cat_name"))->first())) {
                return Response::json(['message' => 'category is existed!', 'input' => $request->input()]);
            }

            $cate = new CategoryForum;
            $cate->cat_name = $request->input('cat_name');
            $cate->cat_des = $request->input('cat_des');
            $cate->save();
            return Response::json(['message' => 'you created successfully', 'input' => $request->input()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $id = urldecode($id);
        $cate = CategoryForum::whereRaw("cat_name = '$id'")->get()->toArray();
        $cate = CategoryForum::findOrFail($cate[0]["id"]);
        $topics = [];
        $paginate = $cate->TopicForums()->orderBy('topic_date', 'desc')->paginate(10);
        foreach ($paginate as $topic) {
            $temp = [];
            $temp['topicName'] = $topic->topic_subject;
            $temp['cateName'] = $id;
            $temp['excerp'] = substr($topic->PostForum()->first()->post_content, 0, 500);
            $temp['count'] = $topic->replyForums()->count();
            $temp['date'] = \Carbon\Carbon::parse($topic->topic_date)->format("M d,Y");
            $topics[] = $temp;
        }
        $items = CategoryForum::all();
        $cateName = $id;
        return View('forum.showAll', compact('items', 'topics', 'cateName', 'paginate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
