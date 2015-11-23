<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{

	protected $fillable = ['course_id', 'user_id', 'lec_name', 'description', 'order'];

    public function video(){
    	return $this->hasOne('App\Video','id','lec_id');
    }

    public function document(){
    	return $this->hasOne('App\Document','id','lec_id');
    }
}
