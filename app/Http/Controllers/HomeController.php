<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;

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
    	$user = User::findOrFail(7);
    	$role = $user->role;
    	return view('test',compact('role'));
    }
    public function manage(){
        return View('admin.manage');
    }
}
