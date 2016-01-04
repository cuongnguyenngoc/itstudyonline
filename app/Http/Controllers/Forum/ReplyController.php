<?php

namespace App\Http\Controllers\forum;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ReplyForum;
use App\User;

class ReplyController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if (!Auth::check())
            return \Illuminate\Support\Facades\Redirect::to('/forum');

        if (null == $request->input('content'))
            return $this->destroy($request);

        if (null == $request->input('idTopic'))
            return $this->edit($request);
        else {
            $reply = new ReplyForum;
            $reply->rep_content = $request->input("content");
            $reply->rep_date = \Carbon\Carbon::now()->toDateTimeString();
            $reply->rep_topic = $request->input("idTopic");
            $reply->rep_by = Auth::user()->id;
            if (null != $request->input('idParent'))
                $reply->parent_id = $request->input('idParent');
            //$reply->rep_by = 2;
            $reply->save();
            $reply->rep_by = User::find($reply->rep_by)->fullname;
            $reply->rep_date = \Carbon\Carbon::parse($reply->rep_date)->format("M d,Y");
            return Response::json(['message' => $reply, 'input' => $request->input()]);
        }
    }

    public function edit(Request $request) {
        if (!Auth::check())
            return \Illuminate\Support\Facades\Redirect::to('/forum');
        $reply = ReplyForum::find($request->input('idComment'));
        $reply->rep_content = $request->input("content");
        $reply->save();
        return Response::json(['message' => $reply->rep_content, 'input' => $request->input()]);
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
    public function destroy(Request $request) {
        $id = $request->input('idComment');
        $data = ReplyForum::where('parent_id', '=', $id)->get();
        foreach ($data as $i) {
            $i->delete();
        }
        ReplyForum::find($id)->delete();
        return Response::json(['message' => 'ok men', 'input' => $request->input()]);
    }

}
