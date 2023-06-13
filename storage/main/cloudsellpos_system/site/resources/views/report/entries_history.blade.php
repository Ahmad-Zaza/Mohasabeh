@extends('crudbooster::admin_template')
@section('content')

    <div class="box">
        <div class="box-header">
            <form id="filter-form" method="get" action="{{ url('modules/entries_history_report') }}" class="print_display_none">
                <div class="col-lg-12">
                    <div class="col-lg-3" id="report-filter-account">
                        {{trans('modules.account')}} :
                        <select class="form-control" name="account_id" id="select-account">
                            <option value="-1">{{trans('labels.all_accounts')}} </option>
                            @foreach ($accounts as $item)
                                <option value="{{ $item->id }}" {{ $account_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-3" id="report-filter-delegate">
                        {{trans('modules.delegate')}} :
                        <select class="form-control" name="delegate_id" id="select-delegate">

                            <option value="-1">{{trans('labels.all_delegates')}} </option>
                            @foreach ($delegates as $item)
                                <option value="{{ $item->id }}" {{ $delegate_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3" id="report-filter-currency">
                        {{trans('modules.currency')}} :
                        <select class="form-control" name="currency_id" id="select-currency">
                            <option value="-1">{{trans('labels.all_currencies')}} </option>
                            @foreach ($currencies as $item)
                                <option value="{{ $item->id }}" {{ $currency_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3" id="report-filter-action">
                        {{trans('modules.action')}} :
                        <select class="form-control" name="action" id="select-action">
                            <option value="-1">{{trans('labels.all_actions')}} </option>
                            <option value="1" {{ $action == 1 ? 'selected' : '' }}>{{trans('labels.edit')}}</option>
                            <option value="2" {{ $action == 2 ? 'selected' : '' }}>{{trans('labels.delete')}}</option>

                        </select>
                    </div>
                    <div class="col-lg-3" id="report-filter-from_date">{{ trans('crudbooster.From') }} :
                        {{ $from_date }}

                        <input type="date" name="from_date" id="from_date" class="form-control"
                            value="{{ $from_date }}">
                    </div>

                    <div class="col-lg-3" id="report-filter-to_date">{{ trans('crudbooster.To') }} : {{ $to_date }}

                        <input type="date" name="to_date" id="to_date" class="form-control"
                            value="{{ $to_date }}">
                    </div>



                    <div class="col-lg-6">
                        <br>
                        <button type="submit" class="btn btn-primary btn-xs" id="search">
                            {{ trans('crudbooster.Search') }} <i class="fa fa-search"></i></button>
                        <a name='reset' class="btn btn-warning btn-xs" href="{{ url('/modules/entries_history_report') }}"
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
                    <center> {{trans('labels.history_edit_delete_entries')}}</center>
                </b></caption>
            <thead>
                <tr class="active">
                    <th width="auto"> {{trans('modules.entry')}} </th>
                    <th width="auto"> {{trans('modules.name')}} </th>
                    <th width="auto"> {{trans('modules.debit')}} </th>
                    <th width="auto"> {{trans('modules.credit')}} </th>
                    <th width="auto"> {{trans('modules.narration')}} </th>
                    <th width="auto"> {{trans('modules.currency')}} </th>
                    <th width="auto"> {{trans('modules.action_date')}} </th>
                    <th width="auto"> {{trans('modules.action_by')}} </th>
                    <th width="auto"> {{trans('modules.action')}} </th>
                    <th width="auto" class="print_display_none">
                        <center>{{trans('modules.source')}}</center>
                    </th>
                </tr>
            </thead>
            <tbody class="ui-sortable">
                @if (count($data) > 0)
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->entryBaseId }}</td>

                            <td>
                                {{ $item->name }}
                            </td>

                            <td title="{{trans('modules.debit')}}">
                                {{ $item->received_amount ? number_format($item->received_amount, 2) : 0 }}

                            </td>
                            <td title="{{trans('modules.credit')}}">
                                {{ $item->paid_amount ? number_format($item->paid_amount, 2) : 0 }}
                            </td>
                            <td>
                                {{ $item->narration }}
                            </td>
                            <td>
                                {{ $item->currency }}
                            </td>
                            @php
                                $temp_id = '';
                                $temp_type = '';
                                $is_bill = '';
                                $action = '';
                                if ($item->bill_id != null) {
                                    $temp_id = $item->bill_id;
                                    $temp_type = $item->bill_type;
                                    $is_bill = 'yes';
                                    $action = $item->action == 'delete' ? trans('labels.delete') : trans('labels.edit');
                                    $staff = "";
                                    $action_date = "";
                                    if($item->action == 'edit'){
                                        $action_date =$item->edit_date;
                                        $staff =  $item->edit_by_name;
                                    }else{
                                        $action_date =$item->delete_date;
                                        $staff =  $item->employee_name;
                                    }
                                } else {
                                    $temp_id = $item->voucher_id;
                                    $temp_type = $item->voucher_type;
                                    $is_bill = 'no';
                                    $action = $item->action == 'delete' ? trans('labels.delete') : trans('labels.edit');
                                    $staff = "";
                                    $action_date = "";
                                    if($item->action == 'edit'){
                                        $action_date =$item->edit_date;
                                        $staff =  $item->edit_by_name;
                                    }else{
                                        $action_date =$item->delete_date;
                                        $staff =  $item->employee_name;
                                    }
                                }
                            @endphp
                            <td class="table-date">

                                {{ $action_date }}
                            </td>
                            <td>
                                {{ $staff }}
                            </td>
                            <td>
                                {{ $action }}
                            </td>
                            <td class="print_display_none">

                                <button type="button" class="btn btn-primary btn-edit btn-xs print_display_none"
                                    id="edit" data-entry_base_id="{{ $item->entryBaseId }}"
                                    data-is_bill="{{ $is_bill }}" data-id="{{ $temp_id }}"
                                    data-type="{{ $temp_type }}"> {{trans('modules.source')}}</button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="10">
                            <center>
                                {{trans('labels.no_result')}}
                            </center>
                        </td>
                    </tr>
                @endif


            </tbody>
            <tfoot>
                <tr class="active">
                    <th width="auto"> {{trans('modules.entry')}} </th>
                    <th width="auto"> {{trans('modules.name')}} </th>
                    <th width="auto"> {{trans('modules.debit')}} </th>
                    <th width="auto"> {{trans('modules.credit')}} </th>
                    <th width="auto"> {{trans('modules.narration')}} </th>
                    <th width="auto"> {{trans('modules.currency')}} </th>
                    <th width="auto"> {{trans('modules.action_date')}} </th>
                    <th width="auto"> {{trans('modules.action_by')}} </th>
                    <th width="auto"> {{trans('modules.action')}} </th>
                    <th width="auto" class="print_display_none">
                        <center>{{trans('modules.source')}}</center>
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="pagination-sect text-center">
        {!! $data->appends(request()->query())->links() !!}
    </div>

    <script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <link href="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/select2/select2.min.js') }}"></script>
    <script type="text/javascript">
        $('#select-account').select2();
        $('#select-delegate').select2();
        $('#select-currency').select2();
        $('#select-action').select2();



        $('#table_dashboard').delegate('.btn-edit', 'click', function() {

            var is_bill = $(this).data('is_bill');
            var value = $(this).data('id');

            var type = $(this).data('type');

            var entryBaseId = $(this).data('entry_base_id');


            var base_url = window.location.origin;
            var source_url = '#';
            if (is_bill == 'yes') {
                if (type == 1) {
                    source_url = base_url + "/modules/bills_purchase_invoice/detail/" + value;
                }

                if (type == 2) {
                    source_url = base_url + "/modules/bills_sales_invoice/detail/" + value;

                }
                if (type == 3) {
                    source_url = base_url + "/modules/bills_purchase_return_invoice/detail/" + value;

                }
                if (type == 4) {
                    source_url = base_url + "/modules/bills_sales_return_invoice/detail/" + value;

                }
            } else {
                if (type == 1) {
                    source_url = base_url + "/modules/receipt_voucher/detail/" + value;
                }
                if (type == 2) {
                    source_url = base_url + "/modules/payment_voucher/detail/" + value;
                }
                if (type == 3) {
                    source_url = base_url + "/modules/transfer_vouchers/detail/" + value;
                }
                if (type == 4) {
                    source_url = base_url + "/modules/initial_voucher/detail/" + value;
                }

                if (type == 5) {
                    source_url = base_url + "/modules/daily_voucher/detail/" + value;
                }
                if (type == 6) {
                    source_url = base_url + "/modules/exchange_voucher/detail/" + value;
                }

            }


            if (value == 0) {
                source_url = base_url + "/modules/entry_base/detail/" + entryBaseId;

            }

            window.open(source_url + "?link=source", '_blank');
        })

        $(document).ready(function() {
            $('#export').click(function(event) {
                let data = $('form').serializeArray();
                let data_json = JSON.stringify(data);
                window.open("/modules/entries_history/export/" + data_json, '_blank');
                event.preventDefault();
            });


            $('#PrintReport').click(function(event) {
                let data = $('form').serializeArray();
                let data_json = JSON.stringify(data);
                window.open("/modules/entries_history/print/" + data_json, '_blank');
                event.preventDefault();
            });

            $("#search").click(function() {
                $("#search i").removeClass('fa-search');
                $("#search i").addClass('fa-spinner fa-spin');
            });
        });
    </script>
@endsection
