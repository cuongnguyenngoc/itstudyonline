 @extends('admin.home')
 @section('admin-content')
 
 <style type="text/css">
 #Langugage{
  margin-bottom: 30px;
 }
</style>
<div id="Language">
    @if(session('statusdelete'))
        <div class="alert alert-success" role="alert">{{ session('statusdelete') }}</div>
    @endif
    <a data-toggle="collapse" href="#adminCollapse" id="div-a" class="btn btn-primary">Languages <span class="caret"></span></a>
    <div id="adminCollapse" class="panel-collapse collapse">
        <ul class="list-group">
        @foreach ($languages as $language)
            <li class="list-group-item">
                {{$language->lang_name}}   
                <a href="{{route('admin.language.delete',$language->id)}}" onclick="return confirm('Do you want to delete this Category?')"><p>Delete</p></a>                                         
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
        <form action="{{route('admin.language.update')}}" method="POST" role="form" id="addLanguage">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                <label for="">Programming language</label>
                <input type="text" class="form-control" name="lang_name" id="lang_name">
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

        $("#addLanguage").validate({  
            rules: {
                lang_name: {
                    required: true,
                    remote: {
                        url: '/admin/checkLanguageExisted',
                        type: 'post',
                        dataType: 'json'
                    }
                }
            },
            messages: {
                lang_name: {
                    required: "Please enter programming language",
                    remote: "This programming language is taken, please enter another one"
                }
            },
            errorPlacement: function (error , element) { 
                element.parents('div.form-group').find('.message').html(error);
            }          
        });
    });
    
</script>
@stop













