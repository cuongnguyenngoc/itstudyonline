<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = "programminglangugages";
    protected $fillable= array('id', 'lang_name');
    public $timestamps = false;
    
    public function courses(){
        $this->hasMany('App\Course','lang_id', 'id');
    }
}
