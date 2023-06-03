@extends('crudbooster::admin_template')

@section('content')

    <div>



        @if (CRUDBooster::getCurrentMethod() != 'getProfile')
            @if (g('return_url'))
                <p><a title='Return' href='{{ g('return_url') }}'><i class='fa fa-chevron-circle-left '></i>

                        &nbsp;

                        {{ trans('crudbooster.form_back_to_list', ['module' => CRUDBooster::getCurrentModule()->name]) }}</a>

                </p>
            @else
                <p><a title='Main Module' href='{{ CRUDBooster::mainpath() }}'><i class='fa fa-chevron-circle-left '></i>

                        &nbsp;

                        {{ trans('crudbooster.form_back_to_list', ['module' => CRUDBooster::getCurrentModule()->name]) }}</a>

                </p>
            @endif
        @endif

    </div>

    <div class="panel panel-default">

        <div class="panel-heading">

            <strong><i class='{{ CRUDBooster::getCurrentModule()->icon }}'></i> {!! 'Customer Renewal Subscription' !!}</strong>

        </div>



        <div class="panel-body" style="padding:20px 0px 0px 0px">

            <?php $action = CRUDBooster::mainpath('saveRenewalSubscription'); ?>

            <form class='form-horizontal was-validated' method='post' id="form" enctype="multipart/form-data"
                action='{{ $action }}'>

                <input type="hidden" name="id" value="{{ $customer->id }}">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <input type='hidden' name='return_url' value='{{ @$return_url }}' />

                <input type='hidden' name='ref_mainpath' value='{{ CRUDBooster::mainpath() }}' />

                <input type='hidden' name='ref_parameter' value='{{ urldecode(http_build_query(@$_GET)) }}' />

                <div class="box-body" id="parent-form-area">

                    @include('crudbooster::default.type_components.date.asset')

                    <div class='form-group form-datepicker' id='form-group-subscription-end-date'
                        style="{{ @$form['style'] }}">

                        <label class='control-label col-sm-2'>Old Subscription Start Date

                        </label>



                        <div class="col-sm-4">

                            <div class="input-group">

                                <span class="input-group-addon open-datetimepicker"><a><i
                                            class='fa fa-calendar '></i></a></span>

                                <input type='text' title="Subscription Start Date" disabled
                                    class='form-control notfocus input_date' name="old-subscription-start-date"
                                    value='{{ $customer->subscription_start_date ?: $customer->free_trial_start_date }}' />

                            </div>

                            <div class="text-danger">{!! $errors->first($name) ? "<i class='fa fa-info-circle'></i> " . $errors->first($name) : '' !!}</div>

                        </div>

                    </div>

                    <div class='form-group form-datepicker' id='form-group-subscription-end-date'
                        style="{{ @$form['style'] }}">

                        <label class='control-label col-sm-2'>Old Subscription End Date

                        </label>



                        <div class="col-sm-4">

                            <div class="input-group">

                                <span class="input-group-addon open-datetimepicker"><a><i
                                            class='fa fa-calendar '></i></a></span>

                                <input type='text' title="Subscription End Date" disabled
                                    class='form-control notfocus input_date' name="old-subscription-end-date"
                                    value='{{ $customer->subscription_end_date ?: $customer->free_trial_end_date }}' />

                            </div>

                            <div class="text-danger">{!! $errors->first($name) ? "<i class='fa fa-info-circle'></i> " . $errors->first($name) : '' !!}</div>

                        </div>

                    </div>



                    <div class='form-group form-datepicker' id='form-group-last-renewal-date'
                        style="{{ @$form['style'] }}">

                        <label class='control-label col-sm-2'>Last Renewal Date

                        </label>

                        <div class="col-sm-4">

                            <div class="input-group">

                                <span class="input-group-addon open-datetimepicker"><a><i
                                            class='fa fa-calendar '></i></a></span>

                                <input type='text' title="Last Renewal Date" disabled
                                    class='form-control notfocus input_date' name="last-renewal-date" id="last-renewal-date"
                                    value='{{ $customer->last_renewal_date }}' />

                            </div>

                            <div class="text-danger">{!! $errors->first($name) ? "<i class='fa fa-info-circle'></i> " . $errors->first($name) : '' !!}</div>

                        </div>

                    </div>

                    <div class='form-group' id='form-group-subscription-type' style="{{ @$form['style'] }}">

                        <label class='control-label col-sm-2'>Subscription Type

                        </label>



                        <div class="col-sm-4">

                            <select name="subscription_type" id="subscription_type" class="form-control">

                                <option value="year">Year</option>

                                <option value="month">Month</option>

                                <option value="six-month">Six Month</option>

                            </select>

                            <div class="text-danger">{!! $errors->first($name) ? "<i class='fa fa-info-circle'></i> " . $errors->first($name) : '' !!}</div>

                        </div>

                    </div>

                    <div class='form-group form-datepicker' id='form-group-subscription-end-date'
                        style="{{ @$form['style'] }}">

                        <label class='control-label col-sm-2'>New Subscription Start Date

                        </label>



                        <div class="col-sm-4">

                            <div class="input-group">

                                <span class="input-group-addon open-datetimepicker"><a><i
                                            class='fa fa-calendar '></i></a></span>

                                <input type='text' title="Subscription Start Date" required
                                    class='form-control notfocus input_date' name="subscription-start-date"
                                    id="subscription-start-date" value='{{ date('Y-m-d') }}' />

                            </div>

                            <div class="text-danger">{!! $errors->first($name) ? "<i class='fa fa-info-circle'></i> " . $errors->first($name) : '' !!}</div>

                        </div>

                    </div>

                    <div class='form-group form-datepicker' id='form-group-subscription-end-date'
                        style="{{ @$form['style'] }}">

                        <label class='control-label col-sm-2'>Subscription End Date

                        </label>



                        <div class="col-sm-4">

                            <div class="input-group">

                                <span class="input-group-addon open-datetimepicker"><a><i
                                            class='fa fa-calendar '></i></a></span>

                                <input type='text' title="Subscription End Date" required readonly
                                    class='form-control notfocus' name="subscription-end-date" id="subscription-end-date"
                                    value='' />

                            </div>

                            <div class="text-danger">{!! $errors->first($name) ? "<i class='fa fa-info-circle'></i> " . $errors->first($name) : '' !!}</div>

                        </div>

                    </div>



                </div>

                <div class='form-group' id='form-group-subscription-type' style="{{ @$form['style'] }}">

                    <label class='control-label col-sm-2'>New Package

                    </label>



                    <div class="col-sm-4">

                        <select name="package_id" id="package_id" class="form-control">

                            @foreach ($packages as $package)
                                @if ($package->id == $customer->package_id)
                                    <option selected value="{{ $package->id }}"
                                        data-users_count="{{ $package->users_count }}"
                                        data-currency="{{ $package->currency }}"
                                        data-warehouses="{{ $package->warehouses }}"
                                        data-storage="{{ $package->storage_attached_size }}"
                                        data-backups_size="{{ $package->backups_size }}">

                                        {{ $package->title_en }}</option>
                                @else
                                    <option value="{{ $package->id }}" data-users_count="{{ $package->users_count }}"
                                        data-currency="{{ $package->currency }}"
                                        data-warehouses="{{ $package->warehouses }}"
                                        data-storage="{{ $package->storage_attached_size }}"
                                        data-backups_size="{{ $package->backups_size }}">

                                        {{ $package->title_en }}</option>
                                @endif
                            @endforeach

                        </select>

                    </div>

                </div>



                <div class='form-group' id='form-group-users_count' style="{{ @$form['style'] }}">

                    <label class='control-label col-sm-2'>

                        Users Count

                    </label>



                    <div class="col-sm-4">

                        <div class="input-group">

                            <input type='number' title="Users Count" required class='form-control' name="users_count"
                                id="users_count" />

                        </div>

                    </div>

                </div>

                <div class='form-group' id='form-group-warehouses' style="{{ @$form['style'] }}">

                    <label class='control-label col-sm-2'>

                        Warehouses Count

                    </label>



                    <div class="col-sm-4">

                        <div class="input-group">

                            <input type='number' title="Warehouses Count" required class='form-control'
                                name="warehouses" id="warehouses" />

                        </div>

                    </div>

                </div>

                <div class='form-group' id='form-group-currency' style="{{ @$form['style'] }}">

                    <label class='control-label col-sm-2'>

                        Currencies Count

                    </label>



                    <div class="col-sm-4">

                        <div class="input-group">

                            <input type='number' title="Currencies Count" required class='form-control' name="currency"
                                id="currency" />

                        </div>

                    </div>

                </div>



                <div class='form-group' id='form-group-currency' style="{{ @$form['style'] }}">

                    <label class='control-label col-sm-2'>

                        Storage Size

                    </label>



                    <div class="col-sm-4">

                        <div class="input-group">

                            <input type='number' title="Storage Size" required class='form-control'
                                name="storage_attached_size" id="storage" />

                        </div>

                    </div>

                </div>

                <div class='form-group' id='form-group-currency' style="{{ @$form['style'] }}">

                    <label class='control-label col-sm-2'>

                        Backups Size

                    </label>



                    <div class="col-sm-4">

                        <div class="input-group">

                            <input type='number' title="Backups Size" required class='form-control' name="backups_size"
                                id="backups_size" />

                        </div>

                    </div>

                </div>



                <div class="box-footer" style="background: #F5F5F5">

                    <div class="form-group">

                        <label class="control-label col-sm-2"></label>

                        <div class="col-sm-10">

                            <input type="submit" name="submit" value='{{ trans('crudbooster.button_save') }}'
                                class='btn btn-success'>

                            <a href='{{ CRUDBooster::mainpath() }}' class='btn btn-default'><i
                                    class='fa fa-chevron-circle-left'></i> {{ trans('crudbooster.button_back') }}</a>

                        </div>

                    </div>





                </div><!-- /.box-footer-->



            </form>

        </div>

    </div>

@endsection

@push('bottom')
    <script src='<?php echo asset('vendor/crudbooster/assets/select2/dist/js/select2.full.min.js'); ?>'></script>

    <script type="text/javascript">
        $("#subscription_type").change(function() {

            changeSubscribtionDate();

        }).change();



        $("#subscription-start-date").change(function() {

            changeSubscribtionDate();

        }).change();



        $('#modules').select2();



        function changeSubscribtionDate() {

            let type = $("#subscription_type").val();

            let startDate = $("#subscription-start-date").val();

            let d = new Date(startDate);

            if (type == "year") {

                d.setMonth(d.getMonth() + 12);

            } else if (type == "month") {

                d.setMonth(d.getMonth() + 1);

            } else if (type == "six-month") {

                d.setMonth(d.getMonth() + 6);

            }

            var d2 = new Date(d.getFullYear(), d.getMonth(), d.getDate());

            let endDate = d2.getFullYear() + '-' + ('0' + (d2.getMonth() + 1)).slice(-2) + '-' +

                ('0' + d2.getDate()).slice(-2);

            $("#subscription-end-date").val(endDate);

        }



        $(function() {

            $("#package_id").change(function() {

                let selectedOption = $(this).find("option:selected");

                $("#users_count").val(selectedOption.attr("data-users_count"));

                $("#warehouses").val(selectedOption.attr("data-warehouses"));

                $("#currency").val(selectedOption.attr("data-currency"));

                $("#storage").val(selectedOption.attr("data-storage"));

                $("#backups_size").val(selectedOption.attr("data-backups_size"));

            }).change();

        })
    </script>
@endpush



@push('head')
    <link rel='stylesheet' href='<?php echo asset('vendor/crudbooster/assets/select2/dist/css/select2.min.css'); ?>' />

    <style type="text/css">
        .select2-container--default .select2-selection--single {

            border-radius: 0px !important
        }



        .select2-container .select2-selection--single {

            height: 35px
        }



        .select2-container--default .select2-selection--multiple .select2-selection__choice {

            background-color: #3c8dbc !important;

            border-color: #367fa9 !important;

            color: #fff !important;

        }



        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {

            color: #fff !important;

        }
    </style>
@endpush
