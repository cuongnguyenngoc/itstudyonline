<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public function courses(){
        $this->hasMany('App\Course');
    }
}
