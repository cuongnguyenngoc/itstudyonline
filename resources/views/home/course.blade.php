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
                <a href="#">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    <span>{{$course->ratings->count()}} ratings, {{$course->enrolls->count()}} students enrolled</span>
                </a> 
                <div>
                    <p class="col-md-4" style="padding: 0px;"> Created by <a href="#" style="font-size: 16px;"> {{$course->usercreatecourse->user->fullname}}</a></p>
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
                <a href="#" class="btn btn-primary btn-lg" style="margin-top: 0px;" id="enrollCourseBtn"> Enroll This Course</a>
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
                    <a href="{{url('user/'.$course->usercreatecourse->user->id)}}" class="thumbnail col-md-3">
                        <img src="{{($course->usercreatecourse->user->image)?url($course->usercreatecourse->user->image->path):''}}" height="100px" />
                    </a>
                    <a href="#" class="col-md-9">
                        {{$course->usercreatecourse->user->fullname}}
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
                    <div class="btn btn-primary"> I will do this later</div>

                    <div class="comments">
                        Comments will be showed below, buddy
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
    <script type="text/javascript">
        //$(document).ready(function(){
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

