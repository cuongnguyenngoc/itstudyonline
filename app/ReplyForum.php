<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReplyForum extends Model
{
    protected $table = 'replies_forum';

    public $timestamps = false;

    public function User() {
        return $this->belongsTo("App\User", "rep_by");
    }

    public function TopicForum() {
        return $this->belongsTo("App\TopicForum", "rep_topic", "id");
    }
}
