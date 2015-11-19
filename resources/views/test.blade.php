@extends('public.layouts.app')

<script>
</script>
oh guy
@foreach($thumbnails as $thumbnail)
	oh guy {{$thumbnail}}
@endforeach

@section('footer')
	@include('public.layouts.footer')
@stop

