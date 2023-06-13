@extends('crudbooster::admin_template')
@section('content')
    <p><a title="Return" href="{{url(CRUDBooster::adminPath('financial_cycles'))}}" id="go-back"><i class="fa fa-chevron-circle-left "></i>
       &nbsp;  {{trans('labels.go_back_financial_cycles_list')}}</a></p>
    <div class="row">
        <div class="col-md-12">
        <div class="box box-solid box-info">
        <div class="box-header">
            <i class="fa fa-gear"></i>
            <h3 class="box-title"> {{trans('labels.actions_history')}} - {{$cycle->cycle_name}}</h3>
            @if($showActionBtn)
                <a class='btn btn-xs btn-success pull-left'  href="/modules/financial_cycles/reCalculateData/{{$cycle->id}}">{{trans('labels.re_calculate_data')}}</a>
            @endif
        </div>

        <div class="box-body">
            <table class="table table-bordered table-striped" style="text-align:center;">
                <thead>
                    <tr>
                        <th style="text-align:center;">{{trans('labels.operation')}}</th>
                        <th style="text-align:center;">{{trans('modules.date')}}</th>
                        <th style="text-align:center;">{{trans('labels.upgrade_cycle')}}</th>
                        <th style="text-align:center;">{{trans('labels.selected_upgrade_options')}}</th>
                    </tr>
                </thead>   
                <tbody>    
                    @if(count($cycle_history) > 0)
                        @foreach ($cycle_history as $record)
                            <tr>
                                <td>{{$record->action_trans}}</td>
                                <td>{{$record->date}}</td>
                                <td>{{$record->upgrade_cycle_name}}</td>
                                <td style="font-size:10px; text-align:right;">
                                    <div style="display:inline-block;width:49%;">
                                        @if(in_array('initial_balances',$record->options))
                                            <p><i class="fa fa-check"></i>  {{trans('labels.initial_balances')}}</p>
                                        @else
                                            <p><i class="fa fa-close"></i>  {{trans('labels.initial_balances')}}</p>
                                        @endif
                                        @if(in_array('beginning_items',$record->options))
                                            <p><i class="fa fa-check"></i>  {{trans('labels.beginning_items')}}</p>
                                        @else
                                            <p><i class="fa fa-close"></i>  {{trans('labels.beginning_items')}}</p>
                                        @endif
                                        @if(in_array('entries_list',$record->options))
                                            <p><i class="fa fa-check"></i>  {{trans('labels.entries_list')}}</p>
                                        @else
                                            <p><i class="fa fa-close"></i>  {{trans('labels.entries_list')}}</p>
                                        @endif
                                    </div>
                                    <div style="display:inline-block;width:49%;">
                                        @if(in_array('helpful_accounts',$record->options))
                                            <p><i class="fa fa-check"></i>  {{trans('labels.helpful_accounts')}}</p>
                                        @else
                                            <p><i class="fa fa-close"></i>  {{trans('labels.helpful_accounts')}}</p>
                                        @endif
                                        @if(in_array('items_cost',$record->options))
                                            <p><i class="fa fa-check"></i>  {{trans('labels.items_cost')}}</p>
                                        @else
                                            <p><i class="fa fa-close"></i>  {{trans('labels.items_cost')}}</p>
                                        @endif
                                        @if(in_array('currencies_ex_rates',$record->options))
                                            <p><i class="fa fa-check"></i>  {{trans('labels.currencies_ex_rates')}}</p>
                                        @else
                                            <p><i class="fa fa-close"></i>  {{trans('labels.currencies_ex_rates')}}</p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan='4'>{{trans('labels.no_result')}}</td> 
                        </tr>
                    @endif
                    
                </tbody>
            </table>
        </div>

    </div>
        </div>
    </div>
@endsection
