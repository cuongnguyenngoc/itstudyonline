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
<div class="container main" style="min-height: 500px;">

    <div class="row">
        <div class="col-md-8 col-md-push-2 news-show">	
            <div class="news-showtitle mt10">
                <strong class="cat-name">
                    <?php $link_cat = url('forum/category') . "/" . urlencode($result['cate']); ?>
                    <a href="{{$link_cat}}">{{$result['cate']}}</a>
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
                        <span class="glyphicon glyphicon-user" style="size: 15px;"></span>{{$result['user']}} | {{$result['date']}}
                    </div>
                </div>
            </div>

            <div class="content clearfix">
                <div id="ContentDetail">
                    {!!$result['content']!!}
                </div>
            </div>
            @if(Auth::check())
            <div id="TotalAssessment">
                <!--Ming Comment-->

                <div class="comentvietid">
                    @if(isset($result['cuName']))
                    <div class="panel-body form-comment">
                        <div class = "row" id = "form_post_comment" >
                            <div><img src = "{{url(\App\Image::where('user_id', '=', Auth::user()->id)->get()->first()->path)}}" width="48px" height="48px"/></div>
                            <div class="text-box">
                                <textarea style="height: 48px;" id="txtComment" placeholder="write a comment..."></textarea>
                            </div>
                            <input type="hidden" id = "idTopic" value = "{{$result['idTopic']}}"/>
                        </div>
                        <div class = "row send-box p-lr">
                            <input class="btn btn-primary" type="button" id ="submitComment" value="Send comment" />
                        </div>
                    </div>
                    @endif

                    <div class="border-nobottom"></div>
                    <div class="bar">
                        {{$result['repCount']}} Comment
                        <input type="hidden" id = "repCount" value = "{{$result['repCount']}}"/>
                    </div>

                    <div class=" row col-md-12" data-example-id="default-media"> 
                        @foreach ($result['replies'] as $item)
                        <div class="media" > 
                            <div class="media-left"> 
                                <a href="#"> <img data-holder-rendered="true" src="{{url($item->link_img)}}" style="width: 48px; height: 48px;" class="media-object" data-src="holder.js/64x64" alt="64x64"> </a> 
                            </div> 
                            <div class="media-body" >
                                <h4 class="media-heading {{$item->isEdit}}" id = "cm-{{$item->id}}">{{$item->rep_by}} <span>·</span> {{$item->rep_date}}</h4>
                                <p class = "cm-content">{!!$item->rep_content !!}</p>
                                <div class = "co-action" style="margin-top: 5px;">
                                    <a href = "#" class = "reply-comment" id = "{{$item->id}}" style="color: blue; font-size: 12px">Reply</a>
                                </div>
                                @if($item->subReply->count() >0)
                                @foreach($item->subReply as $sub)
                                <div class="media" > 
                                    <div class="media-left">
                                        <a href="#"> <img data-holder-rendered="true" src="{{url(\App\Image::where('user_id', '=', $sub->rep_by)->get()->first()->path)}}" style="width: 32px; height: 32px;" class="media-object" alt="48x48"> 
                                        </a> 
                                    </div>
                                    <div class="media-body"> 
                                        <h4 class="media-heading {{(Auth::check() && Auth::user()->id == $sub->rep_by) ? "edit" : ""}}" id = "cm-{{$sub->id}}">{{\App\User::find($sub->rep_by)->fullname}} <span>·</span> {{\Carbon\Carbon::parse($sub->rep_date)->format("M d,Y")}}</h4>
                                        <p class="cm-content">{!!$sub->rep_content !!}</p>
                                    </div> 
                                </div> 
                                @endforeach
                                @endif
                            </div> 
                        </div> 
                        @endforeach

                    </div>

                </div> 
                <!--End MingComment-->
                <div class="other-news">
                    <span class="other-news-title">
                        Lastest new</span>
                    <ul>
                        @foreach($recentTopics as $reTopic)
                        <?php
                        $link_topics = url('forum/topic') . "/" . urlencode($reTopic->topic_subject);
                        $time = \Carbon\Carbon::parse($reTopic->topic_date)->format("d/m");
                        ?>
                        <li><a title="" href="{{$link_topics}}">{{$reTopic->topic_subject}}</a>&nbsp;<span class="fwb">({{$time}})</span> </li>
                        @endforeach
                        @if($recentTopics->count() == 0)
                        <li>Nothing to show</li>
                        @endif

                    </ul>


                </div>
                <!--end:newshot2-->
            </div>
            @else
                <div class="col-md-12" style="padding: 10px;">You have to login to comment. Click <a href="#" id="loginToComment">here</a> to login.</div>
            @endif
        </div>

    </div>
</div>

@stop
@section('footer-bottom')
    <footer>
    @include('public.layouts.footer.footer-bottom')
@stop
    
@if(Auth::check())
    @section('script')
        <script>
            $(document).ready(function () {
                $("textarea").keyup(function (e) {
                    $(this).height(15);
                    $(this).height(this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth")));
                });
                $(".reply-comment").click(function () {
                    var id = $(this).attr('id');
                    $(this).after('<div class="media" id = "me' + id + '">' +
                            '<div class="media-left">' +
                            '<a href="#"> <img data-holder-rendered="true" src={{url(\App\Image::where("user_id", "=", Auth::user()->id)->get()->first()->path)}} style="width: 32px; height: 32px;" class="media-object" />' +
                            '</a>' +
                            '</div>' +
                            '<div class="media-body" style = "overflow:auto">' +
                            '<div class="text-box"> ' +
                            '<textarea style="height: 48px;" id="txtReply" placeholder="add a reply..."></textarea> ' +
                            '</div> ' +
                            '<div class = "row send-box p-lr"> ' +
                            '<input class="btn btn-primary cancelReply" type="button" id ="' + id + '" value = "Cancel"/>' +
                            '<input class="btn btn-primary submitReply" type="button" id ="' + id + '" value="Send comment" />' +
                            '</div> ' +
                            '</div>' +
                            '</div>');
                    return false;
                });
                

                $('h4.media-heading.edit').hover(
                        function () {
                            var id = $(this).attr('id');
                            $('h4.media-heading#' + id).append($("<span style= 'margin-left : 5px;' class = 'option'><a href = '#' class = 'cm-edit' id ='" + id + "'><span class='glyphicon glyphicon-edit' style='size: 15px;'></span></a><a href = '#' class ='cm-remove' id ='" + id + "'><span class='glyphicon glyphicon-remove' style='margin-left:5px;size: 15px;'></span></a></span>"));
                        }, function () {
                    var id = $(this).attr('id');
                    $('h4.media-heading#' + id).find("span.option").remove();
                }
                );


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
                        url: "{{url('forum/reply/store')}}",
                        data: rep,
                        dataType: 'json',
                        success: function (response) {
                            $("textarea#txtComment").val("");
                            location.reload();
                        }
                    });
                });
                //appear edit comment
                var textEdit = '';
                $(document).on("click", ".cm-edit", function (e) {
                    e.preventDefault();
                    var id = $(this).attr('id');
                    var tagNext = $("h4.media-heading.edit span.option").parent().next();
                    var text = tagNext.html().replace(/<br>/g, "\n");
                    textEdit = text;
                    tagNext.replaceWith('<div id = "' + id + '"><div class="text-box"> ' +
                            '<textarea style="height: 48px;" id="txtEdit" placeholder="add a reply...">' + text + '</textarea> ' +
                            '</div> ' +
                            '<div class = "row send-box p-lr"> ' +
                            '<input class="btn btn-primary cancelEdit" type="button" id="' + id + '"  value = "Cancel"/>' +
                            '<input class="btn btn-primary submitEdit" type="button" id ="' + id + '"  value="Update" />' +
                            '</div></div>')
                    return false;
                });
                //cancel comment
                $(document).on("click", ".cancelEdit", function () {
                    var divP = "div#" + $(this).attr('id');
                    // var text = $('textarea#txtEdit').val().replace(/\r\n|\r|\n/g, "<br/>");
                    var text = textEdit.replace(/\r\n|\r|\n/g, "<br/>");
                    $(divP).replaceWith("<p>" + text + "</p>");
                });
                //changecomment
                $(document).on("click", ".submitEdit", function (e) {
                    if ($("textarea#txtEdit").val() == '')
                        return;
                    e.preventDefault();
                    var rep = {};
                    var text = $("textarea#txtEdit").val();
                    text = text.replace(/\r\n|\r|\n/g, "<br/>");
                    rep.content = text;
                    rep.idComment = $(this).attr('id').substr(4);
                    $.ajax({
                        type: "POST",
                        url: "{{url('forum/reply/store')}}",
                        data: rep,
                        dataType: 'json',
                        success: function (response) {

                            text = response.message;
                        }
                    });
                    var divP = "div#" + $(this).attr('id');
                    $(divP).replaceWith("<p>" + text + "</p>");
                });


                $(document).on("click", ".cm-remove", function (e) {
                    e.preventDefault();
                    var rep = {};
                    rep.idComment = $(this).attr('id').substr(3, 4);
                    $.ajax({
                        type: "POST",
                        url: "{{url('forum/reply/store')}}",
                        data: rep,
                        dataType: 'json',
                        success: function (response) {
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
                $(document).on("keyup", "textarea", function (e) {
                    $(this).height(15);
                    $(this).height(this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth")));

                });


            });
        </script>
    @stop

@else
    @section('script')
        <script>
            $(document).ready(function () {
                $('#loginToComment').click(function(){
                    $("#authModal").modal();
                    login_selected();
                });
            });
        </script>
    @stop
@endif

    

