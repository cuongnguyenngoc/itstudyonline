 <div class="panel panel-info curriculum panel-right hide" id="curriculum">
    <div class="panel-heading">
        Curriculum
    </div>
    @if($course && $course->bosscreatecourse() && !$course->usercreatecourse(Auth::user()->id)->can_edit_lec)
        <div class="panel-body" style="background-color: #F1F3F6; text-align: center; min-height: 326px;">
            You dont have permission to edit lectures, Try to ask your boss <a href="">{{$course->bosscreatecourse()->user->fullname}}</a> to learn more detail
        </div>
    <!--/panel-body-->
    @else
        <div class="panel-body">
            <!-- show lecture here -->
            <div id="curriculumPanel">
                @if($course && $course->lectures()->count() > 0)
                    @foreach($course->lectures()->orderBy('oldOrder','asc')->get() as $lecture)
                        @if($lecture->type != 'Quiz')
                            <div class='row small-panel' id='lec{{$lecture->oldOrder}}'>
                                <div class='panel-collapse panel-primary col-md-12 showLecture' lecName="{{$lecture->lec_name}}" id='showLecture{{$lecture->oldOrder}}'>
                                     <div class='panel-heading'>
                                        <div class='row'>
                                            <div id='lec_name{{$lecture->oldOrder}}' class='col-md-10 lec-name' getId='{{$lecture->oldOrder}}'>
                                                <i>Lecture {{$lecture->order}}: </i><span>{{$lecture->lec_name}}</span>
                                                <a href='javascript:void(0)' id='editLecture{{$lecture->oldOrder}}' getId='{{$lecture->oldOrder}}' style='margin-left: 20px; color: #fff;' class='edit-lecture hide'><span class='glyphicon glyphicon-edit'></span></a>
                                                <a href='javascript:void(0)' id='delLecture{{$lecture->oldOrder}}' getId='{{$lecture->oldOrder}}' getName="Lecture" style='margin-left: 10px; color: #fff;' class='del-lecture hide'><span class='glyphicon glyphicon-trash'></span></a>
                                            </div>
                                            <input type='hidden' value='{{$lecture->id}}' name='lec_id' id='lec_id{{$lecture->oldOrder}}'>
                                            <button class='btn btn-primary btn-sm col-md-1 col-md-offset-1 collapse-lecture' id='addContentBtn{{$lecture->oldOrder}}' data-toggle='collapse' data-target='#addContent{{$lecture->oldOrder}}' aria-expanded='false' getId='{{$lecture->oldOrder}}'>
                                                <span class='glyphicon glyphicon-triangle-bottom' aria-hidden='true'></span>
                                            </button>
                                        </div>
                                     </div>
                                     <div class='panel-body small-panel hide' id='collapseLecture{{$lecture->oldOrder}}'>
                                        <div id='divEditLecture{{$lecture->oldOrder}}' style='display:none;'>
                                            <form getId='{{$lecture->oldOrder}}' class='form-editLecture'>
                                                <input type='text' class='form-control' id='inputLecName{{$lecture->oldOrder}}' placeholder=' Type your lecture name'/>
                                                <button type='submit' class='btn btn-primary btn-md' style='margin-top: 10px; margin-bottom: 20px;'> Update</button>
                                            </form>
                                        </div>
                                        <div id='toggleAddContentDetail{{$lecture->oldOrder}}' class=''>
                                            <div class='panel-collapse panel-default col-md-12' id='addContentDetail{{$lecture->oldOrder}}'>
                                                <div class='panel-body' id='showVideo{{$lecture->oldOrder}}'>
                                                    <div class='show-content-preview col-md-4'>
                                                        @if($lecture->type == 'Video')
                                                            <a href='javascript:void(0)' class='change-thumbnail' getId='"+this.getId+"'>
                                                                <img src='/{{$lecture->video->thumbnail->path}}' alt='{{$lecture->video->thumbnail->img_name}}' class='img-thumbnail' id='imgThumbnail{{$lecture->oldOrder}}'/>
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
                                                            <a href='javascript:void(0)' class='change-video' id='changeVideo{{$lecture->oldOrder}}' getId='{{$lecture->oldOrder}}' getName="Video">
                                                                <span class='glyphicon glyphicon-edit'></span> Change Video
                                                            </a>
                                                        @elseif($lecture->type == 'Document')
                                                            <p>{{$lecture->document->doc_name}}</p>
                                                            <a href='javascript:void(0)' class='change-video' id='changeVideo{{$lecture->oldOrder}}' getId='{{$lecture->oldOrder}}' getName="Document">
                                                                <span class='glyphicon glyphicon-edit'></span> Change Document
                                                            </a>
                                                        @else
                                                            <p>Text document</p>
                                                            <a href='javascript:void(0)' class='change-video' id='changeVideo{{$lecture->oldOrder}}' getId='{{$lecture->oldOrder}}' getName="Text">
                                                                <span class='glyphicon glyphicon-edit'></span> Change Text
                                                            </a>
                                                        @endif
                                                        Or <a href='javascript:void(0)' class='edit-content' id='editContent{{$lecture->oldOrder}}' getId='{{$lecture->oldOrder}}'> <span class='glyphicon glyphicon-edit'></span> Edit Content</a>   
                                                    </div>
                                                    <div class='col-md-1 publish-lecture'>
                                                        <a href='javascript:void(0)' class='publish btn btn-success btn-sm hide published' id='publish{{$lecture->oldOrder}}' getId='{{$lecture->oldOrder}}'> Publish</a>
                                                    </div>
                                               </div>
                                                <div class='panel-body hide' id='uploadVideo{{$lecture->oldOrder}}'>
                                                    <ul class='nav nav-tabs' style='padding-left: 0px;'>
                                                        @if($lecture->type == 'Video')
                                                            <li class='active'><a data-toggle='tab' href='#video{{$lecture->oldOrder}}'>Add Video</a></li>
                                                        @elseif($lecture->type == 'Document')
                                                            <li class='active'><a data-toggle='tab' href='#video{{$lecture->oldOrder}}'>Add Document</a></li>
                                                        @else
                                                            <li class='active'><a data-toggle='tab' href='#video{{$lecture->oldOrder}}'>Add Text</a></li>
                                                        @endif
                                                        <li class='cancel-addContent' getId='{{$lecture->oldOrder}}'>
                                                            <a href='javascript:void(0)' id='cancel{{$lecture->oldOrder}}'> Cancel</a>
                                                        </li>
                                                    </ul>
                                                    <div class='tab-content'>
                                                        @if($lecture->type == 'Video')
                                                            <div id='video{{$lecture->oldOrder}}' class="tab-pane fade in active">
                                                                <form id='addVideo{{$lecture->oldOrder}}' class="addVideo" getId='{{$lecture->oldOrder}}'>
                                                                    <input type='hidden' name='_token' value='{!! csrf_token() !!}'>
                                                                    <input type='hidden' name='video_id' id='video_id{{$lecture->oldOrder}}' value="{{($lecture->video) ? $lecture->video->id : null}}">
                                                                    <input type='hidden' name='doc_id' id='doc_video_id{{$lecture->oldOrder}}' value="{{($lecture->document) ? $lecture->document->id : null}}">

                                                                </form>
                                                                <form id='addDocument{{$lecture->oldOrder}}' class="addVideo hide" getId='{{$lecture->oldOrder}}'>
                                                                    <input type='hidden' name='_token' value='{!! csrf_token() !!}'>
                                                                    <input type='hidden' name='doc_id' id='doc_id{{$lecture->oldOrder}}' value="{{($lecture->document) ? $lecture->document->id : null}}">
                                                                    <input type='hidden' name='video_id' id='video_doc_id{{$lecture->oldOrder}}' value="{{($lecture->video) ? $lecture->video->id : null}}">
                                                                </form>
                                                            </div>
                                                            <div id='textContent{{$lecture->oldOrder}}' class="tab-pane fade in active hide">
                                                                <form id='addText{{$lecture->oldOrder}}' class='addText' getId='{{$lecture->oldOrder}}'>
                                                                    <div class='form-group'>
                                                                        <textarea name='textContent' class='form-control textContent' rows='10' id='textarea{{$lecture->oldOrder}}' style='width:100%'>{{$lecture->text}}</textarea>
                                                                    </div>
                                                                    <button type='submit' class='btn btn-primary col-md-1'>Save</button>
                                                                </form>
                                                            </div>
                                                        @elseif($lecture->type == 'Document')
                                                            <div id='video{{$lecture->oldOrder}}' class="tab-pane fade in active">
                                                                <form id='addVideo{{$lecture->oldOrder}}' class="addVideo hide" getId='{{$lecture->oldOrder}}'>
                                                                    <input type='hidden' name='_token' value='{!! csrf_token() !!}'>
                                                                    <input type='hidden' name='video_id' id='video_id{{$lecture->oldOrder}}' value="{{($lecture->video) ? $lecture->video->id : null}}">
                                                                    <input type='hidden' name='doc_id' id='doc_video_id{{$lecture->oldOrder}}' value="{{($lecture->document) ? $lecture->document->id : null}}">

                                                                </form>
                                                                <form id='addDocument{{$lecture->oldOrder}}' class="addVideo" getId='{{$lecture->oldOrder}}'>
                                                                    <input type='hidden' name='_token' value='{!! csrf_token() !!}'>
                                                                    <input type='hidden' name='doc_id' id='doc_id{{$lecture->oldOrder}}' value="{{($lecture->document) ? $lecture->document->id : null}}">
                                                                    <input type='hidden' name='video_id' id='video_doc_id{{$lecture->oldOrder}}' value="{{($lecture->video) ? $lecture->video->id : null}}">
                                                                </form>
                                                            </div>
                                                            <div id='textContent{{$lecture->oldOrder}}' class="tab-pane fade in active hide">
                                                                <form id='addText{{$lecture->oldOrder}}' class='addText' getId='{{$lecture->oldOrder}}'>
                                                                    <div class='form-group'>
                                                                        <textarea name='textContent' class='form-control textContent' rows='10' id='textarea{{$lecture->oldOrder}}' style='width:100%'>{{$lecture->text}}</textarea>
                                                                    </div>
                                                                    <button type='submit' class='btn btn-primary col-md-1'>Save</button>
                                                                </form>
                                                            </div>
                                                        @else
                                                            <div id='video{{$lecture->oldOrder}}' class="tab-pane fade in active hide">
                                                               <form id='addVideo{{$lecture->oldOrder}}' class="addVideo hide" getId='{{$lecture->oldOrder}}'>
                                                                    <input type='hidden' name='_token' value='{!! csrf_token() !!}'>
                                                                    <input type='hidden' name='video_id' id='video_id{{$lecture->oldOrder}}' value="{{($lecture->video) ? $lecture->video->id : null}}">
                                                                    <input type='hidden' name='doc_id' id='doc_video_id{{$lecture->oldOrder}}' value="{{($lecture->document) ? $lecture->document->id : null}}">

                                                                </form>
                                                                <form id='addDocument{{$lecture->oldOrder}}' class="addVideo" getId='{{$lecture->oldOrder}}'>
                                                                    <input type='hidden' name='_token' value='{!! csrf_token() !!}'>
                                                                    <input type='hidden' name='doc_id' id='doc_id{{$lecture->oldOrder}}' value="{{($lecture->document) ? $lecture->document->id : null}}">
                                                                    <input type='hidden' name='video_id' id='video_doc_id{{$lecture->oldOrder}}' value="{{($lecture->video) ? $lecture->video->id : null}}">
                                                                </form>
                                                            </div>
                                                            <div id='textContent{{$lecture->oldOrder}}' class="tab-pane fade in active">
                                                                <form id='addText{{$lecture->oldOrder}}' class='addText' getId='{{$lecture->oldOrder}}'>
                                                                    <div class='form-group'>
                                                                        <textarea name='textContent' class='form-control textContent' rows='10' id='textarea{{$lecture->oldOrder}}' style='width:100%'>{{$lecture->text}}</textarea>
                                                                    </div>
                                                                    <button type='submit' class='btn btn-primary col-md-1'>Save</button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class='panel-body hide' id='chooseThumbnail{{$lecture->oldOrder}}'>
                                                    <ul class='nav nav-tabs' style='padding-left: 0px;'>
                                                        <li class='active'><a data-toggle='tab' href='#thumbnails{{$lecture->oldOrder}}'> Choose thumbnail</a></li>
                                                    </ul>
                                                    <div class='tab-content'>
                                                        <div id='thumbnails{{$lecture->oldOrder}}' class='tab-pane fade in active'>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='panel-collapse panel-default col-md-12 collapse hide' aria-expanded="true" id='addContent{{$lecture->oldOrder}}'>
                                                <div class='panel-heading'>Select content type</div>
                                                <div class='panel-body'>                 
                                                    <div class='row'>
                                                        <div class='col-xs-6 col-md-4'>
                                                            <a href='javascript:void(0)' class='type-content thumbnail' getId='{{$lecture->oldOrder}}' getName='Video'>
                                                                <img src='/images/video-icon.png' alt='Video content' style='height: 60px;'/>
                                                            </a>
                                                        </div>
                                                        <div class='col-xs-6 col-md-4'>
                                                            <a href='javascript:void(0)' class='type-content thumbnail' getId='{{$lecture->oldOrder}}' getName='Document'>
                                                                <img src='/images/doc-icon.png' alt='Document content' style='height: 60px;'/>
                                                            </a>
                                                        </div>
                                                        <div class='col-xs-6 col-md-4'>
                                                            <a href='javascript:void(0)' class='type-contentText thumbnail' getId='{{$lecture->oldOrder}}' getName='Text'>
                                                                <img src='/images/text-icon.jpg' alt='Text content' style='height: 60px;'/>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id='toggleDescription{{$lecture->oldOrder}}'>
                                            <div class='panel-collapse panel-default col-md-12' id='addDescriptionArea{{$lecture->oldOrder}}'>
                                                <div class='panel-body'>
                                                    <div id='showDescription{{$lecture->oldOrder}}' class='showDesClass' getId='{{$lecture->oldOrder}}'>{{$lecture->description}}</div>
                                                    <form class='add-description hide' id='addDescription{{$lecture->oldOrder}}' getId='{{$lecture->oldOrder}}'>
                                                        <div class='form-group'>
                                                            <label for='lec_description'>Lecture description</label>
                                                            <textarea class='form-control description-textarea' id='descriptionTextArea{{$lecture->oldOrder}}' name='description' placeholder='Enter lecture description' style='width:100%'>{{$lecture->description}}</textarea>
                                                        </div>
                                                        <button type='submit' class='btn btn-primary col-md-1'>Save</button>
                                                        <p class='col-md-11'> or <a href='javascript:void(0)' id='cancelDescription{{$lecture->oldOrder}}' class='cancel-description' getId='{{$lecture->oldOrder}}'>Cancel</a></p>
                                                    </form>
                                                </div>
                                            </div>
                                            <button class='btn btn-primary addDescriptionBtn hide' id='{{$lecture->oldOrder}}' style='margin-top:0px;'>Add Description</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class='row small-panel' id='lec{{$lecture->oldOrder}}'>
                                <div class='panel-collapse panel-primary col-md-12 showLecture' lecName='{{$lecture->lec_name}}' id='showLecture{{$lecture->oldOrder}}'>
                                     <div class='panel-heading'>
                                        <div class='row'>
                                            <div id='lec_name{{$lecture->oldOrder}}' class='col-md-10 lec-name' getId='{{$lecture->oldOrder}}'>
                                                <i>Quiz {{$lecture->order}}:</i><span> {{$lecture->lec_name}}</span>
                                                <a href='javascript:void(0)' id='editLecture{{$lecture->oldOrder}}' getId='{{$lecture->oldOrder}}' style='margin-left: 20px; color: #fff;' class='edit-lecture hide'><span class='glyphicon glyphicon-edit'></span></a>
                                                <a href='javascript:void(0)' id='delLecture{{$lecture->oldOrder}}' getId='{{$lecture->oldOrder}}' getName='Quiz' style='margin-left: 10px; color: #fff;' class='del-lecture hide'><span class='glyphicon glyphicon-trash'></span></a>
                                            </div>
                                            <input type='hidden' value='{{$lecture->id}}' name='quiz_id' id='quiz_id{{$lecture->oldOrder}}'/>
                                            <button class='btn btn-primary btn-sm col-md-1 col-md-offset-1 collapse-lecture' id='addContentBtn{{$lecture->oldOrder}}' data-toggle='collapse' data-target='#addContent{{$lecture->oldOrder}}' aria-expanded='false' getId='{{$lecture->oldOrder}}'>
                                                <span class='glyphicon glyphicon-triangle-bottom' aria-hidden='true'></span>
                                            </button>
                                        </div>
                                     </div>
                                     <div class='panel-body small-panel hide' id='collapseLecture{{$lecture->oldOrder}}'>
                                        <div id='divEditLecture{{$lecture->oldOrder}}' style='display:none;'>
                                            <form getId='{{$lecture->oldOrder}}' class='form-editLecture'>
                                                <input type='text' value="{{$lecture->lec_name}}" class='form-control' id='inputLecName{{$lecture->oldOrder}}' placeholder=' Type your quiz name'/>
                                                <button type='submit' class='btn btn-primary btn-md' style='margin-top: 10px; margin-bottom: 20px;'> Update</button>
                                            </form>
                                        </div>
                                        <div id='toggleAddContentDetail{{$lecture->oldOrder}}' class=''>
                                            <div class='panel-collapse panel-default col-md-12' id='addContentDetail{{$lecture->oldOrder}}'>
                                                <div class='panel-body' id='showVideo{{$lecture->oldOrder}}'>
                                                    <div class='show-content-preview col-md-4'>
                                                        <img src='/images/quiz-icon.png' alt='Quiz' class='img-thumbnail'/>
                                                    </div>
                                                    <div class='col-md-7 editContent'>
                                                        <p>Question Quiz</p>
                                                        <a href='javascript:void(0)' class='change-video' id='changeVideo{{$lecture->oldOrder}}' getId='{{$lecture->oldOrder}}' getName='Quiz'>
                                                            <span class="glyphicon glyphicon-edit"></span>
                                                            Change question
                                                        </a>
                                                    </div>
                                                    <div class='col-md-1 publish-lecture'>
                                                        <a href='javascript:void(0)' class='publish-quiz btn btn-success btn-sm hide' id='publish{{$lecture->oldOrder}}' getId='{{$lecture->oldOrder}}'> Publish</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='panel-collapse panel-default collapse col-md-12 hide' id='addContent{{$lecture->oldOrder}}'>
                                            <div class='panel-body'>                
                                                <div class='row'>
                                                    <form id='addQuizQuestion{{$lecture->oldOrder}}' class='addQuizQuestion' getId='{{$lecture->oldOrder}}'>
                                                        <input type='hidden' name='que_id' id='que_id{{$lecture->oldOrder}}' value="{{$lecture->questions[0]->id}}">
                                                        <div class='form-group'>
                                                            <label for='question'>Question: </label>
                                                            <textarea name='content' class='form-control content' rows='3' id='questionContent{{$lecture->oldOrder}}' style='width:100%'>{{$lecture->questions[0]->content}}</textarea>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label for='answer'>Answers: </label>
                                                            <p> Type 4 answers to user choose, and remember to choose a right answer for above question </p>
                                                            @if($lecture->questions[0]->answers()->count() > 1)
                                                                @foreach($lecture->questions[0]->answers as $answer)
                                                                    <div class='input-group'>
                                                                        <span class='input-group-addon'>
                                                                            <input type='radio' name='optradio' {{($answer->isRight)?'checked':''}}>
                                                                        </span>
                                                                        <input type='text' class='form-control' value="{{$answer->content}}">
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <button type='submit' class='btn btn-primary col-md-1'>Save</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
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
                                <input type="text" class="form-control lec-title" id="lec_title" placeholder="Enter lecture name" name="lec_name">
                                <div class="message"></div>
                            </div>
                            <button type="submit" class="btn btn-primary" style="margin-top:0px;">Add Lecture</button>
                        </form>
                    </div>
                </div>
            </div> <!-- End of add info lecture -->
            <!-- Add info of quiz here -->
            <div class="row small-panel">
                <div class="panel-collapse panel-info collapse col-md-12" id="addQuizPanel">
                    <div class="panel-body">
                        <form id="addQuiz">
                            <div class="form-group">
                                <label for="quiz_name">New Quiz</label>
                                <input type="text" class="form-control quiz-title" id="quiz_title" placeholder="Enter quiz name" name="quiz_name">
                                <div class="message"></div>
                            </div>
                            <button type="submit" class="btn btn-primary" style="margin-top:0px;">Add quiz</button>
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
                    <button type="button" class="btn btn-primary btn-lg" style="width: 100%; margin-top:0px;" data-toggle="collapse" data-target="#addQuizPanel" aria-expanded="false">
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
    @endif
</div>
<!--/panel-->
<script type="text/javascript">
    $(document).ready(function(){
        var addUniqueQuizName = function(){
            var checkQuizExisted = true;
            $.validator.addMethod(
                "uniqueQuizName", 
                function(value, element) {
                    
                    $('#curriculumPanel').find('div.small-panel').each(function(){
                        var input = $(this).text();
                        if($(this).find('.showLecture').attr('lecName') === value){
                            checkLecExisted = false;
                            return false;
                        };
                    });
                    return checkLecExisted;
                }
            );
        }

        var addUniqueLectureName = function(){
            var checkLecExisted = true;
            $.validator.addMethod(
                "uniqueLectureName", 
                function(value, element) {
                    
                    $('#curriculumPanel').find('div.small-panel').each(function(){
                        var input = $(this).text();
                        if($(this).find('.showLecture').attr('lecName') === value){
                            checkLecExisted = false;
                            return false;
                        };
                    });
                    return checkLecExisted;
                }
            );
        }

        $("#lec_title").on('keyup',function(e){
            addUniqueLectureName();
            
            $('#addLecture').validate({
                rules: { 
                    lec_name : {
                        required : true,
                        remote: {
                            url: '/master/check-lecture-existed',
                            type: 'post',
                            dataType: 'json'
                        },
                        uniqueLectureName: true
                    }
                },
                messages: {
                    lec_name: {
                        required: "Please enter new Lecture's name",
                        remote: "This lecture's name was taken, please type another lecture's name",
                        uniqueLectureName: "This lecture's name was taken, please type another lecture's name"
                    }
                },
                errorPlacement: function (error , element) { 
                    element.parents('div.form-group').find('.message').html(error);
                } 
            });
        });
        //var count = 0; //this variable was declared global
        var count = {{($course->id && $course->lectures()->count() != 0) ? $course->lectures()->orderBy('oldOrder','asc')->get()->last()->oldOrder : '0'}};
        var numberofLectures = {{($course->id) ? $course->lectures()->count() : '0'}};
        $("#addLecture").on('submit',function(e){
            if($(this).valid()){
                e.preventDefault();

                {{($course->id)?'preventLoadPage()':''}};
                count++;
                numberofLectures++;
                if(count == 1){
                    $('#curriculumPanel').prepend(
                        @include('master.panel.show-lecture-in-curriculum-panel') // In show file, it have had count variable already to recognize lecture own.
                    );
                }else{
                    $('#curriculumPanel').append(
                        @include('master.panel.show-lecture-in-curriculum-panel') // In show file, it have had count variable already to recognize lecture own.
                    );
                }
                var input = $('#lec_title').val();
                $('#showLecture'+count).find('#lec_name'+count+' > span').text($('#lec_title').val());
                $('#showLecture'+count).find('#lec_name'+count+' > i').text('Lecture: ');
                $('#showLecture'+count).attr('lecName',$('#lec_title').val());
                $('#countLectures').text(numberofLectures - numberLecturesBeDeleted).attr('countLectures',(numberofLectures - numberLecturesBeDeleted));
                $('#lec_title').val(null);
            }
        });

        $("#addQuiz").on('submit',function(e){
            if($(this).valid()){
                e.preventDefault();

                {{($course->id)?'preventLoadPage()':''}};
                count++;
                if(count == 1){
                    $('#curriculumPanel').prepend(
                        @include('master.panel.show-quiz-in-curriculum-panel') // In show file, it have had count variable already to recognize lecture own.
                    );
                }else{
                    $('#curriculumPanel').append(
                        @include('master.panel.show-quiz-in-curriculum-panel') // In show file, it have had count variable already to recognize lecture own.
                    );
                }
                var input = $('#quiz_title').val();
                $('#showLecture'+count).find('#lec_name'+count+' > span').text($('#quiz_title').val());
                $('#showLecture'+count).find('#lec_name'+count+' > i').text('Quiz: ');
                $('#showLecture'+count).attr('lecName',$('#quiz_title').val());
                $('#quiz_title').val(null);
            }
        });

        $('#curriculumPanel').on('submit','form.addQuizQuestion',function(e){
            var getId = $(this).attr('getId');
            e.preventDefault();
            preventLoadPage();
            
            $('#addContent'+getId).addClass('hide');
            $('#toggleAddContentDetail'+getId).removeClass('hide');
            $('#addContentDetail'+getId).removeClass('hide');
            $('#showVideo'+getId).removeClass('hide');
            //To show publish button when you edit something
            $('#publish'+getId).removeClass('hide');
            if($('#publish'+getId).hasClass('published')){
                $('#publish'+getId).removeClass('hide');
                $('#publish'+getId).removeClass('published');
                $('#showLecture'+getId).removeClass('panel-primary')
                                       .addClass('panel-danger');
            }

            $('#addContentBtn'+getId).empty()
                        .html("<span class='glyphicon glyphicon-triangle-bottom' aria-hidden='true'></span>")
                        .addClass('collapse-lecture')
                        .removeClass('col-md-2')
                        .addClass('col-md-1 col-md-offset-1');

            $('#changeVideo'+getId).html("<span class='glyphicon glyphicon-edit'></span> Change question").attr('getName','Quiz');
            $('#showVideo'+getId).find('p').text('Question Quiz');
            $('#showVideo'+getId).find('div.show-content-preview').html(
                "<img src='/images/quiz-icon.png' alt='Quiz' class='img-thumbnail'/>"
            );
        });

        $('#curriculumPanel').on('click','a.publish-quiz',function(e){
            var getId = $(this).attr('getId');

            preventLoadPage();
            var answers = [];
            var itself = $(this);
            $('#addQuizQuestion'+getId).find('.input-group').each(function(){
                var answer = [];
                answer.push($(this).find('input[type=radio]').is(':checked'));
                answer.push($(this).find('input[type=text]').val());
                answers.push(answer);
            });

            var quiz = {};
            quiz.content = $('#questionContent'+getId).val();
            quiz.answers = answers;
            quiz.course_id = $('#course_id').val();
            quiz.lec_name = $('#lec_name'+getId).find('span').first().text();
            quiz.lec_id = $('#quiz_id'+getId).val();
            quiz.oldOrder = getId;
            quiz.que_id = $('#que_id'+getId).val();
            $.ajax({
                type: "POST",
                url : "/master/add-quiz",
                dataType: 'json',
                data: quiz, // remember that be must to pass data object type
                success : function(response){
                    console.log(response);
                    if(response.status){
                        preventLoadPage();
                        $('#quiz_id'+getId).val(response.quiz.id);
                        $('#que_id'+getId).val(response.question.id);
                        itself.addClass('hide')
                              .addClass('published');
                        $('#showLecture'+getId).addClass('panel-primary')
                                               .removeClass('panel-danger');
                        var n = noty({text: response.message, layout: 'top', type: 'success', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });
                    }else{
                        var n = noty({text: response.message, layout: 'top', type: 'error', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });
                    }
                }
            });
        });

        $('#curriculumPanel').on('mouseover','div.lec-name',function(){
            $('#editLecture'+$(this).attr('getId')).removeClass('hide');
            $('#delLecture'+$(this).attr('getId')).removeClass('hide');
        });
        $('#curriculumPanel').on('mouseout','div.lec-name',function(){
            $('#editLecture'+$(this).attr('getId')).addClass('hide');
            $('#delLecture'+$(this).attr('getId')).addClass('hide');
        });

        $('#curriculumPanel').on('click','a.edit-lecture',function(){
            var getId = $(this).attr('getId');
            $('#collapseLecture'+getId).removeClass('hide');
            $('#divEditLecture'+getId).fadeIn(1000);
            $('#inputLecName'+getId).val($('#lec_name'+getId).find('span').first().text());
        });

        $('#curriculumPanel').on('submit','.form-editLecture',function(e){
            var getId = $(this).attr('getId');
            e.preventDefault();

            preventLoadPage();

            $('#lec_name'+getId).find('span').first().text($('#inputLecName'+getId).val());
            $('#divEditLecture'+getId).fadeOut(100);

            if($('#publish'+this.getId).hasClass('published')){
                $('#publish'+this.getId).removeClass('hide');
                $('#showLecture'+this.getId)
                    .removeClass('panel-primary')
                    .addClass('panel-danger');
                $('#publish'+this.getId).removeClass('published');
            }else{
                if($('#showVideo'+getId).find('p').text() != ''){
                    $('#publish'+getId).removeClass('hide');
                }
            }
            $('#showLecture'+getId)
                    .removeClass('panel-primary')
                    .addClass('panel-danger');

        });

        var numberLecturesBeDeleted = 0;
        $('#curriculumPanel').on('click','a.del-lecture',function(){

            
            var getId = $(this).attr('getId');
            var getName = $(this).attr('getName');
            if(getName=='Lecture'){

                var lecture = {};
                lecture.lec_id = $('#lec_id'+getId).val();
                lecture.doc_id = $('#doc_id'+getId).val();
                lecture.video_id = $('#video_id'+getId).val();
                lecture.course_id = $('#course_id').val();
                var r = confirm('Do you wanna delete this Lecture?');
            }else{
                var quiz = {};
                quiz.quiz_id = $('#quiz_id'+getId).val();
                var r = confirm('Do you wanna delete this Quiz?');
            }
            
            if (r == true) {

                $.ajax({
                    type: "POST",
                    url : (getName=='Lecture')?"/course/delete-lecture":"/master/delete-quiz",
                    dataType: 'json',
                    data: (getName=='Lecture')?lecture:quiz, // remember that be must to pass data object type
                    success : function(response){
                        console.log(response);
                        if(response.status){
                            $('#lec'+getId).remove();
                            preventLoadPage();
                            var n = noty({text: response.message, layout: 'top', type: 'success', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });
                            if(getName=='Lecture'){
                                numberLecturesBeDeleted++;

                                $('#lecturesPublished').text(response.lectures.length).attr('lecturesPublished',response.lectures.length);;
                                
                                $('#countLectures').text(numberofLectures - numberLecturesBeDeleted);
                            }
                        }
                    }
                });
            }
        });

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
                        $('#uploadVideo'+this.getId+' > ul').append("<li class='cancel-addContent' getId='"+this.getId+"'><a href='javascript:void(0)' id='cancel"+this.getId+"'> Cancel</a></li>");
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
                                preventLoadPage();
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
                    if(getName=='Video'){
                        $('#changeVideo'+this.getId).html("<span class='glyphicon glyphicon-edit'></span> Change Video")
                                                    .attr('getName','Video');
                        $('#showVideo'+this.getId).find('div.show-content-preview').html(
                            "<a href='javascript:void(0)' class='change-thumbnail' getId='"+this.getId+"'>"+
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
            preventLoadPage();
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
            preventLoadPage();
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
            }else if(getName == 'Quiz'){
                $('#toggleAddContentDetail'+getId).addClass('hide');
                $('#addContent'+getId).addClass('in').removeClass('hide');
                
            }else{
                chooseOrChangeContent(getName,getId);
            }
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
                            "<a href='javascript:void(0)' class='choose-thumbnail' getId='"+getId+"' getValue='"+response.thumbnails[i].id+"'>"+
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
                    preventLoadPage();
                    console.log(response);
                    $('#curriculumPanel').find('#imgThumbnail'+getId).attr('src','/'+response.thumbnail.path);
                    $('#curriculumPanel').find('#imgThumbnail'+getId).attr('alt',response.thumbnail.img_name);   
                }
            });
        });

        $('#curriculumPanel').on('click','div.publish-lecture a.publish',function(){
            
            var getId = $(this).attr('getId');
            var lecture = {};   

            lecture.lec_name = $('#lec_name'+getId).find('span').first().text();
            lecture.course_id = $('#course_id').val();
            lecture.description = $('#showDescription'+getId).text();
            lecture.video_id = $('#video_id'+getId).val();
            lecture.doc_id = $('#doc_id'+getId).val();
            lecture.lec_id = $('input#lec_id'+getId).val();
            lecture.oldOrder = getId;
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
                        preventLoadPage();

                        $('input#lec_id'+getId).val(response.lecture.id);
                        itself.addClass('hide')
                              .addClass('published');
                        $('#showLecture'+getId).addClass('panel-primary')
                                               .removeClass('panel-danger');
                        $('#lecturesPublished').text(response.lectures.length).attr('lecturesPublished',response.lectures.length);
                        var n = noty({text: response.message, layout: 'top', type: 'success', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });
                    }else{
                        var n = noty({text: response.message, layout: 'top', type: 'error', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });
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
