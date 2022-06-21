@extends('layouts.app')

@section('content')
<style>
    .footer-sm {
    bottom: 0;
    position: fixed;
    width: 100%;
}
</style>
<div class="w-100 container hero pb-0 message-parent relative progress-parent flex align-items-center">
    <div class="w-100 text-center message-cont">
        <div class="col-md-12 col-sm-12 col-xs-12 mb-5"> 
            {{__("data.configure_account")}}
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">

            <div class="progress">
                <div id="progress-bar" class="progress-bar active" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="background-color:#ee653a;width:5%">
                    5%
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        let customerId = "{{$customer->id}}";

        let minutes = "{{env('PROGREE_PERIOD_MINUTES')}}";
        let widthStep = 5;
        let step = minutes * 60 * 5 * 1000 / 100;
        let width = widthStep;
        let nIntervId = setInterval(function(){ 
            if(width == 100)
                clearInterval(nIntervId);
            else {
                width += widthStep;
                $("#progress-bar").width(width+"%");
                $("#progress-bar").html(width+"%");
            }
        }, step);

        $.get("{{url('activate-customer')}}/"+customerId, function(res){
            width = 100;
            $("#progress-bar").width(width+"%");
            $("#progress-bar").html(width+"%");
            $(".progress-parent").addClass("hide");
            $(".message-cont").html(res.message);
        });
    })
</script>
@endsection
