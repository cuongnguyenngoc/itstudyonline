 @extends('admin.home')
 @section('admin-content')
 
 <style type="text/css">
 #Category{
  margin-bottom: 30px;
 }
</style>
<div id="Category">
    @if(session('statusdelete'))
        <div class="alert alert-success" role="alert">{{ session('statusdelete') }}</div>
    @endif
    <a data-toggle="collapse" href="#adminCollapse" id="div-a" class="btn btn-primary">Categories <span class="caret"></span></a>
    <div id="adminCollapse" class="panel-collapse collapse">
        <ul class="list-group">
        @foreach ($categories as $category)
            <li class="list-group-item">
                {{$category->cat_name}}  
                <a href="{{route('admin.category.delete',$category->id)}}" onclick="return confirm('Do you want to delete this Category?')"><p>Delete</p></a>                     
            </li>
        @endforeach
        </ul>
   </div>
</div>
<div class="panel panel-info panel-right">
    <div class="panel-heading">Add Category</div>
    <div class="panel-body">
        @if(session('status'))
            <div class="alert alert-success" role="alert">{{ session('status') }}</div>
        @endif
        <form action="{{route('admin.category.update')}}" method="POST" id="addCategory">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label for="">Category name</label>
                <input type="text" class="form-control" name="cat_name" id="cat_name">
                <div class="message"></div>
            </div>
            <div class="form-group">
                <label for="">Description</label>
                <input type="text" class="form-control" name="description" id="description">
                <div class="message"></div>
            </div>
            <button class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

@stop
@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        $(".message").empty();

        $("#addCategory").validate({  
            rules: {
                cat_name: {
                    required: true,
                    remote: {
                        url: '/admin/checkCategoryExisted',
                        type: 'post',
                        dataType: 'json'
                    }
                },
                description: {
                    required: true,
                    minlength: 30
                }
            },
            messages: {
                cat_name: {
                    required: "Please enter category",
                    remote: "This category is taken, please enter another one"
                },
                description: {
                    required: "Please enter category name",
                    minlength: "Password should be minimax 30 characters"
                }
            },
            errorPlacement: function (error , element) { 
                element.parents('div.form-group').find('.message').html(error);
            }          
        });
    });
</script>
@stop












