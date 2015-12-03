<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{

	protected $fillable = ['course_id', 'user_id', 'lec_name', 'description', 'order', 'oldOrder'];

    public function video(){
    	return $this->hasOne('App\Video','lec_id','id');
    }

    public function document(){
    	return $this->hasOne('App\Document','lec_id','id');
    }

    public function comments(){
    	return $this->hasMany('App\Comment','lec_id','id');
    }
}
