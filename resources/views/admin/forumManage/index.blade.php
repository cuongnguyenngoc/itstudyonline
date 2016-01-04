 @extends('admin.home')
 @section('admin-content')
 
 <style type="text/css">
  
  #contend{
    margin: 50px;
    padding: 20px;  
    background-color: #E8E8E8 ;
  }
  #name{
    font-weight: bold;
    font-size: 20px;
    color: #8C8C88;
    text-decoration: none;
  }
  #name:hover{
    color: #FE980F;
    text-decoration: none;
  }
  #content-comment{
    margin-top: 10px;
  }
  .panel-body{
    border: 1px #e4e4e4 solid;
   padding: 20px;
   border-radius: 4px;
   box-shadow: 0 0 6px #ccc;
   border-radius: 20px;
   -moz-border-radius: 20px;
   -webkit-border-radius: 20px;
  }

  p{
    font-family: Time New Roman;
  }
  #forum{
   border: 1px #e4e4e4 solid;
   padding: 20px;
   border-radius: 4px;
   box-shadow: 0 0 6px #ccc;
   border-radius: 20px;
   -moz-border-radius: 20px;
   -webkit-border-radius: 20px;
 }
 #title{
  border: 1px #e4e4e4 solid;
  padding: 20px;
  border-radius: 4px;
  box-shadow: 0 0 6px #ccc;
  border-radius: 20px;
  -moz-border-radius: 20px;
  -webkit-border-radius: 20px;
  margin-bottom: 10px;
  text-align: center;
  background-color: #337ab7;
  color: #FE980F;
  font-size: 20px;
}
#comment{
 border: 1px #e4e4e4 solid;
 padding: 20px;
 border-radius: 4px;
 box-shadow: 0 0 6px #ccc;
 border-radius: 20px;
 -moz-border-radius: 20px;
 -webkit-border-radius: 20px;
}
#content{
  border: 1px #e4e4e4 solid;
  padding: 20px;
  border-radius: 4px;
  box-shadow: 0 0 6px #ccc;
  border-radius: 20px;
  -moz-border-radius: 20px;
  -webkit-border-radius: 20px;
  margin-bottom: 10px;
}
#div-a{
  color: #8C8C88;
  font-size: 15px;
}
#div-a:hover{
  color:  #FE980F;
}
</style>


<div id="forum">
  <div id="title">
    Manage Comments 
  </div>
  <div id="comment">
    <?php foreach ($comments as $comment): ?>
      <div id="content">
        <a data-toggle="collapse" href="#collapse"><p id="name">{{$comment->user->fullname}}</p></a>
        <div id="collapse" class="panel-collapse collapse">
          <div class="panel-body">{{$comment->user->biography}}</div>
        </div>
        <p id="content-comment">{{$comment->content}}</p>
        <p><a href="{{route('admin.forumManage.delete',$comment->id)}}" onclick="return confirm('Do you want to delete Comment?')" id="div-a">Delete</a></p>
      </div>
    <?php endforeach ?>
  </div>
</div>
<div class="row">
  <div class="col-lg-4  col-lg-offset-5">
  {!! $comments->render() !!}
  </div>
</div>
@stop














