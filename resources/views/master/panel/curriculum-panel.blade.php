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

        /* swap triangle-bottom/up button icons when clicking to add more lecture */
        $('#curriculumPanel').on('click','button.collapse-lecture',function(){
            // toggle icon
            $(this).find("span").toggleClass("glyphicon-triangle-bottom glyphicon-triangle-top");
            $('#collapseLecture'+$(this).attr('getId')).toggleClass('hide');
        });

        var count = 0;
        $("#addLecture").submit(function(e){
            
            e.preventDefault();
            count++;
            if(count == 1){
                $('#curriculumPanel').prepend(
                    @include('master.panel.show-lecture-in-curriculum-panel') // In show file, it have had count variable already to recognize lecture own.
                );
            }else{
                $('#curriculumPanel').append(
                    @include('master.panel.show-lecture-in-curriculum-panel') // In show file, it have had count variable already to recognize lecture own.
                );
            }
            $('#showLecture'+count).find('#lec_name').text($('#lec_title').val());   
        });

        $('#curriculumPanel').on('click','button.addDescriptionBtn',function(){

            $('#addDescriptionArea'+this.id).removeClass('hide');
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
            //This will check if showDescription div is empty so it will show Add Description button
            // If not, it will show content of showDescription
            if($('#showDescription'+$(this).attr('class')).text()==''){
                $('#addDescriptionArea'+$(this).attr('class')).addClass('hide');
                $('#'+$(this).attr('class')).removeClass('hide');  //Cái này là button addDescription

            }else{
                $('#addDescription.'+$(this).attr('class')).addClass('hide');
                $('#showDescription'+$(this).attr('class')).removeClass('hide');
            }
        });


        // When u click on cancel tab, it will give you choose type of content again
        $('#curriculumPanel').on('click','li.cancel-addContent',function(e){
            var getId = $(this).attr('getId');

            if($('#showVideo'+getId).find('p').text()===''){
                $('#addContentDetail'+getId).addClass('hide');
                $('#addContent'+getId).removeClass('hide');

                //$('#uploadVideo'+this.getId).removeClass('hide');
                //$('#showVideo'+getId).addClass('hide');
            }else{
                $('#uploadVideo'+getId).addClass('hide');
                $('#showVideo'+getId).removeClass('hide');
            }                    

        });

        // When u click on save button, it will assign value of area to showDescription div

        $('#curriculumPanel').on('submit','#addDescription',function(e){
            e.preventDefault();
            $('#showDescription'+$(this).attr('class')).removeClass('hide').text($(this).find('#lec_description').val());
            $(this).addClass('hide');
        });
        
        // When you click on div showDescription, it will show form to edit description content.
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
        $('#curriculumPanel').on('click','a.type-content',function(){
            
            var getId = $(this).attr('getId');
            var getName = $(this).attr('getName');

            $('#addContent'+getId).addClass('hide');
            $('#addContentDetail'+getId).removeClass('hide');
            $('#addContentDetail'+getId).find('#uploadVideo'+getId+' a').first().text('Add '+getName);
            $('#showVideo'+getId).addClass('hide');
            $('#uploadVideo'+getId).removeClass('hide');

            if(getName == 'Video'){
                $('#addVideo'+getId).removeClass('hide');
                $('#addDocument'+getId).addClass('hide');
            }else{
                $('#addDocument'+getId).removeClass('hide');
                $('#addVideo'+getId).addClass('hide');
            }

            $('#add'+getName+getId).addClass('dropzone');
            
            $('#add'+getName+getId).dropzone({
                
                url: (getName=='Video') ? "/video/do-upload" : "/document/do-upload",
                maxFilesize: 500,
                maxFiles: 1,
                acceptedFiles: (getName=='Video') ? '.mp4, .flv' : '.pdf',
                addRemoveLinks: 'dictCancelUpload',
                init: function() {
                    this.getId = getId;

                    this.on("uploadprogress", function(file, progress) {
                        console.log("File progress", progress);
                        $('#uploadVideo'+this.getId).find('li.cancel-addContent').remove();
                    });
                    this.on("maxfilesexceeded", function(file) {
                        this.hiddenFileInput.removeAttribute('multiple');
                        this.removeAllFiles();
                        this.addFile(file);
                    });
                    this.on("canceled", function(file) {
                        // check it out old upload or new upload to decide show or hide showVideo div.
                        if($('#showVideo'+this.getId).find('p').text()===''){
                            $('#uploadVideo'+this.getId).removeClass('hide');
                            $('#showVideo'+this.getId).addClass('hide');
                        }else{
                            $('#uploadVideo'+this.getId).addClass('hide');
                            $('#showVideo'+this.getId).removeClass('hide');
                        }                    

                    });

                    this.on("complete", function (file) {
                        console.log(file);
                        console.log(this);
                        this.removeFile(file);
                        $('#uploadVideo'+this.getId+' > ul').append("<li class='cancel-addContent' getId='"+this.getId+"'><a href='#lec"+this.getId+"' id='cancel"+this.getId+"'> Cancel</a></li>");
                        if(file.status != 'error'){
                            
                            if(this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                                $('#uploadVideo'+this.getId).addClass('hide');
                                $('#showVideo'+this.getId).removeClass('hide');
                                $('#toggleDescription'+this.getId).removeClass('hide');
                                $('#addDescriptionArea'+this.getId).removeClass('hide');
                                $('div#chooseThumbnail'+this.getId).addClass('hide');
                                // $showDescription.removeClass('hide');
                                if($('#showDescription'+this.getId).text()==''){
                                    $('#addDescriptionArea'+this.getId).addClass('hide');
                                    $('#'+this.getId).removeClass('hide');  //This is button AddDescription.

                                }else{
                                    $('#addDescription'+this.getId).addClass('hide');
                                    $('#showDescription'+this.getId).removeClass('hide');
                                }
                            }
                        }else{
                            // $divVideo.empty();
                            alert('<p>You need to upload file which has size be smaller 500M</p>');
                        }                       
                    });
                },
                success: function(file,response){
                    console.log(file);
                    console.log(response);
                    $('#addContentBtn'+this.getId).empty()
                        .html("<span class='glyphicon glyphicon-triangle-bottom' aria-hidden='true'></span>")
                        .addClass('collapse-lecture')
                        .removeClass('col-md-2')
                        .addClass('col-md-1 col-md-offset-1');
                        
                    if(getName=='Video'){
                        $('#changeVideo'+this.getId).html("<span class='glyphicon glyphicon-edit'></span> Change Video");
                        $('#showVideo'+this.getId).find('div.show-content-preview').html(
                            "<a href='#lec"+this.getId+"' class='change-thumbnail' getId='"+this.getId+"'>"+
                                "<img src='/"+response.thumbnail.path+"' alt='"+response.thumbnail.img_name+"' class='img-thumbnail' id='imgThumbnail"+this.getId+"'/>"+
                            "</a>"
                        );
                        $('#showVideo'+this.getId).find('p').text(response.thumbnail.img_name);
                        $('input#video_id'+this.getId).val(response.video.id);
                        $('input#video_doc_id'+this.getId).val(response.video.id);
                    }else{
                        $('#changeVideo'+this.getId).html("<span class='glyphicon glyphicon-edit'></span> Change Document");
                        $('#showVideo'+this.getId).find('p').text(response.doc.doc_name);
                        $('#showVideo'+this.getId).find('div.show-content-preview').html(
                            "<embed src='/"+response.doc.path+"' type='"+file.type+"' height='130' width='210'/>"
                        );
                        $('input#doc_id'+this.getId).val(response.doc.id);
                        $('input#doc_video_id'+this.getId).val(response.doc.id);
                    }
                    
                }
            });
        });

        $('#curriculumPanel').on('click','div.editContent > a.change-video',function(){

            $('#uploadVideo'+$(this).attr('getId')).removeClass('hide');
            $('#showVideo'+$(this).attr('getId')).addClass('hide');
            $('#chooseThumbnail'+$(this).attr('getId')).addClass('hide');
        });

        $('#curriculumPanel').on('click','a.edit-content',function(){

            var getId = $(this).attr('getId');

            $('#addContentDetail'+getId).addClass('hide');
            $('#addContent'+getId).removeClass('hide');
        });

        $('#curriculumPanel').on('click','a.change-thumbnail',function(){

            var getId = $(this).attr('getId');
            $('#chooseThumbnail'+getId).removeClass('hide');
            $thumbnails = $('div#thumbnails'+getId);
            var video_id = $('#video_id'+getId).val();

            $.ajax({
                type: "POST",
                url : "/video/choose-thumbnail",
                dataType: 'json',
                data: {'id' : video_id }, // remember that be must to pass data object type
                success : function(response){
                    console.log(response);
                    
                    $thumbnails.empty();
                    for(var i = 0; i < response.thumbnails.length; i++){
                        $thumbnails.append(
                            "<a href='#lec"+getId+"' class='choose-thumbnail' getId='"+getId+"' getValue='"+response.thumbnails[i].id+"'>"+
                                "<img src='/"+response.thumbnails[i].path+"' alt='"+response.thumbnails[i].img_name+"' class='img-thumbnail col-md-4'/>"+
                            "</a>"
                        );
                    }                 
                }
            });
        });

        $('#curriculumPanel').on('click','a.choose-thumbnail',function(){

            var getId = $(this).attr('getId');
            $('#chooseThumbnail'+getId).addClass('hide');

            var thumb_id = $(this).attr('getValue');

            $.ajax({
                type: "POST",
                url : "/video/update-thumbnail",
                dataType: 'json',
                data: {'thumb_id' : thumb_id }, // remember that be must to pass data object type
                success : function(response){
                    console.log(response);
                    $('#curriculumPanel').find('#imgThumbnail'+getId).attr('src','/'+response.thumbnail.path);
                    $('#curriculumPanel').find('#imgThumbnail'+getId).attr('alt',response.thumbnail.img_name);   
                }
            });
        });

    });

</script>
