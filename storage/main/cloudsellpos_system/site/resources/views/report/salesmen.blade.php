@extends('crudbooster::admin_template')
@section('content')

    <div class="box">
        <div class="box-header">
            <form method="get" action="{{ url('modules/salesmen_report') }}" class="print_display_none">
                <div class="col-lg-12">
                    <div class="col-lg-4" id="report-filter-delegate">
                        {{trans('modules.delegate')}} :
                        <select class="form-control" name="delegate_id" id="delegate_id">
                            <option value="-1">{{trans('labels.choose_delegate')}}</option>
                            @foreach ($delegates as $item)
                                <option value="{{ $item->id }}" {{ $delegate_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!--div class="col-lg-3" id="report-filter-account">
                    الزبون:
                        <select class="form-control" name="account_id" id="account_id">
                            <option value="-1">اختر الزبون</option>
                            @foreach ($customers as $item)
                            <option value="{{ $item->account_id }}" {{ $account_id == $item->account_id ? 'selected' : '' }}>{{ $item->name_ar }}</option>
                            @endforeach
                        </select>
                    </div-->



                    <div class="col-lg-4" id="report-filter-from_date">

                        {{ trans('crudbooster.From') }} : {{ $from_date }}<input type="date" name="from_date"
                            id="from_date" value="{{ $from_date }}" class="form-control">
                    </div>


                    <div class="col-lg-4" id="report-filter-to_date">
                        {{ trans('crudbooster.To') }} : {{ $to_date }} <input type="date" name="to_date"
                            id="to_date" class="form-control" value="{{ $to_date }}">
                    </div>
                    <!--div class="col-lg-3" id="report-filter-currency">
                    {{trans('modules.currency')}} :
                        <select class="form-control" name="currency_id" id="select_currency">
                            <option value="-1"> جميع العملات</option>
                            @foreach ($currencies as $item)
                            <option value="{{ $item->id }}" {{ $currency_id == $item->id ? 'selected' : '' }}>{{ $item->name_ar }}</option>
                            @endforeach
                        </select>
                    </div-->
                    <div class="col-lg-4" style="margin-top:20px;">
                        <button type="submit" class="btn btn-primary btn-xs" id="search">
                            {{ trans('crudbooster.Search') }} <i class="fa fa-search"></i></button>
                        <a name='reset' class="btn btn-warning btn-xs" href="{{ url('/modules/salesmen_report') }}"
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

        @if ($delegate_id == null || $delegate_id == -1)
            <div class="col-sm-12">
                <div class="col-sm-12">
                    <div class="callout callout-info" style="margin-top:50px;">
                        رجاءا اختر مندوب لعرض تفصيل التقرير
                    </div>
                </div>
            </div>
        @else
            <!---- start Report ------>

            <table id="table_dashboard" class="table table-hover table-striped table-bordered report-table">
                <caption> <b>
                        <center> {{trans('labels.delegate_report')}} <br /> {{ $delegate_name }}</center>
                    </b></caption>
                <thead>
                    <tr class="active">
                        <th width="auto">
                            <center> {{trans('modules.operation_name')}} </center>
                        </th>
                        <th width="auto">
                            <center> {{trans('modules.document_number')}} </center>
                        </th>
                        <th width="auto">
                            <center> {{trans('modules.narration')}} </center>
                        </th>
                        <th width="auto">
                            <center> {{trans('modules.date')}} </center>
                        </th>
                        <th width="auto">
                            <center> {{trans('modules.client')}} </center>
                        </th>
                        <th width="auto">
                            <center> {{trans('modules.currency')}} </center>
                        </th>
                        <th width="auto">
                            <center> {{trans('modules.paid_type')}} </center>
                        </th>
                        <th width="auto">
                            <center> {{trans('modules.staff')}} </center>
                        </th>
                        <th width="auto" class="print_display_none">
                            <center> {{trans('modules.source')}} </center>
                        </th>
                    </tr>
                </thead>
                <tbody class="ui-sortable" align="center">
                    @if ($data != null)
                        @foreach ($data as $item)
                            <tr id="{{ $item->id }}" data-id="{{ $item->id }}" data-type="{{ $item->type_id }}">
                                <td>
                                    {{ $item->type_name }}
                                </td>
                                <td>
                                    {{ $item->number }}
                                </td>
                                <td>
                                    {{ $item->narration }}
                                </td>

                                <td>
                                    {{ $item->date }}
                                </td>

                                <td>
                                    {{ $item->customer_name }}
                                </td>

                                <td>
                                    {{ $item->currency_name }}
                                </td>
                                <td>
                                    {{ $item->is_cash }}
                                </td>
                                <td>
                                    {{ $item->staff_name }}
                                </td>

                                <td class="print_display_none">
                                    <button type="button" class="btn btn-primary btn-xs btn-edit print_display_none"
                                        id="edit" data-id="{{ $item->id }}" data-type="{{ $item->type_id }}"
                                        data-is_bill="{{ $item->is_bill }}"> {{trans('modules.source')}}</button>
                                </td>

                            </tr>
                        @endforeach
                    @endif


                </tbody>
                <tfoot>

                    @if ($data->count() == 0)    
                        <tr>
                            <td colspan="9">
                                <center>
                                    {{trans('labels.no_result')}}
                                </center>
                            </td>
                        </tr>
                    @else 
                        <tr class="active">
                            <th width="auto">
                                <center> {{trans('modules.operation_name')}} </center>
                            </th>
                            <th width="auto">
                                <center> {{trans('modules.document_number')}} </center>
                            </th>
                            <th width="auto">
                                <center> {{trans('modules.narration')}} </center>
                            </th>
                            <th width="auto">
                                <center> {{trans('modules.date')}} </center>
                            </th>
                            <th width="auto">
                                <center> {{trans('modules.client')}} </center>
                            </th>
                            <th width="auto">
                                <center> {{trans('modules.currency')}} </center>
                            </th>
                            <th width="auto">
                                <center> {{trans('modules.paid_type')}} </center>
                            </th>
                            <th width="auto">
                                <center> {{trans('modules.staff')}} </center>
                            </th>
                            <th width="auto" class="print_display_none">
                                <center> {{trans('modules.source')}} </center>
                            </th>
                        </tr>
                       
                    @endif

                </tfoot>


            </table>
            <div class="pagination-sect text-center">
                {!! $data->appends(request()->query())->links() !!}
            </div>
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-archive"></i>
                    <h3 class="box-title">القيود المعدلة</h3>
                </div>

                <div class="box-body">
                    <p class="text-muted">لمشاهدة القيود المعدلة والمحذوفة المتعلقة بالمندوب المختار .
                        <a href='{{ url(config('crudbooster.ADMIN_PATH') . "/entries_history_report?delegate_id=$delegate_id") }}'
                            target="_blank" class="btn btn-success btn-xs">أنقر هنا</a>
                    </p>
                </div>

            </div>
    </div>
    <!---- end Report ------>
    @endif
    <script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <link href="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/select2/select2.min.js') }}"></script>
    <script type="text/javascript">
        $('#delegate_id').select2();
        $('#account_id').select2();
        $('#select_currency').select2();



        $('#table_dashboard').delegate('.btn-edit', 'click', function() {
            var is_bill = $(this).data('is_bill');
            var value = $(this).data('id');
            var type = $(this).data('type');

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

            window.open(source_url + "?link=source", '_blank');

        });


        $(document).ready(function() {
            $('#export').click(function(event) {
                let data = $('form').serializeArray();
                let data_json = JSON.stringify(data);
                window.open("/modules/salesmen/export/" + data_json, '_blank');
                event.preventDefault();
            });

            $('#PrintReport').click(function(event) {
                let data = $('form').serializeArray();
                let data_json = JSON.stringify(data);
                window.open("/modules/salesmen/print/" + data_json, '_blank');
                event.preventDefault();
            });

            $("#search").click(function() {
                $("#search i").removeClass('fa-search');
                $("#search i").addClass('fa-spinner fa-spin');
            });
        });
    </script>
@stop
