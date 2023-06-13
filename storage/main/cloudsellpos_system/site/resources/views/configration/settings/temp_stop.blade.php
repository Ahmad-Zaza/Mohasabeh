@extends('crudbooster::admin_template')
@section('content')
<div class="row">

<div class="col-md-12">
    <div class="box box-solid">
        <div class="box-header with-border">
            <i class="fa fa-ban"></i>
            <h3 class="box-title">{{trans('labels.temp_stop')}}</h3>
        </div>

        <div class="box-body">
            {!! trans('labels.temp_stop_details') !!}
            <hr/>
                <h4>{{trans('labels.change_setting_value')}}</h4>
              
                <form id="TempStopsettingForm" class="form">
                    <input type="radio" id="on" name="option" value="on" @if($status == 'on') checked @endif >
                    <label for="html">{{trans('labels.on')}}</label><br>
                    <input type="radio" id="off" name="option" value="off" @if($status == 'off') checked @endif>
                    <label for="css"> {{trans('labels.off')}} </label><br>
                    @php $path = url(CRUDBooster::mainPath()); @endphp
                    <a class="btn btn-sm btn-warning" href="javascript:void(0)"
                        onclick="location.href = '{{$path}}'"> {{trans('labels.back')}} 
                        <i class="fa fa-chevron-circle-right"></i>
                    </a>
                    <button class="btn btn-sm btn-primary" type='submit'> {{trans('crudbooster.button_save')}} <i class="fa fa-save"></i> </button>
                </form> 
        </div>

    </div>
</div>
    
</div> <!-- end row -->


@endsection
