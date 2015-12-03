 <div class="panel panel-info image panel-right hide">
    <div class="panel-heading">
        Image
    </div>
    <div class="panel-body">
        <div class="row small-panel">
            <div class="panel panel-info col-md-12" id="imagePanel" style="margin-bottom: 0px;">
                <div class="panel-body">
                    <div class="row">
                        <img src="nothing" alt="" class='col-md-12' width="700px" height="300px" id='img_preview'/>
                        <div class="col-md-12" style="margin-top: 10px;">
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End of add info lecture -->
        <div class="row small-panel">
            <div class="panel panel-info col-md-12" id="imagePanel">
                <div class="panel-body">
                    <form class='dropzone' action="/master/upload-image" id="uploadImageCourse">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <input type="hidden" name="course_id" id="course_id_img" value="">
                        <input type="hidden" name="img_id" id="img_id" value="">
                    </form>
                    <button class="btn btn-primary col-md-offset-5 hide" id="changeImageCourse"> Change</button>
                </div>
            </div>
        </div> <!-- End of add info lecture -->
    </div>
    <!--/panel-body-->
</div>
<!--/panel-->

<script>
$(document).on('ready', function() {

    $('#uploadImageCourse').dropzone({
                
        maxFilesize: 10,
        maxFiles: 1,
        acceptedFiles: 'image/*',
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
                    $('#uploadImageCourse').addClass('hide');
                    $('#changeImageCourse').removeClass('hide');
                }   
            });
        },
        success: function(file,response){
            console.log(file);
            console.log(response);
            if(response.status){
                $('#img_preview').attr('src','/'+response.image.path).attr('alt',response.image.img_name);
                $('#img_id').val(response.image.id);
                $('#headCourse').find('img').attr('src','/'+response.image.path).attr('alt',response.image.img_name);
            }else{
                console.log(response);
            }          
            
        }
    });

    $('#changeImageCourse').click(function(){

        $('#uploadImageCourse').removeClass('hide');
    });
});
</script>