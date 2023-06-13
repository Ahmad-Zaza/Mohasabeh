@extends('crudbooster::admin_template')
@section('content')

    <div class="box">
        <div class="box-header">
            <form method="get" action="{{ url('modules/item_movement_report') }}" class="print_display_none">
                <div class="col-lg-12">
                    <div class="col-lg-4" id="report-filter-inventory">
                        {{trans('modules.inventory')}}:
                        <select class="form-control" name="inventory_id" id="select-inventory">
                            <option value="-1"> {{trans('labels.all_inventories')}}</option>
                            @foreach ($inventories as $item)
                                <option value="{{ $item->id }}" {{ $inventory_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-4" id="report-filter-item">
                        {{trans('modules.item')}}:
                        <select class="form-control" name="item_id" id="select-item">
                            <option value="-1">{{trans('labels.choose_item')}}</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}" {{ $item_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->p_code }} - {{ $item->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4" id="report-filter-operation">
                        {{trans('modules.operation')}}:
                        <select class="form-control" name="type_id" id="select-operation">
                            <option value="-1"> {{trans('labels.all_operations')}}</option>
                            @foreach ($types as $item)
                                <option value="{{ $item->id }}" {{ $type_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="col-lg-4" id="report-filter-from_date">

                        {{ trans('crudbooster.From') }} : <input type="date" name="from_date" id="date"
                            class="form-control" value="{{ $from_date }}">
                    </div>

                    <div class="col-lg-4" id="report-filter-to_date">
                        {{ trans('crudbooster.To') }} : <input type="date" name="to_date" id="date"
                            class="form-control" value="{{ $to_date }}">
                    </div>
                    <br>
                    <div class="col-lg-4">
                        <button type="submit" class="btn btn-primary btn-xs" id="search">
                            {{ trans('crudbooster.Search') }} <i class="fa fa-search"></i></button>
                        <a name='reset' class="btn btn-warning btn-xs" href="{{ url('/modules/item_movement_report') }}"
                            id="reset"> {{ trans('crudbooster.Reset') }} <i class="fa fa-refresh"></i></a>
                        @php
                            $disabled = 'disabled';
                            if ($data != null && count($data) > 0 && $item_id != '-1' && $item_id != null) {
                                $disabled = '';
                            }
                        @endphp
                        <button id="PrintReport" class="btn btn-success btn-xs" {{ $disabled }}> {{trans('labels.print')}} <i
                                class="fa fa-print"></i></button>
                        <button id="export" name='export' class="btn btn-info btn-xs" {{ $disabled }}> {{trans('labels.export')}} <i
                                class="fa fa-file-excel-o"></i></button>

                    </div>
                </div>
            </form>
            <hr>
        </div>

        <!--div class="print_display_none">
    <br>
    <br>
    <br>
    <br>
    <br>
    </div-->

        @if ($item_id == null || $item_id == -1)
            <div class="col-sm-12">
                <div class="col-sm-12">
                    <div class="callout callout-info" style="margin-top:50px;">
                        {{trans('labels.please_choose_item_to_show_report')}}
                    </div>
                </div>
            </div>
        @else
            <!---- start Report ------>


            <table id="table_dashboard"
                class="table table-hover table-striped table-bordered print_margn-rght-20 report-table">
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
                        <th width="auto"> {{trans('modules.the_balance')}} </th>

                        <!--th width="auto"> {{trans('modules.the_balance')}} </th-->
                        <th width="auto" class="print_display_none">{{trans('modules.source')}} </th>

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

                                <td class="print_display_none">
                                    <button type="button" class="btn btn-primary btn-xs btn-edit" id="edit"
                                        data-id="{{ $item->trackingId }}"> {{trans('modules.source')}}</button>
                                </td>

                            </tr>
                        @endforeach
                        @if (count($data) >= config('setting.PAGINATIOM_LIMITATION'))
                            <tr class="loadmore-tr">
                                <td colspan="11">
                                    <center>
                                        <a id="loadmore-btn" data-offset="0"
                                            data-limit="{{ config('setting.PAGINATIOM_LIMITATION') }}"
                                            data-subtotal="{{ $allQuantity }}" href="javascript:void(0)">{{trans('labels.show_more')}} <i
                                                class="fa fa-angle-double-down"></i></a>
                                    </center>
                                </td>
                            </tr>
                        @endif
                    @else
                        <tr>
                            <td colspan="11">
                                <center>
                                    {{trans('labels.no_data_for_this_item')}}
                                </center>
                            </td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    @if (count($data) > 0)
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
                            <th width="auto"> {{trans('modules.the_balance')}} </th>

                            <!--th width="auto"> {{trans('modules.the_balance')}} </th-->
                            <th width="auto" class="print_display_none">{{trans('modules.source')}} </th>

                        </tr>
                        
                        <tr>
                            <td colspan="8" bgcolor="#00ff7f">{{trans('labels.total_balance')}} </td>
                            <td bgcolor="#00ff7f"></td>
                            <td bgcolor="#7fff00">{{ number_format($total_quantity, 2) }}</td>
                            <td bgcolor="#00ff7f"></td>
                        </tr>
                    @endif

                </tfoot>


            </table>


    </div>

    <!---- end Report ------>
    @endif
    <script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <link href="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/select2/select2.min.js') }}"></script>
    <script type="text/javascript">
        $('#select-inventory').select2();
        $('#select-item').select2();
        $('#select-operation').select2();

        $('#table_dashboard').delegate('.btn-edit', 'click', function() {

            // var value = $(this).data('id');
            var currentRow = $(this).closest("tr");
            var type = currentRow.find("td:eq(0)").text(); // get current row 1st TD value
            var trackingId = currentRow.find("td:eq(1)").text(); // get current row 1st TD value
            var billId = currentRow.find("td:eq(2)").text(); // get current row 1st TD value

            var base_url = window.location.origin;
            var source_url = '#';
            if (type == "bill") {
                source_url = base_url + "/modules/bills_purchase_invoice/detail/" + billId;

            }
            if (type == "inventory beginning") {
                source_url = base_url + "/modules/inventory_beginning/detail/" + trackingId;

            }
            if (type == "invoice") {
                source_url = base_url + "/modules/bills_sales_invoice/detail/" + billId;

            }
            if (type == "Purchase return") {
                source_url = base_url + "/modules/bills_purchase_return_invoice/detail/" + billId;

            }
            if (type == "Sales return") {
                source_url = base_url + "/modules/bills_sales_return_invoice/detail/" + billId;

            }
            if (type == "Transfer") {
                source_url = base_url + "/modules/transfer_items/detail/" + trackingId;

            }

            window.open(source_url + "?link=source", '_blank');
        })

        $(document).ready(function() {
            $('#export').click(function(event) {
                let data = $('form').serializeArray();
                let data_json = JSON.stringify(data);
                window.open("/modules/item_movement/export/" + data_json, '_blank');
                event.preventDefault();
            });

            $('#PrintReport').click(function(event) {
                let data = $('form').serializeArray();
                let data_json = JSON.stringify(data);
                window.open("/modules/item_movement/print/" + data_json, '_blank');
                event.preventDefault();
            });

            $("#search").click(function() {
                $("#search i").removeClass('fa-search');
                $("#search i").addClass('fa-spinner fa-spin');
            });

            $('#loadmore-btn').click(function() {
                let data = $('form').serializeArray();
                let data_json = JSON.stringify(data);

                let offset = $(this).data('offset');
                let limit = $(this).data('limit');
                let new_offset = offset + limit;

                let subtotal = $(this).data('subtotal');
                console.log(subtotal);
                $('#loadmore-btn i').removeClass('fa-angle-double-down');
                $('#loadmore-btn i').addClass('fa-spinner fa-spin');
                $.get('/modules/item_movement/loadmore/offset' + new_offset + '/limit' + limit +
                    '/subtotal' + subtotal + '/' + data_json,
                    function(res) {
                        console.log(res);
                        res.forEach(element => {
                            const target = document.querySelector('.loadmore-tr');
                            target.insertAdjacentHTML('beforebegin', "<tr data-record='" +
                                element.record_id + "' id='" + element.billId +
                                "'><td style='display:none;'>" + element.typeEn +
                                "</td><td style='display:none;'>" + element.trackingId +
                                "</td><td style='display:none;'>" + element.billId +
                                "</td><td>" + element.typeName + "</td><td>" + element
                                .trackingName + "</td><td>" + element.account_name +
                                "</td><td>" + element.trackingDate + "</td><td>" + element
                                .sourceInventory + "</td><td>" + element.itemNameAr +
                                "</td><td>" + element.itemUnitNameAr + "</td><td>" + element
                                .item_in + "</td><td>" + element.item_out + "</td><td>" +
                                element.allQuantity +
                                "</td><td class='print_display_none'><button type='button' class='btn btn-primary btn-xs btn-edit' id='edit' data-id='" +
                                element.trackingId + "' > {{trans('modules.source')}}</button></td></tr>");
                        });

                        if (res.length < limit || res.length == 0) {
                            $('.loadmore-tr').hide();
                        }

                        $('#loadmore-btn i').removeClass('fa-spinner fa-spin');
                        $('#loadmore-btn i').addClass('fa-angle-double-down');
                        $('#loadmore-btn').data('offset', new_offset);
                        $('#loadmore-btn').data('subtotal', res[res.length - 1].allQuantity);
                    });
            });

        });

    </script>
@stop
