<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";
    protected $fillable = array('id', 'cat_name', 'description');
    public $timestamps = false;
    
    public function courses(){
        return $this->hasMany('App\Course', 'cat_id', 'id');
    }
   
}
