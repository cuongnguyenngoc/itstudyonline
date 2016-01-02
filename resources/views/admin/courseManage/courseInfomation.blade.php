 @extends('admin.home')
 @section('admin-content')
 <style type="text/css">
 	#box-right{
 		border: 1px #e4e4e4 solid;
 		padding: 20px;
 		border-radius: 4px;
 		box-shadow: 0 0 6px #ccc;
 		background-color: #fff;
 		border-radius: 20px;
 		-moz-border-radius: 20px;
 		-webkit-border-radius: 20px;
 	}

 	p{
 		font-family: "Times New Roman";
 		font-size: 20px;
 		margin: 20px;
 		margin-left: 20px;
 		margin-right: 20px;
 		margin-top: 20px;
 		
 		

 	}
 	#img{
 		border: 1px #e4e4e4 solid;
 		padding: 20px;
 		border-radius: 4px;
 		box-shadow: 0 0 6px #ccc;
 		background-color: #fff;
 		border-radius: 20px;
 		-moz-border-radius: 20px;
 		-webkit-border-radius: 20px;
 	}
 	.left{
 		float: left;
 		width: 50%;
 		height: 50%;
 		background-color: #D3D3D3;
 		border: 5px solid #CDCDCD;
 		margin-bottom: 5px;
 		/*boder*/
 		border: 1px #e4e4e4 solid;
 		padding: 20px;
 		border-radius: 4px;
 		box-shadow: 0 0 6px #ccc;
 		background-color: #fff;
 		border-radius: 20px;
 		-moz-border-radius: 20px;
 		-webkit-border-radius: 20px;

 	}
 	.right{
 		float: right;
 		width: 50%;
 		height: 50%;
 		text-align: right;
 		border: 1px #e4e4e4 solid;
 		padding: 20px;
 		border-radius: 4px;
 		box-shadow: 0 0 6px #ccc;
 		background-color: #fff;
 		border-radius: 20px;
 		-moz-border-radius: 20px;
 		-webkit-border-radius: 20px;
 		
 	}
 	.description{
 		text-align: center;
 		border: 1px #e4e4e4 solid;
 		padding: 20px;
 		border-radius: 4px;
 		box-shadow: 0 0 6px #ccc;
 		background-color: #fff;
 		border-radius: 20px;
 		-moz-border-radius: 20px;
 		-webkit-border-radius: 20px;
 	}
 	
 	#title{
 		width: auto;
 		height: 50px;
 		background-color: #337ab7;
 		font-size: 20px;
 		color: #FE980F;
 		font-family: Time New Roman;
 		text-align: center;
 		/*boder*/
 		border: 1px #e4e4e4 solid;
 		padding: 20px;
 		border-radius: 4px;
 		box-shadow: 0 0 6px #ccc;
 		background-color: #337ab7;
 		border-radius: 20px;
 		-moz-border-radius: 20px;
 		-webkit-border-radius: 20px;
 	}
 	#infomation{
 		border: 1px #e4e4e4 solid;
 		padding: 20px;
 		border-radius: 4px;
 		box-shadow: 0 0 6px #ccc;
 		background-color: #fff;
 		border-radius: 20px;
 		-moz-border-radius: 20px;
 		-webkit-border-radius: 20px;
 	}

   /* id : #
    class : .
    */
    

</style>
<div id="box-right">
	<div id="title">
		<strong>
			Infomation Course
		</strong>
		
	</div>
	
	<div id="infomation">
		<div id="img">
			<p>
				<img src="/{{($course->image)?$course->image->path:'nothing'}}" width="150px" height="150px">
			</p>
		</div>
		<div class="left">
			<p>
				<strong>
					Name : 
				</strong>
				{{$course->course_name}}
			</p>
			<p>
				<strong>
					Category : 
				</strong>
				{{$course->category->cat_name}}	
			</p>
			<p>
				<strong>
					Languages : 
				</strong>
				{{$course->language->lang_name}}	
			</p>
			<p>
				<strong>
					Learn Level : 
				</strong>
				{{$course->level->level_name}}	
			</p>
		</div>

		<!-- box right -->
		<div class="right">
			<p id="cost">
				<strong>
					Cost : 
				</strong>
				$ {{$course->cost}}
			</p>
			<p>
				<strong>
					Public :
				</strong>
				@if ($course->isPublic==0)
					Not Yet	
				@else
					Already
				@endif
				
			</p>
			<p>
				<strong>
					Shares :

				</strong>
				{{$course->shares}}
				
			</p>
			<p>
				<strong>
					Views :
				</strong>
				{{$course->views}}
			</p>
		</div>
		<hr  width="30%" align="center" color="red" />
		<div class="description">
			{!!$course->description!!}
		</div> 
		</div>
		
	</div>
@stop













