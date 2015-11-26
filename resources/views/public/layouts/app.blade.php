<!DOCTYPE html>
<html lang="en">
<head>
    @include('public.layouts.resources.link-css')
    @yield('css')
    @include('public.layouts.resources.scripts')
    <!-- @yield('script') -->
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

    <!-- @include('public.layouts.resources.scripts') -->
    @yield('script')
</body>
</html>