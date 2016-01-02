<!DOCTYPE html>
<html lang="en">
<head>
    @include('public.layouts.resources.link-css')
    @yield('css')
    @include('public.layouts.resources.scripts')
    <style type="text/css">
		#nprogress .bar {
		    background:#58D550;
		    padding: 2px;
		}
		#nprogress .spinner-icon {
		    border-top-color:#58D550;
		    border-left-color:#58D550;
		    padding: 15px;
		    left: 500px;
		}
		#nprogress .peg {
		    box-shadow: 0 0 10px #58D550, 0 0 5px #58D550;
		}
    </style>
</head><!--/head-->

<body>
	<header id="header"><!--header-->
		@yield('header-top')
			@if($errors->count())
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong>Errors!</strong>
				<ul>
				@foreach($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
				</ul>
			</div>
			@endif
		@yield('header-middle')
		@yield('header-bottom')
	</header>

	@yield('content')
  	@yield('footer-top')
  	@yield('footer-bottom')

    @yield('script')
    <script type="text/javascript">
    	var preventLoadPage = function(){
	    	$(window).on("beforeunload", function() {
	            return "Are you sure? You didn't finish the form! Please submit first to avoid lose your data";
	        });
	    }
    </script>
</body>
</html>