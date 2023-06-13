@extends('crudbooster::admin_template')
@section('content')

    <div class="box">
        <div class="box-header">
            <div class="pull-left print_display_none">
                <button class="btn btn-success btn-xs" onclick="window.print();"> {{trans('labels.print')}} <i class="fa fa-print"></i></button>
                <button class="btn btn-primary btn-xs" onclick='window.close();'> {{trans('labels.close')}} <i class="fa fa-close"></i></button>
            </div>
        </div>


        @if ($currency_id != '-1' && $currency_id != '-2')

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
                                <td>
                                    {{ $item->debit ? number_format($item->debit, 2) : 0 }}
                                </td>
                                <td>
                                    {{ $item->credit ? number_format($item->credit, 2) : 0 }}
                                </td>
                                <td>
                                    {{ $item->currency_nameAr }}
                                </td>
                                <td>
                                    {{ number_format($item->sum_balance['curr_balance_' . $currency_id], 2) }}
                                </td>

                            </tr>
                        @endforeach
                        @if (count($data) > 0)
                            <tr id="trTotal">
                                <td colspan="5" bgcolor="#00ff7f" style="text-align:right;">
                                    {{trans('labels.total_balance')}}
                                </td>

                                <td id="total" bgcolor="#7fff00">
                                    <span class="badge btn-primary" style="padding:10px;" id="totalval"
                                        title="{{trans('labels.debit_to_commpany')}}">{{ number_format($final_balance['curr_balance_' . $currency_id], 2) }}</span>
                                </td>

                            </tr>
                        @else
                            <tr id="trTotal">
                                <td colspan='8' style="text-align:center;"> {{trans('labels.no_entries_for_this_account')}}</td>
                            </tr>
                        @endif
                    @endif
                </tbody>

            </table>
        @elseif($currency_id == '-1')
            <!---- عند اختيار جميع العملات --->
            <table id="table_dashboard" class="table table-hover table-striped table-bordered report-table">
                <caption> <b>
                        <center> {{trans('labels.account_details')}} <br /> {{ $person_name }} </center>
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
                                <td>
                                    {{ $item->debit ? number_format($item->debit, 2) : 0 }}
                                </td>
                                <td>
                                    {{ $item->credit ? number_format($item->credit, 2) : 0 }}
                                </td>
                                <td>
                                    {{ $item->currency_nameAr }}
                                </td>
                                @foreach ($active_currencies as $curr)
                                    <td>{{ number_format($item->sum_balance['curr_balance_' . $curr->id], 2) }}</td>
                                @endforeach

                            </tr>
                        @endforeach
                        @if (count($data) > 0)
                            <tr id="trTotal">
                                <td colspan="5" bgcolor="#00ff7f" style="text-align:right;">
                                    {{trans('labels.total_balance')}}
                                </td>
                                @foreach ($active_currencies as $curr)
                                    <td bgcolor="#7fff00"><span class="badge btn-primary"
                                            style="padding:10px;">{{ number_format($final_balance['curr_balance_' . $curr->id], 2) }}
                                    </td></span>
                                @endforeach
                            </tr>
                        @else
                            <tr id="trTotal">
                                <td colspan='{{ 5 + count($active_currencies) }}' style="text-align:center;"> {{trans('labels.no_entries_for_this_account')}}</td>
                            </tr>
                        @endif
                    @endif
                </tbody>

            </table>
        @else
            <div> {{trans('labels.no_entries_for_this_account')}}</div>
        @endif


    </div>

    <script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <script>
        $('body').addClass('sidebar-collapse');
        $(document).ready(function() {
            window.print();
        });
    </script>
@endsection
