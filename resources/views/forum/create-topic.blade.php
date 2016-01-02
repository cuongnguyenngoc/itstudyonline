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
<div class="container main">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    New Topic
                </div>
                <div class="panel-body">
                    <div class="alert alert-success hide" id="message">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <p></p>
                    </div>
                    {!!Form::open(array('route' => 'forum.topic.create',"method" => "POST","id"=>"frm"))!!}
                    {!!Form::hidden('id',null,['id'=>'topic_id'])!!} 
                    <div class="col-lg-6">
                        {!! Form::text('topic_name',null,['id'=>'topic_name' , 'placeholder'=>'What is this discussion about in one of sentence?','class'=>'form-control']) !!}
                    </div>
                    @if(isset($items))
                    <div class="col-lg-6">    
                        {!! Form::select('cate_id',array() + $items,null, ['id' => 'cate_id', 'class' => 'form-control']) !!}
                    </div>
                    @else
                    {!!Form::hidden('enroll_id',$enroll_id,['id'=>'enroll_id'])!!}
                    @endif
                    <div class="col-lg-12">
                        {!! Form::textarea('editor1',null,['id'=>'editor1' ,'rows'=>'5','class'=>'form-control']) !!}
                    </div>
                    <div class = "col-lg-2">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                    {!! Form:: close() !!}
                </div>

                <!--/panel-body-->
            </div>
            <!--/panel-->
            <a href="{{url('forum')}}" class="btn btn-primary btn-sm" style="margin-bottom: 20px;">Back to forum</a>
        </div>
    </div>
</div>
@stop

@section('footer-bottom')
    <footer>
    @include('public.layouts.footer.footer-bottom')
@stop

@section('script')
<script src="{{url('js/forum/ckeditor.js')}}"></script>
<script src="{{url('js/forum/adapters/jquery.js')}}"></script>
<script>

$('document').ready(function () {
    CKEDITOR.replace('editor1', {
        height: 350
    });
    $("#frm").submit(function (e) {
        e.preventDefault();
        var topic = {};
        topic.id = $("#topic_id").val();
        topic.topic_name = $('#topic_name').val();
        topic.token = $("input[name=_token]").val();
        topic.post = CKEDITOR.instances.editor1.getData();
        @if(isset($items))
            topic.cat_id = $('select option:selected').val();
        @else
            topic.enroll_id = $("#enroll_id").val();
        @endif
        
        if(topic.post == '')
            return;
        $.ajax({
            type: "POST",
            url : "{{url('forum/topic/store')}}",
            data: topic,
            success: function (response) {
                $('#message').removeClass('hide');
                $('#message').find('p').text(response.message);
            }
        });
        
    });
});
</script>
@stop
