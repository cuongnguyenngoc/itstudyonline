<?php

namespace App\Http\Controllers\Forum;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App\CategoryForum;

class CategoryController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $items = CategoryForum::all();
        $topics = [];
        foreach ($items as $cate) {
            foreach ($cate->TopicForums()->get() as $topic) {
                $temp = [];
//            $temp[] = $topic->id . '';
                $temp[] = $topic->topic_subject;
                $temp[] = $cate->cat_name;
                $temp[] = $topic->topic_by;
                $temp[] = \Carbon\Carbon::parse($topic->topic_date)->diffForHumans(\Carbon\Carbon::now());
                $topics[] = $temp;
            }
        }
        $cateName = 'UnCategory';
        return View('forum.showAll', compact('items', 'topics', 'cateName'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return View('forum.create-category');
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
            if (strcmp($request->input('cat_name'), "") == 0)
                return Response::json(['message' => 'Error man', 'input' => $request->input()]);

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
        if($id == 'UnCategory')
            return $this->index();

        $cate = CategoryForum::whereRaw("cat_name = '$id'")->get()->toArray();
        $cate = CategoryForum::findOrFail($cate[0]["id"]);
        $topics = [];
        foreach ($cate->TopicForums()->get() as $topic) {
            $temp = [];
            $temp[] = $topic->topic_subject;
            $temp[] = $id;
            $temp[] = $topic->topic_by;
            $temp[] = \Carbon\Carbon::parse($topic->topic_date)->diffForHumans(\Carbon\Carbon::now());
            $topics[] = $temp;
        }
        $items = CategoryForum::all();
        $cateName = $id;
        return View('forum.showAll', compact('items', 'topics', 'cateName'));
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
