<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<div class="panel panel-info course-goals panel-right">
    <div class="panel-heading"></div>
    <div class="panel-body">
        <div class="alert alert-success hide" id="message">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p></p>
        </div>

        {!! Form::open(['url'=>'user/update','id' => 'userprofile'])!!}
        <div class="form-group">
            <label for="fullname">FullName</label>
            <input class="form-control" id="fullname" name="fullname" value="{{Auth::user()->fullname }}">
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input class="form-control" id="address" name="address" value="{{Auth::user()->address}}" placeholder="Address">
        </div>
        <div class="form-group">
            <label for="birth">Birth</label>
            <input class="form-control" id="datepicker" name="birth" value="{{Auth::user()->birth}}">           
        </div>
        <div class="form-group">
            <label for="biography">Biography</label>
            <textarea class="form-control" rows="5" name="biography" value="{{Auth::user()->biography}}" id="biography"></textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-info">Save</button>
        </div>
        
        {!! Form::close() !!}
    </div>  
</div>
    <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>

  <script type="text/javascript">
  $(document).on('ready',function(){
    $("#userprofile").validate({  
            rules: {
                fullname: {
                    required: true
                },
            },     
        });

    $("#userprofile").on('submit',function(e){
            e.preventDefault();
            if($("#userprofile").valid()){
                var fullname = $("#fullname").val();
                $.ajax({
                    type: "POST",
                    url : "/user/update",
                    dataType: 'json',
                    data: fullname,
                    success : function(response){
                        console.log(response);
                        if(response.status){
                            // $('#headCourse').removeClass('hide');
                            // $('#course_id').val(response.course.id);
                            $('#message').removeClass('hide');
                            $('#message').find('p').text(response.message);
                            $('.list-group-item-success.course-goals').removeClass('active');
                            $('.list-group-item-success.curriculum').addClass('active');
                            $('div.course-goals').addClass('hide');
                            $('div.curriculum').removeClass('hide');

                            // $('#courseName').text(response.course.course_name);
                        }
                    }
                });
            }
        });

  });
  </script>
