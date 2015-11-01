<html>
    <head>
        <title>{!! $title !!}</title>
        <meta charset="utf-8">
    </head>
    <body>
        <form action="/master/regis-process" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            Course Name : <input type="text" name="name"/><br/>
            Category : 
            <select name='cate' size=1>

                @foreach ( $cates as $key => $value )
                <option value ="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select> 
            <br/>
            Language : 
            <select name='lang' size=1>
                @foreach ( $langs as $key => $value )
                <option value ="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select> 
            <br/>
            Level :
            <select name='level' size=1>
               @foreach ( $levels as $key => $value )
                <option value ="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select> 
            <br/>
            Cost :<input type="text" name = "cost"/>
            <br/>
            <textarea cols="30" rows="5" name="des">write desciption about course in here</textarea>
            <br/>
            <input type="submit" value = "submit"/>
        </form>

    </body>
</html>
