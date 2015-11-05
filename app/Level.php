<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $table = "learninglevels";
    protected $fillable = array('id', 'level_name');
    public $timestamps= false;
     public function courses(){
        $this->hasMany('App\Course','level_id', 'id');
    }
}
