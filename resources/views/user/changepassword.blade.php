
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
            

            <ul class="side-nav">
                <img src="/{{Auth::user()->image->path}}" width="150" height="150" style="display:inline-block;border: 1px solid #ddd;padding: 4px;margin-top:10px;" />
                <h5>{{ Auth::user()->fullname }}</h5>
                <li style=""> <a href="{{ route('user.editprofile') }}" class="list-group-item ">Profile</a>
                </li>
                <li > <a href="{{ url('user/addphoto') }}" class="list-group-item "> Photo</a>
                </li>
                <li><a href="{{ url('user/changepassword') }}" class="list-group-item "> ChangePassword</a>
                </li>
                <li > <a href="#" class="list-group-item ">Credit Card</a>
                </li>
            </ul>

            <hr>

        </div>
        <!-- /col-3 -->
        <div class="col-sm-9">

            <div class="col-md-9">
            <h2 style="text-align:center"><i></i>Account</h2>
            <p style="text-align:center; font-size:15px">Change Your Password</p>
                
               <div class="panel panel-info course-goals panel-right">
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
            <label for="password">PassWord</label>
            <input type="password" class="form-control" id="currentpassword" name="currentpassword" placeholder="Current password">   
        </div>
        <div class="form-group">    
            <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="New Password">
        </div>
        <div class="form-group">     
            <input type="password"class="form-control" id="confirm" name="confirm" placeholder="Confirm New Password">
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
@stop

<script type="text/javascript">
    $document.ready(function() {
        $("#formpassword").validate({
        rules:{
            currentpassword:{
                required:true
            },
            newpassword:{
                required:true
            },
            confirm:{
                equalTo:"#newpassqord"
            }
            },
            message:{
                currentpassword:"Bạn phải nhập mât khẩu",
                newpassword: "Vui lòng nhập mật khẩu mới",
                confirm: "Mật khẩu xác nhận không đúng"
            }
    });
        $("#formpassword").on('submit',function(e){
            e.preventDefault();
            var currentpassword = $("#currentpassword").val();
            var newpassword = $("#newpassword").val();
            var confirm = $("#confirm").val();
            var data = 'currentpassword'+currentpassword+'&newpassword'+newpassword+'&confirm'+confirm;

                    $.ajax({
                    type: "POST",
                    url:"user/changepass",
                    data: data,
                    success  : function(response){
                        console.log(response);
                        if(response.status){
                            $('#message').removeClass('hide');
                            $('#message').find('p').text(response.message);

                        }
                    }
                });
        }
        
    });


        // $("#formpassword").validate({
        //     errorElement: "span",
        //     submitHandler: function(form){
        //         var currentpassword = $("#currentpassword").attr('value');
        //         var newpassword = $("#newpassword").attr('value');
        //         var confirm = $("#confirm").attr('value');
        //         var data = 'currentpassword'+currentpassword+'&newpassword'+newpassword;
        //         $.ajax({
        //             type: "POST",
        //             url:"user/changepassword",
        //             data: "name="+ name +"&email="+ email,
        //         })

        //     }
        // })
        
        // $("#formpassword").click(function(){
        //     var currentpassword = $("#currentpassword").val();
        //     var newpassword = $("#newpassword").val();
        //     var confirm = $("#confirm").val();
        //     var type = "POST";
        //     var url ="user/changepassword";

        //     if(currentpassword == "") {
        //    $(".error").slideDown('slow').delay(1000).slideUp('slow');
        //    $("#currentpassword").focus();
        //    return false;
        // }
        // })
    
</script>