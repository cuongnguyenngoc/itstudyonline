@extends('public.layouts.app')

@section('css')
    <link href="{{url('css/master/styles.css')}}" rel="stylesheet">
@stop

@section('header-middle')
    @include('disciple.course-learning-header')
@stop

@section('content')

<!-- Main -->
<div class="container main">
    <div class="row">
        <div class="col-md-3" style="padding-right: 0px;">
            <div class="col-md-3">Progress</div>
            <div class="progress">
                <div class="progress-bar col-md-6" id="progress" role="progressbar" aria-valuenow="{{$enroll->process}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$enroll->process}}%;">
                    {{$enroll->process}}%
                </div>
            </div>
            <div class="category-tab"><!--category-tab-->
                <div class="col-sm-12">
                    <ul class="nav nav-tabs" style="margin-bottom: 0px;">
                        <li class="active"><a href="#listlectures" data-toggle="tab"><span class="glyphicon glyphicon-th-list"></span></a></li>
                        <li><a href="#downloadable" data-toggle="tab"><span class="glyphicon glyphicon-download-alt"></span></a></li>
                        <li><a href="#discussion" data-toggle="tab"><span class="glyphicon glyphicon-comment"></span></a></li>
                    </ul>
                </div>
                <input type="hidden" name="course_id" id="course_id" value="{{$enroll->course->id}}">
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="listlectures">
                        <div class="col-sm-12">
                            <ul class="nav nav-pills nav-stacked" style="overflow-y: scroll; height: 629px;">
                                @foreach($enroll->course->lectures()->orderBy('order','asc')->get() as $lecture)
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
                        <div class="col-sm-12" style="margin-bottom: 30px;">
                            <div style="overflow-y: scroll; height: 629px;">
                                This is download
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="discussion">
                        <div class="col-sm-12" style="margin-bottom: 30px;">
                            <div style="overflow-y: scroll; height: 629px;">
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
                                                <div class="col-md-12" style="padding: 0px;margin-top: 10px; padding-bottom: 20px; border-bottom: 1px solid #F0F0E9;"  id="commentCover{{$comment->id}}">
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
        <div class="col-md-9" id="forward" style="padding-left: 0px; margin-top: 20px;">
            <h2 style="text-align: center;" id="lec_name">{{$lecture1->lec_name}}</h2>
            <div class="col-md-12" style="padding-left: 0px; border: 1px solid #F0F0E9; background: #52D449; padding-bottom: 15px;">
                <div class="col-md-4">
                    <a href="#" class="btn btn-primary btn-md {{($previousLecture1) ? null : 'hide'}}" id="previousLecture" getId="{{($previousLecture1)?$previousLecture1->id:null}}">
                        <span class="glyphicon glyphicon-fast-backward"></span> Previous Lecture
                    </a>
                </div>
                <div class="col-md-3 col-md-offset-1" style="padding-left: 0px;">
                    <a href="#forward" class="btn btn-primary btn-md" id="markLecture" getId="{{$lecture1->id}}">
                        @if($enroll->mark($lecture1->id))
                            <span class='glyphicon glyphicon-ok'></span>
                        @else
                            Mark to complete this lecture
                        @endif
                    </a>
                </div>
                <div class="col-md-2 col-md-offset-2">
                    <a href="#" class="btn btn-primary btn-md {{($nextLecture1) ? null : 'hide'}}" id="nextLecture" getId="{{($nextLecture1)?$nextLecture1->id:null}}">
                        Next Lecture <span class="glyphicon glyphicon-fast-forward"></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-9" id="contentLearning" style="padding-left: 0px;">
            
            @if($lecture1->type == 'Text')
                <div style="overflow-y: scroll; height: 561px;">
                    {!!$lecture1->text!!}
                </div>
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
    ul li{
        list-style: disc;
    }
</style>

@stop

@section('footer-bottom')
    <footer>
    @include('public.layouts.footer.footer-bottom')
@stop

@section('script')
    <script type="text/javascript">
        $('.container').addClass('container-fluid').removeClass('container');
        $('#listlectures').find('#lecture{{$lecture1->id}}').parent().addClass('active');
        // $('#listlectures').find('ul li').first().addClass('active');

        $('#listlectures').on('click','li a',function(){
            var getId = $(this).attr('getId');

            $('#listlectures').find('ul li').removeClass('active');
            $(this).parent().addClass('active');

            changeLectureByAjax(getId);
            
        });

        var changeLectureByAjax = function(getId){

            $.ajax({
                type: "POST",
                url : "/course/get-lecture",
                dataType: 'json',
                data: {
                    'course_id': $('#course_id').val(),
                    'lec_id' : getId,
                    'enroll_id' : {{$enroll->id}},
                    '_token' : '{{ csrf_token() }}'
                }, // remember that be must to pass data object type
                beforeSend: function(){
                    NProgress.start();
                },
                complete: function(){
                    NProgress.done();
                },
                error: function(response){
                    NProgress.inc();
                    var n = noty({text: 'Something went wrong??', layout: 'top', type: 'error', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });
                },
                success : function(response){
                    console.log(response);
                    if(response.status){
                        $('#discussion').find('form')
                                        .attr('id','addComment'+response.lecture.id)
                                        .attr('getId',response.lecture.id);
                        $('#discussion').find('textarea')     
                                        .attr('id','contentComment'+response.lecture.id)
                                        .val(null);
                        
                        (response.previousLecture) ? $('#previousLecture').attr('getId',response.previousLecture.id) : $('#previousLecture').attr('getId',null);
                        $('#markLecture').attr('getId',response.lecture.id);
                        if(response.mark)
                            $('#markLecture').html("<span class='glyphicon glyphicon-ok'></span>");
                        else
                            $('#markLecture').html("Mark to complete this lecture");

                        (response.nextLecture)?$('#nextLecture').attr('getId',response.nextLecture.id):$('#nextLecture').attr('getId',null);

                        if(response.lecture.order == 1){
                            $('#previousLecture').addClass('hide');
                        }else{
                            $('#previousLecture').removeClass('hide');
                        }
                        if(response.lecture.order == {{$enroll->course->lectures->count()}}){
                            $('#nextLecture').addClass('hide')
                        }else{
                            $('#nextLecture').removeClass('hide');
                        }

                        if(response.lecture.comments.length > 0){
                            $('#discussion').find('#cmtArea').html("");
                            for(var i = 0; i < response.lecture.comments.length; i++){
                                if(response.lecture.comments[i].user.id == {{Auth::user()->id}}){
                                    $('#discussion').find('#cmtArea').append(
                                        "<div class='col-md-12' style='padding: 0px;margin-top: 10px; padding-bottom: 20px; border-bottom: 1px solid #F0F0E9;' id='commentCover"+response.lecture.comments[i].id+"'>"+
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
                        
                        $('#lec_name').text(response.lecture.lec_name);
                        if(response.lecture.type == 'Text'){
                            $('#contentLearning').html("<div style='overflow-y: scroll; height: 561px;'>"+response.lecture.text+"</div>");
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
        }
        $('#discussion').on('submit','form.add-comment',function(e){
            e.preventDefault();
            $(this).find('button').prepend('<i class="fa fa-refresh fa-spin"></i> ');
            var itself = $(this);
            var getId = $(this).attr('getId');
            var comment = {};
            comment.lec_id = getId;
            comment.comment_id = $('#comment_id'+getId).val();
            comment.content = $('#contentComment'+getId).val();
            comment._token = '{{ csrf_token() }}';

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
                    itself.find('button').children('i').remove();

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
            comment._token = '{{ csrf_token() }}';

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
                            var n = noty({text: 'delete success', layout: 'top', type: 'success', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });
                        }
                    }
                });
            }
        });

        $('#discussion').on('submit','form.form-edit-comment',function(e){

            e.preventDefault();
            $(this).find('button').prepend('<i class="fa fa-refresh fa-spin"></i> ');
            var getId = $(this).attr('getId');
            var getLecId = $(this).attr('getLecId');

            var comment = {};
            comment.lec_id = getLecId;
            comment.comment_id = $('#comment_id'+getLecId+getId).val();
            comment.content = $('#editContentComment'+getLecId+getId).val();
            comment._token = '{{ csrf_token() }}';

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
                    itself.find('button').children('i').remove();

                }
            });
        });

        $('a#previousLecture').on('click',function(){

            var getId = $(this).attr('getId');
            if(getId){
                changeLectureByAjax(getId);
                $('#listlectures').find('ul li').removeClass('active');
                $('#lecture'+getId).parent().addClass('active');
                
            }else{
                $(this).addClass('hide');
            }
        });

        $('a#nextLecture').on('click',function(){

            var getId = $(this).attr('getId');
            if(getId){
                changeLectureByAjax(getId);
                $('#listlectures').find('ul li').removeClass('active');
                $('#lecture'+getId).parent().addClass('active');
                
            }
            else{
                $(this).addClass('hide');
            }
        });

        $('a#markLecture').on('click',function(){
            var getId = $(this).attr('getId');
            var itself = $(this);
            var enroll = {};
            enroll.lec_id = getId;
            enroll.enroll_id = {{$enroll->id}};
            enroll._token = '{{ csrf_token() }}';

            $(this).prepend('<i class="fa fa-refresh fa-spin"></i> ');
            $.ajax({
                type: "POST",
                url : "/lecture/mark-lecture",
                dataType: 'json',
                data: enroll, // remember that be must to pass data object type
                success : function(response){
                    console.log(response);
                    if(response.status){
                        setTimeout(function(){
                            itself.children('i').remove();
                            itself.empty();
                            itself.prepend("<span class='glyphicon glyphicon-ok'></span>");
                        },1000);
                        $('#progress').attr('aria-valuenow',response.enroll.process)
                                      .attr('style','width:'+response.enroll.process+'%')
                                      .text(response.enroll.process+'%');
                        // ;.empty().prepend("<span class='glyphicon glyphicon-ok'></span>");
                    }
                    itself.find('button').children('i').remove();

                }
            });
        });

    </script>
@stop

