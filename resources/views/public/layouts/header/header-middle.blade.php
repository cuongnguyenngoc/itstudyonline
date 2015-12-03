<div class="header-middle"><!--header-middle-->
	<div class="container">
		<div class="row">
			<div class="col-sm-4">
				<div class="logo pull-left">
					<a href="{{url('/')}}"><img src="/images/home/itstudyonline.png" alt="" /></a>
				</div>
			</div>
			<div class="col-sm-8">
				<div class="shop-menu pull-right">
					<ul class="nav navbar-nav" id="main-nav">
						@if(Auth::guest())
							<li><a href="#" class="access" id="loginButton"><i class="fa fa-lock"></i> Login</a></li>
							<li><a href="#" class="access" id="signupButton"><i class="fa fa-lock"></i> SignUp</a></li>
						@else
							<li class="dropdown">
	                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> {{ Auth::user()->fullname }} <span class="caret"></span></a>
	                            @include('public.menu-profile.menu-user-dropdown')
	                        </li>
	                    @endif
					</ul>
				</div>
			</div>		
		</div>
	</div>
	@include('public.auth.auth-modal')
</div><!--/header-middle-->

		
		
		