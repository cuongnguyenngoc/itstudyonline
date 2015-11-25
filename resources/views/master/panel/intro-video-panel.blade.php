 <div class="panel panel-info intro-video panel-right hide">
    <div class="panel-heading">
        Introduction Video
    </div>
    <div class="panel-body">
        <div class="row small-panel">
            <div class="panel panel-info col-md-12" id="imagePanel" style="margin-bottom: 0px;">
                <div class="panel-body">
                    <div class="row">
                        <div class="embed-responsive embed-responsive-16by9">
                            <video class="embed-responsive-item" controls="controls" preload="auto">
                                <source src="" type="" id='video_preview'>
                                Your browser does not support HTML5 video.
                            </video>
                        </div>                     
                        <div class="col-md-12" style="margin-top: 10px;">
                            <p>A good course image is critical to a course's success. It should grab the attention 
                            of the viewer and help them understand the essence of what the course has to offer.</p>
                            <p>All images will be reviewed to make sure they meet the requirements for publication,
                            please review the guidelines before you create your image.</p>
                            <p>If you would like some help, we have engaged a team of professional designers who can 
                            create a custom image for you. To receive your free image, fill out this simple request form.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End of add info lecture -->
        <div class="row small-panel">
            <div class="panel panel-info col-md-12" id="videoPanel">
                <div class="panel-body">
                    <form class='dropzone' action="/master/upload-video-intro" id="uploadVideoCourse">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <input type="hidden" name="course_id" id="course_id_video" value="">
                        <input type="hidden" name="video_id" id="videointro_id" value="">
                    </form>
                    <button class="btn btn-primary col-md-offset-5 hide" id="changeVideoCourse"> Change</button>
                </div>
            </div>
        </div> <!-- End of add info lecture -->
    </div>
    <!--/panel-body-->
</div>
<!--/panel-->

<script>
$(document).on('ready', function() {

    $('#uploadVideoCourse').dropzone({
                
        maxFilesize: 100,
        maxFiles: 1,
        acceptedFiles: 'video/*',
        addRemoveLinks: 'dictCancelUpload',
        init: function() {

            this.on("uploadprogress", function(file, progress) {
                console.log("File progress", progress);
                // $('#uploadVideo'+this.getId).find('li.cancel-addContent').remove();
            });
            this.on("maxfilesexceeded", function(file) {
                this.hiddenFileInput.removeAttribute('multiple');
                this.removeAllFiles();
                this.addFile(file);
            });
            this.on("canceled", function(file) {
                // check it out old upload or new upload to decide show or hide showVideo div.
                                 
            });

            this.on("complete", function (file) {
                console.log(file);
                if(this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                    $('#uploadVideoCourse').addClass('hide');
                    $('#changeVideoCourse').removeClass('hide');
                }   
            });
        },
        success: function(file,response){
            console.log(file);
            console.log(response);
            if(response.status){
                $('#video_preview').attr('src','/'+response.videointro.path).attr('type',file.type);
                $('video')[0].load();
                $('#videointro_id').val(response.videointro.id);
            }else{
                console.log(response);
            }          
            
        },
        error: function(file,errorMessage){
            console.log(errorMessage);
        }
    });

    $('#changeVideoCourse').click(function(){

        $('#uploadVideoCourse').removeClass('hide');
    });
});
</script>