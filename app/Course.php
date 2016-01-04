<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{

    public function language(){
    	return $this->belongsTo('App\ProgrammingLanguage','lang_id','id');
    }

    public function category(){
    	return $this->belongsTo('App\Category','cat_id','id');
    }

    public function level(){
    	return $this->belongsTo('App\Learninglevel','level_id','id');
    }

    public function image(){
    	return $this->hasOne('App\Image');
    }

    public function videointro(){
        return $this->hasOne('App\Introvideo');
    }

    public function lectures(){
    	return $this->hasMany('App\Lecture');
    }

    public function usercreatecourses(){
        return $this->hasMany('App\UserCreateCourse','course_id','id');
    }

    public function usercreatecourse($user_id){
        return $this->usercreatecourses->where('user_id',intval($user_id))->first();
    }

    public function membercreatecourses(){
        return $this->usercreatecourses()->where('isBoss',0)->get();
    }

    public function bosscreatecourse(){
        return $this->usercreatecourses()->where('isBoss',1)->first();
    }

    public function ratings(){
        return $this->hasMany('App\Rating');
    }

    public function fivestars(){
        return $this->ratings()->where('num_stars',5)->count();
    }
    public function fourstars(){
        return $this->ratings()->where('num_stars',4)->count();
    }
    public function threestars(){
        return $this->ratings()->where('num_stars',3)->count();
    }
    public function twostars(){
        return $this->ratings()->where('num_stars',2)->count();
    }
    public function onestar(){
        return $this->ratings()->where('num_stars',1)->count();
    }

    public function sumStars(){
        return $this->fivestars() + $this->fourstars() + $this->threestars() + $this->twostars() + $this->onestar();
    }
    public function fiveStarsPercent(){
        return ($this->sumStars() != 0) ? $this->fivestars() / ($this->sumStars()) * 100 : 0;
    }

    public function fourStarsPercent(){
        return ($this->sumStars() != 0) ? $this->fourstars() / ($this->sumStars()) * 100 : 0;
    }

    public function threeStarsPercent(){
        return ($this->sumStars() != 0) ? $this->threestars() / ($this->sumStars()) * 100 : 0;
    }

    public function twoStarsPercent(){
        return ($this->sumStars() != 0) ? $this->twostars() / ($this->sumStars()) * 100 : 0;
    }

    public function oneStarPercent(){
        return ($this->sumStars() != 0) ? $this->onestar() / ($this->sumStars()) * 100 : 0;
    }

    public function averageRating(){
        return ($this->sumStars() != 0) ? round((5 * $this->fivestars() + 4 * $this->fourstars() + 3 * $this->threestars() + 
                2 * $this->twostars() + 1 * $this->onestar()) / $this->sumStars(),1) : 0;
    }

    public function enrolls(){
        return $this->hasMany('App\Enroll');
    }

    public function numQuizs(){
        return $this->lectures()->where('type','Quiz')->count();
    }

    public function numWrongAnswerInQuizs(){
        $num = 0;
        foreach ($this->lectures as $lecture) {
            foreach ($lecture->questions as $question) {
                $num += $question->num_wrong_answers;
            }
        }
        return $num;
    }
}
