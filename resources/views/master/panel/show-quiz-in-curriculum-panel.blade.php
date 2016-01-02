"<div class='row small-panel' id='lec"+count+"'>"+
    "<div class='panel-collapse panel-danger col-md-12 showLecture' lecName='' id='showLecture"+count+"'>"+
         "<div class='panel-heading'>"+
         	"<div class='row'>"+
         		"<div id='lec_name"+count+"' class='col-md-10 lec-name' getId='"+count+"'>"+
         			"<i></i><span></span>"+
         			"<a href='javascript:void(0)' id='editLecture"+count+"' getId='"+count+"' style='margin-left: 20px; color: #fff;' class='edit-lecture hide'><span class='glyphicon glyphicon-edit'></span></a>"+
         			"<a href='javascript:void(0)' id='delLecture"+count+"' getId='"+count+"' getName='Quiz' style='margin-left: 10px; color: #fff;' class='del-lecture hide'><span class='glyphicon glyphicon-trash'></span></a>"+
         		"</div>"+
         		"<input type='hidden' value='' name='quiz_id' id='quiz_id"+count+"'/>"+
         		"<button class='btn btn-primary addContentBtn btn-sm col-md-2' id='addContentBtn"+count+"' data-toggle='collapse' data-target='#addContent"+count+"' aria-expanded='false' getId='"+count+"'>"+
         		"<span class='glyphicon glyphicon glyphicon-plus' aria-hidden='true'></span>"+
         		"Add Quiz Content"+
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
			         	"</div>"+
			         	"<div class='col-md-1 publish-lecture'>"+
			         		"<a href='javascript:void(0)' class='publish-quiz btn btn-success btn-sm hide' id='publish"+count+"' getId='"+count+"'> Publish</a>"+	
			         	"</div>"+
					"</div>"+
	            "</div>"+
			"</div>"+
			"<div class='panel-collapse panel-default collapse col-md-12' id='addContent"+count+"'>"+
         		"<div class='panel-body'>"+       			
					"<div class='row'>"+
					  	"<form id='addQuizQuestion"+count+"' class='addQuizQuestion' getId='"+count+"'>"+
					  		"<input type='hidden' name='que_id' id='que_id"+count+"'>"+
				      		"<div class='form-group'>"+
				      		 	"<label for='question'>Question: </label>"+
								"<textarea name='content' class='form-control content' rows='3' id='questionContent"+count+"' style='width:100%'></textarea>"+
							"</div>"+
							"<div class='form-group'>"+
				      		 	"<label for='answer'>Answers: </label>"+
				      		 	"<p> Type 4 answers to user choose, and remember to choose a right answer for above question </p>"+
								"<div class='input-group'>"+
							      	"<span class='input-group-addon'>"+
							        	"<input type='radio' name='optradio'>"+
							      	"</span>"+
							      	"<input type='text' class='form-control'>"+
							    "</div>"+
							    "<div class='input-group'>"+
							      	"<span class='input-group-addon'>"+
							        	"<input type='radio' name='optradio'>"+
							      	"</span>"+
							      	"<input type='text' class='form-control'>"+
							    "</div>"+
							    "<div class='input-group'>"+
							      	"<span class='input-group-addon'>"+
							        	"<input type='radio' name='optradio'>"+
							      	"</span>"+
							      	"<input type='text' class='form-control'>"+
							    "</div>"+
							    "<div class='input-group'>"+
							      	"<span class='input-group-addon'>"+
							        	"<input type='radio' name='optradio'>"+
							      	"</span>"+
							      	"<input type='text' class='form-control'>"+
							    "</div>"+
							"</div>"+
							"<button type='submit' class='btn btn-primary col-md-1'>Save</button>"+
				      	"</form>"+
					"</div>"+
                "</div>"+
            "</div>"+
        "</div>"+
    "</div>"+
"</div>" 