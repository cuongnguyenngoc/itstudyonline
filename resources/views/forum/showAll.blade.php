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

<!-- Main -->
<div class="container main">
    <div class="row">
        <div class="col-md-12">
            @include('forum.panel.menu-panel',  ['items'=> $items, 'cateName' => $cateName])
        </div>
    </div>
    <div class = "row">
        <div class="col-md-12">
            <table class="table table-striped" id = "cateList">
                <colgroup>
                    <col style="width:60%">
                    <col style="width:10%">
                    <col style="width:10%">
                    <col style="width:10%">
                </colgroup>  
                <thead>
                    <tr>
                        <th>Topic</th>
                        <th>Category</th>
                        <th>Replies</th>
                        <th>Activity</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($topics))
                    @foreach($topics as  $value)
                    <tr>
                        @foreach($value as  $val)
                        <td>{{ $val }}</td>
                        @endforeach
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>

@stop

@section('script')
<script>
    $(document).ready(function () {
        $('div.btn-group ul.dropdown-menu li a').click(function (e) {
            var $div = $(this).parent().parent().parent();
            var $btn = $div.find('button');
            var text = $(this).text();
            $btn.html(text + ' <span class="caret"></span>');
            e.preventDefault();
            $(location).attr('href', '/forum/category/' + encodeURIComponent($(this).text()));
            return false;
        });
        
        $('table#cateList tr').click(function (event){
            $(location).attr('href', '/forum/topic/' + encodeURIComponent($(this).find('td:first').text()));
        });
    });
</script>


@stop

