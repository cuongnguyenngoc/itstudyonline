@extends('public.layouts.app')

@section('header')
	@include('public.layouts.header')
@stop

@section('content')
	<div class="container">
		<p>{{$role->id}}</p>
		<p>{{$role->role_name}}</p>
	</div>
	<div class="container">
		<h1>Write something here</h1>

		{!! Form::open(['url' => 'register', 'role' => 'form', 'class' => 'row', 'id' => 'loginForm' ]) !!}
			<div class="form-group">
				{!! Form::label('name','Name') !!}
				{!! Form::text('name',null,['class'=>'form-control','foo'=>'bar']) !!}
			</div>
		{!! Form::close() !!}
	</div>
	<div>You are logged in</div>
@stop

@section('footer')
	@include('public.layouts.footer')
@stop