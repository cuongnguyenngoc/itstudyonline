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
            <li role="presentation"><a href="#">Edit Course</a></li>
            <li role="presentation"><a href="#">Profile</a></li>
        </ul>
        <!-- <div class="col-sm-3"> -->
            <!-- Left column -->
            <!-- <a href="#"><strong><i class="glyphicon glyphicon-wrench"></i> Tools</strong></a>

            <ul class="nav nav-stacked left-sidebar">
                <li class="nav-header"> <a href="#" data-toggle="collapse" data-target="#manage">Manage Course<i class="glyphicon glyphicon-chevron-right"></i></a>
                    <ul class="nav nav-stacked collapse" id="manage">
                        <li class="active"> <a href="{{url('master/create-course')}}"><span class="glyphicon glyphicon-folder-open"></span> Create Course</a></li>
                        <li><a href="#"><i class="glyphicon glyphicon-envelope"></i> Messages <span class="badge badge-info">4</span></a></li>
                        <li><a href="#"><i class="glyphicon glyphicon-cog"></i> Options</a></li>
                        <li><a href="#"><i class="glyphicon glyphicon-off"></i> Logout</a></li>
                    </ul>
                </li>
                <li class="nav-header"> <a href="#" data-toggle="collapse" data-target="#menu2"> Reports <i class="glyphicon glyphicon-chevron-right"></i></a>

                    <ul class="nav nav-stacked collapse" id="menu2">
                        <li><a href="#">Information &amp; Stats</a>
                        </li>
                        <li><a href="#">Views</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">
                    <a href="#" data-toggle="collapse" data-target="#menu3"> Social Media <i class="glyphicon glyphicon-chevron-right"></i></a>
                    <ul class="nav nav-stacked collapse" id="menu3">
                        <li><a href=""><i class="glyphicon glyphicon-circle"></i> Facebook</a></li>
                        <li><a href=""><i class="glyphicon glyphicon-circle"></i> Twitter</a></li>
                    </ul>
                </li>
            </ul>

            <hr>

            <a href="#"><strong><i class="glyphicon glyphicon-link"></i> Resources</strong></a>

            <hr>

            <ul class="nav nav-pills nav-stacked left-sidebar">
                <li class="nav-header"></li>
                <li><a href="#"><i class="glyphicon glyphicon-list"></i> Layouts &amp; Templates</a></li>
                <li><a href="#"><i class="glyphicon glyphicon-briefcase"></i> Toolbox</a></li>
                <li><a href="#"><i class="glyphicon glyphicon-link"></i> Widgets</a></li>
                <li><a href="#"><i class="glyphicon glyphicon-list-alt"></i> Reports</a></li>
            </ul>

            <hr>
            <ul class="nav nav-stacked left-sidebar">
                <li class="active"><a href="http://bootply.com" title="The Bootstrap Playground" target="ext">Playground</a></li>
                <li><a href="/tagged/bootstrap-3">Bootstrap 3</a></li>
                <li><a href="/61518" title="Bootstrap 3 Panel">Panels</a></li>
                <li><a href="/61521" title="Bootstrap 3 Icons">Glyphicons</a></li>
                <li><a href="/62603">Layout</a></li>
            </ul>

            <hr>

            <a href="#"><strong><i class="glyphicon glyphicon-list"></i> More Templates</strong></a>

            <hr>

            <ul class="nav nav-stacked left-sidebar">
                <li class="active"><a rel="nofollow" href="http://goo.gl/pQoXEh" target="ext">Premium Themes</a></li>
                <li><a rel="nofollow" href="https://wrapbootstrap.com/?ref=bootply">Wrap Bootstrap</a></li>
                <li><a rel="nofollow" href="http://bootstrapzero.com">BootstrapZero</a></li>
            </ul>
        </div> -->
        <!-- /col-3 -->
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
                                            <a href="" class="thumbnail">
                                                <img src="/{{$usercreatecourse->course->image->path}}" alt="{{$usercreatecourse->course->image->img_name}}" style="height: 240px;" />
                                            </a>
                                            <h2>{{$usercreatecourse->course->course_name}}</h2>
                                            <ul class="nav nav-pills nav-justified">
                                                <li><h5><a href="#"><i class="glyphicon glyphicon-user"></i>{{$usercreatecourse->course->enrolls()->count()}} students enrolled</a></h5></li>
                                                <li><h5><i class="glyphicon glyphicon-usd"></i>{{($usercreatecourse->course->cost == 0) ? "FREE" : $usercreatecourse->course->cost." VND"}}</h5></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="choose">
                                        <ul class="nav nav-pills nav-justified">
                                            <li><h5><a href="#" class="editCourse" getId="{{$usercreatecourse->course->id}}"><i class="glyphicon glyphicon-edit"></i> Edit</a></h5></li>
                                            <li><h5 style="padding-left: 47px;"><a href="#" class="deleteCourse" getId="{{$usercreatecourse->course->id}}"><i class="glyphicon glyphicon-trash"></i> Delete</h5></a></li>
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
            var course = {};
            course.course_id = getId;
            course._token = '{{ csrf_token() }}';

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
                                                        "<a href=' class='thumbnail'>"+
                                                            "<img src='/"+response.usercreatecourses[i].course.image.path+"' alt='"+response.usercreatecourses[i].course.image.img_name+"' style='height: 240px;' />"+
                                                        "</a>"+
                                                        "<h2>"+response.usercreatecourses[i].course.course_name+"</h2>"+
                                                        "<ul class='nav nav-pills nav-justified'>"+
                                                            "<li><h5><a href='#'><i class='glyphicon glyphicon-user'></i>"+response.usercreatecourses[i].course.enrolls.length+" students enrolled</a></h5></li>"+
                                                            "<li><h5><i class='glyphicon glyphicon-usd'></i>"+response.usercreatecourses[i].course.cost+"</h5></li>"+
                                                        "</ul>"+
                                                    "</div>"+
                                                "</div>"+
                                                "<div class='choose'>"+
                                                    "<ul class='nav nav-pills nav-justified'>"+
                                                        "<li><h5><a href='#'><i class='glyphicon glyphicon-edit'></i> Edit</a></h5></li>"+
                                                        "<li><h5 style='padding-left: 47px;'><a href='#' class='deleteCourse' getId='"+response.usercreatecourses[i].course.id+"'><i class='glyphicon glyphicon-trash'></i> Delete</h5></a></li>"+
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
        });
        
        $('a.editCourse').on('click',function(){
            
            var getId = $(this).attr('getId');
            window.location.href = "/master/edit-course/" + getId;
        });
    </script>
@stop

