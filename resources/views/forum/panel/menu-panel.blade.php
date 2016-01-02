<div class = "row">
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {!! $cateName!!} <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            @foreach ($items as $item)
            <li><a href="#">{{$item->cat_name }}</a></li>
             @endforeach
             <li class="divider"></li>
             <li><a href="{{URL::to('forum/category/create')}}">New Category</a></li>
            </ul>
        </div>
        <a class="btn pull-right btn-default" id="newTopic" type="button" href="javascript:void(0)"><span class = "glyphicon glyphicon-plus"> </span> New Topic</a>
        
    </div>
    @if(Auth::check())
        <script>{{ 'var signin = true;' }}</script>
    @else
        <script>{{ 'var signin = false;' }}</script>
    @endif

<script type="text/javascript">
    
    $('#newTopic').click(function(e){
        if(!signin){
            $("#authModal").modal();
            login_selected();
        }else{
            window.location.href = "{{URL::to('forum/topic/create')}}";
        }
    });
</script>
    


