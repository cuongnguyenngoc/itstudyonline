"<div class='row small-panel' id='lec"+count+"'>"+
    "<div class='panel-collapse panel-primary col-md-12' id='showLecture"+count+"'>"+
         "<div class='panel-heading'>"+
         	"<div class='row'>"+
         		"<div id='lec_name' class='col-md-10'></div>"+
         		"<button class='btn btn-primary addContentBtn btn-sm col-md-2' data-toggle='collapse' data-target='#addContent"+count+"' aria-expanded='false' getId='"+count+"'>"+
         		"<span class='glyphicon glyphicon glyphicon-plus' aria-hidden='true'></span>"+
         		"Add Content"+
         		"</button>"+
         	"</div>"+
         "</div>"+
         "<div class='panel-body small-panel'>"+

         	"<div id='toggleAddContentDetail"+count+"' class='hide'>"+
	         	"<div class='panel-collapse panel-default col-md-12 hide' id='addContentDetail"+count+"'>"+
	         		"<div class='panel-body hide' id='showVideo"+count+"'>"+
			         	"This is show video, image area"+
					"</div>"+
		         	"<div class='panel-body' id='uploadVideo"+count+"'>"+
			         	"<ul class='nav nav-tabs' style='padding-left: 0px;'>"+
			 				"<li class='active'><a data-toggle='tab' href='#video"+count+"'></a></li>"+
						"</ul>"+
						"<div class='tab-content'>"+
						    "<div id='video"+count+"' class='tab-pane fade in active'>"+
						      	"<form action='/video/do-upload' id='addVideo"+count+"' class='addVideo'>"+
									"<input type='hidden' name='_token' value='{!! csrf_token() !!}'>"+
									
						      	"</form>"+
						    "</div>"+
						"</div>"+
					"</div>"+
	            "</div>"+
	         	"<div class='panel-collapse panel-default collapse col-md-12' id='addContent"+count+"'>"+
	         		"<div class='panel-heading'>Select content type</div>"+
	         		"<div class='panel-body'>"+       			
						"<div class='row'>"+
						  	"<div class='col-xs-6 col-md-4'>"+
						    	"<a href='#' class='thumbnail' getId='"+count+"' getName='Video'>"+
						      		"<img src='...' alt='...'>"+
						    	"</a>"+
						  	"</div>"+
						  	"<div class='col-xs-6 col-md-4'>"+
						    	"<a href='#' class='thumbnail' getId='"+count+"' getName='Text'>"+
						      		"<img src='...' alt='...'>"+
						    	"</a>"+
						  	"</div>"+
						  	"<div class='col-xs-6 col-md-4'>"+
						    	"<a href='#' class='thumbnail' getId='"+count+"' getName='Document'>"+
						      		"<img src='...' alt='...'>"+
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
	         			"<form id='addDescription' class='"+count+"'>"+
	                        "<div class='form-group'>"+
	                            "<label for='lec_description'>Lecture description</label>"+
	                            "<textarea class='form-control' id='lec_description' name='description' placeholder='Enter lecture description'></textarea>"+
	                        "</div>"+
	                        "<button type='submit' class='btn btn-primary col-md-1'>Save</button>"+
	                        "<p class='col-md-11'> or <a href='#lec"+count+"' id='cancelDescription' class='"+count+"'>Cancel</a></p>"+
	                    "</form>"+
	                "</div>"+
	            "</div>"+
				"<button class='btn btn-primary addDescriptionBtn' id='"+count+"' style='margin-top:0px;'>Add Description</button>"+
			"</div>"+
        "</div>"+
    "</div>"+
"</div>" 