@extends('crudbooster::admin_template')
@section('content')
<div class="row">

<div class="col-md-12">
    <div class="box box-solid">
        <div class="box-header with-border">
            <i class="fa fa-lock"></i>
            <h3 class="box-title">{{trans('labels.lock_url')}}</h3>
        </div>

        <div class="box-body">
            {!! trans('labels.lock_url_details') !!}
            <hr/>
              
            <div class="text-center lock_url_btn_div @if($status == 'on') hidden @endif" >
                <button class="btn btn-md btn-primary" id="lockURL"> {{trans('labels.lock_url')}} <i class="fa fa-lock"></i> </button>
            </div>
            <div class="text-center success_locked_message @if($status == 'off') hidden @endif">
                 <i class="fa fa-5x fa-check-circle text-green"></i>
                 <br/>
                 <p> {{trans('labels.lock_url_message_done')}} </p>
                 <code>{{$unlock_req}}</code>
            </div>        
        </div>

    </div>
</div>
    
</div> <!-- end row -->

<script>
    var  _ARE_YOU_CONFIRM= "{{trans('labels.are_you_confirm')}}";
    var  _LOCK_SYSTEM_URL_MESSAGE= "{{trans('labels.lock_system_url_confirm_message')}}";
    var  _YES= "{{trans('crudbooster.confirmation_yes')}}";
    var  _NO= "{{trans('crudbooster.confirmation_no')}}";
</script>
@endsection
