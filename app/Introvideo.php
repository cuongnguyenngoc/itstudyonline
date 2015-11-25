<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Introvideo extends Model
{
    protected $fillable = ['course_id', 'video_name', 'path'];

    public function course(){

        return $this->belongsTo('App\Course');
    }
}
