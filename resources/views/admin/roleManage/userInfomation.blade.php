
@extends('admin.home')
@section('admin-content')
<style type="text/css">
	p{
		font-family: "Times New Roman";
		font-size: 20px;
		margin: 20px;
		margin-left: 20px;
		margin-right: 20px;
		margin-top: 20px;

	}
   /* id : #
    class : .
    */
    #user{
    	border: 1px #e4e4e4 solid;
    	padding: 20px;
    	border-radius: 4px;
    	box-shadow: 0 0 6px #ccc;
    	border-radius: 20px;
    	-moz-border-radius: 20px;
    	-webkit-border-radius: 20px;
    }
    #mainContent{
    	position: relative;
    	margin: 0px auto;
    	padding: 0px;
    	background-color:#F0F0F0 ;
    }
    #center{
    	background-color:#FFFFFF ;
    }
    #goBack{
    	text-align: center;
    	font-weight: 100;
    	font-size: 40px;
    }
    #user-img{
    	border: 1px #e4e4e4 solid;
    	padding: 20px;
    	border-radius: 4px;
    	box-shadow: 0 0 6px #ccc;
    	border-radius: 20px;
    	-moz-border-radius: 20px;
    	-webkit-border-radius: 20px;
    	height: 100px;
    	margin-right: 400px;
    	margin-left: 400px;
    }
    #content{
    	border: 1px #e4e4e4 solid;
    	padding: 20px;
    	border-radius: 4px;
    	box-shadow: 0 0 6px #ccc;
    	border-radius: 20px;
    	-moz-border-radius: 20px;
    	-webkit-border-radius: 20px;
    }


</style>




<div id="user">
	<div id="user-img">
		<img src="">
	</div>
	<div id="content">
		<p>
			<strong>
				Name : 
			</strong>                    
			{{$User->fullname}}
		</p>
		<p>
			<strong>
				Address : 
			</strong>
			{{$User->address}}
		</p>
		<p>
			<strong>
				Email : 
			</strong>
			{{$User->email}}
		</p>
		<p>
			<strong>
				Birth Day : 
			</strong>
			{{$User->birth}}
		</p>
		<p>
			<strong>
				Contact : {{$User->links}}
			</strong>
		</p>
		<p>
			<strong>
				Introduction :
			</strong>
			{{$User->biography}}
		</p>
		<p>
			<strong>
				Expert : 
			</strong>
			{{$User->expert}}
		</p>
	</div>
				<!-- <p id="goBack">
					<a href="{{route('admin.roleManage')}}">
					<span class="glyphicon glyphicon-step-backward"></span>
					<strong>Go Back</strong>
					</a>
				</p> -->

			</div>
			

			
			@stop








