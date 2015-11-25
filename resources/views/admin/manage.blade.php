@extends('public.layouts.app')


@section('content')
	<section>
		<video controls preload="auto">
            <source src="{{url('uploads/videos/5654875aa891dBoa_Hancock_hugs_Luffy(One_Piece_3D2Y).mp4')}}" type="video/mp4" id='video_preview'>
            Your browser does not support HTML5 video.
        </video>
	</section>
@stop

@section('footer')
	@include('public.layouts.footer')
@stop