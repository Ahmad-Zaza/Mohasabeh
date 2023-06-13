@extends('crudbooster::admin_template')
@section('content')
    @php
        use App\Http\Controllers\General\GeneralFunctionsController;
        $gfunc = new GeneralFunctionsController();
        $hasPermission = $gfunc->checkOldCycleHasEditedPermission();
    
        $column_num = count($active_currencies);
        if (count($active_currencies) >= 5) {
            $column_num = 3;
        }
    @endphp
    <div class='row'>
        <div class="col-sm-12">
            <div class="col-sm-10">
                <h3> {{trans('labels.dashboard')}} </h3>
                <hr style="border:1px solid white;" />
            </div>
            <div class="col-sm-2">
                @if (CRUDBooster::isSuperAdmin() && $hasPermission)
                    <a class="btn btn-primary" id="btn-settings" style="float:left;"
                        href="{{ url('modules/admin/statistics/setting') }}"> {{trans('labels.configration')}} <i class="fa fa-gear"></i> </a>
                @endif
            </div>
        </div>
    </div>



    <div class='row' id="accounts-sect">
        @if ($show_method == 0)
            <!-- start show method is tables -->
            <!----- start Table ------>
            <div class="col-sm-12">
                <div id="form-table" class="dataTables_wrapper form-inline dt-bootstrap">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="tableFixHead">
                                <table id="tableId" class="table table-bordered table-striped dataTable text-center"
                                    role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr role="row">
                                            <th style="text-align:right"> {{trans('labels.account_name')}}</th>
                                            @foreach ($active_currencies as $curr)
                                                <th style="text-align:center">  {{trans('modules.balance')}}  {{ $curr->name_ar }} </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($accounts_info != null)
                                            @foreach ($accounts_info as $item)
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

                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!----- End table -------->
            <!-- end show method is tables -->
        @else
            <!-- start show method is Boxes -->
            @if ($accounts_info != null)

                @foreach ($accounts_info as $item)

                    @if ($item['account_id'] == $general_box)
                        <div class="col-sm-12">
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <i class="fa fa-archive"></i>
                                    <h3 class="box-title">{{trans('labels.balance_of_main_box')}}</h3>
                                </div>

                            </div>
                        </div>
                        @foreach($active_currencies as $curr)
                        @php
                            $icon = $curr->icon != null ? $curr->icon : 'fa fa-money';
                            $bg_color = $curr->color != null ? 'bg-' . $curr->color : 'bg-red';
                            $bal = 0;
                            $bal = $item['curr_balance_' . $curr->id];
                            $link = '/modules/accounts_report?account_id=' . $item['account_id'] . '&delegate_id=-1&from_date=&to_date=&currency_id=' . $curr->id;
                        @endphp
                        <div class="col-md-{{ 12 / $column_num }} col-sm-{{ 12 / $column_num }} col-xs-12">
                            <div class="border-box">
                                <div class="small-box {{ $bg_color }}	">
                                    <div class="inner inner-box">
                                        <h3 id="final_SP_balance"> {{ number_format($bal, 2) }} </h3>
                                        <p>{{ $curr->name_ar }}</p>
                                    </div>
                                    <div class="icon">
                                        <i class="{{ $icon }}	"></i>
                                    </div>
                                    <a href="{{ $link }}" class="small-box-footer">{{trans('labels.show_details')}}<i
                                            class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                    
                        <div class="col-sm-12">
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <i class="fa fa-text-width"></i>
                                    <h3 class="box-title">{{ $item['account_name'] }}</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="row">
                                        @foreach ($active_currencies as $curr)
                                            @php
                                                $icon = $curr->icon != null ? $curr->icon : 'fa fa-money';
                                                $bg_color = $curr->color != null ? 'bg-' . $curr->color : 'bg-red';
                                            @endphp
                                            <div
                                                class="col-md-{{ 12 / $column_num }} col-sm-{{ 12 / $column_num }} col-xs-12">
                                                <div class="info-box">
                                                    <span class="info-box-icon {{ $bg_color }}"><i
                                                            class="{{ $icon }}"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">{{ $curr->name_ar }}</span>
                                                        <span
                                                            class="info-box-number">{{ number_format($item['curr_balance_' . $curr->id], 2) }}</span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    @endif
                @endforeach
            @endif

            <!-- end show method is Boxes -->
        @endif

    </div>
    <div class="row">  
        <div class="col-sm-12">   
        @include('statistics.components.notifications_alert')
        </div>
    </div>

    <script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    
@endsection
