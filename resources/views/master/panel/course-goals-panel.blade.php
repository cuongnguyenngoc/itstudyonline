 <div class="panel panel-info course-goals">
    <div class="panel-heading">
        Course goals
    </div>
    <div class="panel-body">
        <div class="alert alert-success hide" id="message">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p></p>
        </div>
        {!! Form::model($course,['route' => 'master.course.create', 'role' => 'form', 'id' => 'courseGoals' ]) !!}
            <div class="form-group">
                <label for="category">Category</label>
                {!! Form::select('cat_id',array('default'=>'Select category') + $categories, $course->cat_id, ['id' => 'cat_id', 'class' => 'form-control']) !!}
            </div>
            {!!Form::hidden('id',$course->id,['id'=>'course_id'])!!} 
            <div class="form-group">    
                <label for="language">Programming Language</label>
                {!! Form::select('lang_id',array('default'=>'Select language') + $languages, $course->lang_id, ['id' => 'lang_id', 'class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                <label for="level">Level for disciple</label>
                {!! Form::select('level_id',array('default'=>'Select level') + $levels, $course->level_id, ['id' => 'level_id', 'class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                <label for="course-name">Course name</label>
                {!! Form::text('course_name',$course->course_name,['id'=>'course_name','placeholder'=>'Enter course name','class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                <label for="description">Description for your course</label>
                {!! Form::textarea('description',$course->description,['id'=>'description','rows'=>'5','class'=>'form-control']) !!}
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
        {!! Form::close() !!}
    </div>
    <!--/panel-body-->
</div>
<!--/panel-->

<script type="text/javascript">
    $("#courseGoals").submit(function(e){
        e.preventDefault();
        var course = {};
        course.id = $('#course_id').val();
        course.cat_id = $('#cat_id').val();
        course.lang_id = $('#lang_id').val();
        course.level_id = $('#level_id').val();
        course.course_name = $('#course_name').val();
        course.description = $('#description').val();
        $.ajax({
            type: "POST",
            url : "/master/create-course",
            dataType: 'json',
            data: course,
            success : function(response){
                $('#course_id').val(response.course.id);
                $('#message').removeClass('hide');
                $('#message').find('p').text(response.message);
            }
        });
    });

</script>