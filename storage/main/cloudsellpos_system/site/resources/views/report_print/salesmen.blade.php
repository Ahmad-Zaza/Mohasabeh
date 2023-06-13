@extends('crudbooster::admin_template')
@section('content')

    <div class="box">
        <div class="box-header">
            <div class="pull-left print_display_none">
                <button class="btn btn-success btn-xs" onclick="window.print();"> {{trans('labels.print')}} <i class="fa fa-print"></i></button>
                <button class="btn btn-primary btn-xs" onclick='window.close();'> {{trans('labels.close')}} <i class="fa fa-close"></i></button>
            </div>
        </div>

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


                        </tr>
                    @endforeach
                @endif


            </tbody>
            <tfoot>

                @if ($data->count() == 0)
                    <tr>
                        <td colspan="8">
                            <center>
                                {{trans('labels.no_result')}}
                            </center>
                        </td>
                    </tr>
                @endif

            </tfoot>


        </table>

    </div>
    <!---- end Report ------>
    <script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <script>
        $('body').addClass('sidebar-collapse');
        $(document).ready(function() {
            window.print();
        });
    </script>
@stop
