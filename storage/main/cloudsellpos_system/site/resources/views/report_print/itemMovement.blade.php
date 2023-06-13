@extends('crudbooster::admin_template')
@section('content')

    <div class="box">
        <div class="box-header">
            <div class="pull-left print_display_none">
                <button class="btn btn-success btn-xs" onclick="window.print();"> {{trans('labels.print')}} <i class="fa fa-print"></i></button>
                <button class="btn btn-primary btn-xs" onclick='window.close();'> {{trans('labels.close')}} <i class="fa fa-close"></i></button>
            </div>
        </div>

        <!---- start Report ------>

        <table id="table_dashboard" class="table table-hover table-striped table-bordered print_margn-rght-20 report-table">
            <caption> <b>
                    <center>{{trans('labels.item_movement')}}</center>
                </b></caption>
            <thead>
                <tr class="active">
                    <th style="display:none;"></th>
                    <th style="display:none;"></th>
                    <th style="display:none;"></th>
                    <th width="auto"> {{trans('modules.type_name')}} </th>
                    <th width="auto"> {{trans('modules.code')}} </th>
                    <th width="auto"> {{trans('modules.client')}} </th>
                    <th width="auto"> {{trans('modules.date')}} </th>
                    <th width="auto"> {{trans('modules.inventory')}} </th>
                    <th width="auto"> {{trans('modules.item_name')}} </th>
                    <th width="auto"> {{trans('modules.item_unit')}} </th>

                    <th width="auto"> {{trans('modules.in')}} </th>
                    <th width="auto"> {{trans('modules.out')}} </th>
                    <th width="auto"> {{trans('modules.balance')}} </th>
                </tr>
            </thead>
            <tbody class="ui-sortable">
                @php
                    $allQuantity = 0;
                @endphp
                @if (count($data) > 0)
                    @foreach ($data as $item)
                        @php
                            if ($item->typeId == 5) {
                                // بضاعة أول المدة
                                $ib_tracking_id = DB::table('inventory_beginning_items_list')
                                    ->where('p_code', $item->trackingName)
                                    ->where('cycle_id', Session::get('display_cycle'))
                                    ->first()->ib_tracking_id;
                                $item->trackingId = $ib_tracking_id;
                            }
                            if ($item->typeId == 6) {
                                //مناقة مواد
                                $transfer_tracking_id = DB::table('transfer_items_list')
                                    ->where('p_code', $item->trackingName)
                                    ->where('cycle_id', Session::get('display_cycle'))
                                    ->first()->transfer_tracking_id;
                                $item->trackingId = $transfer_tracking_id;
                            }
                        @endphp
                        <tr data-record="{{ $item->record_id }}" id="{{ $item->billId }}">
                            <td style="display:none;">{{ $item->typeEn }}</td>
                            <td style="display:none;">{{ $item->trackingId }}</td>
                            <td style="display:none;">{{ $item->billId }}</td>
                            <td>
                                {{ $item->typeName }}
                            </td>
                            <td>
                                {{ $item->trackingName }}
                            </td>
                            <td>
                                @php
                                    $account_name = '';
                                    if ($item->typeId == 1 || $item->typeId == 3) {
                                        $account_name = $item->creditName;
                                    } else {
                                        $account_name = $item->debitName;
                                    }
                                @endphp
                                {{ $account_name }}
                            </td>
                            <td>
                                {{ $item->trackingDate }}
                            </td>
                            <td>
                                {{ $item->sourceInventory }}
                            </td>

                            <td>
                                {{ $item->itemNameAr }}
                            </td>
                            <td>
                                {{ $item->itemUnitNameAr }}

                            </td>
                            @php
                                $in = 0;
                                $out = 0;
                                if ($item->trackingOperation == 'in') {
                                    $in = $item->trackingQuantity;
                                    $allQuantity += $item->trackingQuantity;
                                } else {
                                    $out = $item->trackingQuantity;
                                    $allQuantity -= $item->trackingQuantity;
                                }
                            @endphp
                            <td>
                                {{ $in != 0 ? number_format($in, 2) : 0 }}
                            </td>

                            <td>
                                {{ $out != 0 ? number_format($out, 2) : 0 }}
                            </td>

                            <td>
                                {{ $allQuantity != 0 ? number_format($allQuantity, 2) : 0 }}
                            </td>

                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="10">
                            <center>
                                {{trans('labels.no_data_for_this_item')}}
                            </center>
                        </td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                @if (count($data) > 0)
                    <tr>
                        <td colspan="8" bgcolor="#00ff7f">{{trans('labels.total_balance')}} </td>
                        <td bgcolor="#00ff7f"></td>
                        <td bgcolor="#7fff00">{{ number_format($total_quantity, 2) }}</td>
                    </tr>
                @endif

            </tfoot>

        </table>


    </div>

    <!---- end Report ------>
    <script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <script>
        $('body').addClass('sidebar-collapse');
        $(document).ready(function() {
            window.print();
        });
    </script>
@stop
