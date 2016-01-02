 <div class="panel panel-info manage-masters panel-right hide">
    <div class="panel-heading">
        Manage Masters
    </div>
    @if($course->usercreatecourse(Auth::user()->id)->isBoss)
        <div class="panel-body" style="background-color: #F1F3F6;">
            <form id="formSaveMaster">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <td>Master</td>
                            <td>Can edit lectures</td>
                            <td>Can delete Course</td>
                            <td>Revenue Share</td>
                            <td>Delete</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Itstudyonline</td>
                            <td><input type="checkbox" checked="checked" disabled="true" class="itstudyonline"/></td>
                            <td><input type="checkbox" checked="checked" disabled="true" class="itstudyonline"/></td>
                            <td class="col-md-2">
                                <input type="text" class="col-md-4 col-md-offset-4 itstudyonline" style="padding: 0px;" value="40" disabled="true"/>
                                <p class="col-md-1" style="margin-top: 3px;"> %</p>
                            </td>
                            <td></td>
                        </tr>
                        <tr class="newMaster">
                            <td>{{Auth::user()->fullname}}</td>
                            <td class='hide joiner'><input type='hidden' class='joiner_id' value="{{Auth::user()->usercreatecourse($course->id)->id}}"></td>
                            <td class='hide'><input type='hidden' class='master_id' value='{{Auth::user()->id}}'></td>
                            <td><input type="checkbox" class='visible' checked="checked" disabled="true"/></td>
                            <td><input type="checkbox" class='canEdit' checked="checked" disabled="true"/></td>
                            <td class="col-md-2">
                                <input type="text" value="{{Auth::user()->usercreatecourse($course->id)->revenue}}" class="col-md-4 col-md-offset-4 revenue" style="padding: 0px;" id="revenueofboss"/>
                                <p class="col-md-1" style="margin-top: 3px;"> %</p>
                            </td>
                            <td></td>
                        </tr>
                        @foreach($course->membercreatecourses() as $membercreatecourse)
                            <tr class="newMaster">
                                <td>{{$membercreatecourse->user->fullname}}</td>
                                <td class='hide'><input type='hidden' class='joiner_id' value="{{$membercreatecourse->id}}"></td>
                                <td class='hide'><input type='hidden' class='master_id' value='{{$membercreatecourse->user->id}}'></td>
                                <td><input type="checkbox" class='visible' {{($membercreatecourse->visible)?'checked':''}}/></td>
                                <td><input type="checkbox" class='canEdit' {{($membercreatecourse->can_edit)?'checked':''}}/></td>
                                <td class="col-md-2">
                                    <input type="text" value="{{$membercreatecourse->revenue}}" class="col-md-4 col-md-offset-4 revenue" style="padding: 0px;"/>
                                    <p class="col-md-1" style="margin-top: 3px;"> %</p>
                                </td>
                                <td><a href='javascript:void(0)' class="delete-master" getId="{{$membercreatecourse->user->id}}"><span class='glyphicon glyphicon-trash'></span></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <p class="col-md-2 col-md-offset-5"><button type="submit" class="btn btn-primary btn-sm" style="margin-top: 0px;"> Save</button></p>
            </form>
            <div class="row">
                
            </div>
        </div>
        <!--/panel-body-->
        <div class="panel-footer">
            <div class="row">
                <div id="divaddMaster" class="col-md-12">
                    <form id="formAddMaster">
                        <div class="col-md-10" style="padding-left: 0px;">
                            <input type="text" name="email" class="form-control" placeholder="Type new master's email you wanna add" id="masterEmail"/>
                        </div>
                        <a href="javascript:void(0)" class="btn btn-primary col-md-2" style="margin-top: 0px;" id="addMaster"> Add master</a>
                    </form>
                </div>
                <div class="col-md-8 col-md-offset-2 hide" style="padding-left: 1px; padding-top: 10px;" id="tipMaster">
                    <p><b> NOTE:</b> Only Itstudyonline users can be added as master.</p> 
                </div>
            </div>       
        </div>
    @else
        <div class="panel-body" style="background-color: #F1F3F6; text-align: center; min-height: 326px;">
            You dont have permission to add other master, Try to ask your boss <a href="">{{$course->bosscreatecourse()->user->fullname}}</a> to learn more detail
        </div>
    @endif
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
    
    var countMaster = {{$course->usercreatecourses()->count()}};
    var oldCountMaster = {{$course->usercreatecourses()->count()}};
    $('#addMaster').on('click',function(){
        
        if($("#masterEmail").valid()){
            $.ajax({
                type: "POST",
                url : "/master/add-master-course",
                dataType: 'json',
                data: {email: $('#masterEmail').val()},
                success : function(response){
                    console.log(response);
                    if(response.status){
                        countMaster++;
                        $('#formSaveMaster table').find('tbody').append(
                            "<tr class='newMaster'>"+
                                "<td>"+response.user.fullname+"</td>"+
                                "<td class='hide'><input type='hidden' id='joiner_id"+countMaster+"' class='joiner_id'></td>"+
                                "<td class='hide'><input type='hidden' id='master_id"+countMaster+"' class='master_id' value='"+response.user.id+"'></td>"+
                                "<td><input type='checkbox' name='visible"+countMaster+"' id='visible"+countMaster+"' class='visible'/></td>"+
                                "<td><input type='checkbox' name='canEdit"+countMaster+"' id='canEdit"+countMaster+"' class='canEdit'/></td>"+
                                "<td class='col-md-2'>"+
                                    "<input type='text' class='col-md-4 col-md-offset-4 revenue' style='padding: 0px;' name='revenue"+countMaster+"' id='revenue"+countMaster+"'/>"+
                                    "<p class='col-md-1' style='margin-top: 3px;'> %</p>"+
                                "</td>"+
                                "<td><a href='javascript:void(0)'class='delete-master' getId='"+response.user.id+"'><span class='glyphicon glyphicon-trash'></span></a></td>"+
                            "</tr>"
                        );
                        $('#masterEmail').val(null);
                        var n = noty({text: response.message, layout: 'top', type: 'success', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });
                    }else{
                        var n = noty({text: response.message, layout: 'top', type: 'error', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });
                    }
                }
            });
        }

    });

    $('#formSaveMaster').on('submit',function(e){
        
        e.preventDefault();
        var isNoneEmpty = true;
        var notEqual100 = true;
        var masters = [];
        var itself = $(this);

        var sum = 0;
        $('table').find('input[type=text]').each(function(){
            if(!$(this).val()){
                isNoneEmpty = false;
            }
            sum += parseInt($(this).val());
        });
        if(sum != 100)
            notEqual100 = false;

        if(isNoneEmpty){
            if(notEqual100){
                $(this).find('tr.newMaster').each(function(index){
                    var master = [];
                    master.push($(this).find('.joiner_id').val());
                    master.push($(this).find('.master_id').val());
                    master.push($(this).find('.visible').is(':checked'));
                    master.push($(this).find('.canEdit').is(':checked'));
                    master.push($(this).find('.revenue').val());
                    masters.push(master);
                });

                $.ajax({
                    type: "POST",
                    url : "/master/save-master-course",
                    dataType: 'json',
                    data: {course_id: $('#course_id').val(), masters: masters},
                    success : function(response){
                        console.log(response);
                        if(response.status){
                            for(var i = (oldCountMaster + 1); i <= response.usercreatecourses.length; i++){
                                itself.find('#joiner_id'+(i)).val(response.usercreatecourses[i - 1].id);
                            }
                            var n = noty({text: response.message, layout: 'top', type: 'success', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });
                        }else{
                            var n = noty({text: response.message, layout: 'top', type: 'error', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });
                        }
                    }
                });
            }else{
               alert('All revenues should have sum be 100 %, please check again'); 
            }
        }else{
            alert('Some fields is not completed yet, Please try again');
        }
    });

    $('#formSaveMaster').on('click','a.delete-master',function(e){
        var getId = $(this).attr('getId');
        var master = {};
        master.course_id = $('#course_id').val();
        master.master_id = getId;
        var itself = $(this);
        var r = confirm('Do you wanna delete this lecture?');
        if (r == true) {

            $.ajax({
                type: "POST",
                url : "/master/delete-master-course",
                dataType: 'json',
                data: master, // remember that be must to pass data object type
                success : function(response){
                    console.log(response);
                    if(response.status){
                        itself.parents('tr.newMaster').remove();
                        $('#revenueofboss').val(response.boss.revenue);
                        var n = noty({text: response.message, layout: 'top', type: 'success', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });
                    }else
                        var n = noty({text: response.message, layout: 'top', type: 'error', template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>', closeWith: ['button'], timeout:2000 });

                }
            });
        }
    });
});
</script>