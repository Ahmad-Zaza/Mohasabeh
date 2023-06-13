@extends('crudbooster::admin_template')
@section('content')
@php
    use App\Http\Controllers\General\GeneralFunctionsController; 
    $gfunc = new GeneralFunctionsController();
@endphp

@push('head')
    <link href="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@push('bottom')
     
    <script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/select2/i18n/ar.js') }}"></script>
@endpush
@if($not_current_cycle_error)
    <div class="row">
        <div class="col-sm-12">
            <div class="callout callout-warning">
                <h4> <i class="icon fa fa-warning"></i> {{trans('labels.warning')}}</h4>
                <p>{{trans('messages.this_cycle_finished_and_rotated_you_donot_rotate_it_again')}}</p>
            </div>
        </div>
    </div>
@elseif($errors)
    <div class="row">
        <div class="col-sm-12">
            <div class="callout callout-warning">
                <h4> <i class="icon fa fa-warning"></i> {{trans('labels.warning')}}</h4>
                <p>{{trans('messages.thare_are_transfer_vouchers_or_transfer_items_not_receipt_yet_please_check_its_before_rotate_data')}}</p>
            </div>
        </div>
    </div>
@elseif ($backups_size_error)
<div class="row">
        <div class="col-sm-12">
            <div class="callout callout-warning">
                <h4> <i class="icon fa fa-warning"></i> {{trans('labels.warning')}}</h4>
                <p>{{trans('messages.no_enough_size_to_create_backup_before_rotate_data_please_upgrade_your_package')}}</p>
            </div>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-md-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">{{trans('labels.rotate_data_configration')}}</a></li>
                    <li class="pull-left" style="padding-top:10px;">
                        <button class="btn btn-xs btn-primary" onclick="location.href='';" > {{trans('crudbooster.action_show_data')}} 
                            <i class="fa fa-refresh "></i></button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">

                        <div class="box">
                            <!--div class="box-header">
                            <h3 class="box-title"></h3>
                        </div-->
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div id="rotate_data_form-table" class="dataTables_wrapper form-inline dt-bootstrap">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form id="rotate_data_setting" method="post"
                                                action="{{ url(config('crudbooster.ADMIN_PATH') .'/rotate_data/continue_rotate_data') }}" class="print_display_none">
                                                {{ csrf_field() }}
                                                <div class="col-lg-12">
                                                    <table class="table table-striped">
                                                        <tr class="">
                                                            <th colspan="3" class="text-center"> {{trans('labels.financial_cycle_named')}} <th>
                                                        </tr>

                                                        <tr>
                                                                <th> {{ trans('labels.choose_name_to_financial_cycle')}}:</th>
                                                                <td>
                                                                    <input type="text" name="cycle_name"
                                                                        required value="{{($old_setting['cycle_name'])?$old_setting['cycle_name']:trans('labels.financial_cycle_default_name',['date'=>date('Y - M')]) }}"
                                                                        style="width:270px;" />
                                                                </td>
                                                                <td></td>
                                                            </tr>

                                                        <tr class="">
                                                            <th colspan="3" class="text-center"> {{trans('labels.rotate_configration')}} <th>
                                                        </tr>
                                                        @foreach ($currencies_not_major as $curr)
                                                            <tr>
                                                                <th> {{ trans('labels.currency_current_ex_rate',['curr_name_ar'=>$curr->name_ar])}}  :</th>
                                                                <td>
                                                                    <input type="text" name="ex_rate_{{ $curr->id }}"
                                                                        required value="{{($old_setting['ex_rate_'.$curr->id])?$old_setting['ex_rate_'.$curr->id]:$curr->ex_rate }}"
                                                                        style="width:160px;" />
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                        @endforeach

                                                        <tr>
                                                            <th>{{trans('labels.closing_date')}} : </th>
                                                            <td><input type="date" name="rotate_date" id="rotate_date"
                                                                    class="form-control" value="{{ ($old_setting['rotate_date'])?$old_setting['rotate_date']:$rotate_date }}"
                                                                    style="width:160px; text-align:right;"></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <th> {{trans('labels.item_cost')}}:</th>
                                                            <td>
                                                                <input type="radio" name="item_cost_type" value="1" 
                                                                    @if($old_setting['item_cost_type'] == 1) checked @endif/> {{trans('labels.cost_avg')}} </br>
                                                                <input type="radio" name="item_cost_type"
                                                                    value="0" @if($old_setting['item_cost_type'] == 0) checked @endif /> {{trans('labels.last_purchase')}}
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        <tr class="">
                                                            <th colspan="3" class="text-center"> {{trans('labels.helpful_accounts')}} <th>
                                                        </tr>
                                                        <tr>
                                                            <th width="30%">  {{trans('labels.profits_and_loss_account')}} :</th>
                                                            <td  width="270px">
                                                                @php
                                                                    $field_structure = $gfunc->createAjaxSelect2("profits_account",trans('modules.account'),"accounts,name_ar",'','',$old_setting['profits_account']);
                                                                    echo $field_structure['html'];
                                                                @endphp 
                                                                @push('bottom')
                                                                    @php echo $field_structure['script']; @endphp
                                                                @endpush
                                                            </td>
                                                            <td rowspan="3" style="padding:30px 80px;"> <span class="" style="font-size:12px;"> {{trans('labels.choose_rotate_data_accounts_or_create_accounts')}} <a class="btn btn-xs btn-primary text-muted" href="{{url(config('crudbooster.ADMIN_PATH').'/accounts/add')}}" target="_blank"> {{trans('labels.create_new_account')}}</a> </span></td>
                                                        </tr>

                                                        <tr>
                                                            <th width="30%">  {{trans('labels.diffent_ex_rates_account')}} :</th>
                                                            <td>
                                                                @php
                                                                    $field_structure = $gfunc->createAjaxSelect2("diff_ex_rate_account",trans('modules.account'),"accounts,name_ar",'','',$old_setting['diff_ex_rate_account']);
                                                                    echo $field_structure['html'];
                                                                @endphp 
                                                                @push('bottom')
                                                                    @php echo $field_structure['script']; @endphp
                                                                @endpush
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th width="30%">  {{trans('labels.last_inventories_items_value_account')}} :</th>
                                                            <td>
                                                                @php
                                                                    $field_structure = $gfunc->createAjaxSelect2("last_inventories_items_value_account",trans('modules.account'),"accounts,name_ar",'','',$old_setting['last_inventories_items_value_account']);
                                                                    echo $field_structure['html'];
                                                               @endphp 
                                                               @push('bottom')
                                                                   @php echo $field_structure['script']; @endphp
                                                               @endpush
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th></th>
                                                            <td>
                                                                <button id="continue" class="btn btn-sm btn-success"
                                                                    type="submit"> {{trans('labels.continue')}} <i
                                                                        class="fa fa-chevron-left "></i></button>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                    </table>

                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>

                    </div>

                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </div>


    </div>

@endif


@push('bottom')
    <script type="text/javascript">
        $('form').submit(function(event) {
            let acc1 =$('#select-ajax-diff_ex_rate_account').val();
            let acc2 =$('#select-ajax-profits_account').val();
            let acc3 =$('#select-ajax-last_inventories_items_value_account').val();

            if(acc1 && acc2 && acc3){
                if(acc1 == acc2 || acc1 == acc3 || acc2 == acc3){
                    notify(_ERROR,"{{trans('messages.please_choose_another_account_there_is_account_choose_more_than_one')}}",'error');
                    event.preventDefault();
                }else{
                    let elem = $('#continue i');
                    elem.removeClass('fa-chevron-left');
                    elem.addClass('fa-spinner fa-spin'); 
                }
            }else{
                notify(_ERROR,"{{trans('messages.please_fill_all_fields')}}",'error');
                event.preventDefault();
            }
        });

        $("#rotate_date").change(function(){
            let rotate_date = $(this).val();
            $.get("/rotate_data/check_date/" + rotate_date, function(res) {
                let json_res = JSON.parse(res);
                let text_msg = json_res.massege;
                if(json_res.status == 'error'){
                    notify(_ERROR,text_msg,'error');
                }else{
                    notify(_SUCCESS,text_msg,'success');
                }
            });
        });
    </script>
@endpush
       
@endsection
