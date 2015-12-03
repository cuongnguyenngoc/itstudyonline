
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

            <!-- column 2 -->

            <div class="col-md-9">
            <h2 style="text-align:center"><i></i>Photo</h2>
            <p style="text-align:center; font-size:15px">Add a Photo for your profile</p>

            {{-- @include('user.uploadphoto') --}}
            {{-- @include('user.photoadd') --}}
            <img src="nothing" alt="" class='col-md-12' width="300px" height="300px" id='img_preview'/>
       
            <div class="col-lg-12 text-center">
        
        
        <form class='dropzone' action="/user/uploadphoto" id="uploadImageCourse">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <input type="hidden" name="user_id" id="user_id_img" value="">
                <input type="hidden" name="img_id" id="img_id" value="">
        </form>
        <button class="btn btn-primary col-md-offset-5 hide" id="changeImageCourse"> Change</button>


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