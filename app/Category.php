<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{   
	protected $fillable = ['id','cat_name','description'];

    public function courses(){
        return $this->hasMany('App\Course','cat_id','id');
    }

    public function usercreatecourses(){
    	return $this->hasManyThrough('App\UserCreateCourse', 'App\Course', 'cat_id', 'course_id');
    }
}


