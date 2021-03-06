@extends('public.layouts.app')

@section('css')
	
@stop

@section('header-top')
	@include('public.layouts.header.header-top')
@stop
@section('header-middle')
	@include('public.layouts.header.header-middle')
@stop
@section('header-bottom')
	@include('public.layouts.header.header-bottom')
@stop

@section('content')

	@include('public.layouts.slider')
	
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<!-- Left column -->
					<div class="left-sidebar" id="sidebar">
						<h2> Browser Courses</h2>
			            <ul class="nav nav-stacked left-sidebar" id="navLeftSidebar" style="background: #F0F0E9;">
			                <li class="nav-header"> 
			                	<a href="#category" data-parent="#navLeftSidebar" data-toggle="collapse">
			                		Category <i class="glyphicon glyphicon-chevron-right" style="margin-left: 157px;"></i>
			                	</a>
			                    <ul class="nav nav-stacked collapse" id="category">
			                    	@foreach($categories as $category)
			                        	<li><a href="#"> {{$category->cat_name}}</a></li>
			                        @endforeach
			                    </ul>
			                </li>
			                <li class="nav-header"> 
			                	<a href="#language" data-parent="#navLeftSidebar" data-toggle="collapse"> 
			                		Programming Language <i class="glyphicon glyphicon-chevron-right" style="margin-left: 63px;"></i>
			                	</a>

			                    <ul class="nav nav-stacked collapse" id="language">
			                        @foreach($languages as $language)
			                        	<li><a href="#"> {{$language->lang_name}}</a></li>
			                        @endforeach
			                    </ul>
			                </li>
			                <li class="nav-header">
			                    <a href="#level" data-parent="#navLeftSidebar" data-toggle="collapse"> 
			                    	Learning Level <i class="glyphicon glyphicon-chevron-right" style="margin-left: 122px;"></i>
			                    </a>
			                    <ul class="nav nav-stacked collapse" id="level">
				                    @foreach($levels as $level)
				                        <li><a href="#"> {{$level->level_name}}</a></li>
				                    @endforeach
			                    </ul>
			                </li>
			            </ul>
					</div>
				</div>
				
				<div class="col-sm-9 padding-right">
					<div class="features_items" id="freecourse"><!--features_items-->
						<h2 class="title text-center">Free Courses</h2>
						@foreach($usercreatecourses as $usercreatecourse)
							@if($usercreatecourse->course->cost == 0 && $usercreatecourse->course->isPublic == 1)
							<div class="col-sm-4">
								<div class="product-image-wrapper">
									<div class="single-products">
										<div class="productinfo text-center">
											<a href="" class="thumbnail">
												<img src="/{{$usercreatecourse->course->image->path}}" alt="{{$usercreatecourse->course->image->img_name}}" style="height: 240px;" />
											</a>
											<h2>{{$usercreatecourse->course->course_name}}</h2>
											<p>By {{$usercreatecourse->user->fullname}}</p>
										</div>
										<div class="product-overlay">
											<div class="overlay-content">
												<h2>{{$usercreatecourse->course->course_name}}</h2>
												<p><a href="">By {{$usercreatecourse->user->fullname}}</a></p>
												<a href="{{url('course/'.$usercreatecourse->course->id)}}" class="btn btn-default add-to-cart"> Detail</a>
											</div>
										</div>
									</div>
									<div class="choose">
										<ul class="nav nav-pills nav-justified">
											<li><h5><a href="#"><i class="glyphicon glyphicon-user"></i>{{$usercreatecourse->course->enrolls()->count()}} students enrolled</a></h5></li>
											<li><h5><i class="glyphicon glyphicon-usd"></i>{{($usercreatecourse->course->cost == 0) ? "FREE" : $usercreatecourse->course->cost." VND"}}</h5></li>
										</ul>
									</div>
								</div>
							</div>
							@endif
						@endforeach
					</div><!--features_items-->
					
					<div class="category-tab" id="coursesbycat"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								@foreach($categories as $category)
									<li><a href="#{{str_replace(' ','_',$category->cat_name)}}" data-toggle="tab">{{$category->cat_name}}</a></li>
								@endforeach
							</ul>
						</div>
						<div class="tab-content">
							@foreach($categories as $category)
								<div class="tab-pane fade" id="{{str_replace(' ','_',$category->cat_name)}}">
									@foreach($category->usercreatecourses()->where('isBoss',1)->get() as $usercreatecourse)
										@if($usercreatecourse->course->isPublic == 1)
										<div class="col-sm-3">
											<div class="product-image-wrapper">
												<div class="single-products">
													<div class="productinfo text-center">
														<img src="/{{$usercreatecourse->course->image->path}}" alt="" height="130px"/>
														<h2>{{$usercreatecourse->course->cost}} VND</h2>
														<p>{{$usercreatecourse->course->course_name}}</p>
														<a href="{{url('course/'.$usercreatecourse->course->id)}}" class="btn btn-default add-to-cart"> Detail</a>
													</div>									
												</div>
											</div>
										</div>
										@endif
									@endforeach
								</div>
							@endforeach
						</div>
					</div><!--/category-tab-->
					
					<div class="recommended_items" id="recommendcourse"><!--recommended_items-->
						<h2 class="title text-center">recommended courses</h2>
						
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								<div class="item active">
									@foreach($usercreatecourses as $usercreatecourse)	
										@if($usercreatecourse->course()->where('views','>',200)->first() != null && $usercreatecourse->course->isPublic == 1)
											<div class="col-sm-4">
												<div class="product-image-wrapper">
													<div class="single-products">
														<div class="productinfo text-center">
															<img src="/{{$usercreatecourse->course->image->path}}" alt="{{$usercreatecourse->course->image->img_name}}" height="160px"/>
															<h2>{{$usercreatecourse->course->cost}}</h2>
															<p>{{$usercreatecourse->course->course_name}}</p>
															<a href="{{url('course/'.$usercreatecourse->course->id)}}" class="btn btn-default add-to-cart"> Detail</a>
														</div>
													</div>
												</div>
											</div>
										@endif
									@endforeach
								</div>
							</div>
							 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>			
						</div>
					</div><!--/recommended_items-->
					
				</div>
			</div>
		</div>
	</section>
@stop

@section('footer-bottom')
	@include('public.layouts.footer.footer-bottom')
@stop

@section('script')
	<script type="text/javascript">
		$('div.category-tab ul.nav-tabs').find('li').first().addClass('active');
		$('div#{{($categories->first()) ? str_replace(' ','_',$categories->first()->cat_name) : ''}}').addClass('active in');
		var $sidebar   = $("#sidebar"), 
	        $window    = $(window),
	        offset     = $sidebar.offset(),
	        topPadding = 15,
	    	footer = $('#footer').offset(),
	    	sidebarDelta = footer.top - $("#header").offset().top - $("#header").outerHeight() - $("#slider").outerHeight() - $sidebar.outerHeight() - $('.recommended_items').outerHeight();
	    
	    $window.scroll(function() {
	    	console.log($window.scrollTop()+" - "+offset.top+" - "+footer.top);
	    	console.log(sidebarDelta +" = "+ Math.min($window.scrollTop() - offset.top + topPadding, sidebarDelta));
	        if ($window.scrollTop() > offset.top) {
	            $sidebar.stop().animate({
	                marginTop: Math.min($window.scrollTop() - offset.top + topPadding, sidebarDelta)
	            });
	        }else{
	        	$sidebar.stop().animate({
	                marginTop: 0
	            });
	        }
	    });
	</script>
@stop
