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
<div class="container-fluid main">
    <div class="row">
        <div class="col-sm-3">
            <!-- Left column -->
            <a href="#"><strong><i class="glyphicon glyphicon-wrench"></i> Tools</strong></a>

            <ul class="nav nav-stacked left-sidebar">
                <li class="nav-header"> <a href="#" data-toggle="collapse" data-target="#manage">Manage <i class="glyphicon glyphicon-chevron-right"></i></a>
                    <ul class="nav nav-stacked collapse" id="manage">
                        <li class="active"> <a href="{{url('master/create-course')}}"><i class="glyphicon glyphicon-home"></i> Create Course</a></li>
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
        </div>
        <!-- /col-3 -->
        <div class="col-sm-9">

            <!-- column 2 -->
            <a href="#"><strong><i class="glyphicon glyphicon-dashboard"></i> Introduce Manage</strong></a>
            <hr>
            
            <div class="row">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Course Roadmap
                    </div>
                    <div class="panel-body">
                        <p>This is guide to create course. This is guide to create course. This is guide to create course.This is guide to create course. This is guide to create course. This is guide to create course</p>
                        <p>This is guide to create course. This is guide to create course. This is guide to create course.This is guide to create course. This is guide to create course. This is guide to create course</p>
                        <p>This is guide to create course. This is guide to create course. This is guide to create course.This is guide to create course. This is guide to create course. This is guide to create course</p>
                        <p>This is guide to create course. This is guide to create course. This is guide to create course.This is guide to create course. This is guide to create course. This is guide to create course</p>
                        <p>This is guide to create course. This is guide to create course. This is guide to create course.This is guide to create course. This is guide to create course. This is guide to create course</p>
                        <p>This is guide to create course. This is guide to create course. This is guide to create course.This is guide to create course. This is guide to create course. This is guide to create course</p>
                        <p>This is guide to create course. This is guide to create course. This is guide to create course.This is guide to create course. This is guide to create course. This is guide to create course</p>
                        <p>This is guide to create course. This is guide to create course. This is guide to create course.This is guide to create course. This is guide to create course. This is guide to create course</p>
                        <p>This is guide to create course. This is guide to create course. This is guide to create course.This is guide to create course. This is guide to create course. This is guide to create course</p>
                        <p>This is guide to create course. This is guide to create course. This is guide to create course.This is guide to create course. This is guide to create course. This is guide to create course</p>
                        <p>This is guide to create course. This is guide to create course. This is guide to create course.This is guide to create course. This is guide to create course. This is guide to create course</p>
                        <p>This is guide to create course. This is guide to create course. This is guide to create course.This is guide to create course. This is guide to create course. This is guide to create course</p>
                        <p>This is guide to create course. This is guide to create course. This is guide to create course.This is guide to create course. This is guide to create course. This is guide to create course</p>

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
@stop

