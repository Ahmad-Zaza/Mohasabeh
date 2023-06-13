@extends('crudbooster::admin_template')
@section('content')
    <p><a title="Return" href="{{url(CRUDBooster::adminPath('financial_cycles'))}}" id="go-back"><i class="fa fa-chevron-circle-left "></i>
       &nbsp;  {{trans('labels.go_back_financial_cycles_list')}}</a></p>
    <div class="row">
        <div class="col-md-12">
        <div class="box box-solid box-info">
        <div class="box-header">
            <i class="fa fa-gear"></i>
            <h3 class="box-title"> {{trans('labels.rotate_data_setting')}}</h3>
        </div>

        <div class="box-body">
            <table class="table table-bordered table-striped">
                <tbody>
                    @foreach ($not_major_currenies as $curr )
                    <tr>
                        <td width="40%"><label for="">{{ trans('labels.currency_ex_rate_at_rotate_date',['curr_name_ar'=>$curr->name_ar])}}</label></td>
                        <td>
                           {{$rotate_data_ex_rates["ex_rate_$curr->id"]}}
                        </td>
                    </tr>     
                    @endforeach
                   
                    <tr>
                        <td width="40%"><label for="">{{ trans('labels.closing_date')}}</label></td>
                        <td>
                           {{$cycle_setting['rotate_date']}}
                        </td>
                    </tr>
                    <tr>
                        <td width="40%"><label for="">{{ trans('labels.item_cost')}}</label></td>
                        <td>
                            {{$cycle_setting['item_cost_type']}}
                        </td>
                    </tr> 
                    <tr>
                        <td colspan="2" align="center" bgcolor="#00ff7f">{{ trans('labels.helpful_accounts')}}</td>
                    </tr>
                    <tr>
                        <td width="40%"><label for="">{{ trans('labels.profits_and_loss_account')}}</label></td>
                        <td>
                            {{$cycle_setting['profits_account']}}
                        </td>
                    </tr>
                    <tr>
                        <td width="40%"><label for="">{{ trans('labels.diffent_ex_rates_account')}}</label></td>
                        <td>
                            {{$cycle_setting['diff_ex_rate_account']}}
                        </td>
                    </tr>
                    <tr>
                        <td width="40%"><label for="">{{ trans('labels.last_inventories_items_value_account')}}</label></td>
                        <td>
                            {{$cycle_setting['last_inventories_items_value_account']}}
                        </td>
                    </tr>
                    
                </tbody>
            </table>
        </div>

    </div>
        </div>
    </div>
@endsection
