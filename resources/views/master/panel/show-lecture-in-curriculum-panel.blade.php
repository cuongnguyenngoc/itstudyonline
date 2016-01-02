"<div class='row small-panel' id='lec"+count+"'>"+
    "<div class='panel-collapse panel-danger col-md-12 showLecture' lecName='' id='showLecture"+count+"'>"+
         "<div class='panel-heading'>"+
         	"<div class='row'>"+
         		"<div id='lec_name"+count+"' class='col-md-10 lec-name' getId='"+count+"'>"+
         			"<i></i><span></span>"+
         			"<a href='javascript:void(0)' id='editLecture"+count+"' getId='"+count+"' style='margin-left: 20px; color: #fff;' class='edit-lecture hide'><span class='glyphicon glyphicon-edit'></span></a>"+
         			"<a href='javascript:void(0)' id='delLecture"+count+"' getId='"+count+"' getName='Lecture' style='margin-left: 10px; color: #fff;' class='del-lecture hide'><span class='glyphicon glyphicon-trash'></span></a>"+
         		"</div>"+
         		"<input type='hidden' value='' name='lec_id' id='lec_id"+count+"'/>"+
         		"<button class='btn btn-primary addContentBtn btn-sm col-md-2' id='addContentBtn"+count+"' data-toggle='collapse' data-target='#addContent"+count+"' aria-expanded='false' getId='"+count+"'>"+
         		"<span class='glyphicon glyphicon glyphicon-plus' aria-hidden='true'></span>"+
         		"Add Content"+
         		"</button>"+
         	"</div>"+
         "</div>"+
         "<div class='panel-body small-panel' id='collapseLecture"+count+"'>"+
			"<div id='divEditLecture"+count+"' style='display:none;'>"+
				"<form getId='"+count+"' class='form-editLecture'>"+
					"<input type='text' class='form-control' id='inputLecName"+count+"' placeholder=' Type your lecture name'/>"+
					"<button type='submit' class='btn btn-primary btn-md' style='margin-top: 10px; margin-bottom: 20px;'> Update</button>"+
				"</form>"+
			"</div>"+
         	"<div id='toggleAddContentDetail"+count+"' class='hide'>"+
	         	"<div class='panel-collapse panel-default col-md-12 hide' id='addContentDetail"+count+"'>"+
	         		"<div class='panel-body hide' id='showVideo"+count+"'>"+
	         			"<div class='show-content-preview col-md-4'>"+
				         	
				        "</div>"+
			         	"<div class='col-md-7 editContent'>"+
			         		"<p></p>"+	
			         		"<a href='javascript:void(0)' class='change-video' id='changeVideo"+count+"' getId='"+count+"' getName=''></a>"+
			         		" Or <a href='javascript:void(0)' class='edit-content' id='editContent"+count+"' getId='"+count+"'> <span class='glyphicon glyphicon-edit'></span> Edit Content</a>"+	
			         	"</div>"+
			         	"<div class='col-md-1 publish-lecture'>"+
			         		"<a href='javascript:void(0)' class='publish btn btn-success btn-sm hide' id='publish"+count+"' getId='"+count+"'> Publish</a>"+	
			         	"</div>"+
					"</div>"+
		         	"<div class='panel-body' id='uploadVideo"+count+"'>"+
			         	"<ul class='nav nav-tabs' style='padding-left: 0px;'>"+
			 				"<li class='active'><a data-toggle='tab' href='#video"+count+"'></a></li>"+
			 				"<li class='cancel-addContent' getId='"+count+"'><a href='javascript:void(0)' id='cancel"+count+"'> Cancel</a></li>"+
						"</ul>"+
						"<div class='tab-content'>"+
						    "<div id='video"+count+"' class='tab-pane fade in active'>"+
						      	"<form id='addVideo"+count+"' class='addVideo hide' getId='"+count+"'>"+
									"<input type='hidden' name='_token' value='{!! csrf_token() !!}'>"+
									"<input type='hidden' name='video_id' id='video_id"+count+"' value=''>"+
									"<input type='hidden' name='doc_id' id='doc_video_id"+count+"' value=''>"+

						      	"</form>"+
						      	"<form id='addDocument"+count+"' class='addVideo hide' getId='"+count+"'>"+
									"<input type='hidden' name='_token' value='{!! csrf_token() !!}'>"+
									"<input type='hidden' name='doc_id' id='doc_id"+count+"' value=''>"+
									"<input type='hidden' name='video_id' id='video_doc_id"+count+"' value=''>"+
						      	"</form>"+
						    "</div>"+
						    "<div id='textContent"+count+"' class='tab-pane fade in active'>"+
						      	"<form id='addText"+count+"' class='addText' getId='"+count+"'>"+
						      		"<div class='form-group'>"+
										"<textarea name='textContent' class='form-control textContent' rows='10' id='textarea"+count+"' style='width:100%'></textarea>"+
									"</div>"+
									"<button type='submit' class='btn btn-primary col-md-1'>Save</button>"+
						      	"</form>"+
						    "</div>"+
						"</div>"+
					"</div>"+
					"<div class='panel-body hide' id='chooseThumbnail"+count+"'>"+
			         	"<ul class='nav nav-tabs' style='padding-left: 0px;'>"+
			 				"<li class='active'><a data-toggle='tab' href='#thumbnails"+count+"'> Choose thumbnail</a></li>"+
						"</ul>"+
						"<div class='tab-content'>"+
						    "<div id='thumbnails"+count+"' class='tab-pane fade in active'>"+

						    "</div>"+
						"</div>"+
					"</div>"+
	            "</div>"+
	         	"<div class='panel-collapse panel-default collapse col-md-12' id='addContent"+count+"'>"+
	         		"<div class='panel-heading'>Select content type</div>"+
	         		"<div class='panel-body'>"+       			
						"<div class='row'>"+
						  	"<div class='col-xs-6 col-md-4'>"+
						    	"<a href='javascript:void(0)' class='type-content thumbnail' getId='"+count+"' getName='Video'>"+
						      		"<img src='/images/video-icon.png' alt='Video content' style='height: 60px;' />"+
						    	"</a>"+
						  	"</div>"+
						  	"<div class='col-xs-6 col-md-4'>"+
						    	"<a href='javascript:void(0)' class='type-content thumbnail' getId='"+count+"' getName='Document'>"+
						      		"<img src='/images/doc-icon.png' alt='Document content' style='height: 60px;'/>"+
						    	"</a>"+
						  	"</div>"+
						  	"<div class='col-xs-6 col-md-4'>"+
						    	"<a href='javascript:void(0)' class='type-contentText thumbnail' getId='"+count+"' getName='Text'>"+
						      		"<img src='/images/text-icon.jpg' alt='Text content' style='height: 60px;'/>"+
						    	"</a>"+
						  	"</div>"+
						"</div>"+
	                "</div>"+
	            "</div>"+
			"</div>"+

            "<div id='toggleDescription"+count+"'>"+
	         	"<div class='panel-collapse panel-default col-md-12 hide' id='addDescriptionArea"+count+"'>"+
	         		"<div class='panel-body'>"+
	         			"<div id='showDescription"+count+"' class='hide showDesClass' getId='"+count+"'></div>"+
	         			"<form class='add-description' id='addDescription"+count+"' getId='"+count+"'>"+
	                        "<div class='form-group'>"+
	                            "<label for='lec_description'>Lecture description</label>"+
	                            "<textarea class='form-control description-textarea' id='descriptionTextArea"+count+"' name='description' placeholder='Enter lecture description' style='width:100%'></textarea>"+
	                        "</div>"+
	                        "<button type='submit' class='btn btn-primary col-md-1'>Save</button>"+
	                        "<p class='col-md-11'> or <a href='javascript:void(0)' id='cancelDescription"+count+"' class='cancel-description' getId='"+count+"'>Cancel</a></p>"+
	                    "</form>"+
	                "</div>"+
	            "</div>"+
				"<button class='btn btn-primary addDescriptionBtn' id='"+count+"' style='margin-top:0px;'>Add Description</button>"+
			"</div>"+
        "</div>"+
    "</div>"+
"</div>" 