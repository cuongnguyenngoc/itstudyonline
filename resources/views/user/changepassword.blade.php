
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
<div class="container main">
    <div class="row">
        <div class="col-sm-3">
            <!-- Left column -->
            <ul class="side-nav" id="sideUser">
                <img src="/{{Auth::user()->image->path}}" width="150" height="150" style="display:inline-block;border: 1px solid #ddd;padding: 4px;margin-top:10px;" />
                <h5>{{ Auth::user()->fullname }}</h5>
                <li style=""> <a href="{{ route('user.editprofile') }}" class="list-group-item ">Profile</a>
                </li>
                <li > <a href="{{ url('user/addphoto') }}" class="list-group-item "> Avatar</a>
                </li>
                <li><a href="{{ url('user/changepassword') }}" class="list-group-item "> ChangePassword</a>
                </li>
            </ul>
            <hr>
        </div>
        <!-- /col-3 -->
        <div class="col-sm-9">

            <div class="col-md-9">
                <h2 style="text-align:center"><i></i>Account</h2>
                <p style="text-align:center; font-size:15px">Change Your Password</p>
                
                <div class="panel panel-info panel-right">
                    <div class="panel-heading"></div>
                    <div class="panel-body">
                        <div class="alert alert-success hide" id="message">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <p></p>
                        </div>
                        {!! Form::open(['url'=>'user/changepassword', 'id'=>'formpassword'])!!}
                            <div class="form-group"style="padding: 4px 19px;box-shadow: 0 1px 2px rgba(0,0,0,.15);height: auto;">
                                <p style="margin 5px 0px;font-size:20px">Your Email: {{Auth::user()->email }}</p>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="currentpassword" name="currentpassword" placeholder="Current password">   
                                <div class="message"></div>
                            </div>
                            <div class="form-group">    
                                <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="New Password">
                                <div class="message"></div>
                            </div>
                            <div class="form-group">     
                                <input type="password"class="form-control" id="confirm" name="confirm" placeholder="Confirm New Password">
                                <div class="message"></div>
                            </div>
                            <div class="form-group">     
                               <button type="submit" class="btn btn-info">Change Password</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!--/col-span-9-->
    </div>
</div>
@stop

@section('footer-bottom')
    <footer>
    @include('public.layouts.footer.footer-bottom')
@stop

@section('script')
    <script src="{{url('js/master/scripts.js')}}"></script>
    <script type="text/javascript">

    $(".message").empty();

    $("#formpassword").validate({  
        rules: {
            currentpassword: {
                required: true,
                remote: {
                    url: '/user/checkRightPassword',
                    type: 'post',
                    dataType: 'json'
                }
            },
            newpassword: {
                required: true,
                minlength: 6
            },
            confirm: {
                required: true,
                equalTo: "#newpassword"
            }
        },
        messages: {
            currentpassword: {
                required: "Please enter your email",
                remote: "Please enter right password"
            },
            newpassword: {
                required: "Please enter your new password",
                minlength: "Password should be minimax 6 characters"
            }
            confirmPwd: {
                required: "Please confirm your password",
                equalTo: "Password don't match, Please try again"
            }
        },
        errorPlacement: function (error , element) { 
            element.parents('div.form-group').find('.message').html(error);
        }          
    });

    $("#formpassword").on('submit',function(e){
       
        if($(this).valid()){
            e.preventDefault();
            var pass = {};
            pass.currentpassword = $("#currentpassword").val();
            pass.newpassword = $("#newpassword").val();
            pass.confirm = $("#confirm").val();

            $.ajax({
                type: "POST",
                url:"/user/changepass",
                data: pass,
                success  : function(response){
                    console.log(response);
                    if(response.status){
                        var n = noty({text: response.message, layout: 'top', type: 'success', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });
                    }
                }
            });
        }
    });
    
</script>
@stop

