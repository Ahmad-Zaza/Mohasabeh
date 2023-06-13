@extends('crudbooster::admin_template')
@section('content')

    <div class="box">
        <div class="box-header">
            <div class="pull-left print_display_none">
                <button class="btn btn-success btn-xs" onclick="window.print();"> {{trans('labels.print')}} <i class="fa fa-print"></i></button>
                <button class="btn btn-primary btn-xs" onclick='window.close();'> {{trans('labels.close')}} <i class="fa fa-close"></i></button>
            </div>
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
    <script>
        $('body').addClass('sidebar-collapse');
        $(document).ready(function() {
            window.print();
        });
    </script>
@stop
