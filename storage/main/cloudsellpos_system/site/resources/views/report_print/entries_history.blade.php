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

                            <td>
                                {{ $item->received_amount ? number_format($item->received_amount, 2) : 0 }}

                            </td>
                            <td>
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

                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9">
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
