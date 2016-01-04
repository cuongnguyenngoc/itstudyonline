
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
                    <img src="{{url(Auth::user()->image->path)}}" width="150" height="150" style="display:inline-block;border: 1px solid #ddd;padding: 4px;margin-top:10px;"/>
                    <h5>{{ Auth::user()->fullname }}</h5>
                    <li style=""> <a href="{{ route('user.editprofile') }}" class="list-group-item ">Profile</a>
                    </li>
                    <li > <a href="{{ url('user/addphoto') }}" class="list-group-item "> Avatar</a>
                    </li>
                    <li><a href="{{ url('user/changepassword') }}" class="list-group-item "> ChangePassword</a>
                    </li>
                    <li><a href="{{ url('user/rechargeMoney') }}" class="list-group-item "> Balance</a>
                    </li>
                </ul>

                <hr>

            </div>
            <!-- /col-3 -->
            <div class="col-sm-9">

                <!-- column 2 -->

                <div class="col-md-9">
                <h2 style="text-align:center"><i></i> Profile</h2>
                <p style="text-align:center; font-size:15px">Add information about yourself</p>
                    @include('user.profileinformation')
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
    <script type="text/javascript">
        $(function() {
            $("#datepicker").datepicker();
            $("#userprofile").validate({  
            rules: {
                fullname: {
                    required: true
                },
                address: {
                    required: true,
                },
                birth: {
                    required: true
                },
                biography: {
                    required: true,
                    minlength: 30
                }
            },
            messages: {
                fullname: {
                    required: "Please enter your full name"
                },
                address: "Please enter your address",
                birth: "Please choose a birth",
                biography: {
                    required: "Please introduce about yourself",
                    equalTo: "Your introduction have to be more than 30 characters"
                }
            },
            errorPlacement: function (error , element) { 
                element.parents('div.form-group').find('.message').html(error);
            }     
        });

        $("#userprofile").on('submit',function(e){
            
            if($(this).valid()){
                e.preventDefault();
                var user = {};
                user.fullname = $('#fullnameu').val();
                user.address = $('#address').val();
                user.birth = $('#datepicker').val();
                user.biography = $('#biography').val();
                $.ajax({
                    type: "POST",
                    url : "/user/update-profile",
                    dataType: 'json',
                    data: user,
                    success : function(response){
                        console.log(response);
                        if(response.status){
                            var n = noty({text: response.message, layout: 'top', type: 'success', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });
                        }
                    }
                });
            }
        });
        });
        
        
    </script>
@stop