<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function language(){
    	return $this->belongsTo('App\ProgrammingLanguage','lang_id','id');
    }

    public function category(){
    	return $this->belongsTo('App\Category','cat_id','id');
    }

    public function level(){
    	return $this->belongsTo('App\Learninglevel','level_id','id');
    }

    public function image(){
    	return $this->hasOne('App\Image');
    }

    public function videointro(){
        return $this->hasOne('App\Introvideo');
    }

    public function lectures(){
    	return $this->hasMany('App\Lecture');
    }

    public function usercreatecourse(){
        return $this->hasOne('App\UserCreateCourse');
    }

    public function ratings(){
        return $this->hasMany('App\Rating');
    }

    public function enrolls(){
        return $this->hasMany('App\Enroll');
    }
}
