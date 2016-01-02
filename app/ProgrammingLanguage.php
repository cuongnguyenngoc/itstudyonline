<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgrammingLanguage extends Model
{
	protected $table = "programminglanguages";
	protected $fillable = array('id','lang_name');
}
