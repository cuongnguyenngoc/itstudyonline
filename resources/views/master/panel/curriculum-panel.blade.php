 <div class="panel panel-info curriculum hide">
    <div class="panel-heading">
        Curriculum
    </div>
    <div class="panel-body">
        <!-- show lecture here -->
        <div id="curriculumPanel">

        </div> <!-- End of show lecture here -->
        <!-- Add info of lecture here -->
        <div class="row small-panel">
            <div class="panel-collapse panel-info collapse col-md-12" id="addLecturePanel">
                <div class="panel-body">
                    <form id="addLecture">
                        <div class="form-group">
                            <label for="lec_name">New Lecture</label>
                            <input type="text" class="form-control" id="lec_title" placeholder="Enter lecture name">
                        </div>
                        <button type="submit" class="btn btn-primary" style="margin-top:0px;">Add Lecture</button>
                    </form>
                </div>
            </div>
        </div> <!-- End of add info lecture -->
        <!-- Button  -->
        <div class="row">
            <div class="col-md-4">
                <button type="button" class="btn btn-primary btn-lg" style="width: 100%; margin-top:0px;" data-toggle="collapse" data-target="#addLecturePanel" aria-expanded="false">
                    <span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span>
                    Add Lecture
                </button>
            </div>
            
            <div class="col-md-4">
                <button type="button" class="btn btn-primary btn-lg" style="width: 100%; margin-top:0px;">
                    <span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span>
                    Add Quiz Exam
                </button>
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-primary btn-lg" style="width: 100%; margin-top:0px;">
                    <span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span>
                    Add Coding Exercise
                </button>
            </div>
        </div> <!-- End of button -->
    </div>
    <!--/panel-body-->
</div>
<!--/panel-->

<script type="text/javascript">
    $(document).ready(function(){
        
        /* swap plus/minus button icons when clicking to add more lecture */
        $('[data-toggle=collapse]').click(function(){
            // toggle icon
            $(this).find("span").toggleClass("glyphicon-plus glyphicon-minus");
        });

        var count = 0;
        $("#addLecture").submit(function(e){
            
            e.preventDefault();
            count++;
            if(count == 1){
                $('#curriculumPanel').prepend(
                    @include('master.panel.show-lecture-in-curriculum-panel') // Trong cái file show... này đã có biến count để add vào id
                );
            }else{
                $('#curriculumPanel').append(
                    @include('master.panel.show-lecture-in-curriculum-panel') // Trong cái file show... này đã có biến count để add vào id
                );
            }
            $('#showLecture'+count).find('#lec_name').text($('#lec_title').val());   
        });

        $('#curriculumPanel').on('click','button.addDescriptionBtn',function(){

            $('#addDescriptionArea'+this.id).removeClass('hide');
            // Khi click to create form description. sử dụng cái này để to plugin validate nhận ra form mới.
            // $.validator.unobtrusive.parse('#addDescription.'+this.id);
            $("#addDescription."+this.id).validate({  
                rules: {
                    description: {
                        required: true
                    }
                },
                messages: {
                    description: {
                        required: "Please enter your description"
                    }
                }        
            });
            $(this).addClass('hide');
        });

        $('#curriculumPanel').on('click','#cancelDescription',function(){
            // $('#addDescriptionArea'+$(this).attr('class')).addClass('hide');
            //Cái này sẽ kiểm tra nếu thẻ div showDescription rỗng thì nó sẽ hiện cái button Add description
            // Còn nếu khác rỗng thì nó sẽ hiển thị nội dung của showDescription
            if($('#showDescription'+$(this).attr('class')).text()==''){
                $('#addDescriptionArea'+$(this).attr('class')).addClass('hide');
                $('#'+$(this).attr('class')).removeClass('hide');  //Cái này là button addDescription

            }else{
                $('#addDescription.'+$(this).attr('class')).addClass('hide');
                $('#showDescription'+$(this).attr('class')).removeClass('hide');
            }
        });


        // Khi click vao button save thi sẽ gán giá trị của area cho thẻ div showDescription
        

        $('#curriculumPanel').on('submit','#addDescription',function(e){
            e.preventDefault();
            $('#showDescription'+$(this).attr('class')).removeClass('hide').text($(this).find('#lec_description').val());
            $(this).addClass('hide');
        });
        
        // Khi click vao thẻ div showDescription thi sẽ hiển thị form để chỉnh sửa description
        $('#curriculumPanel').on('click','div.showDesClass',function(){
            $(this).addClass('hide');
            $('#addDescription.'+$(this).attr('getId')).removeClass('hide');
        });

        $('#curriculumPanel').on('click','button.addContentBtn',function(){
            // toggle icon
            $(this).find("span").toggleClass("glyphicon-plus glyphicon-minus");
            $('#toggleDescription'+$(this).attr('getId')).toggleClass('hide');
            $('#toggleAddContentDetail'+$(this).attr('getId')).toggleClass('hide');
        });

        //Add Content Detail like whether video, document, text...
        $('#curriculumPanel').on('click','a.thumbnail',function(){
            
            $('#addContent'+$(this).attr('getId')).addClass('hide');
            $('#addContentDetail'+$(this).attr('getId')).removeClass('hide');
            $('#addContentDetail'+$(this).attr('getId')).find('a').text('Add '+$(this).attr('getName'));
            $('#addVideo'+$(this).attr('getId')).addClass('dropzone');
            $addVideo = $('#curriculumPanel').find('#addVideo'+$(this).attr('getId'));
            //addVideoId = new Dropzone($addVideo);
            $('#addVideo'+$(this).attr('getId')).dropzone({
                
                maxFilesize: 100,
                maxFiles: 10,
                init: function() {
                    
                },
                success: function(file,response){
                    console.log(file);
                    console.log(response);
                    console.log('what the fuck is going on');
                }
            });
        });
    });

</script>
