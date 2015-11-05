<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = "courses";
    protected $fillable = array('id', 'cat_id', 'lang_id', 'level_id', 'course_name', 'description', 'cost', 'isPublic', 'shares', 'views');
    public $timestamps= false;
    public function category(){
        return $this->belongsTo('App\Category', 'cat_id');
    }
    public function language(){
        return $this->belongsTo('App\Language', 'lang_id');
    }
    public function level(){
        return $this->belongsTo('App\Level', 'level_id');
    }
}
