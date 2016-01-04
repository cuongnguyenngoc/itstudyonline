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
                            <div><img src = "/images/forum/user-def.png" width="50" height="50"/></div>
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
                    <div  class="comment-list" style="display: block">
                        <div class="mingid-commentData">
                            <ul id = "showComment" class="cm-list" alt = "0">
                                @foreach ($result['replies'] as $item)
                                <li>
                                    <div class="left-coint">
                                        <div class="avatar"><img src="/images/forum/user-def.png"/></div>
                                    </div>
                                    <div class="cent-coint">
                                        <span><a href="#">{{$item->rep_by}}</a> | {{$item->rep_date}}</span>
                                    </div>
                                    <div class="cm-content">
                                        <p>{!!$item->rep_content !!}</p>
                                    </div>
                                    <div class = "action">
                                        <div class="cm_reply"  id = "reply-{{$item->id}}"style="">
                                            <a href="javascript://" > Trả  lời</a>
                                            <input value="{{$item->id}}" type="hidden">
                                        </div>
                                    </div>
                                    <div class="re-list  clearfix">
                                        <img src="#" width="15px" height="15px"/>
                                        <div>

                                        </div>
                                    </div>

                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class = "clear">

                    </div>

                </div> 
                <!--End MingComment-->
                <div class="other-news">
                    <span class="other-news-title">
                        Tin mới cập nhật</span>
                    <ul>
                        @foreach($recentTopics as $reTopic)
                        <?php
                        $link_topics = url('forum/topic') . "/" . urlencode($reTopic->topic_subject);
                        $time = \Carbon\Carbon::parse($reTopic->topic_date)->format("d/m");
                        ?>
                        <li><a title="" href="{{$link_topics}}">{{$reTopic->topic_subject}}</a>&nbsp;<span class="fwb">({{$time}})</span> </li>
                        @endforeach
                        @if($recentTopics->count() == 0)
                        <li>không có bài viết nào</li>
                        @endif

                    </ul>


                </div>
                <!--end:newshot2-->
            </div>
        </div>

        <div class="bs-example" data-example-id="default-media"> 
            <div class="media"> 
                <div class="media-left"> 
                    <a href="#"> <img data-holder-rendered="true" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PCEtLQpTb3VyY2UgVVJMOiBob2xkZXIuanMvNjR4NjQKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTE5NmJkNDY3MSB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1MTk2YmQ0NjcxIj48cmVjdCB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSIxMi41IiB5PSIzNi44Ij42NHg2NDwvdGV4dD48L2c+PC9nPjwvc3ZnPg==" style="width: 64px; height: 64px;" class="media-object" data-src="holder.js/64x64" alt="64x64"> </a> 
                </div> 
                <div class="media-body">
                    <h4 class="media-heading">Media heading</h4>
                    Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus. 
                </div> 
            </div> 
            <div class="media"> <div class="media-left">
                    <a href="#"> 
                        <img data-holder-rendered="true" src="" style="width: 64px; height: 64px;" class="media-object" data-src="holder.js/64x64" alt="64x64"> 
                    </a>
                </div>
                <div class="media-body"> 
                    <h4 class="media-heading">Media heading</h4> 
                    Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                    <div class="media"> 
                        <div class="media-left">
                            <a href="#"> <img data-holder-rendered="true" src="" style="width: 64px; height: 64px;" class="media-object" data-src="holder.js/64x64" alt="64x64"> 
                            </a> 
                        </div>
                        <div class="media-body"> 
                            <h4 class="media-heading">Nested media heading</h4>
                            Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                        </div> 
                    </div> 
                </div>
            </div>
            <div class="media">
                <div class="media-body"> 
                    <h4 class="media-heading">Media heading</h4> 
                    Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. 
                </div> 
                <div class="media-right">
                    <a href="#"> <img data-holder-rendered="true" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PCEtLQpTb3VyY2UgVVJMOiBob2xkZXIuanMvNjR4NjQKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTE5NmJkNTI3NCB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1MTk2YmQ1Mjc0Ij48cmVjdCB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSIxMi41IiB5PSIzNi44Ij42NHg2NDwvdGV4dD48L2c+PC9nPjwvc3ZnPg==" style="width: 64px; height: 64px;" class="media-object" data-src="holder.js/64x64" alt="64x64"> 
                    </a> 
                </div> 
            </div>
            <div class="media"> 
                <div class="media-left">
                    <a href="#"> <img data-holder-rendered="true" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PCEtLQpTb3VyY2UgVVJMOiBob2xkZXIuanMvNjR4NjQKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTE5NmJkNjM0NCB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1MTk2YmQ2MzQ0Ij48cmVjdCB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSIxMi41IiB5PSIzNi44Ij42NHg2NDwvdGV4dD48L2c+PC9nPjwvc3ZnPg==" style="width: 64px; height: 64px;" class="media-object" data-src="holder.js/64x64" alt="64x64"> </a>
                </div> 
                <div class="media-body">
                    <h4 class="media-heading">Media heading</h4> 
                    Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.
                </div> 
                <div class="media-right"> 
                    <a href="#"> <img data-holder-rendered="true" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PCEtLQpTb3VyY2UgVVJMOiBob2xkZXIuanMvNjR4NjQKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTE5NmJkNjY0OSB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1MTk2YmQ2NjQ5Ij48cmVjdCB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSIxMi41IiB5PSIzNi44Ij42NHg2NDwvdGV4dD48L2c+PC9nPjwvc3ZnPg==" style="width: 64px; height: 64px;" class="media-object" data-src="holder.js/64x64" alt="64x64">
                    </a> 
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
                $(".cm_reply").click(function (e) {
                    alert($(this).attr('id'));
                    e.preventDefault();
                    $(".action").after('<did class = "sub-reply reply-parent"></did>');
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
                        url: '../reply/store',
                        data: rep,
                        dataType: 'json',
                        success: function (response) {
                            $("textarea#txtComment").val("");
                            location.reload();
                        }
                    });

                });

            });
        </script>
        @stop

$(this).after('<div class="media">' +
                            '<div class="media-left">' +
                            '<a href="#"> <img data-holder-rendered="true" src="/images/forum/user-def.png" style="width: 64px; height: 64px;" class="media-object" />' +
                            '</a>' +
                            '</div>' +
                            '<div class="media-body">' +
                            '<h4 class="media-heading">Nested media heading</h4> ' +
                            '</div>' +
                            '</div>');