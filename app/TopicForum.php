<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TopicForum extends Model
{
    protected $table = 'topics';
    public $timestamps = false;

    public function CategoryForum() {
        return $this->belongsTo("App\CategoryForum", "topic_cat");
    }

    public function User() {
        return $this->belongsTo("App\User", "topic_by");
    }

    public function PostForum() {
        return $this->hasOne("App\PostForum", "post_topic", "id");
    }
    public function replyForums(){
        return $this->hasMany("App\ReplyForum", "rep_topic", "id");
    }
    public function EnrollForum(){
        return $this->belongsTo("App\Enroll", "enroll_id", "id");
    }
}
