<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public function course(){
    	$this->belongsTo('App\Course');
    }
}
