<div class = "row">
    <textarea cols="10" id="editor1" name="editor1" rows="10" >hello world</textarea>
</div>
<div class = "row">
    <button class="btn btn-default" id = "submit">Submit</button>
</div>
<script src="{{url('js/forum/ckeditor.js')}}"></script>
<script src="{{url('js/forum/adapters/jquery.js')}}"></script>
<script>
CKEDITOR.replace('editor1', {
    height: 250
});
$("#submit").click(function (){
    var data = CKEDITOR.instances.editor1.getData();
});
</script>