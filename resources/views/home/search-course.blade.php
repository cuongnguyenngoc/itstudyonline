@extends('public.layouts.app')

@section('css')
	
@stop

@section('header-top')
	@include('public.layouts.header.header-top')
@stop
@section('header-middle')
	@include('public.layouts.header.header-middle')
@stop

@section('content')
	<section>
		<div class="container" style="min-height: 500px;">
			<div class="row">
				<div class="col-md-5 col-md-offset-4">
					<h3 style="text-align: center; color: #444444;"> Result searching for keyword {{$query}}</h3>
				</div>
				<div class="col-sm-3">
				<form action="/search" method="GET" onsubmit="return tk(query.value);">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="search_box pull-right">
						<input type="text" placeholder="Search" name="query" id="query"/>
					</div>
				</form>
			</div>
			</div>
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
						<h2 class="title text-center">Result</h2>
						@if($courses->count() > 0)
							@foreach($courses as $course)
								<div class="col-sm-4">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<a href="" class="thumbnail">
													<img src="/{{$course->image->path}}" alt="{{$course->image->img_name}}" style="height: 240px;" />
												</a>
												<h2>{{$course->course_name}}</h2>
											</div>
											<div class="product-overlay">
												<div class="overlay-content">
													<h2>{{$course->course_name}}</h2>
													<a href="{{url('course/'.$course->id)}}" class="btn btn-default add-to-cart"> Detail</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							@endforeach
						@else
							<h5 style="text-align: center;">Nothing to show</h5>
						@endif
					</div><!--features_items-->
				</div>
			</div>
		</div>
		<div class="row">
        <div class="col-lg-4  col-lg-offset-5">
            {!! $courses->render() !!}
        </div>
    </div>
	</section>
@stop

@section('footer-bottom')
	@include('public.layouts.footer.footer-bottom')
@stop
