<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'userroles';
    protected $fillable = ['id','role_name'];
}
