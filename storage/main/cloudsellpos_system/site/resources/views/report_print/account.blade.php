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
            <div class="pull-left print_display_none">
                <button class="btn btn-success btn-xs" onclick="window.print();"> {{trans('labels.print')}} <i class="fa fa-print"></i></button>
                <button class="btn btn-primary btn-xs" onclick='window.close();'> {{trans('labels.close')}} <i class="fa fa-close"></i></button>
            </div>
        </div>

        <!---- start Report ------>

        @if ($type_display == 1)
            <!---- start Display type 1 ---->
            <!----  عرض خاص بالحسابات الحقيقية  ---->
            @if ($currency_id != -1)

                <table id="table_dashboard"
                    class="table table-hover table-striped table-bordered report-table table_dashboard">
                    <caption> <b>
                            <center> {{trans('labels.account_details')}} </center>
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
                        </tr>
                    </thead>
                    <tbody class="ui-sortable">
                        @if (count($data) > 0)
                            @foreach ($data as $item)
                                <tr data-id='{{ $item->record_id }}'>

                                    <td>
                                        {{ $item->name }}
                                    </td>

                                    <td>
                                        {{ $item->received_amount ? number_format($item->received_amount, 2) : 0 }}

                                    </td>
                                    <td>
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
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7">
                                    <center>
                                        {{trans('labels.no_entries_for_this_account')}}
                                    </center>
                                </td>
                            </tr>
                        @endif

                    </tbody>
                    <tfoot>
                        @if (count($data) > 0)
                            <tr>
                                <td colspan="6" bgcolor="#00ff7f">{{trans('labels.total_balance')}} </td>
                                <td bgcolor="#7fff00">{{ number_format($final_balance['curr_balance_' . $currency_id], 2) }}
                                </td>
                            </tr>
                        @endif

                    </tfoot>
                </table>
            @else
                <table id="table_dashboard"
                    class="table table-hover table-striped table-bordered report-table table_dashboard">
                    <caption> <b>
                            <center> {{trans('labels.account_details')}} </center>
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
                        </tr>
                    </thead>

                    <tbody class="ui-sortable">

                        @if (count($data) > 0)
                            @foreach ($data as $item)
                                <tr data-id='{{ $item->record_id }}' data-currency="{{ $item->currency_id }}">
                                    <td>
                                        {{ $item->name }}
                                    </td>

                                    <td>
                                        {{ $item->received_amount ? number_format($item->received_amount, 2) : 0 }}

                                    </td>

                                    <td>
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

                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="6" bgcolor="#00ff7f"> {{trans('labels.total_balance')}}</td>
                                @foreach ($active_currencies as $curr)
                                    <td bgcolor="#7fff00"> {{ number_format($final_balance['curr_balance_' . $curr->id], 2) }}
                                    </td>
                                @endforeach
                            </tr>
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



                </table>


            @endif
            <!---- end Display type 1 ---->
        @else
            <!---- start Display type 2 ---->
            <!---- عرض خاص بالحسابات التجميعية ---->
            <div class="tableFixHead">
                <table id="table_dashboard"
                    class="table table-hover table-striped table-bordered report-table table_dashboard">
                    <caption> <b>
                            <center> {{trans('labels.account_details')}} </center>
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
                        <tr>
                            <td bgcolor="#00ff7f"> {{trans('labels.total_balance')}}</td>
                            @foreach ($active_currencies as $curr)
                                <td bgcolor="#7fff00"> {{ number_format($final_balance['curr_balance_' . $curr->id], 2) }}
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>


            <!---- end Display type 2  ---->
        @endif


        <!---- end Report ------>

    </div> <!-- end box -->

    <script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <script>
        $('body').addClass('sidebar-collapse');
        $(document).ready(function() {
            window.print();
        });
    </script>
@endsection
