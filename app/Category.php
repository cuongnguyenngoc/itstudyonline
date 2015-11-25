<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Category extends Model
{   
    public function courses(){
        return $this->hasMany('App\Course','cat_id','id');
    }

    public function usercreatecourses(){
    	return $this->hasManyThrough('App\UserCreateCourse', 'App\Course', 'cat_id', 'course_id');
    }
}


