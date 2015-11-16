<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    public function video(){
    	return $this->hasOne('App\Video');
    }
}
