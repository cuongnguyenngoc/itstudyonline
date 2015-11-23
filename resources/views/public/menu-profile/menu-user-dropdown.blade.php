@if(Auth::guest())
	
@elseif(strcmp(Auth::user()->role->role_name, "admin"))
	@include('public.menu-profile.admin')
@elseif(strcmp(Auth::user()->role->role_name, "master"))
	@include('public.menu-profile.master')
@elseif(strcmp(Auth::user()->role->role_name, "disciple"))
	@include('public.menu-profile.disciple')
@else
	<p>{{Auth::user()->role->role_name}}</p>
@endif