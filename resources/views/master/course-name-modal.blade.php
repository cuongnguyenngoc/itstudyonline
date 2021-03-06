<div class="container">
	<!-- Modal -->
	<div class="modal fade" id="courseModal" role="dialog">
		<div class="row">
	    <div class="modal-dialog rol-md-12">
	      	<!-- Modal content-->
	      	<div class="modal-content">
	        	<div class="modal-header" style="padding:15x 50px;">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title"><span class="glyphicon"></span> <span>Ready to Create a Course?</span></h4>
	          		<h4 id="modal-title"><span class="glyphicon"></span> <span>First enter name of Course: </span></h4>
	        	</div>
		        <div class="modal-body">
	          		{!! Form::open(['url' => 'create-course', 'role' => 'form', 'class' => 'row', 'id' => 'courseNameForm' ]) !!}
	          			
          				<div class="form-group">
	              			<div class="input-group input-group-md">
	              				<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
	              				{!! Form::text('course_name',null,['id'=>'course_name','placeholder'=>'Enter course name','class'=>'form-control']) !!}
	              			</div>
	              			<div class="message"></div>
	            		</div>
	              		<button type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Create Course</button>
	          			
	          		{!! Form::close() !!}
	          	</div>
	      	</div>
	    </div>
	    </div>
	</div> 
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#courseNameForm").validate({  
			rules: {
				course_name: {
					required: true,
					minlength: 10
				}
			},
	        messages: {
	        	email: {
	        		required: "Please enter course name",
	        		minlength: "Course name has minimum be 10 characters"
	        	}
	        },
	        errorPlacement: function (error , element) { 
	            element.parents('div.form-group').find('.message').html(error);
	        }          
		});
	});
	
</script>