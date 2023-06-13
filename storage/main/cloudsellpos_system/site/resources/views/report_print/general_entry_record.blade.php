@extends('crudbooster::admin_template')
@section('content')
    <style>
        #table_dashboard thead th {
            text-align: right;
            color: ;
        }
    </style>
    <div class="box">
        <div class="box-header">
            <div class="pull-left print_display_none">
                <button class="btn btn-success btn-xs" onclick="window.print();"> {{trans('labels.print')}} <i class="fa fa-print"></i></button>
                <button class="btn btn-primary btn-xs" onclick='window.close();'> {{trans('labels.close')}} <i class="fa fa-close"></i></button>
            </div>
        </div>
        <table id="table_dashboard" class="table table-hover table-striped table-bordered report-table">
            <caption> <b>
                    <center> {{trans('labels.daily_book_details')}}</center>
                </b></caption>
            <thead>
                <tr class="active">
                    <th width="auto"> {{trans('modules.entry')}} </th>
                    <th width="auto">{{trans('modules.name')}} </th>
                    <th width="auto"> {{trans('modules.debit')}} </th>
                    <th width="auto"> {{trans('modules.credit')}} </th>
                    <th width="auto"> {{trans('modules.date')}} </th>
                    <th width="auto"> {{trans('modules.staff')}} </th>
                    <th width="auto"> {{trans('modules.narration')}} </th>
                    <th width="auto"> {{trans('modules.currency')}} </th>
                    <th width="auto"> {{trans('modules.entry_status')}} </th>
                </tr>
            </thead>
            <tbody class="ui-sortable">
                @if (count($data) > 0)
                    @foreach ($data as $item)
                        <tr data-id="{{ $item->record_id }}">
                            <td>{{ $item->entryBaseId }}</td>

                            <td>
                                {{ $item->name }}
                            </td>

                            <td>
                                {{ $item->received_amount ? number_format($item->received_amount, 2) : 0 }}

                            </td>
                            <td>
                                {{ $item->paid_amount ? number_format($item->paid_amount, 2) : 0 }}
                            </td>

                            <td class="table-date">
                                {{ $item->date }}
                            </td>
                            <td>
                                {{ $item->employee_name }}
                            </td>
                            <td>
                                {{ $item->narration }}
                            </td>
                            <td>
                                {{ $item->currency }}
                            </td>
                            <td>
                                {{ ($item->entry_status)?trans('labels.active_entry'):trans('labels.inactive_entry') }}
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8">
                            <center>
                                {{trans('labels.no_result')}}
                            </center>
                        </td>
                    </tr>
                @endif

            </tbody>
        </table>
    </div>
    <script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <script>
        $('body').addClass('sidebar-collapse');
        $(document).ready(function() {
            window.print();
        });
    </script>
@endsection
