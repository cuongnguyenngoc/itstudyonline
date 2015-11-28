 <div class="panel panel-info course-goals panel-right">
    <div class="panel-heading">
        <a href="#" title="My tooltip text">Course goals</a>
    </div>
    <div class="panel-body">
        <div class="alert alert-success hide" id="message">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p></p>
        </div>
        {!! Form::model($course,['route' => 'master.course.create', 'role' => 'form', 'id' => 'courseGoals' ]) !!}
            <div class="form-group">
                <label for="category">Category</label>
                {!! Form::select('cat_id',array(''=>'Select category') + $categories, $course->cat_id, ['id' => 'cat_id', 'class' => 'form-control']) !!}
            </div>
            {!!Form::hidden('id',$course->id,['id'=>'course_id'])!!} 
            <div class="form-group">    
                <label for="language">Programming Language</label>
                {!! Form::select('lang_id',array(''=>'Select language') + $languages, $course->lang_id, ['id' => 'lang_id', 'class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                <label for="level">Level for disciple</label>
                {!! Form::select('level_id',array(''=>'Select level') + $levels, $course->level_id, ['id' => 'level_id', 'class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                <label for="course-name">Course name</label>
                {!! Form::text('course_name',$course->course_name,['id'=>'course_name','placeholder'=>'Enter course name','class'=>'form-control']) !!}
            </div>
            <div class="form-group showTip">
                <label for="description">Course Summary</label>
                <textarea class='form-control' id='descriptionText' name='descriptionText' placeholder='Enter course description' style='width:100%'>{{$course->description}}</textarea>
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
        {!! Form::close() !!}
    </div>
    <div class='show-tip-summary hide'>
        <p>Write a 300 word overview of your course. Explain who your target audience is and why they should take your course. Consider these questions:</p>
        <ul style="list-style: disc;">
            <li style="list-style: disc;">What is the course about?</li>
            <li style="list-style: disc;">What terminology would your target audience expect to use to find your course?</li>
            <li style="list-style: disc;">What kind of materials are included?</li>
            <li style="list-style: disc;">How long will the course take to complete?</li>
            <li style="list-style: disc;">How is the course structured?</li>
            <li style="list-style: disc;">Why take this course?</li>
        </ul>
        <p>Coupon codes and links are not permitted in this space.</p>
    </div>
    <!--/panel-body-->
</div>
<!--/panel-->

<script type="text/javascript">
    

    $(document).on('ready',function(){
        tinymce.init({
            selector: "textarea#descriptionText",
            plugins: [
                "code"
            ],
            toolbar: "undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist",
            setup: function(editor) {
                editor.on('keyup', function(e) {
                    $('#descriptionText').val(e.target.innerText);
                });
            }     
        });
        
        $('div.showTip').qtip({
            content: $('.show-tip-summary').html(),
            position: {
                my: "center right",
                at: "center left"
            }
        });

        //This code tells the jquery Validation Plugin to check hidden fields as well... And then you can normally. Cool.
        //Because textarea field is hidden, so if we dont setDefault ignore: '' for validator, it is not work. Ok. cool.
        $.validator.setDefaults({
            ignore: ''
        });

        $("#courseGoals").validate({  
            rules: {
                cat_id: {
                    required: true
                },
                lang_id: {
                    required: true
                },
                level_id: {
                    required: true
                },
                course_name: {
                    required: true,
                    minlength: 10
                },
                descriptionText: {
                    required: true,
                    minlength: 15
                }
            },
            messages: {
                cat_id: "Please choose category",
                lang_id: "Please choose programming language",
                level_id: "Please choose study level",
                course_name: {
                    required: "Please enter your course name",
                    minlength: "Course name should be minimax 10 characters"
                },
                descriptionText: {
                    required: "Please enter your course name",
                    minlength: "Course name should be minimax 10 characters"
                }
            }        
        });
      
        $("#courseGoals").on('submit',function(e){
            e.preventDefault();
            if($("#courseGoals").valid()){
                var course = {};
                course.id = $('#course_id').val();
                course.cat_id = $('#cat_id').val();
                course.lang_id = $('#lang_id').val();
                course.level_id = $('#level_id').val();
                course.course_name = $('#course_name').val();
                course.description = tinyMCE.activeEditor.getContent({
                                        format: 'html'
                                     });
                $.ajax({
                    type: "POST",
                    url : "/master/create-course",
                    dataType: 'json',
                    data: course,
                    success : function(response){
                        console.log(response);
                        if(response.status){
                            $('#headCourse').removeClass('hide');
                            $('#course_id').val(response.course.id);
                            $('#course_id_img').val(response.course.id); // To assign value for image when upload image of course
                            $('#course_id_video').val(response.course.id); // To assign value for video when upload video introduction of course
                            $('#message').removeClass('hide');
                            $('#message').find('p').text(response.message);
                            $('.list-group-item-success.course-goals').removeClass('active');
                            $('.list-group-item-success.curriculum').addClass('active');
                            $('div.course-goals').addClass('hide');
                            $('div.curriculum').removeClass('hide');

                            $('#courseName').text(response.course.course_name);
                        }
                    }
                });
            }
        });
    });

</script>