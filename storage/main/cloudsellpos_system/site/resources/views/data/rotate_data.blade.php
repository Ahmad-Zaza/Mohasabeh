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
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">{{trans('labels.initial_balances_for_new_year')}}</a></li>
                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">{{trans('labels.beginning_items_for_new_year')}}</a></li>
                    <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">{{trans('labels.items_cost_for_new_year')}}</a></li>
                    <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false">{{trans('labels.entries_list')}}</a></li>

                    <li class="pull-left" style="padding-top:10px;">
                        @php $path = url('modules/rotate_data'); @endphp
                        <button class="btn btn-xs btn-warning"
                            onclick="location.href = '{{$path}}'"> {{trans('labels.back')}} <i
                                class="fa fa-chevron-circle-right"></i></button>
                        <button id="rotate_data" class="btn btn-xs btn-primary"> {{trans('labels.rotate_data')}} <i
                                class="fa fa-gear "></i></button>
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

    <script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>

    <script type="text/javascript">
        $('#rotate_data').click(function() {

            swal({
                title: "{{trans('labels.are_you_confirm')}}",
                text: "{{trans('labels.rotate_data_message',['next_rotate_date'=>$next_rotate_date])}}",
                type: 'info',
                showCancelButton: true,
                allowOutsideClick: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: "{{trans('labels.continue')}}",
                cancelButtonText: "{{trans('labels.cancel')}}",
                closeOnConfirm: false
            }, function() {
                $('#rotate_data i').addClass('fa-spin');
                $('#rotate_data').addClass('disabled');
                $('.waiting-msg').removeClass('hidden');
                $('.loading').css("display", "table");
                swal.close();
                $.get('/rotate_data', function(res) {
                    let json_res = JSON.parse(res);
                    console.log(res);
                    $('#rotate_data i').removeClass('fa-spin');
                    $('.waiting-msg').addClass('hidden');
                    $('#rotate_data').removeClass('disabled');
                    if (json_res.status == 'error') {
                        notify(_ERROR,json_res.massege,'error');
                    } else {
                        notify(_SUCCESS,json_res.massege,'success');
                        location.href = "{{url(config('crudbooster.ADMIN_PATH').'/rotate_data/result')}}";
                    }

                })

            });



        });
    </script>
@endsection
