
@extends('public.layouts.app')

@section('css')
    <link href="{{url('css/master/styles.css')}}" rel="stylesheet">
@stop

@section('header-top')
    @include('public.layouts.header.header-top')
@stop
@section('header-middle')
    @include('public.layouts.header.header-middle')
@stop

@section('content')

<!-- Main -->
<div class="container main">
    <div class="row">
        <div class="col-sm-12">
            <div class="col-md-3">
                <input type="hidden" name="hide_id" id="course_id_hide" value="{{$course->id}}">
                <a href="{{url('course/'.$course->id)}}" class="thumbnail">
                    <img src="/{{$course->image->path}}" alt="{{$course->image->img_name}}" height="200px" />
                </a>
            </div>
            <div class="col-md-9">
                <h3 style="margin-top: 2px;"><a href="#">{{$course->course_name}}</a></h3>
                <a href="javascript:void(0)">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    <span>{{$course->ratings->count()}} ratings, {{$course->enrolls->count()}} students enrolled</span>
                </a> 
                <div>
                    <p class="col-md-4" style="padding: 0px;"> Created by <a href="#" style="font-size: 16px;"> {{$course->bosscreatecourse()->user->fullname}}</a></p>
                    <p class="col-md-8" style="padding: 0px;"> Category <a href="#" style="font-size: 16px;"> {{$course->category->cat_name}}</a></p>
                </div>            
            </div>
        </div>
        <div class="col-sm-12">
            <div class="col-md-8">
                <div class="embed-responsive embed-responsive-16by9">
                    <video class="embed-responsive-item" controls="controls" preload="auto">
                        <source src="/{{$course->videointro->path}}" type="video/mp4">
                        Your browser does not support HTML5 video.
                    </video>
                </div>
            </div>
            <div class="col-md-4" style="padding-bottom: 15px; border-bottom: 1px solid #F0F0E9;">
                <h3 style="margin-top: 0px;"> {{$course->cost}}k VND</h3>
                <a href="#" class="btn btn-primary btn-lg" style="margin-top: 0px;" id="enrollCourseBtn"> {{($enroll)?"Continue":"Enroll This Course"}}</a>
                <div style="margin-top: 10px;">
                    <a href="#"><span class="glyphicon glyphicon-flag"></span> Report Abuse</a>
                </div>            
            </div>
            <div class="col-md-4" style="padding-top: 15px;">
                <div class="col-md-6" style="padding-left: 0px;">Lectures</div><div class="col-md-6"> {{$course->lectures->count()}}</div>
                <div class="col-md-6" style="padding-left: 0px;">Category</div><div class="col-md-6"> {{$course->category->cat_name}}</div>
                <div class="col-md-6" style="padding-left: 0px;">Learning Level</div><div class="col-md-6"> {{$course->level->level_name}}</div>
                <div class="col-md-6" style="padding-left: 0px;">Programming language</div><div class="col-md-6"> {{$course->language->lang_name}}</div>               
            </div>
        </div>
    </div>

    <hr>
    
    <div class="row">
        <div class="col-sm-12">
            <div class="col-md-8">
                <h3> Course description</h3>
                <div>{!!$course->description!!}</div>
                <h3> Curriculum</h3>
                <hr>
                <div>
                    @foreach($course->lectures as $lecture)
                        <div class="lecture row" getId="{{$lecture->order}}">
                            <div class="col-md-4">
                                <span class="glyphicon glyphicon-play"></span> 
                                Lecture {{$lecture->order}}
                            </div>
                            <div class="col-md-4">
                                {{$lecture->lec_name}} 
                                <span class="toggle glyphicon glyphicon-triangle-bottom"></span>
                            </div> 
                            <div class="col-md-4">
                                {{$lecture->type}} 
                            </div>     
                            <div id="lecture{{$lecture->order}}" class="col-md-12 hide" style="margin: 15px;margin-bottom: 0px; margin-top: 10px;">
                                {!! $lecture->description !!}
                            </div>       
                        </div>
                    @endforeach
                </div>
                <h3>Master Information</h3>
                <div>
                    <a href="{{url('user/'.$course->bosscreatecourse()->user->id)}}" class="thumbnail col-md-3">
                        <img src="{{($course->bosscreatecourse()->user->image)?url($course->bosscreatecourse()->user->image->path):''}}" height="100px" />
                    </a>
                    <a href="#" class="col-md-9">
                        {{$course->bosscreatecourse()->user->fullname}}
                    </a>
                    <div class="social-icons">
                        <ul class="nav navbar-nav">
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                    <div class="col-md-12" style="padding-left: 0px;">
                        Hi, I'm Cuong! I'm a cool guy. I'm here to teach you something new and insteresting about IT
                    </div>           
                </div>
                <div class="col-md-12" style="padding-left: 0px;">
                    <h3>Reviews</h3>
                    <div class="col-md-12" style="padding-left: 0px;">
                        <div class="col-md-6" style="padding-left: 0px;">
                            <p>Average Rating</p>
                            <div class="col-md-12" style="padding-left: 0px;font-size: 75px;color: #D9534F;">{{$course->averageRating()}}</div>
                            <div class="col-md-4" style="padding-left: 0px;">
                                @for($i=1;$i<= intval($course->averageRating());$i++)
                                    <span class="glyphicon glyphicon-star" aria-hidden="true" style="color: #D9534F;"></span>
                                @endfor
                                @for($i=1;$i<= 5 - intval($course->averageRating());$i++)
                                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                @endfor
                                <!-- <span class="glyphicon glyphicon-star" aria-hidden="true" style="color: #D9534F;"></span>
                                <span class="glyphicon glyphicon-star" aria-hidden="true" style="color: #D9534F;"></span>
                                <span class="glyphicon glyphicon-star" aria-hidden="true" style="color: #D9534F;"></span>
                                <span class="glyphicon glyphicon-star" aria-hidden="true" style="color: #D9534F;"></span>
                                <span class="glyphicon glyphicon-star" aria-hidden="true" style="color: #D9534F;"></span> -->
                            </div>
                            <div>{{$course->ratings()->count()}} ratings</div>
                        </div>
                        <div class="col-md-5">
                            <p>Details</p>
                            <div class="col-md-3" style="padding-left: 0px;padding-right: 0px;">5 stars</div>
                            <div class="progress" style="margin: 4px;">
                                <div class="progress-bar progress-bar-danger" role="progressbar"
                                aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:{{$course->fiveStarsPercent()}}%">
                                    {{$course->fivestars()}}
                                </div>
                            </div>
                            <div class="col-md-3" style="padding-left: 0px;padding-right: 0px;">4 stars</div>
                            <div class="progress" style="margin: 4px;">
                                <div class="progress-bar progress-bar-danger" role="progressbar"
                                aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:{{$course->fourStarsPercent()}}%">
                                    {{$course->fourstars()}}
                                </div>
                            </div>
                            <div class="col-md-3" style="padding-left: 0px;padding-right: 0px;">3 stars</div>
                            <div class="progress" style="margin: 4px;">
                                <div class="progress-bar progress-bar-danger" role="progressbar"
                                aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:{{$course->threeStarsPercent()}}%">
                                    {{$course->threestars()}}
                                </div>
                            </div>
                            <div class="col-md-3" style="padding-left: 0px;padding-right: 0px;">2 stars</div>
                            <div class="progress" style="margin: 4px;">
                                <div class="progress-bar progress-bar-danger" role="progressbar"
                                aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:{{$course->twoStarsPercent()}}%">
                                    {{$course->twostars()}}
                                </div>
                            </div>
                            <div class="col-md-3" style="padding-left: 0px;padding-right: 0px;">1 star</div>
                            <div class="progress" style="margin: 4px;">
                                <div class="progress-bar progress-bar-danger" role="progressbar"
                                aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:{{$course->oneStarPercent()}}%">
                                    {{$course->onestar()}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="comments col-md-12" style="padding-left: 0px;">
                        @if($course->ratings()->count() != 0)
                            @foreach($course->ratings as $rating)
                                <div class="col-md-12" style="padding: 0px;margin-top: 10px; padding-bottom: 20px; border-bottom: 1px solid #F0F0E9;">
                                    <img src="/{{($rating->user->image)? $rating->user->image->path:'images/it_me.jpg'}}" class="col-md-1 img-circle" style="padding: 0px;">
                                    <div class="col-md-11" style="padding: 0px;">
                                        <a href="#" class="col-md-4">
                                            {{$rating->user->fullname}}
                                        </a>
                                        @for($i=1;$i<= $rating->num_stars;$i++)
                                            <span class="glyphicon glyphicon-star" aria-hidden="true" style="color: #D9534F;"></span>
                                        @endfor
                                        @for($i=1;$i<= 5 - $rating->num_stars;$i++)
                                            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                        @endfor
                                        <div class="col-md-12">
                                            {{$rating->review}}
                                        </div>                                                    
                                    </div>
                                </div>
                            @endforeach
                        @else
                            No review here
                        @endif
                    </div>
                </div>         
            </div>
            <div class="col-md-4">
                          
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .lecture{
        padding: 10px;
        padding-left: 0px;
        border-bottom: 1px solid #F0F0E9;   
        background: #0C9A14;
        margin-left: 0px;
    }
    ul li{
        list-style: disc;
    }
</style>

@stop

@section('footer-bottom')
    @include('public.layouts.footer.footer-bottom')
@stop



@section('script')
    @if(Auth::check())
        <script>{{ 'var logged = true;' }}</script>
    @else
        <script>{{ 'var logged = false;' }}</script>
    @endif
    @if($enroll != null)
        <script>{{ 'var enroll = true;' }}</script>
    @else
        <script>{{ 'var enroll = false;' }}</script>
    @endif
    <script type="text/javascript">
        //$(document).ready(function(){
            if(enroll)
                var n = noty({text: 'Welcome back. How do you do, buddy', layout: 'top', type: 'success', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });

            $('div.lecture').click(function(){
                var getId = $(this).attr('getId');
                $('#lecture'+getId).toggleClass('hide');
                $(this).find('span.toggle').toggleClass('glyphicon-triangle-bottom glyphicon-triangle-top');
            });   

            $('#enrollCourseBtn').click(function(e){
                e.stopImmediatePropagation();
                if(!logged){
                    $("#authModal").modal();
                    login_selected();
                }else{
                    window.location.href = "/course/learning/" + $('#course_id_hide').val();
                }
            });
        //});
        
    </script>
@stop

