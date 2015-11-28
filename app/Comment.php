<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	protected $fillable = ['user_id', 'lec_id', 'content'];
    public function lecture(){
    	return $this->belongsTo('App\Lecture','lec_id','id');
    }

    public function user(){
    	return $this->belongsTo('App\User','user_id','id');
    }
}
