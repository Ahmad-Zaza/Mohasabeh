@extends('crudbooster::admin_template')
@section('content')
<div class="row">

<div class="col-md-12">
    <div class="box box-solid">
        <div class="box-header with-border">
            <i class="fa fa-file-text-o"></i>
            <h3 class="box-title">{{trans('labels.bills_setting')}}</h3>
        </div>

        <div class="box-body">
            {!! trans('labels.bills_setting_details') !!}
            <hr/>
                <h4>{{trans('labels.change_setting_value')}}</h4>
              
                <form id="BillsSettingForm" class="form">

                <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <td width="40%"><label for="image_max_size">{{trans('labels.allow_negative_bills')}}</label></td>
                                <td>
                                    <input type="radio" id="on" name="negative_bills" value="on" @if($negative_bills == 'on') checked @endif >
                                    <label for="html">{{trans('labels.on')}}</label><br>
                                    <input type="radio" id="off" name="negative_bills" value="off" @if($negative_bills == 'off') checked @endif>
                                    <label for="css"> {{trans('labels.off')}} </label><br>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>    
                            <tr>
                                <td></td>
                                <td>
                                    @php $path = url(CRUDBooster::mainPath()); @endphp
                                    <a class="btn btn-sm btn-warning" href="javascript:void(0)"
                                        onclick="location.href = '{{$path}}'"> {{trans('labels.back')}} 
                                        <i class="fa fa-chevron-circle-right"></i>
                                    </a>
                                    <button class="btn btn-sm btn-primary" type='submit'> {{trans('crudbooster.button_save')}} <i class="fa fa-save"></i> </button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

        
                </form> 
        </div>

    </div>
</div>
    
</div> <!-- end row -->


@endsection
