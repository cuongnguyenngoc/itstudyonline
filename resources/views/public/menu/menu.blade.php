@if(Auth::guest())
	@include('public.menu.guest-menu')
@elseif(Auth::user()->role->role_name == 'admin')
	@include('public.menu.admin-menu')
@elseif(Auth::user()->role->role_name == 'master')
	@include('public.menu.master-menu')
@elseif(Auth::user()->role->role_name == 'disciple')
	@include('public.menu.disciple-menu')
@else
	<p>What's wrong</p>
@endif