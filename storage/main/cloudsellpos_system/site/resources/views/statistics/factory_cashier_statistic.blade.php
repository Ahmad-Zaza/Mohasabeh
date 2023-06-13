@extends('crudbooster::admin_template')
@section('content')
    @php
        //fix data to show it
        $curr_balances = [];
        foreach ($active_currencies as $curr) {
            $curr_balances['curr_balance_' . $curr->id] = 0;
        }
        
        foreach ($user_balance as $bal) {
            $curr_balances['curr_balance_' . $bal->currency_id] = $bal->curr_balance;
        }
    @endphp
    <div class='row'>
        <div class="col-sm-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-archive"></i>
                    <h3 class="box-title"> {{trans('labels.box_balance')}} {{ $user_name }}</h3>
                </div>
            </div>
        </div>
        @foreach ($active_currencies as $curr)
            @php
                $icon = $curr->icon != null ? $curr->icon : 'fa fa-money';
                $bg_color = $curr->color != null ? 'bg-' . $curr->color : 'bg-red';
                $column_num = count($active_currencies);
                if (count($active_currencies) >= 5) {
                    $column_num = 3;
                }
            @endphp
            <div class="col-md-{{ 12 / $column_num }} col-sm-{{ 12 / $column_num }} col-xs-12">
                <div class="border-box">
                    <div class="small-box {{ $bg_color }}">
                        <div class="inner inner-box">
                            <h3 id="final_SP_balance"> {{ number_format($curr_balances['curr_balance_' . $curr->id], 2) }}
                            </h3>
                            <p> {{ $curr->name_ar }} </p>
                        </div>
                        <div class="icon">
                            <i class=" {{ $icon }}	"></i>
                        </div>
                        <a href="/modules/accounts_report?account_id=<?= $user_account_id ?>&currency_id={{ $curr->id }}"
                            class="small-box-footer">{{trans('labels.show_details')}}<i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

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
