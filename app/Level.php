<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    public function courses(){
        $this->hasMany('App\Course');
    }
}
