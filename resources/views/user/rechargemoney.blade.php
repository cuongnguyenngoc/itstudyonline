@extends('public.layouts.app')

@section('css')
<link href="{{url('css/forum/styles.css')}}" rel="stylesheet">
@stop

@section('header-top')
@include('public.layouts.header.header-top')
@stop
@section('header-middle')
@include('public.layouts.header.header-middle')
@stop

@section('content')

<!-- Main -->
<div class="container main" style="min-height: 500px;">

    <div class="row">
        <div class="col-md-8 col-md-push-2 news-show">	
            <div class="news-showtitle mt10">

                <div class="clearfix">
                    <div class="note fl">
                        CHARGING MONEY BY PHONE CARD
                    </div>
                </div>
            </div>

            <div class="content clearfix">
                <div id="ContentDetail">
                 <p>All money you have <b id = "balance">{{$balance}} thousands VND</b> in account</p>
                 <p>You can buy vinaphone card or viettel card to charge card.</p>
                </div>
            </div>

            <div id="TotalAssessment">
                <div class="comentvietid">                    
                    <div class="border-nobottom"></div>
                    <div class="bar">
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <div class= "col-md-8 col-md-push-2">
         <div class="alert alert-success hide" id="message">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <p></p>
        </div>
        <form class="form-horizontal" id="chargeCard">
            <div class= "form-group" style= " margin: 0 auto; width:50%">
                <label class="radio-inline" >
              <input type="radio" name="card_type" id="inlineRadio1" checked value="Viettel"> Viettel
            </label>
            <label class="radio-inline">
              <input type="radio" name="card_type" id="inlineRadio2" value="Mobiphone"> Mobiphone
            </label>
            <label class="radio-inline">
              <input type="radio" name="card_type" id="inlineRadio3" value="Vinaphone"> Vinaphone
            </label>
            </div>
            <br/>
            <div class="form-group">
                <label for="card_num" class="col-sm-2 control-label">Card denomination</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="card_num" id="card_num" placeholder="">
                    <div class="message"></div>
                </div>
            </div>
            <div class="form-group">
                <label for="card_seri" class="col-sm-2 control-label">Card seri number</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="card_seri" id="card_seri" placeholder="">
                    <div class="message"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button  id = "submit" class="btn btn-primary">Charge</button>
            </div>
        </div>
    </form>
</div>
<div class="col-md-2 col-md-offset-9">
    <a class="btn btn-primary btn-sm" href="javascript:history.go(-1)">Back</a>
</div>
</div>

@stop
@section('footer-bottom')
<footer>
    @include('public.layouts.footer.footer-bottom')
    @stop
    @section('script')
    <script>
        $(document).ready(function(){

            $('#chargeCard').validate({
                rules: {
                    card_num: {
                        required: true,
                        minlength: 2
                    },
                    card_seri: {
                        required: true,
                        minlength: 13,
                        maxlength: 13
                    }
                },
                messages: {
                    card_num: {
                        required: "Please enter Card denomination",
                        minlength: "Card denomination should be minimax 2 characters"
                    },
                    card_seri: {
                        required: "Please enter card seri",
                        minlength: "Card seri just be 13 characters",
                        maxlength: "Card seri just be 13 characters"
                    }
                },
                errorPlacement: function (error , element) { 
                    element.parents('div.form-group').find('.message').html(error);
                }
            });

            $("#chargeCard").submit(function(e){
                e.preventDefault();
                if($(this).valid()){
                    var card = {};
                    card.card_type = "";
                    var selected = $("input[type='radio'][name='card_type']:checked");
                    if (selected.length > 0) {
                        card.card_type = selected.val();
                    }
                    if(!$.isNumeric($("#card_num").val()) || '' == $("#card_num").val()){
                        $('#message').removeClass('hide');
                        $('#message').find('p').text("Card id should be number");
                        return;
                    }

                    if(!$.isNumeric($("#card_seri").val()) || '' == $("#card_seri").val()){
                        $('#message').removeClass('hide');
                        $('#message').find('p').text("Card seri shoud be number");
                        return;
                    }
                    card.card_num = $("#card_num").val();
                    card.card_seri = $("#card_seri").val();

                    $.ajax({
                        type: "POST",
                        url: "{{url('user/rechargeMoney')}}",
                        data: card,
                        dataType: 'json',
                        success: function (response) {
                            $('#message').removeClass('hide');
                            $('#message').find('p').text(response.message);
                            $("b#balance").html(response.balance + " thousand VND");
                            
                        }
                    });
                    $("#card_num").val("");
                    $("#card_seri").val("");
                }
            });
        });

    </script>
    @stop

