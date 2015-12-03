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
        <ul class="nav nav-tabs">
            <li role="presentation"><a href="{{url('master/manage')}}">Manage Course</a></li>
            <li role="presentation" class="{{($url=='master/create-course')?'active':''}}"><a href="{{url('master/create-course')}}">Create Course</a></li>
            <li role="presentation" class="{{($url=='master/edit-course')?'active':''}}"><a href="#">Edit Course</a></li>
            <li role="presentation"><a href="#">Profile</a></li>
        </ul>
        <div class="col-md-12 {{($course->id)?'':'hide'}}" id="headCourse" style="margin-top: 20px;">
            <div class="panel panel-info">
                <div class="panel-body">
                    <div class="col-md-8">
                        <img src="/images/itstudyonline/course-image.png" alt='This is course image' class='img-thumbnail col-md-4'/>
                        <div class="caption">
                            <h3 id='courseName' class='col-md-8'></h3>
                            <h5 class='col-md-8'>{{Auth::user()->fullname}}</h5>
                        </div>      
                    </div>
                    <div class="col-md-4">
                        <div class="col-md-6">
                            <p style="margin-top:24px;"> Number of lectures was published 
                                <h3 id="numLectures"> 
                                    <span id="lecturesPublished" lecturesPublished="{{($course->lectures)?$course->lectures()->count():"0"}}">{{($course->lectures)?$course->lectures()->count():"0"}}</span> | 
                                    <span id="countLectures" countLectures="{{($course->lectures)?$course->lectures()->count():"0"}}">{{($course->lectures)?$course->lectures()->count():"0"}}</span>
                                </h3>
                            </p>
                        </div>
                        <div>
                            <input type="hidden" value="{{($course->usercreatecourse)?$course->usercreatecourse->id:''}}" id="submitCourseId"/>
                            <button class="btn btn-primary col-md-6" style="margin-top: 31px;" id="submitCourse">{{($course->id)?"Update your course":"Submit your course"}}</button>
                        </div>      
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3" style="padding-right: 0px; padding-left: 0px;margin-top: 20px;">
            <div class="list-group" id="task-left">
                @foreach($courseItems as  $key => $values)
                    <a href="#" class="list-group-item disabled">
                        {{$key}}
                    </a>
                    @foreach($values as $id => $value)
                        <a href="javascript:void(0)" class="list-group-item list-group-item-success {{$id}} list-arrow" id="{{$id}}">{{$value}}</a> 
                    @endforeach
                @endforeach
            </div>
        </div>
        <div class="col-md-9" style="padding-left: 0px;margin-top: 20px;">
            @include('master.panel.course-goals-panel')
            @include('master.panel.curriculum-panel')        
            @include('master.panel.image-panel')
            @include('master.panel.price-coupons-panel')
            @include('master.panel.intro-video-panel')
        </div>
    </div>
</div>

@stop

@section('footer-top')
    @include('public.layouts.footer.footer-top')
@stop
@section('footer-bottom')
    @include('public.layouts.footer.footer-bottom')
@stop

@section('script')
    <script src="{{url('js/master/scripts.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            $('.list-group-item-success.course-goals').addClass('active');
            $('div.panel-right.course-goals').removeClass('hide');

            $('.list-group-item-success').click(function(e){
                e.stopImmediatePropagation(); // Prevent duplicated click
                $('.list-group-item-success').removeClass('active');
                $('div.panel-right').addClass('hide'); 
                
                if(!$(this).hasClass('course-goals')){
                    if($('#course_id').val()==''){
                        $('.list-group-item-success.course-goals').addClass('active');
                        $('div.panel-right.course-goals').removeClass('hide');
                        alert('you have to create basic course first');
                    }else{    
                        $(this).addClass('active');
                        
                        if($('div.panel').hasClass(this.id)){
                            $('div.panel-right.'+this.id).removeClass('hide');
                        }
                    }
                }else{

                    $(this).addClass('active');
                    $('div.panel-right.'+this.id).removeClass('hide');
                }
            });
            // $('.list-group-item-success').click(function(){
            //     $('.list-group-item-success').removeClass('active');
            //     $('div.panel-right').addClass('hide'); 
            //     if($('div.panel').hasClass(this.id)){
            //         $('div.panel-right.'+this.id).removeClass('hide');
            //     }
                
            // });


            $('#submitCourse').on('click',function(e){
                e.stopImmediatePropagation();
                var check = false;
                $('#curriculumPanel').find('div.small-panel').each(function(index){
                    if($(this).find('div.panel-collapse').first().hasClass('panel-danger')){
                        var r = confirm('Seem be some course havent published yet. So do you wanna dismiss it?');
                        if (r == true) {
                            check = true;
                        }
                    }else{
                        check = true;
                    }
                });
                if(check){
                    if($('#lecturesPublished').attr('lecturesPublished') >= 3){
                        if($('#img_preview').attr('src')!='nothing'){
                            if($('#video_preview').attr('src') != null){
                                $.ajax({
                                    type: "POST",
                                    url : "/master/submit-course",
                                    dataType: 'json',
                                    data: {'course_id' : $('#course_id').val(), 'id' : $('#submitCourseId').val(), '_token' : '{{ csrf_token() }}'}, // remember that be must to pass data object type
                                    success : function(response){
                                        console.log(response);
                                        if(response.status){
                                            $('#submitCourseId').val(response.usercreatecourse.id);
                                            var n = noty({text: response.message, layout: 'top', type: 'success', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });
                                            $(window).off('beforeunload');
                                        }else{
                                            var n = noty({text: response.message, layout: 'top', type: 'error', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });
                                        }
                                    }
                                });
                            }else{
                                var n = noty({text: 'You should upload avatar for course', layout: 'top', type: 'error', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });

                            }                      
                        }else{
                            var n = noty({text: 'You should upload avatar for course', layout: 'top', type: 'error', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });

                        }
                    }else{
                        var n = noty({text: 'Number of lectures is minimax 6', layout: 'top', type: 'error', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });

                    }
                }
                           
            });

            $(window).on("beforeunload", function() {
                return "Are you sure? You didn't finish the form!";
            });


            $('#curriculumPanel').find('div.small-panel').each(function(index){
                if($(this).find('div.panel-collapse').first().hasClass('panel-danger')){
                    $(window).on("beforeunload", function() {
                        return "Are you sure? You didn't finish the form! Please click submit course to complete";
                    });
                    alert('wtf');
                }
            });
        });      
    </script>
@stop

