<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    protected $table = "usersmarklectures";

    protected $fillable = ['enroll_id', 'lec_id', 'isMarked', 'isRight'];

    public function lecture(){
    	return $this->belongsTo('App\Lecture');
    }

    public function enroll(){
    	return $this->belongsTo('App\Enroll');
    }
}
