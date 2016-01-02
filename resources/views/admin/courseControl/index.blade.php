 @extends('admin.home')
 @section('admin-content')
 
 <style type="text/css">
   
  #course-div{
   /*height: auto;*/
   border: 1px #e4e4e4 solid;
   padding: 20px;
   border-radius: 4px;
   box-shadow: 0 0 6px #ccc;
   background-color: #fff;
   border-radius: 20px;
   -moz-border-radius: 20px;
   -webkit-border-radius: 20px;
   height: 740px;
   /*width: auto;*/
 }
 .list_item {
  border: 1px #e4e4e4 solid;
  /*padding: 20px;*/
  border-radius: 4px;
  box-shadow: 0 0 6px #ccc;
  /*background-color: #fff;*/
  border-radius: 20px;
  -moz-border-radius: 20px;
  -webkit-border-radius: 20px;

  margin: 5px;
  padding: 5px;
  /*border: 1px solid gray;*/

  width: 250px;
  height: 300px;
  float: left;
  background-color: #DCDCDC;
}
.list_item:hover{
	background-color:#fdb45e;
	cursor: pointer;
}
#left{
	text-align: left;
	float: left;

}
#right{
	text-align: right;
	float: right;
}
.cost{
	color: #228B22;
}
.name{
	font-weight: bold;
  padding-top: 5px;
}
#AcceptPublic{
	color: #8C8C88;
  font-size: 20px;
}
#readMore{
	color: #8C8C88;
  font-size: 20px;
}
#AcceptPublic:hover{
	color:  #FFFFFF;
}
#readMore:hover{
	color:  #FFFFFF;
}
#title{
  order: 1px #e4e4e4 solid;
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
</style>
<script type="text/javascript">
	function acceptPublic (url) {
		// body...
		// alert(url);
		if(confirm("Do you want accept this Course")){
			window.location.href=url

		}else{false;}
	}
</script>


<div id="course-div">
  <div id="title"><strong>Control Courses</strong></div>
      <div class="col-sm-12" style="margin-top: 20px;">
          <div class="row">
              <div class="panel panel-info">
                  <div class="panel-heading" style="text-align: center;">
                      Control Courses
                  </div>
                  <div class="panel-body">
                      @foreach($courses as $course)
                          <div class="col-sm-3">
                              <div class="product-image-wrapper">
                                  <div class="single-products">
                                      <div class="productinfo text-center">
                                          <a href="javascript:void(0)" class="thumbnail">
                                              @if($course->image)
                                                  <img src="/{{$course->image->path}}" alt="{{$course->image->img_name}}" style="height: 240px;">
                                              @else
                                                  <img src="nothing" alt="This course haven't completed yet, User left it. So Do you want to delete it?" style="height: 240px;">
                                              @endif
                                          </a>
                                          <h2>{{$course->course_name}}</h2>
                                      </div>
                                  </div>
                                  <div class="choose">
                                      <ul class="nav nav-pills nav-justified">
                                          <li><h5><a href="{{route('admin.courseManage.courseInfomation',$course->id)}}"> Read more</a></h5></li>
                                          <li><h5 style="padding-left: 47px;"><a href="#" onclick="acceptPublic('{{route('admin.courseControl.accept',$course->id)}}')"> Accept public</a></h5></li>
                                      </ul>
                                  </div>
                              </div>
                          </div>
                      @endforeach
                  </div>
                  <!--/panel-body-->
              </div>
              <!--/panel-->
          </div>
    </div>
    <div class="row">
        <div class="col-lg-4  col-lg-offset-5">
            {!! $courses->render() !!}
        </div>
    </div>
</div>

@stop













