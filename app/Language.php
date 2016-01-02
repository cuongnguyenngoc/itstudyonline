<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
	protected $fillable = ['id','lang_name'];

    public function courses(){
        $this->hasMany('App\Course');
    }
}
