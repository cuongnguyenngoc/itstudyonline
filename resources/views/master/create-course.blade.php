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
        <div class="col-md-12 hide" id="headCourse">
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
                                    <span id="lecturesPublished" lecturesPublished="">0</span> | 
                                    <span id="countLectures" countLectures="">0</span>
                                </h3>
                            </p>
                        </div>
                        <div>
                            <input type="hidden" value="" id="submitCourseId"/>
                            <button class="btn btn-primary col-md-6" style="margin-top: 31px;" id="submitCourse">Submit your course</button>
                        </div>      
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="list-group" id="task-left">
                @foreach($courseItems as  $key => $values)
                    <a href="#" class="list-group-item disabled">
                        {{$key}}
                    </a>
                    @foreach($values as $id => $value)
                        <a href="#" class="list-group-item list-group-item-success {{$id}} list-arrow" id="{{$id}}">{{$value}}</a> 
                    @endforeach
                @endforeach
            </div>
        </div>
        <div class="col-md-9">
            @include('master.panel.course-goals-panel')
            @include('master.panel.curriculum-panel')        
            @include('master.panel.image-panel')
            @include('master.panel.price-coupons-panel')
        </div>
    </div>
</div>

@stop

@section('footer')
    @include('public.layouts.footer')
@stop

@section('script')
    <script src="{{url('js/master/scripts.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            $('.list-group-item-success.course-goals').addClass('active');
            $('div.panel-right.course-goals').removeClass('hide');

            $('.list-group-item-success').click(function(){
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
                if($('#lecturesPublished').attr('lecturesPublished') >= 3){
                    if($('#img_preview').attr('src')!='nothing'){

                        $.ajax({
                            type: "POST",
                            url : "/master/submit-course",
                            dataType: 'json',
                            data: {'course_id' : $('#course_id').val(), 'id' : $('#submitCourseId').val()}, // remember that be must to pass data object type
                            success : function(response){
                                console.log(response);
                                if(response.status){
                                    $('#submitCourseId').val(response.usercreatecourse.id);
                                    alert('You submit course successfully');
                                }
                            }
                        });
                    }else{
                        alert('You should upload avatar for course');
                    }
                }else{
                    alert('Number of lectures is minimax 6');
                }           
            });
        });      
    </script>
@stop

