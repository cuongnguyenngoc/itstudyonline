<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostForum extends Model
{
    protected $table = 'post_forum';
     public $timestamps = false;
     public function topicForum(){
         return $this->belongsTo("App\TopicForum", "post_topic");
     }
     public function User(){
         return $this->belongsTo("App\User", "post_by");
     }
}
