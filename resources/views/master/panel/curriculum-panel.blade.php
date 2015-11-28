 <div class="panel panel-info curriculum panel-right hide">
    <div class="panel-heading">
        Curriculum
    </div>
    <div class="panel-body">
        <!-- show lecture here -->
        <div id="curriculumPanel">
            @if($course && $course->lectures()->count() > 0)
                @foreach($course->lectures()->orderBy('order','asc')->get() as $lecture)
                    <div class='row small-panel' id='lec{{$lecture->order}}'>
                        <div class='panel-collapse panel-primary col-md-12' id='showLecture{{$lecture->order}}'>
                             <div class='panel-heading'>
                                <div class='row'>
                                    <div id='lec_name{{$lecture->order}}' class='col-md-10'>{{$lecture->lec_name}}</div>
                                    <input type='hidden' value='{{$lecture->id}}' name='lec_id' id='lec_id{{$lecture->order}}'>
                                    <button class='btn btn-primary addContentBtn btn-sm col-md-1 col-md-offset-1 collapse-lecture' id='addContentBtn{{$lecture->order}}' data-toggle='collapse' data-target='#addContent{{$lecture->order}}' aria-expanded='false' getId='{{$lecture->order}}'>
                                        <span class='glyphicon glyphicon-triangle-bottom' aria-hidden='true'></span>
                                    </button>
                                </div>
                             </div>
                             <div class='panel-body small-panel' id='collapseLecture{{$lecture->order}}'>

                                <div id='toggleAddContentDetail{{$lecture->order}}' class=''>
                                    <div class='panel-collapse panel-default col-md-12' id='addContentDetail{{$lecture->order}}'>
                                        <div class='panel-body' id='showVideo{{$lecture->order}}'>
                                            <div class='show-content-preview col-md-4'>
                                                @if($lecture->type == 'Video')
                                                    <a href='#lec{{$lecture->order}}' class='change-thumbnail' getId='"+this.getId+"'>
                                                        <img src='/{{$lecture->video->thumbnail->path}}' alt='{{$lecture->video->thumbnail->img_name}}' class='img-thumbnail' id='imgThumbnail{{$lecture->order}}'/>
                                                    </a>
                                                @elseif($lecture->type == 'Document')
                                                    <embed src='/{{$lecture->document->path}}' type='application/pdf' height='130' width='210'/>
                                                @else
                                                    <img src='/images/course/text-icon.png' alt='text' class='img-thumbnail'/>
                                                @endif
                                            </div>
                                            <div class='col-md-7 editContent'>
                                                @if($lecture->type == 'Video')
                                                    <p>{{$lecture->video->video_name}}</p>
                                                    <a href='#lec{{$lecture->order}}' class='change-video' id='changeVideo{{$lecture->order}}' getId='{{$lecture->order}}' getName="Video">
                                                        <span class='glyphicon glyphicon-edit'></span> Change Video
                                                    </a>
                                                @elseif($lecture->type == 'Document')
                                                    <p>{{$lecture->document->doc_name}}</p>
                                                    <a href='#lec{{$lecture->order}}' class='change-video' id='changeVideo{{$lecture->order}}' getId='{{$lecture->order}}' getName="Document">
                                                        <span class='glyphicon glyphicon-edit'></span> Change Document
                                                    </a>
                                                @else
                                                    <p>Text document</p>
                                                    <a href='#lec{{$lecture->order}}' class='change-video' id='changeVideo{{$lecture->order}}' getId='{{$lecture->order}}' getName="Text">
                                                        <span class='glyphicon glyphicon-edit'></span> Change Text
                                                    </a>
                                                @endif
                                                Or <a href='#lec{{$lecture->order}}' class='edit-content' id='editContent{{$lecture->order}}' getId='{{$lecture->order}}'> <span class='glyphicon glyphicon-edit'></span> Edit Content</a>   
                                            </div>
                                            <div class='col-md-1 publish-lecture'>
                                                <a href='#lec{{$lecture->order}}' class='publish btn btn-success btn-sm hide published' id='publish{{$lecture->order}}' getId='{{$lecture->order}}'> Publish</a>
                                            </div>
                                       </div>
                                        <div class='panel-body hide' id='uploadVideo{{$lecture->order}}'>
                                            <ul class='nav nav-tabs' style='padding-left: 0px;'>
                                                @if($lecture->type == 'Video')
                                                    <li class='active'><a data-toggle='tab' href='#video{{$lecture->order}}'>Add Video</a></li>
                                                @elseif($lecture->type == 'Document')
                                                    <li class='active'><a data-toggle='tab' href='#video{{$lecture->order}}'>Add Document</a></li>
                                                @else
                                                    <li class='active'><a data-toggle='tab' href='#video{{$lecture->order}}'>Add Text</a></li>
                                                @endif
                                                <li class='cancel-addContent' getId='{{$lecture->order}}'>
                                                    <a href='#lec{{$lecture->order}}' id='cancel{{$lecture->order}}'> Cancel</a>
                                                </li>
                                            </ul>
                                            <div class='tab-content'>
                                                @if($lecture->type == 'Video')
                                                    <div id='video{{$lecture->order}}' class="tab-pane fade in active">
                                                       <form id='addVideo{{$lecture->order}}' class="addVideo" getId='{{$lecture->order}}'>
                                                            <input type='hidden' name='_token' value='{!! csrf_token() !!}'>
                                                            <input type='hidden' name='video_id' id='video_id{{$lecture->order}}' value="{{($lecture->video) ? $lecture->video->id : null}}">
                                                            <input type='hidden' name='doc_id' id='doc_video_id{{$lecture->order}}' value="{{($lecture->document) ? $lecture->document->id : null}}">

                                                        </form>
                                                        <form id='addDocument{{$lecture->order}}' class="addVideo hide" getId='{{$lecture->order}}'>
                                                            <input type='hidden' name='_token' value='{!! csrf_token() !!}'>
                                                            <input type='hidden' name='doc_id' id='doc_id{{$lecture->order}}' value="{{($lecture->document) ? $lecture->document->id : null}}">
                                                            <input type='hidden' name='video_id' id='video_doc_id{{$lecture->order}}' value="{{($lecture->video) ? $lecture->video->id : null}}">
                                                        </form>
                                                    </div>
                                                    <div id='textContent{{$lecture->order}}' class="tab-pane fade in active hide">
                                                        <form id='addText{{$lecture->order}}' class='addText' getId='{{$lecture->order}}'>
                                                            <div class='form-group'>
                                                                <textarea name='textContent' class='form-control textContent' rows='10' id='textarea{{$lecture->order}}' style='width:100%'>{{$lecture->text}}</textarea>
                                                            </div>
                                                            <button type='submit' class='btn btn-primary col-md-1'>Save</button>
                                                        </form>
                                                    </div>
                                                @elseif($lecture->type == 'Document')
                                                    <div id='video{{$lecture->order}}' class="tab-pane fade in active">
                                                       <form id='addVideo{{$lecture->order}}' class="addVideo hide" getId='{{$lecture->order}}'>
                                                            <input type='hidden' name='_token' value='{!! csrf_token() !!}'>
                                                            <input type='hidden' name='video_id' id='video_id{{$lecture->order}}' value="{{($lecture->video) ? $lecture->video->id : null}}">
                                                            <input type='hidden' name='doc_id' id='doc_video_id{{$lecture->order}}' value="{{($lecture->document) ? $lecture->document->id : null}}">

                                                        </form>
                                                        <form id='addDocument{{$lecture->order}}' class="addVideo" getId='{{$lecture->order}}'>
                                                            <input type='hidden' name='_token' value='{!! csrf_token() !!}'>
                                                            <input type='hidden' name='doc_id' id='doc_id{{$lecture->order}}' value="{{($lecture->document) ? $lecture->document->id : null}}">
                                                            <input type='hidden' name='video_id' id='video_doc_id{{$lecture->order}}' value="{{($lecture->video) ? $lecture->video->id : null}}">
                                                        </form>
                                                    </div>
                                                    <div id='textContent{{$lecture->order}}' class="tab-pane fade in active hide">
                                                        <form id='addText{{$lecture->order}}' class='addText' getId='{{$lecture->order}}'>
                                                            <div class='form-group'>
                                                                <textarea name='textContent' class='form-control textContent' rows='10' id='textarea{{$lecture->order}}' style='width:100%'>{{$lecture->text}}</textarea>
                                                            </div>
                                                            <button type='submit' class='btn btn-primary col-md-1'>Save</button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <div id='video{{$lecture->order}}' class="tab-pane fade in active hide">
                                                       <form id='addVideo{{$lecture->order}}' class="addVideo hide" getId='{{$lecture->order}}'>
                                                            <input type='hidden' name='_token' value='{!! csrf_token() !!}'>
                                                            <input type='hidden' name='video_id' id='video_id{{$lecture->order}}' value="{{($lecture->video) ? $lecture->video->id : null}}">
                                                            <input type='hidden' name='doc_id' id='doc_video_id{{$lecture->order}}' value="{{($lecture->document) ? $lecture->document->id : null}}">

                                                        </form>
                                                        <form id='addDocument{{$lecture->order}}' class="addVideo" getId='{{$lecture->order}}'>
                                                            <input type='hidden' name='_token' value='{!! csrf_token() !!}'>
                                                            <input type='hidden' name='doc_id' id='doc_id{{$lecture->order}}' value="{{($lecture->document) ? $lecture->document->id : null}}">
                                                            <input type='hidden' name='video_id' id='video_doc_id{{$lecture->order}}' value="{{($lecture->video) ? $lecture->video->id : null}}">
                                                        </form>
                                                    </div>
                                                    <div id='textContent{{$lecture->order}}' class="tab-pane fade in active">
                                                        <form id='addText{{$lecture->order}}' class='addText' getId='{{$lecture->order}}'>
                                                            <div class='form-group'>
                                                                <textarea name='textContent' class='form-control textContent' rows='10' id='textarea{{$lecture->order}}' style='width:100%'>{{$lecture->text}}</textarea>
                                                            </div>
                                                            <button type='submit' class='btn btn-primary col-md-1'>Save</button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class='panel-body hide' id='chooseThumbnail{{$lecture->order}}'>
                                            <ul class='nav nav-tabs' style='padding-left: 0px;'>
                                                <li class='active'><a data-toggle='tab' href='#thumbnails{{$lecture->order}}'> Choose thumbnail</a></li>
                                            </ul>
                                            <div class='tab-content'>
                                                <div id='thumbnails{{$lecture->order}}' class='tab-pane fade in active'>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='panel-collapse panel-default col-md-12 collapse in hide' aria-expanded="true" id='addContent{{$lecture->order}}'>
                                        <div class='panel-heading'>Select content type</div>
                                        <div class='panel-body'>                 
                                            <div class='row'>
                                                <div class='col-xs-6 col-md-4'>
                                                    <a href='#lec{{$lecture->order}}' class='type-content thumbnail' getId='{{$lecture->order}}' getName='Video'>
                                                        <img src='...' alt='...'/>
                                                    </a>
                                                </div>
                                                <div class='col-xs-6 col-md-4'>
                                                    <a href='#lec{{$lecture->order}}' class='type-content thumbnail' getId='{{$lecture->order}}' getName='Document'>
                                                        <img src='...' alt='...'/>
                                                    </a>
                                                </div>
                                                <div class='col-xs-6 col-md-4'>
                                                    <a href='#lec{{$lecture->order}}' class='type-contentText thumbnail' getId='{{$lecture->order}}' getName='Text'>
                                                        <img src='...' alt='...'/>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id='toggleDescription{{$lecture->order}}'>
                                    <div class='panel-collapse panel-default col-md-12' id='addDescriptionArea{{$lecture->order}}'>
                                        <div class='panel-body'>
                                            <div id='showDescription{{$lecture->order}}' class='showDesClass' getId='{{$lecture->order}}'>{{$lecture->description}}</div>
                                            <form class='add-description hide' id='addDescription{{$lecture->order}}' getId='{{$lecture->order}}'>
                                                <div class='form-group'>
                                                    <label for='lec_description'>Lecture description</label>
                                                    <textarea class='form-control description-textarea' id='descriptionTextArea{{$lecture->order}}' name='description' placeholder='Enter lecture description' style='width:100%'>{{$lecture->description}}</textarea>
                                                </div>
                                                <button type='submit' class='btn btn-primary col-md-1'>Save</button>
                                                <p class='col-md-11'> or <a href='#lec{{$lecture->order}}' id='cancelDescription{{$lecture->order}}' class='cancel-description' getId='{{$lecture->order}}'>Cancel</a></p>
                                            </form>
                                        </div>
                                    </div>
                                    <button class='btn btn-primary addDescriptionBtn hide' id='{{$lecture->order}}' style='margin-top:0px;'>Add Description</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
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
        
        var attachDropzoneToForm = function(getName, getId){
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
                                    //$('#addDescription'+this.getId).addClass('hide');
                                    $('#showDescription'+this.getId).removeClass('hide');
                                    $('#publish'+this.getId).removeClass('hide');
                                }
                            }
                        }else{
                            // $divVideo.empty();
                            alert('<p>You need to upload file which has size be smaller 500M</p>');
                        }                       
                    });
                },
                success: function(file,response){

                    console.log(response);
                    if($('#publish'+this.getId).hasClass('published')){
                        $('#publish'+this.getId).removeClass('hide');
                        $('#showLecture'+this.getId)
                            .removeClass('panel-primary')
                            .addClass('panel-danger');
                        $('#publish'+this.getId).removeClass('published');
                    }

                    $('#addContentBtn'+this.getId).empty()
                        .html("<span class='glyphicon glyphicon-triangle-bottom' aria-hidden='true'></span>")
                        .addClass('collapse-lecture')
                        .removeClass('col-md-2')
                        .addClass('col-md-1 col-md-offset-1');

                    // Set value of textarea = null 
                    $('textarea#textarea'+this.getId).val(null);
                    alert( $('textarea#textarea'+this.getId));
                    if(getName=='Video'){
                        $('#changeVideo'+this.getId).html("<span class='glyphicon glyphicon-edit'></span> Change Video")
                                                    .attr('getName','Video');
                        $('#showVideo'+this.getId).find('div.show-content-preview').html(
                            "<a href='#lec"+this.getId+"' class='change-thumbnail' getId='"+this.getId+"'>"+
                                "<img src='/"+response.thumbnail.path+"' alt='"+response.thumbnail.img_name+"' class='img-thumbnail' id='imgThumbnail"+this.getId+"'/>"+
                            "</a>"
                        );
                        $('#showVideo'+this.getId).find('p').text(response.thumbnail.img_name);
                        // Set value for corresponding id
                        $('input#video_id'+this.getId).val(response.video.id);
                        $('input#video_doc_id'+this.getId).val(response.video.id);
                        $('input#doc_video_id'+this.getId).val(null);
                        $('input#doc_id'+this.getId).val(null);
                    }else{
                        $('#changeVideo'+this.getId).html("<span class='glyphicon glyphicon-edit'></span> Change Document")
                                                    .attr('getName','Document');
                        $('#showVideo'+this.getId).find('p').text(response.doc.doc_name);
                        $('#showVideo'+this.getId).find('div.show-content-preview').html(
                            "<embed src='/"+response.doc.path+"' type='"+file.type+"' height='130' width='210'/>"
                        );
                        // Set value for corresponding id
                        $('input#doc_id'+this.getId).val(response.doc.id);
                        $('input#doc_video_id'+this.getId).val(response.doc.id);
                        $('input#video_id'+this.getId).val(null);
                        $('input#video_doc_id'+this.getId).val(null);
                    }
                    
                }
            });
        }
        
        var chooseOrChangeContent = function(getName,getId){

            $('#addContent'+getId).addClass('hide');
            $('#addContentDetail'+getId).removeClass('hide');
            $('#addContentDetail'+getId).find('#uploadVideo'+getId+' a').first().text('Add '+getName);
            $('#showVideo'+getId).addClass('hide');
            $('#uploadVideo'+getId).removeClass('hide');
            $('#textContent'+getId).addClass('hide');
            $('#video'+getId).removeClass('hide');

            if(getName == 'Video'){
                $('#addVideo'+getId).removeClass('hide');
                $('#addDocument'+getId).addClass('hide');
            }else{
                $('#addDocument'+getId).removeClass('hide');
                $('#addVideo'+getId).addClass('hide');
            }

            attachDropzoneToForm(getName,getId);
        }

        var chooseOrChangeContentText = function(getName, getId){
            tinymce.init({
                selector: "textarea.textContent",
                plugins: [
                    "advlist autolink lists link image charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste jbimages"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link jbimages",
                setup: function(editor) {
                    editor.on('keyup', function(e) {
                        $('#textarea'+getId).val(e.target.innerText);
                    });
                }
            });

            $("form#addText"+getId).validate({  
                rules: {
                    textContent: {
                        required: true,
                        minlength: 37
                    }
                },
                messages: {
                    textContent: {
                        required: "Please enter your description",
                        minlength: "Text content should be minimax 500 characters"
                    }
                }        
            });

            $('#addContent'+getId).addClass('hide');
            $('#addContentDetail'+getId).removeClass('hide');
            $('#addContentDetail'+getId).find('#uploadVideo'+getId+' a').first().text('Add '+getName);
            $('#changeVideo'+getId).attr('getName',getName);
            $('#showVideo'+getId).addClass('hide');
            $('#uploadVideo'+getId).removeClass('hide');
            $('#textContent'+getId).removeClass('hide');
            $('#video'+getId).addClass('hide');
        }

        var addPluginTinymceAndValidationToForm = function(getId){
            tinymce.init({
                selector: "#descriptionTextArea"+getId,
                plugins: [
                    "code"
                ],
                toolbar: "undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image",
                setup: function(editor) {
                    editor.on('keyup', function(e) {
                        $('#descriptionTextArea'+getId).val(e.target.innerText);
                    });
                }
            });

            $("#addDescription"+getId).validate({  
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
        }

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

        var count = 0; //this variable was declared global
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
            $('#showLecture'+count).find('#lec_name'+count).text($('#lec_title').val());   
            $('#countLectures').text(count).attr('countLectures',count);
        });

        $('#curriculumPanel').on('click','button.addDescriptionBtn',function(){

            $('#addDescriptionArea'+this.id).removeClass('hide');
            // $.validator.unobtrusive.parse('#addDescription.'+this.id);
            var getId = this.id;
            
            addPluginTinymceAndValidationToForm(getId);

            $(this).addClass('hide');
        });

        $('#curriculumPanel').on('click','a.cancel-description',function(){
            // $('#addDescriptionArea'+$(this).attr('class')).addClass('hide');
            //This will check if showDescription div is empty so it will show Add Description button
            // If not, it will show content of showDescription
            var getId = $(this).attr('getId');
            if($('#showDescription'+getId).text()==''){
                $('#addDescriptionArea'+getId).addClass('hide');
                $('#'+getId).removeClass('hide');  //Cái này là button addDescription

            }else{
                $('#addDescription'+getId).addClass('hide');
                $('#showDescription'+getId).removeClass('hide');
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

        $('#curriculumPanel').on('submit','form.add-description',function(e){
            e.preventDefault();
            var getId = $(this).attr('getId');
            $('#showDescription'+getId)
                .removeClass('hide')
                .html($(this).find('#descriptionTextArea'+getId).val());
            $(this).addClass('hide');

            // $('#publish'+getId).removeClass('hide');
            //To show publish button when you edit something
            if($('#publish'+getId).hasClass('published')){
                $('#publish'+getId).removeClass('hide');
                $('#publish'+getId).removeClass('published');
                $('#showLecture'+getId).removeClass('panel-primary')
                                       .addClass('panel-danger');
            }else{
                if($('#showVideo'+getId).find('p').text() != ''){
                    $('#publish'+getId).removeClass('hide');
                }
            }
        });
        
        // When you click on div showDescription, it will show form to edit description content.
        $('#curriculumPanel').on('click','div.showDesClass',function(){
            $(this).addClass('hide');
            $('#addDescription'+$(this).attr('getId')).removeClass('hide');
            addPluginTinymceAndValidationToForm($(this).attr('getId'));
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

            chooseOrChangeContent(getName,getId);

        });
        
        $('#curriculumPanel').on('click','a.type-contentText',function(){

            var getId = $(this).attr('getId');
            var getName = $(this).attr('getName');

            chooseOrChangeContentText(getName, getId);

        });

        $('#curriculumPanel').on('submit','form.addText',function(e){

            e.preventDefault();
            var getId = $(this).attr('getId');
            var getName = $(this).attr('getName');

            //To show publish button when you edit something
            if($('#publish'+getId).hasClass('published')){
                $('#publish'+getId).removeClass('hide');
                $('#publish'+getId).removeClass('published');
                $('#showLecture'+getId).removeClass('panel-primary')
                                       .addClass('panel-danger');
            }

            $('#uploadVideo'+getId).addClass('hide');
            $('#showVideo'+getId).removeClass('hide');
            $('#toggleDescription'+getId).removeClass('hide');
            $('#addDescriptionArea'+getId).removeClass('hide');
            $('div#chooseThumbnail'+getId).addClass('hide');
            if($('#showDescription'+getId).text()==''){
                $('#addDescriptionArea'+getId).addClass('hide');
                $('#'+getId).removeClass('hide');  //This is button AddDescription.

            }else{
                $('#showDescription'+getId).removeClass('hide');
                $('#publish'+getId).removeClass('hide');
            }

            $('#addContentBtn'+getId).empty()
                        .html("<span class='glyphicon glyphicon-triangle-bottom' aria-hidden='true'></span>")
                        .addClass('collapse-lecture')
                        .removeClass('col-md-2')
                        .addClass('col-md-1 col-md-offset-1');

            $('#changeVideo'+getId).html("<span class='glyphicon glyphicon-edit'></span> Change Text");
            $('#showVideo'+getId).find('p').text('Text document');
            $('#showVideo'+getId).find('div.show-content-preview').html(
                "<img src='/images/course/text-icon.png' alt='text' class='img-thumbnail'/>"
            );

            // Set value null for corresponding id
            $('input#doc_id'+getId).val(null);
            $('input#video_id'+getId).val(null);
        });

        $('#curriculumPanel').on('click','div.editContent > a.change-video',function(){

            var getId = $(this).attr('getId');
            var getName = $(this).attr('getName');

            $('#chooseThumbnail'+getId).addClass('hide');
            if(getName == 'Text'){
                chooseOrChangeContentText(getName,getId);
            }else
                chooseOrChangeContent(getName,getId);
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
                data: {'id' : video_id, '_token' : '{{ csrf_token() }}'}, // remember that be must to pass data object type
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
                data: {'thumb_id' : thumb_id, '_token' : '{{ csrf_token() }}'}, // remember that be must to pass data object type
                success : function(response){
                    console.log(response);
                    $('#curriculumPanel').find('#imgThumbnail'+getId).attr('src','/'+response.thumbnail.path);
                    $('#curriculumPanel').find('#imgThumbnail'+getId).attr('alt',response.thumbnail.img_name);   
                }
            });
        });

        $('#curriculumPanel').on('click','div.publish-lecture a.publish',function(){
            
            var getId = $(this).attr('getId');
            var lecture = {};

            // $('#publish'+getId).addClass('disableBtn'); // Avoid to the second click 

            lecture.lec_name = $('#lec_name'+getId).text();
            lecture.course_id = $('#course_id').val();
            lecture.description = $('#showDescription'+getId).text();
            lecture.video_id = $('#video_id'+getId).val();
            lecture.doc_id = $('#doc_id'+getId).val();
            lecture.lec_id = $('input#lec_id'+getId).val();
            lecture.order = getId;
            lecture.text = $('textarea#textarea'+getId).val();
            lecture._token = '{{ csrf_token() }}';
            var itself = $(this);
            $.ajax({
                type: "POST",
                url : "/master/update-course",
                dataType: 'json',
                data: lecture, // remember that be must to pass data object type
                success : function(response){
                    console.log(response);
                    if(response.status){
                        $('input#lec_id'+getId).val(response.lecture.id);
                        itself.addClass('hide')
                              .addClass('published');
                        $('#showLecture'+getId).addClass('panel-primary')
                                               .removeClass('panel-danger');
                        $('#lecturesPublished').text(response.course.lectures.length).attr('lecturesPublished',response.course.lectures.length);
                    }
                },
                error: function(response){
                    console.log(response);
                    $('#publish'+getId).removeClass('disableBtn');
                }
            });
        });
    });

</script>
