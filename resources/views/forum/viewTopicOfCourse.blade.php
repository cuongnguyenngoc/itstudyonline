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
<div class="container main">

    <div class="row">
        <div class="col-md-8 col-md-push-2 news-show">	
            <div class="news-showtitle mt10">
                <strong class="cat-name">
                    <?php $link_cat = url('forum/course') . "/" . urlencode($result['course_id']); ?>
                    <a href="{{$link_cat}}">{{$result['course_id']}}</a>
                </strong>
                <h1>
                    <p>{{$result['subject']}} </p>
                </h1>
                @if($result['isEdit'])
                <div class="dropdown" style="float: right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-chevron-down" style="font-size: 10px"></span></a>
                    <ul class="dropdown-menu">
                        <?php
                        $editLink = $_SERVER['REQUEST_URI'] . '/edit';
                        $deleteLink = $_SERVER['REQUEST_URI'] . '/delete';
                        ?>
                        <li><a href="{{$editLink}}">Edit... </a></li>
                        <li><a href="{{$deleteLink}}">Delete</a></li>
                    </ul>
                </div>
                @endif
                <div class="clearfix">
                    <div class="note fl">
                        <span class="glyphicon glyphicon-user" style="size: 15px;"></span><a href="#">{{$result['user']}}</a> | {{$result['date']}}
                    </div>
                </div>
            </div>

            <div class="content clearfix">
                <div id="ContentDetail">
                    {!!$result['content']!!}
                </div>
            </div>

            <div id="TotalAssessment">
                <!--Ming Comment-->

                <div class="comentvietid">
                    @if(isset($result['cuName']))
                    <div class="panel-body form-comment">
                        <div class = "row" id = "form_post_comment" >
                            <div><img src = "/images/forum/user-def.png" width="48px" height="48px"/></div>
                            <div class="text-box">
                                <textarea style="height: 48px;" id="txtComment" placeholder="write a comment..."></textarea>
                            </div>
                            <input type="hidden" id = "idTopic" value = "{{$result['idTopic']}}"/>
                        </div>
                        <div class = "row send-box p-lr">
                            <input class="btn btn-primary" type="button" id ="submitComment" value="Gửi bình luận" />
                        </div>
                    </div>
                    @endif

                    <div class="border-nobottom"></div>
                    <div class="bar">
                        {{$result['repCount']}} Bình luận
                        <input type="hidden" id = "repCount" value = "{{$result['repCount']}}"/>
                    </div>

                    <div class=" row col-md-12" data-example-id="default-media"> 
                        @foreach ($result['replies'] as $item)
                        <div class="media"> 
                            <div class="media-left"> 
                                <a href="#"> <img data-holder-rendered="true" src="/images/forum/user-def.png" style="width: 48px; height: 48px;" class="media-object" data-src="holder.js/64x64" alt="64x64"> </a> 
                            </div> 
                            <div class="media-body">
                                <h4 class="media-heading">{{$item->rep_by}} <span>·</span> {{$item->rep_date}}</h4>
                                {!!$item->rep_content !!}
                                <div class = "co-action" style="margin-top: 5px;">
                                    <a href = "#" class = "reply-comment" id = "{{$item->id}}" style="color: blue; font-size: 12px">Reply</a>
                                </div>
                                @if($item->subReply->count() >0)
                                @foreach($item->subReply as $sub)
                                <div class="media"> 
                                    <div class="media-left">
                                        <a href="#"> <img data-holder-rendered="true" src="/images/forum/user-def.png" style="width: 32px; height: 32px;" class="media-object" alt="48x48"> 
                                        </a> 
                                    </div>
                                    <div class="media-body"> 
                                        <h4 class="media-heading">{{\App\User::find($sub->rep_by)->fullname}} <span>·</span> {{\Carbon\Carbon::parse($sub->rep_date)->format("M d,Y")}}</h4>
                                       {!!$sub->rep_content !!}
                                    </div> 
                                </div> 
                                @endforeach
                                @endif
                            </div> 
                        </div> 
                        @endforeach

                    </div>
                    
                </div> 
             
            </div>
        </div>



        @stop
@section('footer-bottom')
    <footer>
    @include('public.layouts.footer.footer-bottom')
@stop
        @section('script')
        <script>
            $(document).ready(function () {
                $("textarea#txtComment").keyup(function (e) {
                    $(this).height(15);
                    $(this).height(this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth")));
                });

                $(".reply-comment").click(function () {
                    var id = $(this).attr('id');
                    $(this).after('<div class="media" id = "me' + id + '">' +
                            '<div class="media-left">' +
                            '<a href="#"> <img data-holder-rendered="true" src="/images/forum/user-def.png" style="width: 32px; height: 32px;" class="media-object" />' +
                            '</a>' +
                            '</div>' +
                            '<div class="media-body" style = "overflow:auto">' +
                            '<div class="text-box"> ' +
                            '<textarea style="height: 48px;" id="txtReply" placeholder="add a reply..."></textarea> ' +
                            '</div> ' +
                            '<div class = "row send-box p-lr"> ' +
                            '<input class="btn btn-primary cancelReply" type="button" id ="' + id + '" value = "Cancel"/>' +
                            '<input class="btn btn-primary submitReply" type="button" id ="' + id + '" value="Gửi bình luận" />' +
                            '</div> ' +
                            '</div>' +
                            '</div>');
                    return false;
                });


                $('input#submitComment').click(function (e) {
                    if ($("textarea#txtComment").val() == '')
                        return;
                    e.preventDefault();
                    var rep = {};
                    var text = $("textarea#txtComment").val();
                    text = text.replace(/\r\n|\r|\n/g, "<br/>");
                    rep.content = text;
                    rep.idTopic = $("input#idTopic").val();
                    $.ajax({
                        type: "POST",
                        url:"{{url('forum/reply/store')}}",
                        data: rep,
                        dataType: 'json',
                        success: function (response) {
                            $("textarea#txtComment").val("");
                            location.reload();
                        }
                    });
                });

                $(document).on("click", ".cancelReply", function () {
                    var divP = "div#me" + $(this).attr('id');
                    $(divP).remove();
                });
                $(document).on("click", ".submitReply", function (e) {
                    if ($("textarea#txtReply").val() == '')
                        return;
                    e.preventDefault();
                    var rep = {};
                    var text = $("textarea#txtReply").val();
                    text = text.replace(/\r\n|\r|\n/g, "<br/>");
                    rep.content = text;
                    rep.idTopic = $("input#idTopic").val();
                    rep.idParent = $(this).attr('id');
                    $.ajax({
                        type: "POST",
                        url: "{{url('forum/reply/store')}}",
                        data: rep,
                        dataType: 'json',
                        success: function (response) {
                            $("textarea#txtReply").val("");
                            location.reload();
                        }
                    });
                });

            });
        </script>
        @stop

