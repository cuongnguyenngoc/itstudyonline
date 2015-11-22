 <div class="panel panel-info manage-masters panel-right hide">
    <div class="panel-heading">
        Manage Masters
    </div>
    <form id="formAddMaster">
        <div class="panel-body" style="background-color: #F1F3F6;">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <td>Master</td>
                        <td>Visible</td>
                        <td>Can edit</td>
                        <td>Revenue Share</td>
                        <td>Delete</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Itstudyonline</td>
                        <td><input type="checkbox" checked="checked" disabled="true"/></td>
                        <td><input type="checkbox" checked="checked" disabled="true"/></td>
                        <td class="col-md-2">
                            <input type="text" class="col-md-4 col-md-offset-4" style="padding: 0px;" />
                            <p class="col-md-1" style="margin-top: 3px;"> %</p>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>{{Auth::user()->fullname}}</td>
                        <td><input type="checkbox" checked="checked" disabled="true"/></td>
                        <td><input type="checkbox" checked="checked" disabled="true"/></td>
                        <td class="col-md-2">
                            <input type="text" class="col-md-4 col-md-offset-4" style="padding: 0px;" />
                            <p class="col-md-1" style="margin-top: 3px;"> %</p>
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <div id="divaddMaster" class="col-md-12">
                    <div class="col-md-10" style="padding-left: 0px;">
                        <input type="text" name="email" class="form-control" placeholder="Type new master's email you wanna add" id="masterEmail"/>
                    </div>
                    <a href="#" class="btn btn-primary col-md-2" style="margin-top: 0px;" id="addMaster"> Add master</a>
                </div>
                <div class="col-md-8 col-md-offset-2 hide" style="padding-left: 1px; padding-top: 10px;" id="tipMaster">
                    <p><b> NOTE:</b> Only Itstudyonline users can be added as master.</p> 
                </div>
            </div>
        </div>
        <!--/panel-body-->
        <div class="panel-footer">
            <div class="row">
                <p class="col-md-2 col-md-offset-5"><button type="submit" class="btn btn-primary btn-sm" style="margin-top: 0px;"> Save</button></p>
            </div>       
        </div>
    </form>
</div>
<!--/panel-->
<style type="text/css">
    td {
        text-align: center;
    }
</style>
<script>
$(document).on('ready', function() {

    $('div#divaddMaster div').qtip({
        content: $('#tipMaster').html(),
        position: {
            my: "top center",
            at: "bottom center"
        }
    });

    $('#formAddMaster').validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            email: {
                required: "Please enter master email to add",
                email: "Please enter a valid email"
            }
        }
    });
    
    var countMaster = 0;
    $('#addMaster').on('click',function(){
        countMaster++;
        if($("#formAddMaster").valid()){
            $.ajax({
                type: "POST",
                url : "/master/add-master-course",
                dataType: 'json',
                data: {email: $('#masterEmail').val()},
                success : function(response){
                    console.log(response);
                    if(response.status){
                        
                        $('#formAddMaster table').find('tbody').append(
                            "<tr id='newMaster'"+countMaster+">"+
                                "<td>"+response.user.fullname+"</td>"+
                                "<td><input type='checkbox'/></td>"+
                                "<td><input type='checkbox'/></td>"+
                                "<td class='col-md-2'>"+
                                    "<input type='text' class='col-md-4 col-md-offset-4' style='padding: 0px;' />"+
                                    "<p class='col-md-1' style='margin-top: 3px;'> %</p>"+
                                "</td>"+
                                "<td><a href='#' id='deleteMaster'"+countMaster+"><span class='glyphicon glyphicon-trash'></span></a></td>"+
                            "</tr>"
                        );
                    }
                }
            });
        }
    });

    $('#formAddMaster').submit(function(e){
        e.preventDefault();
        var course = {};
        course.course_id = $('#course_id').val();
        course.price = $('#priceCourse').val();
        if ($("#formPrice").valid()){
            $.ajax({
                type: "POST",
                url : "/master/update-price-course",
                dataType: 'json',
                data: course,
                success : function(response){
                    console.log(response);
                    if(response.status){
                        $('#priceSetting').fadeOut(1000);
                        $('#showPrice').find('h2').text(response.course.cost+'VND');
                        $('.price-coupons').find('div.panel-footer').addClass('hide');
                    }
                }
            });
        }
    });
});
</script>