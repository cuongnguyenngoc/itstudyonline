<div class="header-bottom"><!--header-bottom-->
	<div class="container">
		<div class="row">
			<div class="col-sm-9">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="mainmenu pull-left">
					<ul class="nav navbar-nav collapse navbar-collapse">
						<li><a href="index.html" class="active">IT STUDY ONLINE</a></li>
						<li class="dropdown"><a href="#">Learning course<i class="fa fa-angle-down"></i></a>
                            <ul role="menu" class="sub-menu">
                                <li><a href="#freecourse">Free courses</a></li>
								<li><a href="#coursesbycat">Courses by category</a></li> 
								<li><a href="#recommendcourse">Recommend courses</a></li>  
                            </ul>
                        </li> 
                        @if(Auth::check())
							<li><a href="{{url('disciple/watch-rank')}}">Rank of Course</a></li> 
                        @endif
						<li><a href="{{url('forum')}}">Forum</a></li> 
						<li><a href="contact-us.html">Contact</a></li>
					</ul>
				</div>
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
	</div>
</div><!--/header-bottom-->
<script type="text/javascript">
	function search(query)
{
	if (isEmpty(query)==false)
    {
		alert("Chưa nhập từ khóa cần tìm!");
		return false;
	}	
return true;
}
</script>