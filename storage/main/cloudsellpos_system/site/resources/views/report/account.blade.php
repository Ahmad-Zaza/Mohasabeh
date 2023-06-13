@extends('crudbooster::admin_template')
@section('content')
    @php
        $column_num = count($active_currencies);
        if (count($active_currencies) >= 5) {
            $column_num = 3;
        }
    @endphp

    <div class="box">
        <div class="box-header">
            <form method="get" action="{{ url('modules/accounts_report') }}" class="print_display_none">
                <div class="col-lg-12" id="report-filter-sec">
                    <div class="col-lg-4" id="report-filter-account">
                        {{trans('modules.account')}} :
                        <select class="form-control" name="account_id" id="select-account">
                            <option value="-1">{{trans('labels.choose_account')}}</option>
                            @foreach ($accounts as $item)
                                <option value="{{ $item->id }}" {{ $account_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if (CRUDBooster::isSuperAdmin())
                        <div class="col-lg-4">
                            {{trans('modules.delegate')}} :
                            <select class="form-control" name="delegate_id" id="select-delegate">
                                <option value="-1">{{trans('labels.choose_delegate')}}</option>
                                @foreach ($delegates as $item)
                                    <option value="{{ $item->id }}" {{ $delegate_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="col-lg-4" id="report-filter-from_date">{{ trans('crudbooster.From') }} : {{ $from_date }}

                        <input type="date" name="from_date" id="from_date" class="form-control"
                            value="{{ $from_date }}">
                    </div>

                    <div class="col-lg-4" id="report-filter-to_date">{{ trans('crudbooster.To') }} : {{ $to_date }}

                        <input type="date" name="to_date" id="to_date" class="form-control"
                            value="{{ $to_date }}">
                    </div>
                    <div class="col-lg-4" id="report-filter-currency">
                        {{trans('modules.currency')}} :
                        <select class="form-control" name="currency_id" id="select-currency">
                            <option value="-1"> {{trans('labels.all_currencies')}}</option>
                            @foreach ($currencies as $item)
                                <option value="{{ $item->id }}" {{ $currency_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-lg-4">
                        <br>
                        <button type="submit" class="btn btn-primary btn-xs" id="search">
                            {{ trans('crudbooster.Search') }} <i class="fa fa-search"></i></button>
                        <a name='reset' class="btn btn-warning btn-xs" href="{{ url('/modules/accounts_report') }}"
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

        <!--div class="print_display_none">
    <br>
    <br>
    <br>
    <br>
    </div-->
        @if ($account_id == null || $account_id == -1)
            <div class="col-sm-12">
                <div class="col-sm-12">
                    <div class="callout callout-info" style="margin-top:50px;">
                    {{trans('labels.please_choose_account_to_show_report')}}
                    </div>
                </div>
            </div>
        @else
            <!---- start Report ------>

            @if ($type_display == 1)
                <!---- start Display type 1 ---->
                <!----  عرض خاص بالحسابات الحقيقية  ---->
                @if ($currency_id != -1)

                    <table id="table_dashboard"
                        class="table table-hover table-striped table-bordered report-table table_dashboard">
                        <caption> <b>
                                <center> {{trans('labels.account_details')}}</center>
                            </b></caption>
                        <thead>
                            <tr class="active">
                                <th width="auto"> {{trans('modules.name')}} </th>
                                <th width="auto"> {{trans('modules.debit')}} </th>
                                <th width="auto"> {{trans('modules.credit')}} </th>
                                <th width="auto"> {{trans('modules.date')}} </th>
                                <th width="auto"> {{trans('modules.narration')}} </th>
                                <th width="auto"> {{trans('modules.currency')}} </th>
                                <th width="auto"> {{trans('modules.the_balance')}} </th>
                                <th width="auto"> {{trans('modules.source')}} </th>
                            </tr>
                        </thead>
                        <tbody class="ui-sortable">
                            @if (count($data) > 0)
                                @foreach ($data as $item)
                                    <tr data-id='{{ $item->record_id }}'>

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
                                            {{ $item->date }}
                                        </td>
                                        <td>
                                            {{ $item->narration }}
                                        </td>
                                        <td>
                                            {{ $item->currency }}
                                        </td>
                                        <td>
                                            {{ number_format($item->sum_balance['curr_balance_' . $currency_id], 2) }}
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-primary btn-xs btn-edit print_display_none" id="edit"
                                                data-entry_base_id="{{ $item->entryBaseId }}"
                                                data-is_bill="{{ $item->is_bill }}" data-id="{{ $item->temp_id }}"
                                                data-type="{{ $item->temp_type }}"> {{trans('modules.source')}}</button>
                                        </td>
                                    </tr>
                                @endforeach
                                @if (count($data) >= config('setting.PAGINATIOM_LIMITATION'))
                                    <tr class="loadmore-tr">
                                        <td colspan="{{ 7 + count($active_currencies) }}">
                                            <center>
                                                <a id="loadmore-btn" data-offset="0"
                                                    data-limit="{{ config('setting.PAGINATIOM_LIMITATION') }}"
                                                    data-sumbalance="{{ json_encode($sum_balance) }}"
                                                    data-currency_id="{{ $currency_id }}" ;
                                                    href="javascript:void(0)">{{trans('labels.show_more')}} <i
                                                        class="fa fa-angle-double-down"></i></a>
                                            </center>
                                        </td>
                                    </tr>
                                @endif
                            @else
                                <tr>
                                    <td colspan="8">
                                        <center>
                                            {{trans('labels.no_entries_for_this_account')}}
                                        </center>
                                    </td>
                                </tr>
                            @endif

                        </tbody>
                        <tfoot>
                            <tr class="active">
                                <th width="auto"> {{trans('modules.name')}} </th>
                                <th width="auto"> {{trans('modules.debit')}} </th>
                                <th width="auto"> {{trans('modules.credit')}} </th>
                                <th width="auto"> {{trans('modules.date')}} </th>
                                <th width="auto"> {{trans('modules.narration')}} </th>
                                <th width="auto"> {{trans('modules.currency')}} </th>
                                <th width="auto"> {{trans('modules.the_balance')}} </th>
                                <th width="auto"> {{trans('modules.source')}} </th>
                            </tr>
                        
                            @if (count($data) > 0)
                                <tr>
                                    <td colspan="6" bgcolor="#00ff7f">{{trans('labels.total_balance')}} </td>
                                    <td bgcolor="#7fff00">
                                        {{ number_format($final_balance['curr_balance_' . $currency_id], 2) }}</td>
                                    <td bgcolor="#00ff7f"></td>
                                </tr>
                            @endif

                        </tfoot>
                    </table>
                @else
                    <table id="table_dashboard"
                        class="table table-hover table-striped table-bordered report-table table_dashboard">
                        <caption> <b>
                                <center> {{trans('labels.account_details')}}</center>
                            </b></caption>
                        <thead>
                            <tr class="active">
                                <th width="auto"> {{trans('modules.name')}} </th>
                                <th width="auto"> {{trans('modules.debit')}} </th>
                                <th width="auto"> {{trans('modules.credit')}} </th>
                                <th width="auto"> {{trans('modules.date')}} </th>
                                <th width="auto"> {{trans('modules.narration')}} </th>
                                <th width="auto"> {{trans('modules.currency')}} </th>
                                @foreach ($active_currencies as $curr)
                                    <th width="auto"> {{trans('modules.the_balance')}} ({{ $curr->name_ar }}) </th>
                                @endforeach
                                <th width="auto"> {{trans('modules.source')}} </th>
                            </tr>
                        </thead>

                        <tbody class="ui-sortable">

                            @if (count($data) > 0)
                                @foreach ($data as $item)
                                    <tr data-id='{{ $item->record_id }}' data-currency="{{ $item->currency_id }}">
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
                                            {{ $item->date }}
                                        </td>
                                        <td>
                                            {{ $item->narration }}
                                        </td>
                                        <td>
                                            {{ $item->currency }}
                                        </td>
                                        @foreach ($active_currencies as $curr)
                                            <td>
                                                {{ number_format($item->sum_balance['curr_balance_' . $curr->id], 2) }}
                                            </td>
                                        @endforeach

                                        <td>
                                            <button type="button"
                                                class="btn btn-primary btn-xs btn-edit print_display_none" id="edit"
                                                data-entry_base_id="{{ $item->entryBaseId }}"
                                                data-is_bill="{{ $item->is_bill }}" data-id="{{ $item->temp_id }}"
                                                data-type="{{ $item->temp_type }}"> {{trans('modules.source')}}</button>
                                        </td>
                                    </tr>
                                @endforeach
                                @if (count($data) >= config('setting.PAGINATIOM_LIMITATION'))
                                    <tr class="loadmore-tr">
                                        <td colspan="{{ 7 + count($active_currencies) }}">
                                            <center>
                                                <a id="loadmore-btn" data-offset="0"
                                                    data-limit="{{ config('setting.PAGINATIOM_LIMITATION') }}"
                                                    data-sumbalance="{{ json_encode($sum_balance) }}"
                                                    href="javascript:void(0)">{{trans('labels.show_more')}} <i
                                                        class="fa fa-angle-double-down"></i></a>
                                            </center>
                                        </td>
                                    </tr>
                                @endif
                            @else
                                <tr>
                                    <td colspan="{{ 7 + count($active_currencies) }}">
                                        <center>
                                            {{trans('labels.no_entries_for_this_account')}}
                                        </center>
                                    </td>
                                </tr>
                            @endif


                        </tbody>
                        <tfoot>
                            <tr class="active">
                                <th width="auto"> {{trans('modules.name')}} </th>
                                <th width="auto"> {{trans('modules.debit')}} </th>
                                <th width="auto"> {{trans('modules.credit')}} </th>
                                <th width="auto"> {{trans('modules.date')}} </th>
                                <th width="auto"> {{trans('modules.narration')}} </th>
                                <th width="auto"> {{trans('modules.currency')}} </th>
                                @foreach ($active_currencies as $curr)
                                    <th width="auto"> {{trans('modules.the_balance')}} ({{ $curr->name_ar }}) </th>
                                @endforeach
                                <th width="auto"> {{trans('modules.source')}} </th>
                            </tr>
                        </tfoot>
                    </table>

                    <div class='row'>

                        @foreach ($active_currencies as $curr)
                            @php
                                $icon = $curr->icon != null ? $curr->icon : 'fa fa-money';
                                $bg_color = $curr->color != null ? 'bg-' . $curr->color : 'bg-red';
                            @endphp

                            <div class="col-md-{{ 12 / $column_num }} col-sm-{{ 12 / $column_num }} col-xs-12 ">
                                <div class="border-box">
                                    <div class="small-box {{ $bg_color }}	">
                                        <div class="inner inner-box">
                                            <h3 id="final_SP_balance">
                                                {{ number_format($final_balance['curr_balance_' . $curr->id], 2) }} </h3>
                                            <p>{{trans('labels.account_balance')}} {{ $curr->name_ar }} </p>
                                        </div>
                                        <div class="icon">
                                            <i class="{{ $icon }}"></i>
                                        </div>
                                        <a href="/modules/accounts_report?account_id=<?= $_REQUEST['account_id'] ?>&delegate_id=<?= $_REQUEST['delegate_id'] ?>&from_date=<?= $_REQUEST['from_date'] ?>&to_date=<?= $_REQUEST['to_date'] ?>&currency_id={{ $curr->id }}"
                                            class="small-box-footer">{{trans('labels.show_details')}}<i
                                                class="fa fa-arrow-circle-right"></i> </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                @endif
                <!---- end Display type 1 ---->
            @else
                <!---- start Display type 2 ---->
                <!---- عرض خاص بالحسابات التجميعية ---->
                <div class="tableFixHead">
                    <table id="table_dashboard"
                        class="table table-hover table-striped table-bordered report-table table_dashboard">
                        <caption> <b>
                                <center> {{trans('labels.account_details')}}</center>
                            </b></caption>
                        <thead>
                            <tr class="active">
                                <th width="auto"> {{trans('labels.account_name')}} </th>
                                @foreach ($active_currencies as $curr)
                                    <th width="auto"> {{trans('modules.the_balance')}} ({{ $curr->name_ar }}) </th>
                                @endforeach

                            </tr>
                        </thead>

                        <tbody class="ui-sortable">
                            @php
                                $final_balance = [];
                                foreach ($active_currencies as $curr) {
                                    $final_balance['curr_balance_' . $curr->id] = 0;
                                }
                            @endphp

                            @foreach ($data as $item)
                                @php
                                    foreach ($active_currencies as $curr) {
                                        $final_balance['curr_balance_' . $curr->id] += $item['curr_balance_' . $curr->id];
                                    }
                                @endphp
                                <tr>
                                    <td>
                                        {{ $item['name'] }}
                                    </td>
                                    @foreach ($active_currencies as $curr)
                                        <td>
                                            {{ number_format($item['curr_balance_' . $curr->id], 2) }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class='row'>

                    @foreach ($active_currencies as $curr)
                        @php
                            $icon = $curr->icon != null ? $curr->icon : 'fa fa-money';
                            $bg_color = $curr->color != null ? 'bg-' . $curr->color : 'bg-red';
                        @endphp
                        <div class="col-md-{{ 12 / $column_num }} col-sm-{{ 12 / $column_num }} col-xs-12 ">
                            <div class="border-box">
                                <div class="small-box {{ $bg_color }}	">
                                    <div class="inner inner-box">
                                        <h3> {{ number_format($final_balance['curr_balance_' . $curr->id], 2) }} </h3>
                                        <p>{{trans('labels.account_balance')}} {{ $curr->name_ar }} </p>
                                    </div>
                                    <div class="icon">
                                        <i class="{{ $icon }}	"></i>
                                    </div>
                                    <a href="javascript:void(0)" class="small-box-footer">{{trans('labels.show_details')}}<i
                                            class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                <!---- end Display type 2  ---->
            @endif


            <!---- end Report ------>
        @endif
    </div> <!-- end box -->

    <script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <link href="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/select2/select2.min.js') }}"></script>
    <script type="text/javascript">
        $('#select-account').select2();
        $('#select-delegate').select2();
        $('#select-currency').select2();

        $('.table_dashboard').delegate('.btn-edit', 'click', function() {

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
                window.open("/modules/account/export/" + data_json, '_blank');
                event.preventDefault();
            });

            $('#PrintReport').click(function(event) {
                let data = $('form').serializeArray();
                let data_json = JSON.stringify(data);
                window.open("/modules/account/print/" + data_json, '_blank');
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

                let sumbalance = $(this).data('sumbalance');
                let sumbalance_data = JSON.stringify(sumbalance);

                let currency_id = $(this).data('currency_id');
                console.log(sumbalance);
                $('#loadmore-btn i').removeClass('fa-angle-double-down');
                $('#loadmore-btn i').addClass('fa-spinner fa-spin');
                $.get('/modules/account/loadmore/offset' + new_offset + '/limit' + limit + '/sumbalance' +
                    sumbalance_data + '/' + data_json,
                    function(res) {
                        console.log(res);
                        res.forEach(element => {
                            const target = document.querySelector('.loadmore-tr');

                            let sum_balance_tds = "";
                            let obj = element.sum_balance_fix_format;
                            //display just one currency
                            if (currency_id && currency_id > 0) {
                                sum_balance_tds = `<td>${obj['curr_balance_'+currency_id]}</td>`
                            } else { //dispaly all currency
                                Object.keys(obj).forEach(e =>
                                    sum_balance_tds += `<td>${obj[e]}</td>`
                                );
                            }
                            //console.log(sum_balance_tds);            

                            let html_tr = `
                                <tr data-id='${element.record_id}' data-currency='${element.currency_id}'>
                                <td>${element.name}</td>
                                <td title="{{trans('modules.debit')}}">${element.received_amount}</td>
                                <td title="{{trans('modules.credit')}}">${element.paid_amount}</td>
                                <td>${element.date}</td>
                                <td>${element.narration}</td>
                                <td>${element.currency}</td>
                                ${sum_balance_tds}
                                <td>
                                    <button type='button' class='btn btn-primary btn-xs btn-edit print_display_none' id='edit' data-entry_base_id='${element.entryBaseId}' data-is_bill='${element.is_bill}' data-id='${element.temp_id}' data-type='${element.temp_type}'> {{trans('modules.source')}}</button>
                                </td>
                                </tr>
                            `;
                            target.insertAdjacentHTML('beforebegin', html_tr);

                        });

                        if (res.length < limit || res.length == 0) {
                            $('.loadmore-tr').hide();
                        }

                        $('#loadmore-btn i').removeClass('fa-spinner fa-spin');
                        $('#loadmore-btn i').addClass('fa-angle-double-down');
                        $('#loadmore-btn').data('offset', new_offset);
                        $('#loadmore-btn').data('sumbalance', res[res.length - 1].sum_balance);
                    });
            });

        });
    </script>
@endsection
