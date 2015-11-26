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
    <div class="row">
        <div class="col-md-3 col-md-offset-9">
            <div class="col-md-6">
                <h5> Master</h5>
                <a href="#">
                    {{$course->usercreatecourse->user->fullname}}
                </a>
            </div>
            <a href="{{url('user/'.$course->usercreatecourse->user->id)}}" class="col-md-6">
                <img class="img-circle" src="{{($course->usercreatecourse->user->image)?url($course->usercreatecourse->user->image->path):'/images/it_me.jpg'}}" height="100px" />
            </a>   
        </div>
        <div class="col-md-3">
            <div class="category-tab"><!--category-tab-->
                <div class="col-sm-12">
                    <ul class="nav nav-tabs" style="margin-bottom: 0px;">
                        <li class="active"><a href="#listlectures" data-toggle="tab"><span class="glyphicon glyphicon-th-list"></span></a></li>
                        <li><a href="#downloadable" data-toggle="tab"><span class="glyphicon glyphicon-download-alt"></span></a></li>
                        <li><a href="#discussion" data-toggle="tab"><span class="glyphicon glyphicon-comment"></span></a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="listlectures">
                        <div class="col-sm-12">
                            <ul class="nav nav-pills nav-stacked" style="overflow-y: scroll">
                                @foreach($course->lectures as $lecture)
                                    <li role="presentation">
                                        <a href="#" style="text-transform: none;" getId="{{$lecture->id}}" id="lecture{{$lecture->id}}">
                                            <span class="glyphicon glyphicon-adjust"></span> Lecture {{$lecture->order}}: {{$lecture->lec_name}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="downloadable">
                        <div class="col-sm-12">
                            this is download
                        </div>
                    </div>
                    <div class="tab-pane fade" id="discussion">
                        <div class="col-sm-12">
                            <div style="overflow-y: scroll">
                                <div class="form-add-comment col-md-12" style="padding: 0px; margin-top: 15px;">
                                    <img src="/{{(Auth::user()->image)? Auth::user()->image->path:'images/it_me.jpg'}}" class="col-md-1 img-circle" style="padding: 0px;">
                                    <form id="addComment{{$lecture1->id}}" getId="{{$lecture1->id}}" class="col-md-11 add-comment" style="padding: 0px;">
                                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                        <textarea id="contentComment{{$lecture1->id}}" style="width: 100%; overflow-y: none" class="form-control"s placeholder="You need to discussion about content which related this lecture to other people can help you or talking to you"></textarea>
                                        <button type="submit" class="btn btn-primary btn-md"> Post</button>
                                    </form>
                                </div>
                                <div class="cmtArea col-md-12" style="padding: 0px;margin-top: 20px;" id="cmtArea">
                                    @if($lecture1->comments->count() != 0)
                                        @foreach($lecture1->comments as $comment)
                                            @if($comment->user->id == Auth::user()->id)
                                                <div class="col-md-12" style="padding: 0px;margin-top: 10px; padding-bottom: 20px; border-bottom: 1px solid #F0F0E9;">
                                                    <img src="/{{($comment->user->image)? $comment->user->image->path:'images/it_me.jpg'}}" class="col-md-1 img-circle" style="padding: 0px;">
                                                    <div class="col-md-11" style="padding: 0px;">
                                                        <a href="#" class="col-md-8">
                                                            {{$comment->user->fullname}}
                                                        </a>
                                                        <a href='#discussion' class='col-md-1 editComment' id='editComment{{$lecture1->id.$comment->id}}' getLecId='{{$lecture1->id}}' getId='{{$comment->id}}'>
                                                            <span class='glyphicon glyphicon-edit'></span>
                                                        </a>
                                                        <a href='#discussion' class='col-md-1 delComment' id='delComment{{$lecture1->id.$comment->id}}' getLecId='{{$lecture1->id}}' getId='{{$comment->id}}'>
                                                            <span class='glyphicon glyphicon-trash'></span>
                                                        </a>
                                                        <div class="col-md-12" id='showContentCmt{{$lecture1->id.$comment->id}}'>
                                                            {{$comment->content}}
                                                        </div>  
                                                        <form class='form-edit-comment col-md-11 hide' id='formEditComment{{$lecture1->id.$comment->id}}' getLecId='{{$lecture1->id}}' getId='{{$comment->id}}' style='padding: 0px;'>
                                                            <input type='hidden' name='_token' value='{!! csrf_token() !!}'>
                                                            <input type='hidden' name='comment_id' id='comment_id{{$lecture1->id.$comment->id}}' value='"+response.comment.id+"'>
                                                            <textarea id='editContentComment{{$lecture1->id.$comment->id}}' style='width: 100%; overflow-y: none' class='form-control'>{{$comment->content}}</textarea>
                                                            <button type='submit' class='btn btn-primary btn-sm' style='margin-top: 5px;'> Post</button> Or <a href='#discussion' class='cancel' id='cancel{{$lecture1->id.$comment->id}}' getLecId='{{$lecture1->id}}' getId='{{$comment->id}}'> Cancel</a>
                                                        </form>                                                     
                                                    </div>
                                                </div> 
                                            @else
                                                <div class="col-md-12" style="padding: 0px;margin-top: 10px; padding-bottom: 20px; border-bottom: 1px solid #F0F0E9;">
                                                    <img src="/{{($comment->user->image)? $comment->user->image->path:'images/it_me.jpg'}}" class="col-md-1 img-circle" style="padding: 0px;">
                                                    <div class="col-md-11" style="padding: 0px;">
                                                        <a href="#" class="col-md-12">
                                                            {{$comment->user->fullname}}
                                                        </a>
                                                        <div class="col-md-12">
                                                            {{$comment->content}}
                                                        </div>                                                    
                                                    </div>
                                                </div>
                                            @endif         
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--/category-tab-->
        </div>
        <div class="col-md-8" id="contentLearning">
            @if($lecture1->type == 'Text')
                {{$lecture1->text}}
            @elseif($lecture1->type == 'Video')
                <div class="embed-responsive embed-responsive-16by9">
                    <video class="embed-responsive-item" controls="controls" preload="auto">
                        <source src="/{{$lecture1->video->path}}" type="video/mp4">
                        Your browser does not support HTML5 video.
                    </video>
                </div>
            @else
                <div class="embed-responsive embed-responsive-16by9">
                    <embed src='/{{$lecture1->document->path}}' type='application/pdf'/>
                </div>
            @endif
        </div>
    </div>
</div>
<style type="text/css">
    .lecture{
        padding: 10px;
        padding-left: 0px;
        border-bottom: 1px solid #F0F0E9;   
        background: #0C9A14;
        margin-left: 0px;
    }
</style>

@stop

@section('footer-bottom')
    @include('public.layouts.footer.footer-bottom')
@stop

@section('script')
    <script type="text/javascript">
        $('.container').addClass('container-fluid').removeClass('container');

        $('#listlectures').on('click','li a',function(){
            var getId = $(this).attr('getId');
            $.ajax({
                type: "POST",
                url : "/course/get-lecture",
                dataType: 'json',
                data: {'lec_id' : getId}, // remember that be must to pass data object type
                success : function(response){
                    console.log(response);
                    if(response.status){
                        $('#discussion').find('form')
                                        .attr('id','addComment'+response.lecture.id)
                                        .attr('getId',response.lecture.id);
                        $('#discussion').find('textarea')     
                                        .attr('id','contentComment'+response.lecture.id)
                                        .val(null);

                        if(response.lecture.comments.length > 0){
                            $('#discussion').find('#cmtArea').html("");
                            for(var i = 0; i < response.lecture.comments.length; i++){
                                if(response.lecture.comments[i].user.id == response.user.id){
                                    $('#discussion').find('#cmtArea').append(
                                        "<div class='col-md-12' style='padding: 0px;margin-top: 10px; padding-bottom: 20px; border-bottom: 1px solid #F0F0E9;'>"+
                                            "<img src='/"+response.lecture.comments[i].user.image.path+"' class='col-md-1 img-circle' style='padding: 0px;'>"+
                                            "<div class='col-md-11' style='padding: 0px;'>"+
                                                "<a href='#' class='col-md-8'>"
                                                    +response.lecture.comments[i].user.fullname+
                                                "</a>"+
                                                "<a href='#discussion' class='col-md-1 editComment' id='editComment"+response.lecture.id+response.lecture.comments[i].id+"' getLecId='"+response.lecture.id+"' getId='"+response.lecture.comments[i].id+"'>"+
                                                    "<span class='glyphicon glyphicon-edit'></span>"+
                                                "</a>"+
                                                "<a href='#discussion' class='col-md-1 delComment' id='delComment"+response.lecture.id+response.lecture.comments[i].id+"' getLecId='"+response.lecture.id+"' getId='"+response.lecture.comments[i].id+"'>"+
                                                    "<span class='glyphicon glyphicon-trash'></span>"+
                                                "</a>"+
                                                "<div class='col-md-12' id='showContentCmt"+response.lecture.id+response.lecture.comments[i].id+"'>"
                                                    +response.lecture.comments[i].content+
                                                "</div> "+    
                                                "<form class='form-edit-comment col-md-11 hide' id='formEditComment"+response.lecture.id+response.lecture.comments[i].id+"' getLecId='"+response.lecture.id+"' getId='"+response.lecture.comments[i].id+"' style='padding: 0px;'>"+
                                                    "<input type='hidden' name='_token' value='{!! csrf_token() !!}'>"+
                                                    "<input type='hidden' name='comment_id' id='comment_id"+response.lecture.id+response.lecture.comments[i].id+"' value='"+response.lecture.comments[i].id+"'>"+
                                                    "<textarea id='editContentComment"+response.lecture.id+response.lecture.comments[i].id+"' style='width: 100%; overflow-y: none' class='form-control'>"+response.lecture.comments[i].content+"</textarea>"+
                                                    "<button type='submit' class='btn btn-primary btn-sm' style='margin-top: 5px;'> Post</button> Or <a href='#discussion' class='cancel' id='cancel"+response.lecture.id+response.lecture.comments[i].id+"' getLecId='"+response.lecture.id+"' getId='"+response.lecture.comments[i].id+"'> Cancel</a>"+
                                                "</form>"+                                               
                                            "</div>"+
                                        "</div>" 
                                    );
                                }else{
                                    $('#discussion').find('#cmtArea').append(
                                        "<div class='col-md-12' style='padding: 0px;margin-top: 10px; padding-bottom: 20px; border-bottom: 1px solid #F0F0E9;'>"+
                                            "<img src='/"+response.lecture.comments[i].user.image.path+"' class='col-md-1 img-circle' style='padding: 0px;'>"+
                                            "<div class='col-md-11' style='padding: 0px;'>"+
                                                "<a href='#' class='col-md-8'>"
                                                    +response.lecture.comments[i].user.fullname+
                                                "</a>"+
                                                "<div class='col-md-12'>"
                                                    +response.lecture.comments[i].content+
                                                "</div> "+                                              
                                            "</div>"+
                                        "</div>" 
                                    );
                                }
                            }
                        }else{
                            $('#discussion').find('#cmtArea').html(
                                ""
                            );
                        }
                        
                        if(response.lecture.type == 'Text'){
                            $('#contentLearning').html(response.lecture.text);
                        }else if(response.lecture.type == 'Video'){
                            $('#contentLearning').html(
                                "<div class='embed-responsive embed-responsive-16by9'>"+
                                    "<video class='embed-responsive-item' controls='controls' preload='auto'>"+
                                        "<source src='/"+response.lecture.video.path+"' type='video/mp4'>"+
                                        "Your browser does not support HTML5 video."+
                                    "</video>"+
                                "</div>"
                            );
                        }else{
                            $('#contentLearning').html(
                                "<div class='embed-responsive embed-responsive-16by9'>"+
                                    "<embed src='/"+response.lecture.document.path+"' type='application/pdf'/>"+
                                "</div>"
                            );
                        }
                    }
                }
            });
        });

        $('#discussion').on('submit','form.add-comment',function(e){
            e.preventDefault();
            var getId = $(this).attr('getId');
            var comment = {};
            comment.lec_id = getId;
            comment.comment_id = $('#comment_id'+getId).val();
            comment.content = $('#contentComment'+getId).val();
            $.ajax({
                type: "POST",
                url : "/lecture/add-comment",
                dataType: 'json',
                data: comment, // remember that be must to pass data object type
                success : function(response){
                    console.log(response);
                    if(response.status){
                        $('#cmtArea').prepend(
                            "<div class='col-md-12' style='padding: 0px;margin-top: 10px; padding-bottom: 20px; border-bottom: 1px solid #F0F0E9;' id='commentCover"+response.comment.id+"'>"+
                                "<img src='/"+response.user.image.path+"' class='col-md-1 img-circle' style='padding: 0px;'>"+
                                "<div class='col-md-11' style='padding: 0px;'>"+
                                    "<a href='#' class='col-md-8'>"
                                        +response.user.fullname+
                                    "</a>"+
                                    "<a href='#discussion' class='col-md-1 editComment' id='editComment"+response.comment.lecture.id+response.comment.id+"' getLecId='"+response.comment.lecture.id+"' getId='"+response.comment.id+"'>"+
                                        "<span class='glyphicon glyphicon-edit'></span>"+
                                    "</a>"+
                                    "<a href='#discussion' class='col-md-1 delComment' id='delComment"+response.comment.lecture.id+response.comment.id+"' getLecId='"+response.comment.lecture.id+"' getId='"+response.comment.id+"'>"+
                                        "<span class='glyphicon glyphicon-trash'></span>"+
                                    "</a>"+
                                    "<div class='col-md-12' id='showContentCmt"+response.comment.lecture.id+response.comment.id+"'>"
                                        +response.comment.content+
                                    "</div>"+
                                    "<form class='form-edit-comment col-md-11 hide' id='formEditComment"+response.comment.lecture.id+response.comment.id+"' getLecId='"+response.comment.lecture.id+"' getId='"+response.comment.id+"' style='padding: 0px;'>"+
                                        "<input type='hidden' name='_token' value='{!! csrf_token() !!}'>"+
                                        "<input type='hidden' name='comment_id' id='comment_id"+response.comment.lecture.id+response.comment.id+"' value='"+response.comment.id+"'>"+
                                        "<textarea id='editContentComment"+response.comment.lecture.id+response.comment.id+"' style='width: 100%; overflow-y: none' class='form-control'>"+response.comment.content+"</textarea>"+
                                        "<button type='submit' class='btn btn-primary btn-sm' style='margin-top: 5px;'> Post</button> Or <a href='#discussion' class='cancel' id='cancel"+response.comment.lecture.id+response.comment.id+"' getLecId='"+response.comment.lecture.id+"' getId='"+response.comment.id+"'> Cancel</a>"+
                                    "</form>"+                                                  
                                "</div>"+
                            "</div>"   
                        );
                    }
                }
            });
        });

        $('#discussion').on('click','a.editComment',function(){
            
            var getId = $(this).attr('getId');
            var getLecId = $(this).attr('getLecId');

            $('form#formEditComment'+getLecId+getId)
                .removeClass('hide')
                .find('textarea').focus();
            $('#showContentCmt'+getLecId+getId).addClass('hide');
            $('a#editComment'+getLecId+getId).addClass('hide');
            $('a#delComment'+getLecId+getId).addClass('hide');
        });

        $('#discussion').on('click','a.cancel',function(){
            
            var getId = $(this).attr('getId');
            var getLecId = $(this).attr('getLecId');

            $('form#formEditComment'+getLecId+getId)
                .addClass('hide');
            $('#showContentCmt'+getLecId+getId).removeClass('hide');
            $('a#editComment'+getLecId+getId).removeClass('hide');
            $('a#delComment'+getLecId+getId).removeClass('hide');
        });

        $('#discussion').on('click','a.delComment',function(){
            
            var getId = $(this).attr('getId');
            var getLecId = $(this).attr('getLecId');
            var comment = {};
            comment.comment_id = getId;
            var r = confirm('Do you wanna delete this comment?');
            if (r == true) {

                $.ajax({
                    type: "POST",
                    url : "/lecture/delete-comment",
                    dataType: 'json',
                    data: comment, // remember that be must to pass data object type
                    success : function(response){
                        console.log(response);
                        if(response.status){
                            $('#commentCover'+getId).remove();
                        }
                    }
                });
            }
        });

        $('#discussion').on('submit','form.form-edit-comment',function(e){

            e.preventDefault();
            var getId = $(this).attr('getId');
            var getLecId = $(this).attr('getLecId');

            var comment = {};
            comment.lec_id = getLecId;
            comment.comment_id = $('#comment_id'+getLecId+getId).val();
            comment.content = $('#editContentComment'+getLecId+getId).val();
            var itself = $(this);
            $.ajax({
                type: "POST",
                url : "/lecture/add-comment",
                dataType: 'json',
                data: comment, // remember that be must to pass data object type
                success : function(response){
                    console.log(response);
                    if(response.status){
                        $('#showContentCmt'+getLecId+getId).html(response.comment.content).removeClass('hide');
                        $('#editContentComment'+getLecId+getId).val(response.comment.content);
                        itself.addClass('hide');
                        $('#editComment'+getLecId+getId).removeClass('hide');
                        $('#delComment'+getLecId+getId).removeClass('hide');
                    }
                }
            });
        });

    </script>
@stop

