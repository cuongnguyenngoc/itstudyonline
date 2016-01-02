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
            <li role="presentation" class="active"><a href="{{url('master/manage')}}">Manage Course</a></li>
            <li role="presentation"><a href="{{url('master/create-course')}}">Create Course</a></li>
            <li role="presentation"><a href="javascript:void(0)">Edit Course</a></li>
            <li role="presentation"><a href="javascript:void(0)">Profile</a></li>
        </ul>
        <div class="col-sm-12" style="margin-top: 20px;">
            <div class="row">
                <div class="panel panel-info">
                    <div class="panel-heading" style="text-align: center;">
                        Your Courses
                    </div>
                    <div class="panel-body">
                        @foreach($usercreatecourses as $usercreatecourse)
                            <div class="col-sm-3">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <a href="javascript:void(0)" class="thumbnail">
                                                <img src="/{{$usercreatecourse->course->image->path}}" alt="{{$usercreatecourse->course->image->img_name}}" style="height: 240px;">
                                            </a>
                                            <h2>{{$usercreatecourse->course->course_name}}</h2>
                                            <ul class="nav nav-pills nav-justified">
                                                <li>
                                                    <h5>
                                                        <a href="javascript:void(0)"><i class="glyphicon glyphicon-user"></i>
                                                            {{$usercreatecourse->course->enrolls()->count()}} students enrolled
                                                        </a>
                                                    </h5>
                                                </li>
                                                <li><h5><i class="glyphicon glyphicon-usd"></i>{{($usercreatecourse->course->cost == 0) ? "FREE" : $usercreatecourse->course->cost." VND"}}</h5></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="choose">
                                        <ul class="nav nav-pills nav-justified">
                                            <li><h5><a href="javascript:void(0)" class="editCourse" getId="{{$usercreatecourse->course->id}}"><i class="glyphicon glyphicon-edit"></i> Edit</a></h5></li>
                                            <li><h5 style="padding-left: 47px;"><a href="javascript:void(0)" class="deleteCourse" getId="{{$usercreatecourse->course->id}}" del="{{$usercreatecourse->can_delete}}"><i class="glyphicon glyphicon-trash"></i> Delete</a></h5></li>
                                        </ul>
                                    </div>
                                    <div class="choose">
                                        <div class="boss" style="text-align: center; padding:10px;">
                                            {!!($usercreatecourse->isBoss)?"You have ".$usercreatecourse->course->membercreatecourses()->count()." members":"Owner is <a href=''>".$usercreatecourse->course->bosscreatecourse()->user->fullname."</a>"!!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!--/panel-body-->
                </div>
                <!--/panel-->
            </div>
            <!--/row-->
        </div>
        <!--/col-span-9-->
    </div>
</div>

@stop

@section('footer-bottom')
    @include('public.layouts.footer.footer-bottom')
@stop

@section('script')
    <script src="{{url('js/master/scripts.js')}}"></script>
    <script type="text/javascript">

        $('a.deleteCourse').on('click',function(){
            

            var getId = $(this).attr('getId');
            var del = $(this).attr('del');
            var course = {};
            course.course_id = getId;
            course._token = '{{ csrf_token() }}';
            if(del=='1'){
                var r = confirm('Do you wanna delete this course?');
                if (r == true) {

                    $.ajax({
                        type: "POST",
                        url : "/master/delete-course",
                        dataType: 'json',
                        data: course, // remember that be must to pass data object type
                        success : function(response){
                            console.log(response);
                            if(response.status){
                                if(response.usercreatecourses.length){
                                    for(var i = 0; i < response.usercreatecourses.length; i++){
                                        $('div.panel-body').html(
                                            "<div class='col-sm-3'>"+
                                                "<div class='product-image-wrapper'>"+
                                                    "<div class='single-products'>"+
                                                        "<div class='productinfo text-center'>"+
                                                            "<a href='javascript:void(0)' class='thumbnail'>"+
                                                                "<img src='/"+response.usercreatecourses[i].course.image.path+"' alt='"+response.usercreatecourses[i].course.image.img_name+"' style='height: 240px;' />"+
                                                            "</a>"+
                                                            "<h2>"+response.usercreatecourses[i].course.course_name+"</h2>"+
                                                            "<ul class='nav nav-pills nav-justified'>"+
                                                                "<li><h5><a href='javascript:void(0)'><i class='glyphicon glyphicon-user'></i>"+response.usercreatecourses[i].course.enrolls.length+" students enrolled</a></h5></li>"+
                                                                "<li><h5><i class='glyphicon glyphicon-usd'></i>"+response.usercreatecourses[i].course.cost+"</h5></li>"+
                                                            "</ul>"+
                                                        "</div>"+
                                                    "</div>"+
                                                    "<div class='choose'>"+
                                                        "<ul class='nav nav-pills nav-justified'>"+
                                                            "<li><h5><a href='javascript:void(0)'><i class='glyphicon glyphicon-edit'></i> Edit</a></h5></li>"+
                                                            "<li><h5 style='padding-left: 47px;'><a href='javascript:void(0)' class='deleteCourse' getId='"+response.usercreatecourses[i].course.id+"'><i class='glyphicon glyphicon-trash'></i> Delete</h5></a></li>"+
                                                        "</ul>"+
                                                    "</div>"+
                                               "</div>"+
                                            "</div>"
                                        );
                                    }
                                }else{
                                    $('div.panel-body').html(" Nothing to show");
                                }
                                var n = noty({text: response.message, layout: 'top', type: 'success', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });
                            }else{
                                var n = noty({text: response.message, layout: 'top', type: 'error', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });
                            }
                        }
                    });
                }
            }else{
                var n = noty({text: "You dont have permission to delete this course. Ask owner to able to do this", layout: 'top', type: 'error', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });

            }
        });
        $('a.editCourse').on('click',function(){
            
            var getId = $(this).attr('getId');
            window.location.href = "/master/edit-course/" + getId;
        });
    </script>
@stop

