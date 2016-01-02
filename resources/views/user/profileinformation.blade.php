<div class="panel panel-info course-goals panel-right">
    <div class="panel-heading"></div>
    <div class="panel-body">
        <div class="alert alert-success hide" id="message">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p></p>
        </div>

        {!! Form::open(['url'=>'user/update','id' => 'userprofile'])!!}
        <div class="form-group">
            <label for="fullname">FullName</label>
            <input class="form-control" id="fullnameu" name="fullname" value="{{Auth::user()->fullname }}">
            <div class="message"></div>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input class="form-control" id="address" name="address" value="{{Auth::user()->address}}" placeholder="Address">
            <div class="message"></div>
        </div>
        <div class="form-group">
            <label for="birth">Birth</label>
            <input class="form-control" id="datepicker" name="birth" value="{{Auth::user()->birth}}">           
            <div class="message"></div>
        </div>
        <div class="form-group">
            <label for="biography">Biography</label>
            <textarea class="form-control" rows="5" name="biography" value="{{Auth::user()->biography}}" id="biography"></textarea>
            <div class="message"></div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-info">Save</button>
        </div>
        
        {!! Form::close() !!}
    </div>  
</div>
