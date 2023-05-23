@extends('crudbooster::admin_template')
@section('content')
    <style>
        .d_none {
            display: none;
        }

        .d_block {
            display: block;
        }
    </style>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong><i class='fa fa-cog fas-cog'></i> Add Pricing Package Options</strong>
            </div>
            <div class="panel-body" style="padding:20px 0px 0px 0px">
                <form class='form-horizontal' method='post' id="form" enctype="multipart/form-data"
                    action='{{ CRUDBooster::mainpath('add-save') }}'>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type='hidden' name='return_url' value='' />
                    <input type='hidden' name='ref_mainpath' value='' />
                    <input type='hidden' name='ref_parameter' value='' />
                    <div class="box-body" id="parent-form-area">
                        <div class="form-group header-group-0 hidden" id="form-group-title_ar" style="">
                            <label class="control-label col-sm-2">
                                Price Packages
                                <span class="text-danger" title="This field is required">*</span>
                            </label>
                            <div class="col-sm-10">
                                <select class="form-control select2 " name="price_pkg_id">
                                    @foreach ($price_pkgs as $pkg)
                                        <option value="{{ $pkg->id }}">{{ $pkg->title_en }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group header-group-0 " id="form-group-title_ar" style="">
                            <label class="control-label col-sm-2">
                                Option data Type
                                <span class="text-danger" title="This field is required">*</span>
                            </label>
                            <div class="col-sm-10">
                                <select name="type" class="form-control select2" onchange="getValueCol(this.value)">
                                    <option value="1">Text</option>
                                    <option value="2">Select</option>
                                </select>
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group header-group-0 " id="form-group-title_en" style="">
                            <label class="control-label col-sm-2">
                                Code
                                <span class="text-danger" title="This field is required">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" title="Title En" required="" maxlength="255" class="form-control"
                                    name="code" id="code" value="">
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group header-group-0 " id="form-group-description_ar" style="">
                            <label class="control-label col-sm-2">
                                Value
                                <span class="text-danger" title="This field is required">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" title="Value" maxlength="255" class="form-control" name="value"
                                    id="normal_value" value="">
                                <select name="value[]" class="form-control select2 d_none" multiple id="report_value">
                                    @foreach ($reports as $report)
                                        <option value="{{ $report->id }}">{{ $report->title_en }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group header-group-0 " id="form-group-description_en" style="">
                            <label class="control-label col-sm-2">
                                Arabic Label Name
                                <span class="text-danger" title="This field is required">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" title="Arabic Label Name" required="" maxlength="255"
                                    class="form-control" name="name_ar" id="name_ar" value="">
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group header-group-0 " id="form-group-description_en" style="">
                            <label class="control-label col-sm-2">
                                English Label Name
                                <span class="text-danger" title="This field is required">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" title="English Label Name" required="" maxlength="255"
                                    class="form-control" name="name_en" id="name_en" value="">
                                <div class="text-danger"></div>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <script src="http://mohasabeh.voitest.com/vendor/crudbooster/assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js">
                        </script>
                        <script
                            src="http://mohasabeh.voitest.com/vendor/crudbooster/assets/adminlte/plugins/datepicker/bootstrap-datepicker.js">
                        </script>
                    </div>
                    <div class="box-footer" style="background: #F5F5F5">
                        <div class="form-group">
                            <label class="control-label col-sm-2"></label>
                            <div class="col-sm-10">
                                <input type="submit" name="submit" value='{{ trans('crudbooster.button_save_more') }}'
                                    class='btn btn-success'>
                                @if (g('return_url'))
                                    <a href='{{ g('return_url') }}' class='btn btn-default'><i
                                            class='fa fa-chevron-circle-left'></i> {{ trans('crudbooster.button_back') }}
                                    </a>
                                @else
                                    <a href='{{ CRUDBooster::mainpath('?' . http_build_query(@$_GET)) }}'
                                        class='btn btn-default'><i class='fa fa-chevron-circle-left'></i>
                                        {{ trans('crudbooster.button_back') }}
                                    </a>
                                @endif
                            </div>
                        </div>


                    </div><!-- /.box-footer-->

                </form>
            </div>
        </div>
    </div>
    <!--END AUTO MARGIN-->
    <script language="javascript" type="text/javascript">
        function getValueCol(type_id) {
            if (type_id == 1) {
                $('#normal_value').addClass('d_block');
                $('#normal_value').removeClass('d_none');
                $('#report_value').removeClass('d_block');
                $('#report_value').addClass('d_none');
            } else {
                $('#normal_value').removeClass('d_block');
                $('#normal_value').addClass('d_none');
                $('#report_value').addClass('d_block');
                $('#report_value').removeClass('d_none');
            }
        }
        $("#form").submit(function(e) {
            var data = $("#form").serialize();
            $("#form").submit();
            // debugger;
        });
    </script>
@endsection
