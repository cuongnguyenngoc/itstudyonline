
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="index.html"><img src="images/home/logo.png" alt="" /></a>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav" id="main-nav">
								<li><a href="#"><i class="fa fa-user"></i> Account</a></li>
								<li><a href="cart.html"><i class="fa fa-shopping-cart"></i> Cart</a></li>
								@if(Auth::guest())
									<li><a href="#" class="access" id="loginButton"><i class="fa fa-lock"></i> Login</a></li>
									<li><a href="#" class="access" id="signupButton"><i class="fa fa-lock"></i> SignUp</a></li>
								@else
									<li class="dropdown">
			                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->fullname }} <span class="caret"></span></a>
			                            <ul class="dropdown-menu" role="menu">
			                                <li><a href="logout">Logout</a></li>
			                            </ul>
			                        </li>
			                    @endif
							</ul>
						</div>
					</div>	
				</div>
			</div>
			@include('public.auth.auth-modal')
		</div><!--/header-middle-->
		
		@include('public.menu.menu')
		
		