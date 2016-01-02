<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
	protected $fillable = ['course_id', 'num_stars', 'review'];

    public function course(){
    	return $this->belongsTo('App\Course','course_id','id');
    }

    public function user(){
    	return $this->belongsTo('App\User','user_id','id');
    }

}
