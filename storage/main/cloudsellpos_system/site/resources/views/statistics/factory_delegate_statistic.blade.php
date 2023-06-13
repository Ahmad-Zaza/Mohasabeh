@extends('crudbooster::admin_template')
@section('content')

    @include('statistics.components.notifications_alert')

    <div class='row'>
        <div class="col-sm-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-users"></i>
                    <h3 class="box-title"> {{trans('labels.customers_balances')}}</h3>
                </div>
            </div>
        </div>
        <!----- start Table ------>
        <div class="col-sm-12">
            <div id="form-table" class="dataTables_wrapper form-inline dt-bootstrap">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="tableFixHead">
                            <table id="table_dashboard" class="table table-bordered table-striped dataTable text-center"
                                role="grid" aria-describedby="example1_info">
                                <thead style="background:#ddd;">
                                    <tr role="row">
                                        <th style="text-align:right;background:#ddd;"> {{trans('labels.account_name')}}</th>
                                        @foreach ($active_currencies as $curr)
                                            <th style="text-align:center;background:#ddd;"> {{trans('modules.balance')}} {{ $curr->name_ar }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($customers_balances != null)
                                        @foreach ($customers_balances as $item)
                                            <tr>
                                                <td style="text-align:right; padding-right:30px;">
                                                    {{ $item['account_name'] }}</td>
                                                @foreach ($active_currencies as $curr)
                                                    <td>{{ number_format($item['curr_balance_' . $curr->id], 2) }}</td>
                                                @endforeach

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr id="trTotal">
                                            <td colspan='{{ count($active_currencies) + 1 }}'> {{trans('labels.no_result')}}</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td style="text-align:right; padding-right:30px;" bgcolor="#00ff7f"> {{trans('labels.total_balance')}}
                                        </td>
                                        @php $customers_balances_collect = collect($customers_balances); @endphp
                                        @foreach ($active_currencies as $curr)
                                            <td bgcolor="#7fff00">
                                                {{ number_format($customers_balances_collect->sum('curr_balance_' . $curr->id), 2) }}
                                            </td>
                                        @endforeach
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!----- End table -------->

    </div>
    <script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <script type="text/javascript"></script>
@endsection
