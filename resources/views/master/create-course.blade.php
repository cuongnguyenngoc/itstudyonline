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
    @if(Session::has('message'))
        {{print_r(Session::get('message'))}}
    @endif
    <div class="row">
        <div class="col-md-3">
            <div class="list-group" id="task-left">
                @foreach($courseItems as  $key => $values)
                    <a href="#" class="list-group-item disabled">
                        {{$key}}
                    </a>
                    @foreach($values as $id => $value)
                        <a href="#" class="list-group-item list-group-item-success {{$id}}" id="{{$id}}">{{$value}}</a> 
                    @endforeach
                @endforeach
            </div>
        </div>
        <div class="col-md-9">
            @include('master.panel.course-goals-panel')
            @include('master.panel.curriculum-panel')
            @include('master.panel.basics-panel')
            @include('master.panel.course-summary-panel')
        </div>
    </div>
</div>

@stop

@section('footer')
    @include('public.layouts.footer')
@stop

@section('script')
    <script src="{{url('js/master/scripts.js')}}"></script>
    <script type="text/javascript">
        $('.list-group-item-success.course-goals').addClass('active');
        $('div.panel.course-goals').removeClass('hide');

        $('.list-group-item-success').click(function(){
            $('.list-group-item-success').removeClass('active');
            $('div.panel').addClass('hide'); 
            
            if(!$(this).hasClass('course-goals')){
                if($('#course_id').val()==''){
                    $('.list-group-item-success.course-goals').addClass('active');
                    $('div.panel.course-goals').removeClass('hide');
                    alert('you have to create basic course first');
                }else{    
                    $(this).addClass('active');
                    
                    if($('div.panel').hasClass(this.id)){
                        $('div.panel.'+this.id).removeClass('hide');
                    }
                }
            }else{

                $(this).addClass('active');
                $('div.panel.'+this.id).removeClass('hide');
            }
        });
        
    </script>
@stop

