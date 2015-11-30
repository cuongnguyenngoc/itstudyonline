<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryForum extends Model {

    protected $table = 'categories_forum';
    protected $fillable = ['cat_name', 'cat_des'];
    public $timestamps = false;

    public function TopicForums(){
        return $this->hasMany("App\TopicForum","topic_cat", "id");
    }
}
