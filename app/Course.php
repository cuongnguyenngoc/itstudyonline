<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function language(){
    	return $this->belongsTo('App\ProgrammingLanguage');
    }

    public function category(){
    	return $this->belongsTo('App\Category');
    }

    public function level(){
    	return $this->belongsTo('App\Learninglevel');
    }

    public function images(){
    	return $this->hasOne('App\Image');
    }

    public function lectures(){
    	return $this->hasMany('App\Lecture');
    }
}
