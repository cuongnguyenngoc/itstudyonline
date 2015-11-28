<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['fullname', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function role(){

        return $this->belongsTo('App\UserRole','role_id','id');
    }

    public function usercreatecourses(){
        return $this->hasMany('App\UserCreateCourse','user_id','id');
    }

    public function enrolls(){
        return $this->hasMany('App\Enroll');
    }

    public function image(){
        return $this->hasOne('App\Image','user_id','id');
    }

    public function enroll($course_id){
        return $this->enrolls->where('course_id',$course_id)->first();
    }

    public function comments(){
        return $this->hasMany('App\Comment','user_id','id');
    }
}
