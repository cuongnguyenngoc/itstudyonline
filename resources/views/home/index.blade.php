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
			                <li class="nav-header" id="cat"> 
			                	<a href="#manage" data-parent="#navLeftSidebar" data-toggle="collapse">
			                		Category <i class="glyphicon glyphicon-chevron-right" style="margin-left: 157px;"></i>
			                	</a>
			                    <ul class="nav nav-stacked collapse" id="manage">
			                    	@foreach($categories as $category)
			                        	<li><a href="#"> {{$category->cat_name}}</a></li>
			                        @endforeach
			                    </ul>
			                </li>
			                <li class="nav-header" id="prg"> 
			                	<a href="#language" data-parent="#navLeftSidebar" data-toggle="collapse"> 
			                		Programming Language <i class="glyphicon glyphicon-chevron-right" style="margin-left: 63px;"></i>
			                	</a>

			                    <ul class="nav nav-stacked collapse" id="language">
			                        @foreach($languages as $language)
			                        	<li><a href="#"> {{$language->lang_name}}</a></li>
			                        @endforeach
			                    </ul>
			                </li>
			                <li class="nav-header" id="level">
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
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Free Courses</h2>
						@foreach($usercreatecourses as $usercreatecourse)
							<div class="col-sm-4">
								<div class="product-image-wrapper">
									<div class="single-products">
										<div class="productinfo text-center">
											<a href="" class="thumbnail">
												<img src="/{{$usercreatecourse->course->image->path}}" alt="{{$usercreatecourse->course->image->img_name}}" style="height: 240px;" />
											</a>
											<h2>{{$usercreatecourse->course->course_name}}</h2>
											<p>By {{$usercreatecourse->user->fullname}}</p>
											<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Enroll</a>
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
											<li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
											<li><h5><i class="glyphicon glyphicon-usd"></i>{{($usercreatecourse->course->cost == 0) ? "FREE" : $usercreatecourse->course->cost." VND"}}</h5></li>
										</ul>
									</div>
								</div>
							</div>
						@endforeach
					</div><!--features_items-->
					
					<div class="category-tab"><!--category-tab-->
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
									@foreach($category->usercreatecourses as $usercreatecourse)
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
									@endforeach
								</div>
							@endforeach
						</div>
					</div><!--/category-tab-->
					
					<div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">recommended items</h2>
						
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								<div class="item active">	
									<div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
												<div class="productinfo text-center">
													<img src="/images/home/recommend1.jpg" alt="" />
													<h2>$56</h2>
													<p>Easy Polo Black Edition</p>
													<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
												</div>
												
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
												<div class="productinfo text-center">
													<img src="/images/home/recommend2.jpg" alt="" />
													<h2>$56</h2>
													<p>Easy Polo Black Edition</p>
													<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
												</div>
												
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
												<div class="productinfo text-center">
													<img src="/images/home/recommend3.jpg" alt="" />
													<h2>$56</h2>
													<p>Easy Polo Black Edition</p>
													<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
												</div>
												
											</div>
										</div>
									</div>
								</div>
								<div class="item">	
									<div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
												<div class="productinfo text-center">
													<img src="/images/home/recommend1.jpg" alt="" />
													<h2>$56</h2>
													<p>Easy Polo Black Edition</p>
													<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
												</div>
												
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
												<div class="productinfo text-center">
													<img src="/images/home/recommend2.jpg" alt="" />
													<h2>$56</h2>
													<p>Easy Polo Black Edition</p>
													<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
												</div>
												
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
												<div class="productinfo text-center">
													<img src="/images/home/recommend3.jpg" alt="" />
													<h2>$56</h2>
													<p>Easy Polo Black Edition</p>
													<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
												</div>
												
											</div>
										</div>
									</div>
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

@section('footer-top')
	@include('public.layouts.footer.footer-top')
@stop
@section('footer-bottom')
	@include('public.layouts.footer.footer-bottom')
@stop

@section('script')
	<script type="text/javascript">
		$('div.category-tab ul.nav-tabs').find('li').first().addClass('active');
		$('div#Database').addClass('active in');
	</script>
@stop
