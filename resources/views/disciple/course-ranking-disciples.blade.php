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
<div class="container main" style="min-height: 500px;">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <div class="list-group">
                        <a href="#" class="list-group-item active disabled">
                            RANK DISCIPLE'S COURSE LEARNING RESULT
                        </a>
                        @foreach ($usercreatecourses as $usercreatecourse)
                            <a href='javascript:void(0)' getId="{{$usercreatecourse->course->id}}" class='list-group-item list-courses' style="background: {{($course->id==$usercreatecourse->course->id)?'#121212':''}}">
                                {{$usercreatecourse->course->course_name}}
                            </a>
                        @endforeach
                    </div>
                </div><!-- /.col-sm-4 -->
                <div class="col-md-8">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">RANK OF COURSE {{$course->course_name}}</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered" id="tableRank">
                                <thead>
                                    <tr>
                                        <th>Rank order</th>
                                        <th>Student name</th>
                                        <th>Number of wrong answers</th>
                                        <th>Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($course->enrolls()->orderBy('score','desc')->get() as $enroll)
                                        <tr>
                                            <td>{{$order}}</td>
                                            <td>{{$enroll->user->fullname}}</td>
                                            <th>{{$enroll->course->numWrongAnswerInQuizs()}}
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
        $('.list-courses').click(function(e){
            $('.list-courses').css('background','#fff');
            $(this).css('background','#121212');
            var getId = $(this).attr('getId');
            $.ajax({
                type: "POST",
                url : "/disciple/get-rank",
                dataType: 'json',
                data: {getId}, // remember that be must to pass data object type
                success : function(response){
                    console.log(response);
                    if(response.status){
                        $('#tableRank').find('tbody').empty();
                        for(var i=0; i<response.enrolls.length;i++){
                            $('#tableRank').find('tbody').append(
                                '<tr>'+
                                    '<td>'+(i+1)+'</td>'+
                                    '<td>'+response.enrolls[i].user.fullname+'</td>'+
                                    '<td>'+response.enrolls[i].course.numberwrong+'</td>'+
                                    '<td>'+response.enrolls[i].score+'</td>'+
                                '</tr>'
                            );
                        }
                    }

                }
            });
        });
    </script>
@stop

