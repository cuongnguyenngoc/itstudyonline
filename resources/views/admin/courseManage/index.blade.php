@extends('admin.home')
@section('admin-content')
    
<div class="course-div">
    <div id="title"><strong>Manage Course</strong></div>
    <div class="col-sm-12" style="margin-top: 20px;">
        <div class="row">
            <div class="panel panel-info">
                <div class="panel-heading" style="text-align: center;">
                    Manage Courses
                </div>
                <div class="panel-body">
                    @foreach($courses as $course)
                        <div class="col-sm-3">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <a href="javascript:void(0)" class="thumbnail">
                                            @if($course->image)
                                                <img src="/{{$course->image->path}}" alt="{{$course->image->img_name}}" style="height: 240px;">
                                            @else
                                                <img src="nothing" alt="This course haven't completed yet, User left it. So Do you want to delete it?" style="height: 240px;">
                                            @endif
                                        </a>
                                        <h2>{{$course->course_name}}</h2>
                                        <ul class="nav nav-pills nav-justified">
                                            <li>
                                                <h5>
                                                    <a href="javascript:void(0)"><i class="glyphicon glyphicon-user"></i>
                                                        {{$course->enrolls()->count()}} students enrolled
                                                    </a>
                                                </h5>
                                            </li>
                                            <li><h5><i class="glyphicon glyphicon-usd"></i>{{($course->cost == 0) ? "FREE" : $course->cost." VND"}}</h5></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="choose">
                                    <ul class="nav nav-pills nav-justified">
                                        <li><h5><a href="{{route('admin.courseManage.courseInfomation',$course->id)}}"> Read more</a></h5></li>
                                        <li><h5 style="padding-left: 47px;"><a href="{{route('admin.courseManage.delete',$course->id)}}" onclick="return confirm('Do you want to delete this Course?')"><i class="glyphicon glyphicon-trash"></i> Delete</a></h5></li>
                                    </ul>
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
    <div class="row">
        <div class="col-lg-4  col-lg-offset-5">
            {!! $courses->render() !!}
        </div>
    </div>
</div> 
@stop













