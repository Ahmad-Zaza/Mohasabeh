@extends('crudbooster::admin_template')
@section('content')
    <p><a title="Return" href="{{url(CRUDBooster::adminPath('financial_cycles'))}}" id="go-back"><i class="fa fa-chevron-circle-left "></i>
       &nbsp;  {{trans('labels.go_back_financial_cycles_list')}}</a></p>
    <div class="row">
        <div class="col-md-12">
        <div class="box box-solid box-success">
        <div class="box-header">
            <i class="fa fa-pie-chart"></i>
            <h3 class="box-title"> {{trans('labels.cycle_result')}}</h3>
        </div>

        <div class="box-body">
            <table class='table table-bordered table-striped dataTable'>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{trans('modules.debit')}}</th>
                        <th>{{trans('modules.credit')}}</th>
                        <th>{{trans('labels.result')}}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{trans('labels.sales')}}</td>
                        <td></td>
                        <td>{{ number_format($cycle_result->sales, 2) }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>{{trans('labels.sales_return')}}</td>
                        <td>{{ number_format($cycle_result->sales_return, 2) }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>{{trans('labels.granted_discount')}}</td>
                        <td>{{ number_format($cycle_result->granted_discount, 2) }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>{{trans('labels.purchases')}}</td>
                        <td>{{ number_format($cycle_result->purchases, 2) }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>{{trans('labels.purchases_return')}}</td>
                        <td></td>
                        <td>{{ number_format($cycle_result->purchases_return, 2) }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>{{trans('labels.earned_discount')}}</td>
                        <td></td>
                        <td>{{ number_format($cycle_result->earned_discount, 2) }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>{{trans('labels.begin_inventories_items_value')}}</td>
                        <td>{{ number_format($cycle_result->begin_inventories_items_value, 2) }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>{{trans('labels.last_inventories_items_value')}}</td>
                        <td></td>
                        <td>{{ number_format($cycle_result->last_inventories_items_value, 2) }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td bgcolor="#00ff7f">{{trans('labels.gross_profit')}}</td>
                        <td bgcolor="#7fff00">{{ number_format($cycle_result->gross_profit_debit, 2) }}</td>
                        <td bgcolor="#7fff00">{{ number_format($cycle_result->gross_profit_credit, 2) }}</td>
                        <td bgcolor="#00ff7f">{{ number_format($cycle_result->gross_profit, 2) }}</td>
                    </tr>
                    <tr>
                        <td>{{trans('labels.all_incomes')}}</td>
                        <td></td>
                        <td>{{ number_format($cycle_result->incomes, 2) }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>{{trans('labels.all_outgoings')}}</td>
                        <td>{{ number_format($cycle_result->outgoings, 2) }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td bgcolor="#00ff7f">{{trans('labels.net_profit')}}</td>
                        <td bgcolor="#7fff00">{{ number_format($cycle_result->net_profit_debit, 2) }}</td>
                        <td bgcolor="#7fff00">{{ number_format($cycle_result->net_profit_credit, 2) }}</td>
                        <td bgcolor="#00ff7f">{{ number_format($cycle_result->net_profit, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
        </div>
    </div>
@endsection
