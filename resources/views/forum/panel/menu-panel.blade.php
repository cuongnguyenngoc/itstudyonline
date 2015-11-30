<div class = "row">
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {!! $cateName!!} <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li id = ><a href="#">UnCategory</a></li>
            @foreach ($items as $item)
            <li><a href="#">{{$item->cat_name }}</a></li>
             @endforeach
            </ul>
        </div>
        <a class="btn pull-right btn-default"  type="button" href="{{URL::to('forum/topic/create')}}"><span class = "glyphicon glyphicon-plus"> </span> New Topic</a>
        <a class="btn pull-right btn-default"  type="button" href="{{URL::to('forum/category/create')}}" ><span class = "glyphicon glyphicon-plus"> </span> New Category</a>
    </div>
    


