<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['test_id', 'lec_id', 'content'];

    protected $table = "questiontests";

    public function answers(){
    	return $this->hasMany('App\Answer','que_id','id');
    }
}
