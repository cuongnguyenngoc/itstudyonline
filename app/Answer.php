<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['que_id', 'isRight', 'content'];

    protected $table = "answeroptions";
}
