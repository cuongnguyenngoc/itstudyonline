<?php

namespace App\Http\Controllers\Forum;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Response;
use App\User;
use App\TopicForum;
use App\CategoryForum;
use App\PostForum;
use App\Enroll;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware('auth', ['except' => 'show']);
    }

    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $items = CategoryForum::lists("cat_name", "id")->all();
        $items = (array) $items;
        return View('forum.create-topic', compact('items'));
    }

    public function createOfCouse($enroll_id) {
        $enrolls = Enroll::where("user_id", "=", Auth::user()->id)->get();

        if ($enrolls->count() == 0)
            return redirect("/");
        return View('forum.create-topic', compact("enroll_id"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if ($request->ajax()) {
            if (strcmp($request->input('topic_name'), "") == 0) {
                return Response::json(['message' => 'Error man', 'input' => $request->input()]);
            }
            if ($request->input('id') != null)
                $topic = TopicForum::find($request->input('id'));
            else {
                $topic = new TopicForum;
                $topic->topic_date = \Carbon\Carbon::now()->toDateTimeString();
                $user_id = Auth::user()->id;
//            $user_id = 3;
                $user = User::find($user_id);
                $topic->User()->associate($user);
            }
            $topic->topic_subject = $request->input('topic_name');
            if (null !== $request->input("cat_id")) {

                $cate = CategoryForum::find($request->input("cat_id"));
                $topic->CategoryForum()->associate($cate);
            } else {
                $enroll = Enrolls::find($request->input("enroll_id"));
                $topic->EnrollForum()->associate($enroll);
            }

            $topic->save();

            $post = $topic->PostForum()->first();
            if ($post == null) {
                $post = new PostForum;
                $post->topicForum()->associate($topic);
                $post->User()->associate($user);
            } else {
                $post = PostForum::find($post->id);
            }
            $post->post_content = $request->input("post");
            $post->post_date = \Carbon\Carbon::now()->toDateTimeString();
            $post->save();
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
        //get thoi gian
        $topic = TopicForum::whereRaw("topic_subject = '$id'")->get()->toArray();
        $topic = TopicForum::findOrFail($topic[0]["id"]);
        $datediff = \Carbon\Carbon::parse($topic->topic_date)->format("M d,Y");
        //get nguoi dang bai viet
        $subject = $topic->topic_subject;
        $userId = $topic->topic_by;
        $user = User::findOrFail($userId);
        $post = $topic->PostForum()->first();
        //get thu muc cua bai viet
        $cat_id = $topic->topic_cat;
        $cate = CategoryForum::findOrFail($cat_id);
        $result = [];
        $result['idTopic'] = $topic->id;
        $result['user'] = $user->fullname;
        $result['date'] = $datediff;
        $result['subject'] = $subject;
        $result['content'] = $post->post_content;
        $result['cate'] = $cate->cat_name;
        $result['isEdit'] = (Auth::check() && Auth::user()->id == $userId) ? true : false;
        //get cac reply cua bai viet
        $replies = $topic->replyForums()->where('parent_id', '=', '0')->orderBy('rep_date', 'desc')->get();
        $result['repCount'] = $replies->count();
        foreach ($replies as $reply) {
            $reply->rep_by = User::find($reply->rep_by)->fullname;
            $reply->rep_date = \Carbon\Carbon::parse($reply->rep_date)->format("M d,Y");
            $subReply = \App\ReplyForum::where('parent_id', '=', $reply->id)->orderBy('rep_date', 'desc')->get();
            $reply->subReply = $subReply;
        }
        $result['replies'] = $replies;

        if (Auth::check()) {
            $usercurrent = User::find(Auth::user()->id)->fullname;
            $result['cuName'] = $usercurrent;
        }
        //get 10 bai dang gan nhat
        $recentTopics = TopicForum::where('topic_cat', '=', $cat_id)->where('topic_subject', '!=', $id)->orderBy('topic_date', 'desc')->take(10)->get();

        return View('forum.viewTopic', compact('result', 'recentTopics'));
    }

    public function showOfEnroll($enroll_id, $id) {

        $enroll_id = urldecode($enroll_id);
        $id = urldecode($id);
        //get thoi gian
        $topic = TopicForum::whereRaw("topic_subject = '$id'")->get()->toArray();
        $topic = TopicForum::findOrFail($topic[0]["id"]);
        $datediff = \Carbon\Carbon::parse($topic->topic_date)->format("M d,Y");
        //get nguoi dang bai viet
        $subject = $topic->topic_subject;
        $userId = $topic->topic_by;
        $user = User::findOrFail($userId);
        $post = $topic->PostForum()->first();
        //get thu muc cua bai viet
        $enroll = Enroll::where("id", "=", $enroll_id)->where("user_id", "=", Auth::user()->id)->get();
        if($enroll->count() == 0)
            return \Illuminate\Support\Facades\Redirect::back();
        $result = [];
        $result['idTopic'] = $topic->id;
        $result['user'] = $user->fullname;
        $result['date'] = $datediff;
        $result['subject'] = $subject;
        $result['content'] = $post->post_content;
        $result['course_id'] = $enroll[0]->course_id;
        $result['isEdit'] = (Auth::check() && Auth::user()->id == $userId) ? true : false;
        //get cac reply cua bai viet
        $replies = $topic->replyForums()->where('parent_id', '=', '0')->orderBy('rep_date', 'desc')->get();
        $result['repCount'] = $replies->count();
        foreach ($replies as $reply) {
            $reply->rep_by = User::find($reply->rep_by)->fullname;
            $reply->rep_date = \Carbon\Carbon::parse($reply->rep_date)->format("M d,Y");
            $subReply = \App\ReplyForum::where('parent_id', '=', $reply->id)->orderBy('rep_date', 'desc')->get();
            $reply->subReply = $subReply;
        }
        $result['replies'] = $replies;

        if (Auth::check()) {
            $usercurrent = User::find(Auth::user()->id)->fullname;
            $result['cuName'] = $usercurrent;
        }

        return View('forum.viewTopicOfCourse', compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $id = urldecode($id);
        //get thoi gian
        $topic = TopicForum::whereRaw("topic_subject = '$id'")->get()->toArray();
        $topicSub = TopicForum::findOrFail($topic[0]["id"]);
        $topicBy = $topic[0]["topic_by"];
        $items = CategoryForum::lists("cat_name", "id")->all();
        $items = (array) $items;
        $post = $topicSub->PostForum()->first();
        $content = $post->post_content;
        if (Auth::check() && Auth::user()->id == $topicBy) {
            $route = $_SERVER['REQUEST_URI'];
            return view("forum.edit-topic", compact("items", "content"))->with("topic", $topicSub);
        } else {
            return \Illuminate\Support\Facades\Redirect::back();
        }
    }
    public function editOfEnroll($enroll_id, $id){

        $enrolls = Enrolls::where("id", "=", $enroll_id)->where("user_id", "=", Auth::user()->id)->get();
        if ($enrolls->count() == 0)
            return redirect("/");
        
        $id = urldecode($id);
        //get thoi gian
        $enroll_id = $enrolls[0]->id;
        $topic = TopicForum::whereRaw("topic_subject = '$id'")->get()->toArray();
        $topicSub = TopicForum::findOrFail($topic[0]["id"]);
        $topicBy = $topic[0]["topic_by"];
        $post = $topicSub->PostForum()->first();
        $content = $post->post_content;
        if (Auth::check() && Auth::user()->id == $topicBy) {
            $route = $_SERVER['REQUEST_URI'];
            return view("forum.edit-topic", compact("content", "enroll_id"))->with("topic", $topicSub);
        } else {
            return \Illuminate\Support\Facades\Redirect::back();
        }
        
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
        //delete
        $id = urldecode($id);
        //get thoi gian
        $topic = TopicForum::whereRaw("topic_subject = '$id'")->where("enroll_id" ,"=",0)->get()->toArray();
        $topicSub = TopicForum::findOrFail($topic[0]["id"]);
        $topicBy = $topic[0]["topic_by"];
        if (Auth::check() && Auth::user()->id == $topicBy) {
            $topicSub->delete();
            return \Illuminate\Support\Facades\Redirect::to('/forum');
        } else {
            return \Illuminate\Support\Facades\Redirect::back();
        }
    }
    public function destroyOfEnroll($enroll_id, $id){
        $id = urldecode($id);
        //get thoi gian
        $topic = TopicForum::whereRaw("topic_subject = '$id'")->where("enroll_id" ,"=",$enroll_id)->get()->toArray();
        $topicSub = TopicForum::findOrFail($topic[0]["id"]);
        $topicBy = $topic[0]["topic_by"];
        if (Auth::check() && Auth::user()->id == $topicBy) {
            $topicSub->delete();
            return \Illuminate\Support\Facades\Redirect::to('/forum/course/' . $enroll_id);
        } else {
            return \Illuminate\Support\Facades\Redirect::back();
        }
    }
}
