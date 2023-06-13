@extends('crudbooster::admin_template')
@section('content')

    <div class="row">

        <div class="col-md-12">
            <div class="callout callout-info waiting-msg hidden">
                <h4> {{trans('labels.please_waitting')}}</h4>
                <p>{{trans('labels.process_take_some_time')}} <i class="fa fa-refresh fa-spin"></i></p>

            </div>
        </div>
        <div class="col-md-12">
            <div class="text-center">
                <h5> {{trans('labels.result_of_re_calculate_cycle',["cycle_name"=>$cycle_name])}} </h5>
            </div>
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">{{trans('labels.initial_balances')}}</a></li>
                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">{{trans('labels.beginning_items')}}</a></li>
                    <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">{{trans('labels.items_cost')}}</a></li>
                    <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false">{{trans('labels.entries_list')}}</a></li>

                    <li class="pull-left" style="padding-top:10px;">
                        @php 
                            $home = url('modules/financial_cycles');
                            $cycle_path = url('modules/financial_cycles/display/'.$cycle_id);
                        @endphp
                        <button class="btn btn-xs btn-warning"
                            onclick="location.href = '{{$home}}'"> {{trans('labels.back')}} <i
                                class="fa fa-chevron-circle-right"></i></button>
                        
                        <button class="btn btn-xs btn-info"
                            onclick="location.href = '{{$cycle_path}}'"> {{trans('labels.go_back_financial_cycle')}} <i
                                class="fa fa-eye"></i></button>

                        <button class="btn btn-danger btn-xs"  id="go_home_without_re_calculate_data"> {{trans('labels.go_home_without_re_calculate_data')}} <i class="fa fa-ban "></i></button>
                                  
                        <button  class="btn btn-xs btn-primary" data-toggle="modal" data-target="#ReCalculateSaveResultModal"> {{trans('labels.save_re_calculate_result')}} <i
                                class="fa fa-save"></i></button>
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
                                <div id="form-table" class="dataTables_wrapper form-inline dt-bootstrap">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="tableFixHead">
                                                @if ($data != null)
                                                    <table id="tableId"
                                                        class="table table-bordered table-striped dataTable text-center"
                                                        role="grid" aria-describedby="tableId_info">
                                                        <thead>
                                                            <tr role="row">
                                                                <th style="text-align:right"> {{trans('labels.account_name')}}</th>
                                                                <th style="text-align:center">{{trans('modules.equalizer')}}</th>
                                                                @foreach ($activeCurrencies as $curr)
                                                                    <th style="text-align:center"> {{trans('modules.balance')}} {{ $curr->name_ar }}
                                                                    </th>
                                                                @endforeach
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($data as $item)
                                                                <tr>
                                                                    <td style="text-align:right">{{ $item['account_name'] }}
                                                                    </td>
                                                                    <td style="text-align:center"> {{number_format($item['equalizer_balance'],2)}}</td>
                                                                    @foreach ($activeCurrencies as $curr)
                                                                        <td>{{ number_format($item['curr_balance_' . $curr->id], 2) }}
                                                                        </td>
                                                                    @endforeach
                                                                </tr>
                                                            @endforeach
                                                          
                                                            <tr>
                                                                    <td bgcolor="#00ff7f" style="text-align:right">{{trans('modules.subtotal')}}</td>
                                                                    <td bgcolor="#7fff00">{{number_format($final_balances['final_equalizer'],2)}}</td>
                                                                    @foreach ($activeCurrencies as $curr)
                                                                        <td bgcolor="#7fff00">
                                                                            {{ number_format($final_balances['final_balance_' . $curr->id], 2) }}
                                                                        </td>
                                                                    @endforeach
                                                            </tr>
                                                            <!-- start add rotate data result accounts to openning balances table -->
                                                            <tr>
                                                                    <td style="text-align:right"><strong>{{trans('labels.net_profit')}}</strong></td>
                                                                    <td></td>
                                                                    @foreach ($activeCurrencies as $curr)
                                                                        @if ($curr->id == $majorCurrency->id)
                                                                            <td><strong>{{ number_format($profits_and_loss->net_profit,2) }}</strong></td>
                                                                        @else
                                                                            <td>0.00</td>
                                                                        @endif
                                                                    @endforeach
                                                            </tr>

                                                            <tr>
                                                                    <td style="text-align:right"><strong>{{trans('labels.last_inventories_items_value_account')}}</strong></td>
                                                                    <td></td>
                                                                    @foreach ($activeCurrencies as $curr)
                                                                        @if ($curr->id == $majorCurrency->id)
                                                                            <td><strong>{{ number_format($profits_and_loss->last_inventories_items_value,2) }}</strong></td>
                                                                        @else
                                                                            <td>0.00</td>
                                                                        @endif
                                                                    @endforeach
                                                            </tr>

                                                            <tr>
                                                                    <td style="text-align:right"><strong>{{trans('labels.diffent_ex_rates_account')}}</strong></td>
                                                                    <td></td>
                                                                    @foreach ($activeCurrencies as $curr)
                                                                        @if ($curr->id == $majorCurrency->id)
                                                                            <td><strong>{{ number_format($profits_and_loss->ex_rate_difference_value,2) }}</strong></td>
                                                                        @else
                                                                            <td>0.00</td>
                                                                        @endif
                                                                    @endforeach
                                                            </tr>


                                                        </tbody>
                                                        <tfoot>
                                                            @if (count($data) > 0)
                                                                <tr id="trTotal">
                                                                    <td style="text-align:right" bgcolor="#00ff7f">
                                                                        {{trans('modules.total_balance')}}
                                                                    </td>
                                                                    <td bgcolor="#7fff00"></td>
                                                                    @foreach ($activeCurrencies as $curr)
                                                                        @if ($curr->id == $majorCurrency->id)
                                                                        <td bgcolor="#7fff00">
                                                                            {{ number_format($final_balances['final_balance_with_rotate_accounts'], 2) }}
                                                                        </td>
                                                                        @else   
                                                                        <td bgcolor="#7fff00">
                                                                            {{ number_format($final_balances['final_balance_' . $curr->id], 2) }}
                                                                        </td>
                                                                        @endif  
                                                                    @endforeach
                                                                </tr>
                                                            @else
                                                                <tr id="trTotal">
                                                                    <td colspan='{{ count($activeCurrencies)+1 }}'> {{trans('labels.no_result')}}</td>
                                                                </tr>
                                                            @endif
                                                        </tfoot>
                                                    </table>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>

                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        <!-- start Table -->
                        <div class="box">
                            <!--div class="box-header">
                                <h3 class="box-title"></h3>
                            </div-->
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div id="form-table" class="dataTables_wrapper form-inline dt-bootstrap">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="tableFixHead">
                                                <table id="tableId2" class="table table-bordered table-striped dataTable"
                                                    role="grid" aria-describedby="tableId2_info">
                                                    <thead>
                                                        <tr role="row">
                                                            <th>{{trans('modules.item')}}</th>
                                                            <th>{{trans('modules.inventory')}}</th>
                                                            <th>{{trans('modules.quantity')}}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($inventories_data != null)
                                                            @foreach ($inventories_data as $inv_data)
                                                                <tr>
                                                                    <td>{{ $inv_data->nameAr }}</td>
                                                                    <td>{{ $inv_data->sourceInventory }}</td>
                                                                    <td>
                                                                        @php 
                                                                         $value = $inv_data->item_in - ($inv_data->item_out == null ? 0 : $inv_data->item_out);
                                                                        @endphp
                                                                        {{ number_format($value, 2)}}
                                                                    </td>

                                                                </tr>
                                                            @endforeach
                                                            @if (count($inventories_data) < 0)
                                                                <tr id="trTotal">
                                                                    <td colspan='3'> {{trans('labels.no_result')}}</td>
                                                                </tr>
                                                            @endif
                                                        @endif
                                                    </tbody>
                                                    <tfoot>

                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- end Table -->

                    </div>
                    <div class="tab-pane" id="tab_3">
                        <!-- start Table -->
                        <div class="box">
                            <!--div class="box-header">
                                <h3 class="box-title"></h3>
                            </div-->
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div id="form-table" class="dataTables_wrapper form-inline dt-bootstrap">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="tableFixHead">
                                                @php $hasZeroValue = false; @endphp
                                                <table id="tableId3" class="table table-bordered table-striped dataTable"
                                                    role="grid" aria-describedby="tableId3_info">
                                                    <thead>
                                                        <tr role="row">
                                                            <th>{{trans('modules.item')}}</th>
                                                            <th>{{trans('modules.cost')}}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($profits_and_loss->items_cost_list != null)
                                                           
                                                            @foreach ($profits_and_loss->items_cost_list as $item)
                                                                @php
                                                                $color="#000000";
                                                                if($item['cost'] == 0){
                                                                    $hasZeroValue = true;
                                                                    $color="#ff0000";
                                                                }
                                                                @endphp
                                                                <tr style="color:{{$color}};">
                                                                    <td>{{ $item['name_ar'] }}</td>
                                                                    <td>{{ number_format($item['cost'],2) }}</td>
                                                                </tr>
                                                            @endforeach
                                                            @if (count($profits_and_loss->items_cost_list) < 0)
                                                                <tr id="trTotal">
                                                                    <td colspan='2'> {{trans('labels.no_result')}}</td>
                                                                </tr>
                                                            @endif
                                                        @endif
                                                    </tbody>
                                                    <tfoot>
                                                       @if($hasZeroValue)
                                                       <div class='callout callout-warning'>
                                                            <h4><i class="fa fa-warning"></i> {{trans('labels.warning')}} </h4>
                                                            {{trans('messages.items_costs_warning_message')}} 
                                                           
                                                        </div>
                                                       @endif         
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- end Table -->

                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_4">
                        {{trans('labels.entries_list')}} :


                        <table class='table table-bordered table-striped dataTable'>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{trans('modules.debit')}}</th>
                                    <th>{{trans('modules.credit')}}</th>
                                    <th>{{trans('labels.result')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{trans('labels.sales')}}</td>
                                    <td></td>
                                    <td>{{ number_format($profits_and_loss->sales_inMajorCurrency, 2) }}</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>{{trans('labels.sales_return')}}</td>
                                    <td>{{ number_format($profits_and_loss->sales_return_inMajorCurrency, 2) }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>{{trans('labels.granted_discount')}}</td>
                                    <td>{{ number_format($profits_and_loss->granted_discount_inMajorCurrency, 2) }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>{{trans('labels.purchases')}}</td>
                                    <td>{{ number_format($profits_and_loss->purchases_inMajorCurrency, 2) }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>{{trans('labels.purchases_return')}}</td>
                                    <td></td>
                                    <td>{{ number_format($profits_and_loss->purchases_return_inMajorCurrency, 2) }}</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>{{trans('labels.earned_discount')}}</td>
                                    <td></td>
                                    <td>{{ number_format($profits_and_loss->earned_discount_inMajorCurrency, 2) }}</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>{{trans('labels.begin_inventories_items_value')}}</td>
                                    <td>{{ number_format($profits_and_loss->begin_inventories_items_value, 2) }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>{{trans('labels.last_inventories_items_value')}}</td>
                                    <td></td>
                                    <td>{{ number_format($profits_and_loss->last_inventories_items_value, 2) }}</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#00ff7f">{{trans('labels.gross_profit')}}</td>
                                    <td bgcolor="#7fff00">{{ number_format($profits_and_loss->gross_profit_debit, 2) }}</td>
                                    <td bgcolor="#7fff00">{{ number_format($profits_and_loss->gross_profit_credit, 2) }}</td>
                                    <td bgcolor="#00ff7f">{{ number_format($profits_and_loss->gross_profit, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>{{trans('labels.all_incomes')}}</td>
                                    <td></td>
                                    <td>{{ number_format($profits_and_loss->all_incomes_inMajorCurrency, 2) }}</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>{{trans('labels.all_outgoings')}}</td>
                                    <td>{{ number_format($profits_and_loss->all_outgoings_inMajorCurrency, 2) }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td bgcolor="#00ff7f">{{trans('labels.net_profit')}}</td>
                                    <td bgcolor="#7fff00">{{ number_format($profits_and_loss->net_profit_debit, 2) }}</td>
                                    <td bgcolor="#7fff00">{{ number_format($profits_and_loss->net_profit_credit, 2) }}</td>
                                    <td bgcolor="#00ff7f">{{ number_format($profits_and_loss->net_profit, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </div>


    </div>

    <div id="ReCalculateSaveResultModal" class="modal modal-primary fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{trans('labels.save_re_calculate_result')}}</h4>
            </div>
            <div class="modal-body">
                <p> {{trans('labels.choose_options_to_re_calculate_data')}} </p>
                <form role="form" id="RecalculateDataForm">
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="options" value="initial_balances" @if(in_array('initial_balances',$options)) checked @endif>
                                {{trans('labels.initial_balances')}}
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="options" value="beginning_items" @if(in_array('beginning_items',$options)) checked @endif >
                                {{trans('labels.beginning_items')}}
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="options" value="entries_list" @if(in_array('entries_list',$options)) checked @endif>
                                {{trans('labels.entries_list_brief')}}
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="options" value="helpful_accounts" @if(in_array('helpful_accounts',$options)) checked @endif>
                                {{trans('labels.helpful_accounts_brief')}}
                            </label>
                        </div>
                        
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="options" value="items_cost" @if(in_array('items_cost',$options)) checked @endif>
                                {{trans('labels.items_cost')}}
                            </label>
                        </div>
                        <div class="checkbox" >
                            <label>
                                <input type="checkbox" name="options" value="currencies_ex_rates" @if(in_array('currencies_ex_rates',$options)) checked @endif>
                                {{trans('labels.currencies_ex_rates')}}
                            </label>
                        </div>
                    </div>
                </from>
            </div>
            <div class="modal-footer">
                <button type="button" id="save_re_calculate_data_result"  class="btn btn-primary" > {{trans('labels.save_re_calculate_result')}} <i class="fa fa-save "></i> </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"> {{trans('labels.close')}}</button>
            </div>
            </div>

        </div>
    </div>

    @push('bottom')
    <script>
        var _PLEASE_CHOOSE_SOME_OPTIONS = "{{trans('messages.please_choose_some_options')}}";
        var _RECALCULATE_DATA_MESSAGE = "{{trans('messages.re_calculate_data_message')}}";
        var _ARE_YOU_CONFIRM = "{{trans('labels.are_you_confirm')}}";
        var _YES = "{{trans('crudbooster.Yes')}}";
        var _NO = "{{trans('crudbooster.No')}}";
        var _GO_HOME_WITHOUT_RECALCULATE_DATA_MESSAGE = "{{trans('messages.go_home_without_re_calculate_data_message',['cycle_name'=>$cycle_name])}}";

    </script>
    <script src="{{ asset ('js/modules_js/financial_cycles/re_calculate_data_script.js') }}"></script>
    @endpush

@endsection
