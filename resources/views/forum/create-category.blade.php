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
            <div class="panel panel-info course-goals">
                <div class="panel-heading">
                    New Category 
                </div>
                <div class="panel-body">
                    <div class="alert alert-success hide" id="message">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <p></p>
                    </div>
<!--                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif-->
                    {!!Form::open(array('route' => 'forum.cate.create',"method" => "POST","id"=>"frm"))!!}
                    {!!Form::hidden('id',null,['id'=>'cat_id'])!!} 
                    <div class="form-group">
                        <label for="Category-name">Category name</label>
                        {!! Form::text('cat_name',null,['id'=>'cat_name' , 'placeholder'=>'Enter category name','class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <label for="description">Description for your category</label>
                        {!! Form::textarea('cat_des',null,['id'=>'cat_des' ,'rows'=>'5','class'=>'form-control']) !!}
                    </div>
                     <button type="submit" class="btn btn-default">Submit</button>
                    {!! Form:: close() !!}
                </div>

                <!--/panel-body-->
            </div>
            <!--/panel-->
        </div>
    </div>
</div>
@stop

@section('footer')
@include('public.layouts.footer')
@stop

@section('script')
<script>
    $('document').ready(function () {
        $("#frm").submit(function (e) {
            e.preventDefault();
            var cat = {};
            cat.id = $("#cat_id").val();
            cat.cat_name = $('#cat_name').val();
            alert(escape($('#cat_name').val()));
            cat.cat_des = $('#cat_des').val();
            cat.token = $("input[name=_token]").val();
            $.ajax({
                type: "POST",
                url: 'store',
                data: cat,
                dataType : 'json',
                success: function (response) {
                    $('#message').removeClass('hide');
                    $('#message').find('p').text(response.message);
                }
            });
        });
    });
</script>
@stop
