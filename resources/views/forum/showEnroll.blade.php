@extends('public.layouts.app')

@section('css')
<link href="{{url('css/forum/styles.css')}}" rel="stylesheet">
@stop

@section('header-top')
@include('public.layouts.header.header-top')
@stop
@section('header-middle')
@include('public.layouts.header.header-middle')
@stop

@section('content')

<!-- Main -->
<div class="container" style="min-height: 500px;">
    <div class="row">
        <a class="btn pull-right btn-default"  type="button" href="{{URL::to('forum/topic/create/'. $id)}}"><span class = "glyphicon glyphicon-plus"> </span> New Topic</a>
    </div>
    <div class = "row">
        <div class="col-md-12">
            <table class="table table-striped " id = "cateList">
                <colgroup>
                    <col style="width:60%">

                    <col style="width:5%">
                    <col style="width:15%">
                </colgroup>  
                <thead>
                    <tr>
                        <th>Topic</th>

                        <th>Replies</th>
                        <th>Activity</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($topics))
                    @foreach($topics as  $value)
                    <tr>
                        <?php
                        $link_topic = url('forum/course') . '/' . urlencode($value['enroll_id']) . '/' . urlencode($value['topicName']);
                        ?>
                        <td style="word-wrap:break-word" class = "category">
                            <div class="category-name">
                                <a href="{{$link_topic}}">{{$value['topicName']}}</a>
                            </div>
                            <div class = "category-desciption">
                                {!!$value['excerp']!!}
                            </div>
                        </td>

                        <td>{{$value['count']}}</td>
                        <td>{{$value['date']}}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            @if(isset($paginate))
            {!! $paginate->render() !!}
            @endif
        </div>
    </div>

</div>

@stop
@section('footer-bottom')
    <footer>
    @include('public.layouts.footer.footer-bottom')
@stop
@section('script')

@stop

