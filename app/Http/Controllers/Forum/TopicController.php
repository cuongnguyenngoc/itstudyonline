<?php

namespace App\Http\Controllers\Forum;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Response;
use App\User;
use App\TopicForum;
use App\CategoryForum;
use App\PostForum;
use App\Http\Controllers\Controller;

class TopicController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
            $topic = new TopicForum;
            $topic->topic_subject = $request->input('topic_name');

//            $user_id = Auth::user()->id;
            $user_id = 3;
            $user = User::find($user_id);
            $topic->User()->associate($user);

            $cate = CategoryForum::find($request->input("cat_id"));
            $topic->CategoryForum()->associate($cate);
            $topic->topic_date = \Carbon\Carbon::now()->toDateTimeString();
            $topic->save();

            $post = new PostForum;
            $post->post_content = $request->input("post");
            $post->post_date = \Carbon\Carbon::now()->toDateTimeString();
            $post->topicForum()->associate($topic);
            $post->User()->associate($user);
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
        $topic = TopicForum::whereRaw("topic_subject = '$id'")->get()->toArray();
        
        $topic = TopicForum::findOrFail($topic[0]["id"]); 
        $userId = $topic->topic_by;
        $cat_id = $topic->topic_cat;
        $datediff = \Carbon\Carbon::parse($topic->topic_date)->diffForHumans(\Carbon\Carbon::now());
        $subject = $topic->topic_subject;
        
        $user = User::findOrFail($userId);
        $post = $topic->PostForum()->first();
        
        $cate = CategoryForum::findOrFail($cat_id);
       
        $result = [];
        $result['user'] = $user->fullname;
        $result['date'] = $datediff;
        $result['subject'] = $subject;
        $result['content'] = $post->post_content;
        $result['cate'] = $cate->cat_name;
        return View('forum.viewTopic', compact('result'));
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
