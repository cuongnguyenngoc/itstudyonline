<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    public function lecture(){

        return $this->belongsTo('App\Lecture');
    }

    public function thumbnails(){
    	return $this->hasMany('App\Thumbnail');
    }

    public function thumbnail(){
    	return $this->hasOne('App\Thumbnail','id','thumb_id');
    }
}
