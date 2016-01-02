
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
<div class="container main">
    <div class="row">
        <div class="col-sm-3">
            <!-- Left column -->
            <ul class="side-nav" id="sideUser">
                <img src="/{{Auth::user()->image->path}}" width="150" height="150" style="display:inline-block;border: 1px solid #ddd;padding: 4px;margin-top:10px;" />
                <h5>{{ Auth::user()->fullname }}</h5>
                <li style=""> <a href="{{ route('user.editprofile') }}" class="list-group-item ">Profile</a>
                </li>
                <li > <a href="{{ url('user/addphoto') }}" class="list-group-item "> Avatar</a>
                </li>
                <li><a href="{{ url('user/changepassword') }}" class="list-group-item "> ChangePassword</a>
                </li>
            </ul>
            <hr>
        </div>
        <!-- /col-3 -->
        <div class="col-sm-9">
            <!-- column 2 -->
            <div class="col-md-9">
                <h2 style="text-align:center"><i></i>Photo</h2>
                <p style="text-align:center; font-size:15px">Add a Photo for your profile</p>
                @include('user.uploadphoto')
            </div>
        </div>
    </div>            
</div>
@stop

@section('footer-bottom')
    <footer>
    @include('public.layouts.footer.footer-bottom')
@stop

@section('script')
    <script src="{{url('js/master/scripts.js')}}"></script>
@stop