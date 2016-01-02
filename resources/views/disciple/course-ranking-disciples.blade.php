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
<div class="container main" style="min-height: 350px;">
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-4">
                    <div class="list-group">
                        <a href="#" class="list-group-item active">
                            RANK DISCIPLE'S COURSE LEARNING RESULT
                        </a>
                        @foreach ($enrolls as $enroll)
                            <a href='javascript:void(0)' getId="{{$enroll->course->id}}" class='list-group-item'>{{$enroll->course->course_name}}</a>
                        @endforeach
                    </div>
                </div><!-- /.col-sm-4 -->
                <div class="col-md-8">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">RANK OF COURSE {{$enrolls->first()->course->course_name}}</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Rank order</th>
                                        <th>Student name</th>
                                        <th>Number of wrong answers</th>
                                        <th>Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($enrolls->first()->course->enrolls()->orderBy('score','desc')->get() as $enroll)
                                        <tr>
                                            <td>{{$order}}</td>
                                            <td>{{$enroll->user->fullname}}</td>
                                            <th>{{$enroll->}}
                                            <td>{{$enroll->score}}</td>
                                        </tr>
                                        <span class="hide">{{$order++}}</span>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('footer-bottom')
    @include('public.layouts.footer.footer-bottom')
@stop

@section('script')
    <script type="text/javascript">
        
    </script>
@stop

