<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
	protected $fillable = ['course_id', 'img_name', 'path'];

    public function course(){

        return $this->belongsTo('App\Course');
    }
}
