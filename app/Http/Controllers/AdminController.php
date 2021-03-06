<?php
namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Course;
use App\UserRole;
use App\User;
use App\Category;
use App\ProgrammingLanguage;
use Input;
use App\Comment;
use App\Http\Requests\RoleFormRequest;
use App\Http\Requests\CourseFormRequest;
use Illuminate\Http\Request;
use Validator;
use Response;

class adminController extends BaseController
{
    public function __construct(){
        $this->middleware('admin');
    }
    public function index(){
        return view('admin.home');
    }
    //controller Role Manager
    public function roleManage(){
        
        $users = User::paginate(6);
        $url = "admin/roleManage"; 
        return view('admin.roleManage.index',compact('users','url'));

    }
    public function userInfomation($id){
        if(User::find(urldecode($id))!=null){
            $user = User::find($id);
            $url = null;
            return view('admin.roleManage.userInfomation',compact('user','url'));
        }else{
            return view('errors.404');
        }
    }

    public function updateRole($id,$role_id){ 
        if(User::find(urldecode($id))!=null){  
            $user = User::find(urldecode($id));
            $user->role_id = $role_id;
            $user->save();

            return redirect()->route('admin.roleManage')->with('status','Role of user have been changed successfully');
        }else{
            return view('errors.404');
        }
    }
    public function deleteUser($id){
        if(User::find(urldecode($id))!=null){ 
            $User = User::find(urldecode($id))->delete();
            return redirect()->route('admin.roleManage')->with('status','User have been deleted successfully');
        }else{
            return view('errors.404');
        }
    }

    //controller Course Manage
    public function courseManage()
    {
        $courses = Course::paginate(4);
        $url = "admin/courseManage"; 
        return view('admin.courseManage.index',compact('courses','url'));
    }

    public function deleteCourse($id){
        if(Course::find(urldecode($id))!=null){ 
            $course = Course::find($id)->delete();
            return redirect('/admin/courseManage')->with('status','You have deleted course successfully');
        }else{
            return view('errors.404');
        }
    }

    public function courseInfomation($id)
    {
        if(Course::find(urldecode($id))!=null){ 
            $course = Course::find($id); 
            $url = null;
            return view('admin.courseManage.courseInfomation',compact('course','url'));
        }else{
            return view('errors.404');
        }
    }

    //Controller Control Posts
    public function courseControl()
    {
        $courses = Course::where('isPublic','=',0)->paginate(4);
        $url = "admin/courseControl"; 
        return view('admin.courseControl.index',compact('courses','url'));
    }

    public function acceptCourse($id)
    {
        if(Course::find(urldecode($id))!=null){ 
            $course = Course::find($id);
            if($course->isPublic == 0){
                $course->isPublic = 1;
                $course->save();
            }

            return redirect('/admin/courseControl')->with('status','Course is public now');
        }else{
            return view('errors.404');
        }
    }

        //Controller Management Forum
    public function forumManage()
    {
        $comments = Comment::paginate(1);
        $url = "admin/forumManage"; 
        return view('admin.forumManage.index',compact('comments','url'));
    }
    public function deleteComment($id)
    {
        $comment = Comment::find($id)->delete();
        return redirect()->route('admin.forumManage')->with('status','Comment have been deleted');

    }
    public function admin(){
        return view('admin.admin');
    }
    // Management Category
    public function categoryManage(){
        $categories = Category::all();
        $url = "admin/categoryManage";
        return view('admin.category.index',compact('categories','url'));
    }
    public function categoryUpdate(){
        $name = Input::get('cat_name');
        $description = Input::get('description');
        Category::create([
            'cat_name'  => $name,
            'description'   =>$description 
            ]);
        return redirect('/admin/categoryManage')->with('status','Category have been added successfully');
    }

    public function categoryDelete($id){
        if(Category::find(urldecode($id))!=null){ 
            $category = Category::find($id)->delete();
            return redirect()->route('admin.categoryManage')->with('statusdelete','Category have been deleted successfully');
        }else{
            return view('errors.404');
        }
    }

    //Management Language
    public function languageManage(){
        $languages = ProgrammingLanguage::all();
        $url = "admin/language";
        return view('admin.language.index',compact('languages','url'));
    }
    public function languageUpdate(){
        $name = Input::get('lang_name');
        ProgrammingLanguage::create([
            'lang_name'  => $name
            ]);
        return redirect('/admin/language')->with('status','Language have been added successfully');
    }

    public function languageDelete($id){
        if(ProgrammingLanguage::find(urldecode($id))!=null){ 
            $langugage = ProgrammingLanguage::find($id)->delete();
            return redirect()->route('admin.languageManage')->with('statusdelete','Programming Language have been deleted successfully'); ;
        }else{
            return view('errors.404');
        }
    }

    public function checkLanguageExisted(Request $request){

        $input['lang_name'] = $request->get('lang_name');

        if($request->ajax()){

            $validator = Validator::make($input,[
                            'lang_name' => 'unique:programminglanguages'
                        ]);
            if($validator->fails())
                return Response::json(FALSE);
            else 
                return Response::json(TRUE);
        }
    }

    public function checkCategoryExisted(Request $request){

        $input['cat_name'] = $request->get('cat_name');

        if($request->ajax()){

            $validator = Validator::make($input,[
                            'cat_name' => 'unique:categories'
                        ]);
            if($validator->fails())
                return Response::json(FALSE);
            else 
                return Response::json(TRUE);
        }
    }

}