<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Category;
use App\Language;
use App\Course;
use App\Level;
class MasterController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllCategories() {
        $data = Category::all(array('id', 'cat_name'));
        $array = [];
        foreach ($data as $value) {
            $array[$value->id] = $value->cat_name;
        }
        return $array;
    }

    public function getLanguages() {
        $data = Language::all(array('id', 'lang_name'));
        $array = [];
        foreach ($data as $value) {
            $array[$value->id] = $value->lang_name;
        }
        return $array;
    }

    public function getLevels() {
        $data = Level::all(array('id', 'level_name'));
        $array = [];
        foreach ($data as $value) {
            $array[$value->id] = $value->level_name;
        }
        return $array;
    }

    public function index() {
        $cats = $this->getAllCategories();
        $langs = $this->getLanguages();
        $levels = $this->getLevels();
        return view('master.registerCourse', array('title' => 'register course', 'cates' => $cats, 'langs' => $langs, 'levels'=>$levels));
    }

    public function regisProcess() {
        $course_name = $_POST['name'];
        $cat_id = $_POST['cate'];
        $lang_id = $_POST['lang'];
        $level_id = $_POST['level'];
        $cost = $_POST['cost'];
        $des = $_POST['des'];
        echo "$course_name - $cat_id - $lang_id - $cost -$des";
        
        $newCouse = new Course;
        $newCouse->cat_id = $cat_id;
        $newCouse->lang_id = $lang_id;
        $newCouse->level_id =$level_id;
        $newCouse->course_name = $course_name;
        $newCouse->cost = $cost;
        $newCouse->description = $des;
        $newCouse->save();
        echo "insert complete";
    }

  
}
