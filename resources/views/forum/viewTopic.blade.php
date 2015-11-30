@extends('public.layouts.app')

@section('css')
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
    <div class = "row">
        <div class = "col-md-8">
            <h1>{{$result['subject']}}<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></h1>
            <small>{{$result['cate']}}</small>
            <hr/>
            <p>{{$result['user']}}</p>
            <p>{{$result['date']}}</p>
            <p>{!!$result['content']!!}</p>
            <div> 
            </div>
        </div>
    </div>

    <!-- Trigger the modal with a button -->

    <!-- Modal -->
    
</div>

@stop

@section('script')

@stop

