 <div class="panel panel-info image panel-right">
    <div class="panel-heading">
        Update Avatar
    </div>
    <div class="panel-body">
        <div class="row small-panel">
            <div class="panel panel-info col-md-12" id="imagePanel" style="margin-bottom: 0px;">
                <div class="panel-body">
                    <div class="row">
                        <img src="{{(Auth::user()->image) ? '/'.Auth::user()->image->path : 'nothing'}}" alt="{{(Auth::user()->image) ? Auth::user()->image->img_name:''}}" class='col-md-12' width="700px" height="300px" id='img_preview'/>
                        <div class="col-md-12" style="margin-top: 10px;">
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End of add info lecture -->
        <div class="row small-panel">
            <div class="panel panel-info col-md-12" id="imagePanel">
                <div class="panel-body">
                    <form class="dropzone {{(Auth::user()->image) ? 'hide' : ''}}" action="/user/uploadphoto" id="uploadAvatarUser">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <input type="hidden" name="img_id" id="img_id" value="{{Auth::user()->image->id}}">
                    </form>
                    <button class="btn btn-primary col-md-offset-5 {{(Auth::user()->image) ? '' : 'hide'}}" id="changeAvatarUser"> Change</button>
                </div>
            </div>
        </div> <!-- End of add info lecture -->
    </div>
    <!--/panel-body-->
</div>
<!--/panel-->

<script>
$(document).on('ready', function() {

    $('#uploadAvatarUser').dropzone({
                
        maxFilesize: 10,
        maxFiles: 1,
        acceptedFiles: 'image/*',
        addRemoveLinks: 'dictCancelUpload',
        init: function() {

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
                    $('#uploadAvatarUser').addClass('hide');
                    $('#changeAvatarUser').removeClass('hide');
                }   
            });
        },
        success: function(file,response){
            console.log(file);
            console.log(response);
            if(response.status){
                $('#img_preview').attr('src','/'+response.image.path).attr('alt',response.image.img_name);
                $('#img_id').val(response.image.id);
                $('#sideUser').find('img').attr('src','/'+response.image.path).attr('alt',response.image.img_name);
            }else{
                console.log(response);
            }          
            
        }
    });

    $('#changeAvatarUser').click(function(){

        $('#uploadAvatarUser').removeClass('hide');
    });
});
</script>