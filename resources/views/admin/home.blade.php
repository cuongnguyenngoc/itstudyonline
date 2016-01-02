@extends('public.layouts.app')

@section('header-top')
    @include('public.layouts.header.header-top')
@stop
@section('header-middle')
    @include('public.layouts.header.header-middle')
@stop

@section('content')
<div class="container main fluid" style="min-height: 500px;">
    <div class="row">
        <nav class="navbar navbar-default no-margin">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header fixed-brand">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"  id="menu-toggle">
                  <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>
              </button>
              <a class="navbar-brand" href="#"><i class="fa fa-rocket fa-4"></i> ADMIN</a>
          </div><!-- navbar-header-->
        </nav>
        <ul class="sidebar-nav nav-pills nav-stacked col-md-3" id="menu" style="background: #545454">
            <li>
                <a href="{{route('admin.courseManage')}}"><span class="fa-stack fa-lg pull-left"><i class="fa fa-dashboard fa-stack-1x "></i></span> Courses</a>
                <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                    <li class="{{($url=='admin/courseManage')?'active':''}}"><a href="{{route('admin.courseManage')}}">Manage</a></li>
                    <li class="{{($url=='admin/courseControl')?'active':''}}"><a href="{{route('admin.courseControl')}}">Control</a></li>
                </ul>
            </li>
            <li class="{{($url=='admin/roleManage')?'active':''}}">
                <a href="{{route('admin.roleManage')}}"><span class="fa-stack fa-lg pull-left"><i class="fa fa-flag fa-stack-1x "></i></span> Management Users</a>
            </li>
            <li class="{{($url=='admin/forumManage')?'active':''}}">
                <a href="{{route('admin.forumManage')}}"><span class="fa-stack fa-lg pull-left"><i class="fa fa-youtube-play fa-stack-1x "></i></span>Management Forum</a>
            </li>
            <li class="{{($url=='admin/categoryManage')?'active':''}}">
                <a href="{{route('admin.categoryManage')}}"><span class="fa-stack fa-lg pull-left"><i class="fa fa-server fa-stack-1x "></i></span>Management Category</a>
            </li>
            <li class="{{($url=='admin/language')?'active':''}}">
                <a href="{{route('admin.languageManage')}}"><span class="fa-stack fa-lg pull-left"><i class="fa fa-server fa-stack-1x "></i></span>Management Langugages</a>
            </li>
        </ul>
        <!-- Page Content -->
        <div class="col-md-9">
            <div class="row">
                <div class="col-lg-12">
                    @yield('admin-content')
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('footer-bottom')
    @include('public.layouts.footer.footer-bottom')
@stop

@if(session('status'))
    @section('script')
        <script type="text/javascript">
            $(document).ready(function(){
                var n = noty({text: "{{ session('status') }}", layout: 'top', type: 'success', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:3000 });
            });
        </script> 
    @stop 
@endif 