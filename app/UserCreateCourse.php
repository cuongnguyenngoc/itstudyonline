<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCreateCourse extends Model
{
    protected $table = "userscreatecourses";

    protected $fillable = ['user_id', 'course_id', 'isBoss'];

    public function course(){
    	return $this->belongsTo('App\Course');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
