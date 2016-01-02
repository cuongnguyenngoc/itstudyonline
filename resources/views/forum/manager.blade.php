@extends('public.layouts.app')

@section('css')
<!--<link href="{{url('css/master/styles.css')}}" rel="stylesheet">-->
@stop

@section('header-top')
@include('public.layouts.header.header-top')
@stop
@section('header-middle')
@include('public.layouts.header.header-middle')
@stop

@section('content')

<!-- Main -->
<div class="container">
    <div class = "row">
        @include('forum.panel.leftsidebar')
        <div class="col-md-8">
            <table class="table table-striped" id = "cateList">
                <colgroup>
                    <col style="width:60%">
                    <col style="width:10%">
                    <col style="width:10%">
                    <col style="width:10%">
                </colgroup>  
                <thead>
                    <tr>
                        <th>Topic</th>
                        <th>Category</th>
                        <th>Replies</th>
                        <th>Activity</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($topics))
                    @foreach($topics as  $value)
                    <tr>
                        @foreach($value as  $val)
                        <td>{{ $val }}</td>
                        @endforeach
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
<script src="{{url('js/master/scripts.js')}}"></script>
@stop

