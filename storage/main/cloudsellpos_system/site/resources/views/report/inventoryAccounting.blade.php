@extends('crudbooster::admin_template')
@section('content')

    <div class="box">
        <div class="box-header">
            <form method="get" action="{{ url('modules/inventory_accounting_report') }}" class="print_display_none">
                <div class="col-lg-12">
                    <div class="col-lg-4" id="report-filter-item">
                        {{trans('modules.item')}}:
                        <select class="form-control" name="item_id" id="select-item">
                            <option value="-1"> {{trans('labels.all_items')}}</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}" {{ $item_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->p_code }} - {{ $item->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4" id="report-filter-inventory">
                        {{trans('modules.inventory')}}:
                        <select class="form-control" name="inventory_id" id="select-inventory">
                            <option value="-1"> {{trans('labels.all_inventories')}}</option>
                            @foreach ($inventories as $item)
                                <option value="{{ $item->id }}"
                                    {{ ($inventory_id == $item->id or count($inventories) == 1) ? 'selected' : '' }}>
                                    {{ $item->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-4" id="report-filter-date"> {{ trans('crudbooster.Date') }} : {{ $date }}

                        <input type="date" name="date" id="date" class="form-control"
                            value="{{ $date }}">
                    </div>

                    <br>
                    <br>
                    <br>

                    <div class="col-lg-4">
                        <button type="submit" class="btn btn-primary btn-xs" id="search">
                            {{ trans('crudbooster.Search') }} <i class="fa fa-search"></i></button>
                        <a name='reset' class="btn btn-warning btn-xs" href="{{ url('/modules/inventory_accounting_report') }}"
                            id="reset"> {{ trans('crudbooster.Reset') }} <i class="fa fa-refresh"></i></a>
                        @php
                            $disabled = 'disabled';
                            if ($data != null && count($data) > 0) {
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


        <table id="table_dashboard" class="table table-hover table-striped table-bordered report-table">
            <caption> <b>
                    <center>{{trans('labels.items_quantity')}}</center>
                </b></caption>
            <thead>
                <tr class="active">
                    <th width="auto"> {{trans('modules.item_code')}} </th>
                    <th width="auto"> {{trans('modules.item_name')}} </th>
                    <th width="auto"> {{trans('modules.inventory')}} </th>
                    <th width="auto"> {{trans('modules.in')}} </th>
                    <th width="auto"> {{trans('modules.out')}} </th>
                    <th width="auto"> {{trans('modules.the_balance')}} </th>

                </tr>
            </thead>
            <tbody class="ui-sortable">
                @if (count($data) > 0)

                    @foreach ($data as $item)
                        @php
                            $item_in = $item->item_in ? $item->item_in : 0;
                            $item_out = $item->item_out ? $item->item_out : 0;
                        @endphp
                        <tr data-id="{{ $item->record_id }}">
                            <td>
                                {{ $item->pCode }}
                            </td>
                            <td>
                                {{ $item->nameAr }}
                            </td>
                            <td>
                                {{ $item->sourceInventory }}
                            </td>
                            <td>
                                {{ $item->item_in ? number_format($item->item_in, 2) : 0 }}
                            </td>
                            <td>
                                {{ $item->item_out ? number_format($item->item_out, 2) : 0 }}
                            </td>
                            <td>
                                {{ number_format(($item->item_in ? $item->item_in : 0) - ($item->item_out ? $item->item_out : 0), 2) }}

                            </td>
                        </tr>
                    @endforeach
                    @if (count($data) >= config('setting.PAGINATIOM_LIMITATION'))
                        <tr class="loadmore-tr">
                            <td colspan="6">
                                <center>
                                    <a id="loadmore-btn" data-offset="0"
                                        data-limit="{{ config('setting.PAGINATIOM_LIMITATION') }}"
                                        href="javascript:void(0)">{{trans('labels.show_more')}} <i class="fa fa-angle-double-down"></i></a>
                                </center>
                            </td>
                        </tr>
                    @endif
                @else
                    <tr>
                        <td colspan="6">
                            <center>
                                {{trans('labels.no_result')}}
                            </center>
                        </td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                @if (count($data) > 0)
                    <tr class="active">
                        <th width="auto"> {{trans('modules.item_code')}} </th>
                        <th width="auto"> {{trans('modules.item_name')}} </th>
                        <th width="auto"> {{trans('modules.inventory')}} </th>
                        <th width="auto"> {{trans('modules.in')}} </th>
                        <th width="auto"> {{trans('modules.out')}} </th>
                        <th width="auto"> {{trans('modules.the_balance')}} </th>

                    </tr>
                    <tr>
                        <td colspan="3" bgcolor="#00ff7f">{{trans('labels.total_balance')}} </td>
                        <td bgcolor="#7fff00">{{ number_format($items_in, 2) }}</td>
                        <td bgcolor="#7fff00">{{ number_format($items_out, 2) }}</td>
                        <td bgcolor="#7fff00">{{ number_format($items_total, 2) }}</td>
                    </tr>
                @endif
            </tfoot>


        </table>

    </div>
    <script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <link href="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/select2/select2.min.js') }}"></script>
    <script type="text/javascript">
        $('#select-item').select2();
        $('#select-inventory').select2();



        $('#tableId').delegate('.btn-edit', 'click', function() {

            var value = $(this).data('id');
            var currentRow = $(this).closest("tr");
            var type = currentRow.find("td:eq(0)").text(); // get current row 1st TD value
            var trackingId = currentRow.find("td:eq(1)").text(); // get current row 1st TD value
            console.log(type);
            console.log(value);
            var base_url = window.location.origin;

            if (type == "bill") {
                window.location.href = base_url + "/modules/bills_purchase_invoice/detail/" + value;

            }
            if (type == "inventory beginning") {
                window.location.href = base_url + "/modules/inventory_beginning/detail/" + trackingId;

            }
            if (type == "invoice") {
                window.location.href = base_url + "/modules/bills_sales_invoice/detail/" + value;

            }
            if (type == "Purchase return") {
                window.location.href = base_url + "/modules/bills_purchase_return_invoice/detail/" + value;

            }
            if (type == "Sales return") {
                window.location.href = base_url + "/modules/bills_sales_return_invoice/detail/" + value;

            }
            if (type == "Transfer") {
                window.location.href = base_url + "/modules/transfer_items/detail/" + trackingId;

            }

        })

        $(document).ready(function() {
            $('#export').click(function(event) {
                let data = $('form').serializeArray();
                let data_json = JSON.stringify(data);
                window.open("/modules/inventory_accounting/export/" + data_json, '_blank');
                event.preventDefault();
            });

            $('#PrintReport').click(function(event) {
                let data = $('form').serializeArray();
                let data_json = JSON.stringify(data);
                window.open("/modules/inventory_accounting/print/" + data_json, '_blank');
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
                console.log(offset);
                $('#loadmore-btn i').removeClass('fa-angle-double-down');
                $('#loadmore-btn i').addClass('fa-spinner fa-spin');
                $.get('/modules/inventory_accounting/loadmore/offset' + new_offset + '/limit' + limit +
                    '/' + data_json,
                    function(res) {
                        console.log(res);
                        res.forEach(element => {
                            const target = document.querySelector('.loadmore-tr');
                            target.insertAdjacentHTML('beforebegin', "<tr data-id='" + element
                                .record_id + "'><td>" + element.pCode + "</td><td>" +
                                element.nameAr + "</td><td>" + element.sourceInventory +
                                "</td><td>" + element.item_in + "</td><td>" + element
                                .item_out + " </td><td>" + element.item_all + "</td></tr>");
                        });

                        if (res.length < limit || res.length == 0) {
                            $('.loadmore-tr').hide();
                        }

                        $('#loadmore-btn i').removeClass('fa-spinner fa-spin');
                        $('#loadmore-btn i').addClass('fa-angle-double-down');
                        $('#loadmore-btn').data('offset', new_offset);

                    });
            });

        });
    </script>
@stop
