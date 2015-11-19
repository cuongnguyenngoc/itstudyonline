<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thumbnail extends Model
{
	protected $fillable = ['video_id', 'img_name', 'path'];

    public function video(){
    	return $this->belongsTo('App\Video');
    }
}
