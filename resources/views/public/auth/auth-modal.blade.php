<div class="container">
	<!-- Modal -->
	<div class="modal fade" id="authModal" role="dialog">
	    <div class="modal-dialog">
	      	<!-- Modal content-->
	      	<div class="modal-content">
	        	<div class="modal-header" style="padding:15x 50px;">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		<h4 id="modal-title"><span class="glyphicon"></span> <span>Login</span></h4>
	        	</div>
	        	<div id="modal-login">
		        	<div class="modal-body">
		          		{!! Form::open(['url' => 'login', 'role' => 'form', 'class' => 'row', 'id' => 'loginForm' ]) !!}
		          			<div class="col-md-6">
		          				<h5>Login with your account</h5>
		          				<div class="form-group">
			              			<div class="input-group input-group-md">
			              				<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
			              				{!! Form::email('email',null,['id'=>'email','placeholder'=>'Enter email','class'=>'form-control']) !!}
			              			</div>
			              			<div class="message"></div>
			            		</div>
			            		<div class="form-group">
						            <div class="input-group input-group-md">
			              				<span class="input-group-addon"><span class="glyphicon glyphicon-eye-open"></span></span>
			              				{!! Form::password('password',['id'=>'password','placeholder'=>'Enter password','class'=>'form-control'])!!}
			              			</div>
			              			<div class="message"></div>
			            		</div>
			            		<div class="checkbox">
			              			<label>{!! Form::checkbox('remember',null)!!}Remember me</label>
			            		</div>
			              		<button type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Login</button>
		          			</div>
		          			<div class="col-md-1">
		          				<h5>Or</h5>
		          			</div>
		            		<div class="col-md-6">
			              		<a class="btn btn-facebook col-sm-12 btn-md" style="margin-bottom: 10px; font-size: 16px;" href=""><i class="fa fa-facebook "></i> Login with Facebook</a>
	                    		<a class="btn btn-google-plus col-sm-12 btn-md" style="font-size: 16px;" href=""><i class="fa fa-google-plus"></i> Login with Google Plus</a>
		            		</div>
		              		
		          		{!! Form::close() !!}
		        	</div>
		        	<div class="modal-footer">
		          		<p>Don't have an account? <a href="#" id="signupLink">Sign Up</a></p>
		          		<p>Forgot <a href="#" id="passwdLink">Password?</a></p>
		        	</div>
	        	</div>
	        	<div id="modal-signup">
		        	<div class="modal-body">
		          		{!! Form::open(['url' => 'register', 'role' => 'form', 'id' => 'signupForm' ]) !!}
		          			<div class="form-group">
		              			<label for="fullname"> Full name</label>
		              			<div class="input-group input-group-md">
		              				<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
		              				{!! Form::text('fullname',null,['id'=>'fullname','placeholder'=>'Enter your full name','class'=>'form-control']) !!}
		              			</div>
		              			<div class="message"></div>
		            		</div>
		            		<div class="form-group">
		              			<label for="usrname"> Email</label>
		              			<div class="input-group input-group-md">
		              				<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
		              				{!! Form::email('email',null,['id'=>'email','placeholder'=>'Enter email','class'=>'form-control']) !!}
		              			</div>
		              			<div class="message"></div>
		            		</div>
		            		<div class="form-group">
					            <label for="psw"> Password</label>
					            <div class="input-group input-group-md">
		              				<span class="input-group-addon"><span class="glyphicon glyphicon-eye-open"></span></span>
		              				{!! Form::password('password',['id'=>'pwd','placeholder'=>'Enter password','class'=>'form-control'])!!}
		              			</div>
					            <div class="message"></div>
		            		</div>
		            		<div class="form-group">
					            <label for="confirm-psw"> Confirm password</label>
					            <div class="input-group input-group-md">
		              				<span class="input-group-addon"><span class="glyphicon glyphicon-eye-open"></span></span>
		              				{!! Form::password('password_confirmation',['id'=>'confirmPwd','placeholder'=>'Confirm password','class'=>'form-control'])!!}
		              			</div>
					            <div class="message"></div>
		            		</div>
		            		<div class="checkbox">
		              			<label>{!! Form::checkbox('decision',null,['checked'])!!}To be the first person gets newest courses or news</label>
		            		</div>
		              		<button type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Sign Up</button>
		          		{!! Form::close() !!}
		        	</div>
		        	<div class="modal-footer">
		          		<p>Already have an account? <a href="#" id="loginLink">Login</a></p>
		        	</div>
	        	</div>
	        	<div id="modal-forgotPwd">
		        	<div class="modal-body">
		          		{!! Form::open(['url' => '', 'role' => 'form', 'id' => 'resetPwdForm' ]) !!}
		            		<div class="form-group">
		              			<label for="usrname"> Email</label>
		              			<div class="input-group input-group-md">
		              				<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
		              				{!! Form::email('email',null,['id'=>'email','placeholder'=>'Enter email','class'=>'form-control']) !!}
		              			</div>
		              			<div class="message"></div>
		            		</div>
		              		<button type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Reset Password</button>
		          		{!! Form::close() !!}
		        	</div>
		        	<div class="modal-footer">
		          		<p>Already have an account? <a href="#" id="loginLink" onclick="login_selected();">Login</a></p>
		        	</div>
	        	</div>
	      	</div>
	    </div>
	</div> 
</div>
<script type="text/javascript">
// 	$(document).ready(function(){
		function login_selected(){
			$modalLogin.addClass('is-selected');
			$modalsignup.removeClass('is-selected');
			$modalPwd.removeClass('is-selected');
			$modalTitle.children('span').eq(0).addClass('glyphicon-lock');
			$modalTitle.children('span').eq(0).removeClass('glyphicon-cog');
			$modalTitle.children('span').eq(1).text(' LOGIN');
		}
// 	});
	
</script>