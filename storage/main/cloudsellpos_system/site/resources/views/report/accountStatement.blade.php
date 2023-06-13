@extends('crudbooster::admin_template')
@section('content')

    <div class="box">
        <div class="box-header">

            <form method="get" action="{{ url('modules/account_statement_report') }}" class="print_display_none">
                <div class="col-lg-12">
                    <div class="col-lg-4" id="report-filter-person">
                        {{trans('modules.account')}} :
                        <select class="form-control" name="person_id" id="select_customer">
                            <option value="-1">{{trans('labels.choose_account')}}</option>
                            @foreach ($persons as $item)
                                <option value="{{ $item->id }}" {{ $person_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-4" id="report-filter-currency">
                        {{trans('modules.currency')}}:
                        <select class="form-control" name="currency_id" id="select_currency">
                            @if ($_REQUEST['currency_id'] == '-2')
                                <option value="-2"> {{trans('labels.no_currencies')}}</option>
                            @else
                                <option value="-1"> {{trans('labels.all_currencies')}}</option>
                            @endif
                            @foreach ($active_currencies as $curr)
                                <option value="{{ $curr->id }}" {{ $currency_id == $curr->id ? 'selected' : '' }}>
                                    {{ $curr->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-4" id="report-filter-from_date">{{ trans('crudbooster.From') }} : {{ $from_date }}

                        <input type="date" name="from_date" id="from_date" class="form-control"
                            value="{{ $from_date }}">
                    </div>

                    <div class="col-lg-4" id="report-filter-to_date">{{ trans('crudbooster.To') }} : {{ $to_date }}

                        <input type="date" name="to_date" id="to_date" class="form-control"
                            value="{{ $to_date }}">
                    </div>


                    <div class="col-lg-4">
                        <br>
                        <button type="submit" class="btn btn-primary btn-xs" id="search">
                            {{ trans('crudbooster.Search') }} <i class="fa fa-search"></i></button>
                        <a name='reset' class="btn btn-warning btn-xs" href="{{ url('/modules/account_statement_report') }}"
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
        @if ($person_id == null || $person_id == -1)
            <div class="col-sm-12">
                <div class="col-sm-12">
                    <div class="callout callout-info" style="margin-top:50px;">
                        {{trans('labels.please_choose_account_to_show_report')}}
                    </div>
                </div>
            </div>
        @else
            @if ($_REQUEST['currency_id'] != '-1' && $_REQUEST['currency_id'] != '-2')

                <table id="table_dashboard" class="table table-hover table-striped table-bordered report-table">
                    <caption> <b>
                            <center> {{trans('labels.account_details')}} <br /> {{ $person_name }}</center>
                        </b></caption>
                    <thead>
                        <tr class="active">
                            <th width="auto">
                                <center> {{trans('modules.date')}}</center>
                            </th>
                            <th width="auto">
                                <center> {{trans('modules.narration')}}</center>
                            </th>
                            <th width="auto">
                                <center> {{trans('modules.debit')}}</center>
                            </th>
                            <th width="auto">
                                <center> {{trans('modules.credit')}}</center>
                            </th>
                            <th width="auto">
                                <center> {{trans('modules.currency')}}</center>
                            </th>
                            <th width="auto">
                                <center> {{trans('modules.the_balance')}} </center>
                            </th>
                            <th width="auto">
                                <center>{{trans('modules.source')}}</center>
                            </th>
                            <th width="20px" class="print_display_none">
                                <center> <button class="btn btn-xs btn-warning" id="show-all" data-action="show"><i
                                            class='fa fa-plus'></i></button> </center>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="ui-sortable" align="center">
                        @if ($data != null)
                            @php
                                $index = 0;
                            @endphp

                            @foreach ($data as $item)
                                @php
                                    $index = $index + 1;
                                @endphp
                                <tr data-id='{{ $item->record_id }}' data-index="{{ $index }}">
                                    <td>
                                        {{ $item->entryDate }}
                                    </td>
                                    <td>
                                        {{ $item->entryNarration }} / {{ $item->type_name }} / {{ $item->code }}
                                    </td>
                                    <td title="{{trans('modules.debit')}}">
                                        {{ $item->debit ? number_format($item->debit, 2) : 0 }}
                                    </td>
                                    <td title="{{trans('modules.credit')}}">
                                        {{ $item->credit ? number_format($item->credit, 2) : 0 }}
                                    </td>
                                    <td>
                                        {{ $item->currency_nameAr }}
                                    </td>
                                    <td>
                                        {{ number_format($item->sum_balance['curr_balance_' . $currency_id], 2) }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-xs btn-edit print_display_none"
                                            id="edit" data-entry_base_id="{{ $item->entryBaseId }}"
                                            data-is_bill="{{ $item->is_bill }}" data-id="{{ $item->temp_id }}"
                                            data-type="{{ $item->temp_type }}"> {{trans('modules.source')}}</button>
                                    </td>
                                    <td class="print_display_none">
                                        @if ($item->is_bill == 'yes')
                                            <button type="button"
                                                class="btn btn-xs btn-primary btn-md btn-bill-details  print_display_none"
                                                id="show" data-action="show"
                                                data-entry_base_id="{{ $item->entryBaseId }}"
                                                data-is_bill="{{ $item->is_bill }}" data-id="{{ $item->temp_id }}"
                                                data-type="{{ $item->temp_type }}" data-colspan="8"> <i
                                                    class="fa fa-plus"></i> </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            @if (count($data) >= config('setting.PAGINATIOM_LIMITATION'))
                                <tr class="loadmore-tr">
                                    <td colspan="8">
                                        <center>
                                            <a id="loadmore-btn" data-offset="0"
                                                data-limit="{{ config('setting.PAGINATIOM_LIMITATION') }}"
                                                data-sumbalance="{{ json_encode($sum_balance) }}"
                                                data-currency_id={{ $currency_id }}
                                                data-curr-index="{{ $index }}" href="javascript:void(0)">مشاهدة
                                                المزيد <i class="fa fa-angle-double-down"></i></a>
                                        </center>
                                    </td>
                                </tr>
                            @endif
                    </tbody>
                    <tfoot>
                        @if (count($data) > 0)
                            <tr class="active">
                                <th width="auto">
                                    <center> {{trans('modules.date')}}</center>
                                </th>
                                <th width="auto">
                                    <center> {{trans('modules.narration')}}</center>
                                </th>
                                <th width="auto">
                                    <center> {{trans('modules.debit')}}</center>
                                </th>
                                <th width="auto">
                                    <center> {{trans('modules.credit')}}</center>
                                </th>
                                <th width="auto">
                                    <center> {{trans('modules.currency')}}</center>
                                </th>
                                <th width="auto">
                                    <center> {{trans('modules.the_balance')}} </center>
                                </th>
                                <th width="auto">
                                    <center>{{trans('modules.source')}}</center>
                                </th>
                                <th width="20px" class="print_display_none">
                                    
                                </th>
                            </tr>
                            
                            <tr id="trTotal">
                                <td colspan="5" bgcolor="#00ff7f">
                                    {{trans('labels.total_balance')}}
                                </td>

                                <td id="total" bgcolor="#7fff00">
                                    <span class="badge btn-primary" style="padding:10px;" id="totalval"
                                        title="{{trans('labels.debit_to_commpany')}}">{{ number_format($final_balance['curr_balance_' . $currency_id], 2) }}</span>
                                </td>
                                <td class="print_display_none" colspan="2" bgcolor="#00ff7f"></td>
                            </tr>
                        @else
                            <tr id="trTotal">
                                <td colspan='8' style="text-align:center;"> {{trans('labels.no_entries_for_this_account')}}</td>
                            </tr>
                        @endif
            @endif
            </tfoot>
            </table>
        @elseif($_REQUEST['currency_id'] == '-1')
            <!---- عند اختيار جميع العملات --->
            <table id="table_dashboard" class="table table-hover table-striped table-bordered report-table">
                <caption> <b>
                        <center> {{trans('labels.account_details')}} <br /> {{ $person_name }}</center>
                    </b></caption>
                <thead>
                    <tr class="active">
                        <th width="auto">
                            <center> {{trans('modules.date')}}</center>
                        </th>
                        <th width="auto">
                            <center> {{trans('modules.narration')}}</center>
                        </th>
                        <th width="auto">
                            <center> {{trans('modules.debit')}}</center>
                        </th>
                        <th width="auto">
                            <center> {{trans('modules.credit')}}</center>
                        </th>
                        <th width="auto">
                            <center> {{trans('modules.currency')}}</center>
                        </th>
                        @foreach ($active_currencies as $curr)
                            <th width="auto">
                                <center> {{trans('modules.balance')}} ({{ $curr->name_ar }})</center>
                            </th>
                        @endforeach
                        <th width="auto" class="print_display_none">
                            <center>{{trans('modules.source')}}</center>
                        </th>
                        <th width="20px" class="print_display_none">
                            <center> <button class="btn btn-xs btn-warning" id="show-all" data-action="show"><i
                                        class='fa fa-plus'></i></button> </center>
                        </th>
                    </tr>
                </thead>
                <tbody class="ui-sortable" align="center">
                    @if ($data != null)
                        @php
                            $index = 0;
                        @endphp

                        @foreach ($data as $item)
                            @php
                                $index = $index + 1;
                            @endphp
                            <tr data-id='{{ $item->record_id }}' data-index="{{ $index }}"
                                data-currency="{{ $item->currency_id }}">

                                <td>
                                    {{ $item->entryDate }}
                                </td>
                                <td>
                                    {{ $item->entryNarration }} / {{ $item->type_name }} / {{ $item->code }}
                                </td>
                                <td title="{{trans('modules.debit')}}">
                                    {{ $item->debit ? number_format($item->debit, 2) : 0 }}
                                </td>
                                <td title="{{trans('modules.credit')}}">
                                    {{ $item->credit ? number_format($item->credit, 2) : 0 }}
                                </td>
                                <td>
                                    {{ $item->currency_nameAr }}
                                </td>
                                @foreach ($active_currencies as $curr)
                                    <td>{{ number_format($item->sum_balance['curr_balance_' . $curr->id], 2) }}</td>
                                @endforeach
                                <td class="print_display_none">
                                    <button type="button" class="btn btn-primary btn-xs btn-edit print_display_none"
                                        id="edit" data-entry_base_id="{{ $item->entryBaseId }}"
                                        data-is_bill="{{ $item->is_bill }}" data-id="{{ $item->temp_id }}"
                                        data-type="{{ $item->temp_type }}"> {{trans('modules.source')}}</button>
                                </td>

                                <td class="print_display_none">
                                    @php $colspan_num = (7 + count($active_currencies)) @endphp
                                    @if ($item->is_bill == 'yes')
                                        <button type="button"
                                            class="btn btn-xs btn-primary btn-md btn-bill-details  print_display_none"
                                            id="show" data-action="show"
                                            data-entry_base_id="{{ $item->entryBaseId }}"
                                            data-is_bill="{{ $item->is_bill }}" data-id="{{ $item->temp_id }}"
                                            data-type="{{ $item->temp_type }}" data-colspan="{{ $colspan_num }}"> <i
                                                class="fa fa-plus"></i> </button>
                                    @endif
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
                                            data-curr-index="{{ $index }}" href="javascript:void(0)">{{trans('labels.show_more')}}
                                            <i class="fa fa-angle-double-down"></i></a>
                                    </center>
                                </td>
                            </tr>
                        @endif
                </tbody>
                <tfoot>
                    @if (count($data) > 0)
                        <tr class="active">
                            <th width="auto">
                                <center> {{trans('modules.date')}}</center>
                            </th>
                            <th width="auto">
                                <center> {{trans('modules.narration')}}</center>
                            </th>
                            <th width="auto">
                                <center> {{trans('modules.debit')}}</center>
                            </th>
                            <th width="auto">
                                <center> {{trans('modules.credit')}}</center>
                            </th>
                            <th width="auto">
                                <center> {{trans('modules.currency')}}</center>
                            </th>
                            @foreach ($active_currencies as $curr)
                                <th width="auto">
                                    <center> {{trans('modules.balance')}} ({{ $curr->name_ar }})</center>
                                </th>
                            @endforeach
                            <th width="auto" class="print_display_none">
                                <center>{{trans('modules.source')}}</center>
                            </th>
                            <th width="20px" class="print_display_none">
                            
                            </th>
                        </tr>
                        
                        <tr id="trTotal">
                            <td colspan="5" bgcolor="#00ff7f">
                                {{trans('labels.total_balance')}}
                            </td>
                            @foreach ($active_currencies as $curr)
                                <td bgcolor="#7fff00"><span class="badge btn-primary"
                                        style="padding:10px;">{{ number_format($final_balance['curr_balance_' . $curr->id], 2) }}
                                </td></span>
                            @endforeach
                            <td class="print_display_none" bgcolor="#00ff7f"></td>
                            <td class="print_display_none" bgcolor="#00ff7f"></td>
                        </tr>
                    @else
                        <tr id="trTotal">
                            <td colspan='{{ 7 + count($active_currencies) }}' style="text-align:center;">
                            {{trans('labels.no_entries_for_this_account')}}
                            </td>
                        </tr>
                    @endif
        @endif
        </tfoot>
        </table>
    @else
        <div> {{trans('labels.no_entries_for_this_account')}} </div>
        @endif

        @endif
    </div>
    <script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <link href="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/select2/select2.min.js') }}"></script>
    <script type="text/javascript">
        $('#select_customer').select2();
        $('#select_currency').select2();


        // $('#val').val(sumVal);
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

        $('#table_dashboard').delegate('.btn-bill-details', 'click', function() {
            var is_bill = $(this).data('is_bill');
            var value = $(this).data('id');
            var type = $(this).data('type');
            var entryBaseId = $(this).data('entry_base_id');
            var action = $(this).data('action');
            var colspan = $(this).data('colspan');


            var curr_row = $(this).parent().parent();
            var index = curr_row.data('index');

            if (action == 'show') {

                $(this).find('i').addClass('fa-spin');
                $.get('/bill-items/' + value, function(res) {
                    console.log($(this));
                    var elem = curr_row.find('.btn-bill-details');
                    elem.find('i').removeClass('fa-plus fa-spin');
                    elem.find('i').addClass('fa-minus');
                    elem.data('action', 'hidden');
                    var new_elem = $("<tr class='details-" + index + "'><td colspan='" + colspan +
                        "' style='padding:0px'> " + res + " </td></tr>");
                    new_elem.insertAfter(curr_row.closest('tr'));
                });
            } else {
                $(this).find('i').removeClass('fa-minus');
                $(this).find('i').addClass('fa-plus');
                $(this).data('action', 'show');
                $('tr.details-' + index).remove();
            }
        });

        $('#show-all').click(function() {
            var action = $(this).data('action');
            if (action == 'show') {
                $(this).find('i').removeClass('fa-plus');
                $(this).find('i').addClass('fa-minus');
                $(this).data('action', 'hidden');
            } else {
                $(this).find('i').removeClass('fa-minus');
                $(this).find('i').addClass('fa-plus');
                $(this).data('action', 'show');
            }

            $(".btn-bill-details").each(function(index) {
                hisaction = $(this).data('action');
                if (hisaction == action) {
                    $(this).click();
                }
            });

        });

        $(document).ready(function() {
            $('#export').click(function(event) {
                let data = $('form').serializeArray();
                let data_json = JSON.stringify(data);
                window.open("/modules/account_statement/export/" + data_json, '_blank');
                event.preventDefault();
            });

            $('#PrintReport').click(function(event) {
                let data = $('form').serializeArray();
                let data_json = JSON.stringify(data);
                window.open("/modules/account_statement/print/" + data_json, '_blank');
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
                let index = $(this).data('curr-index');
                console.log(sumbalance);
                $('#loadmore-btn i').removeClass('fa-angle-double-down');
                $('#loadmore-btn i').addClass('fa-spinner fa-spin');
                $.get('/modules/account_statement/loadmore/offset' + new_offset + '/limit' + limit +
                    '/sumbalance' + sumbalance_data + '/' + data_json,
                    function(res) {
                        console.log(res);
                        res.forEach(element => {
                            const target = document.querySelector('.loadmore-tr');

                            let sum_balance_tds = "";
                            let obj = element.sum_balance_fix_format;

                            let colspan_num = 0;
                            //display just one currency
                            if (currency_id && currency_id > 0) {
                                sum_balance_tds = `<td>${obj['curr_balance_'+currency_id]}</td>`
                                colspan_num = 8;
                            } else { //dispaly all currency
                                Object.keys(obj).forEach(e =>
                                    sum_balance_tds += `<td>${obj[e]}</td>`
                                );
                                colspan_num = (7 + Object.keys(obj).length);
                            }

                            index = index + 1;
                            let show_bill_btn = "";
                            if (element.is_bill == 'yes') {
                                show_bill_btn =
                                    `<button type='button'  class='btn btn-xs btn-primary btn-md btn-bill-details  print_display_none' id='show' data-action='show' data-entry_base_id='${element.entryBaseId}' data-is_bill='${element.is_bill}' data-id='${element.temp_id}' data-type='${element.temp_type}' data-colspan='${colspan_num}'> <i class="fa fa-plus"></i> </button>`;
                            }

                            let html_tr = `
                                        <tr data-id='${element.record_id}' data-index='${index}' data-currency='${element.currency_id}'>
                                            <td>${element.entryDate}</td>
                                            <td>${element.entryNarration} / ${element.type_name} / ${element.code}</td>
                                            <td title="{{trans('modules.debit')}}">${element.debit}</td>
                                            <td title="{{trans('modules.credit')}}">${element.credit}</td>
                                            <td>${element.currency_nameAr}</td>
                                            ${sum_balance_tds}
                                            <td class='print_display_none'>
                                                <button type='button' class='btn btn-primary btn-xs btn-edit print_display_none' id='edit' data-entry_base_id='${element.entryBaseId}' data-is_bill='${element.is_bill}' data-id='${element.temp_id}' data-type='${element.temp_type}'> {{trans('modules.source')}}</button>
                                            </td>
                                            <td class='print_display_none'>                                                
                                                ${show_bill_btn}
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
                        $('#loadmore-btn').data('index', index);
                        $('#loadmore-btn').data('sumbalance', res[res.length - 1].sum_balance);
                    });
            });
        });
    </script>
@endsection
