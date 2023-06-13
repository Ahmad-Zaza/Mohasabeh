@extends('crudbooster::admin_template')
@section('content')

    @if (!$import_status)
        <ul class='nav nav-tabs'>
            <li style="background:#ffffff" class='active'><a style="color:#111" href='javascript:void(0);'><i
                        class='fa fa-cloud-upload'></i> {{trans('labels.import_data')}} &raquo;</a></li>
            <li style="background:#eeeeee"><a style="color:#111" href='#'><i class='fa fa-database'></i> {{trans('labels.import_data_result')}} </a></li>
        </ul>

        <!-- Box -->
        <div id='box_main' class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"> {{trans('labels.import_data')}} </h3>
                <div class="box-tools">

                </div>
            </div>

            <?php
            $action_path = CRUDBooster::mainpath();
            $action = $action_path . '/get-import-data';
            ?>

            <form method='post' id="form" enctype="multipart/form-data" action='{{ url($action) }}'>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="box-body">

                    <div class='callout callout-success' id="info-message">
                        <h4>{{trans('labels.wellcome_import_data_tool')}} </h4>
                        {!! trans('labels.import_data_statements') !!}
                        <br />
                        <?php
                            $module_path= CRUDBooster::getCurrentModule()->path;
                            if($module_path == 'persons' || $module_path == 'initial_voucher'){
                                
                                ?>
                                {{trans('labels.import_data_statements_note1')}}
                                <a
                            href='{{ url(config('crudbooster.ADMIN_PATH') . '/accounts/export') }}' target='_blank'
                            class='btn btn-xs btn-info'> {{trans('labels.export')}}</a>
                        <br />
                        <?php
                            }
                        ?>

                        <?php
                            if($module_path == 'initial_voucher'){
                                ?>
                        {{trans('labels.import_data_statements_note2_lable1')}}
                        <a href='{{ url(config('crudbooster.ADMIN_PATH') . '/currencies') }}'
                            target='_blank' class='btn btn-xs btn-info'> {{trans('labels.here')}}</a>
                        {{trans('labels.import_data_statements_note2_lable2')}}    
                        <br />
                        <?php
                            }
                        ?>
                        <?php
                            if($module_path == 'inventory_beginning'){
                                
                                ?>
                               {{trans('labels.import_data_statements_note3')}} 
                        <a href='{{ url(config('crudbooster.ADMIN_PATH') . '/inventories/export') }}' target='_blank'
                            class='btn btn-xs btn-info'> {{trans('labels.export')}}</a>
                        <br />
                        {{trans('labels.import_data_statements_note4')}}
                        <a href='{{ url(config('crudbooster.ADMIN_PATH') . '/items/export') }}'
                            target='_blank' class='btn btn-xs btn-info'> {{trans('labels.export')}}</a>
                        <br />
                        <?php
                            }
                        ?>
                        <?php
                            if($module_path == 'items'){
                                
                                ?>
                            {{trans('labels.import_data_statements_note5')}}    
                            <a href='{{ url(config('crudbooster.ADMIN_PATH') . '/item_categories/export') }}' target='_blank'
                            class='btn btn-xs btn-info'> {{trans('labels.export')}}</a>
                        <br />
                        <?php
                            }
                        ?>

                        {{trans('labels.import_data_statements_note6')}}<a class="btn btn-xs btn-info"
                            href='{{ asset("$example_file") }}' target="_blank">{{trans('labels.download')}} <i class="fa fa-download"></i></a>
                    </div>

                    <div class='form-group' id="upload-file-sect">
                        <label>{{trans('labels.xls_xlsx_files')}}</label>
                        <input type='file' name='userfile' id="uploadFile" class='form-control' accept=".xls, .xlsx"
                            required />
                        <div class='help-block'>{{trans('labels.files_types')}}</div>
                    </div>
                    <div class='form-group' id="process_method-sect">
                        <label>{{trans('labels.choose_similarity_process_method')}}</label>
                        <div class="checkbox">
                            <label>
                                <input type="radio" name="process_method" value="1" checked> {{trans('labels.ignore')}}
                            </label>
                            <label>
                                <input type="radio" name="process_method" value="2"> {{trans('labels.replace')}}
                            </label>
                        </div>
                        <div class='help-block'>
                            {{trans('labels.import_data_statements_note7')}}
                        </div>
                    </div>
                </div><!-- /.box-body -->

                <div class="box-footer">
                    <div class='pull-right'>
                        <a href='{{ CRUDBooster::mainpath() }}' class='btn btn-default' id="go-back"> {{trans('labels.back')}} </a>
                        <button id="submit-btn" class='btn btn-primary' name="submit"
                            onclick="return onClickSubmitBtn(event)"> {{trans('labels.import')}} <i class="fa fa-cloud-upload"></i></button>

                    </div>
                    <div class="">
                        <br />
                        <br />
                        <br />
                        <div class="callout callout-info waiting-msg hidden">
                            <h4> {{trans('labels.please_waitting')}}</h4>
                            <p>{{trans('labels.process_take_some_time')}} <i class="fa fa-refresh fa-spin"></i></p>

                        </div>
                    </div>
                </div><!-- /.box-footer-->
            </form>
        </div><!-- /.box -->
    @endif

    @if ($import_status)

        <ul class='nav nav-tabs'>
            <li style="background:#eeeeee"><a style="color:#111" href='#'><i class='fa fa-cloud-upload'></i>
             {{trans('labels.import_data')}} &raquo;</a></li>
            <li style="background:#ffffff" class='active'><a style="color:#111" href='#'><i
                        class='fa fa-database'></i> {{trans('labels.import_data_result')}}</a></li>

        </ul>

        <!-- Box -->
        <div id='box_main' class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"> {{trans('labels.import_data_result')}}</h3>
                <div class="box-tools">

                </div>
            </div>
            <div class="box-body" style="min-height:290px;">

                @if ($import_status == 'success')
                    <div class='callout callout-success'>
                        <h4> <i class="fa  fa-check-circle"></i> {{trans('labels.import_data_success')}} </h4>
                        <div style="max-height:240px; overflow-y: auto;">
                            @foreach ($reports as $report)
                                <li>{{ $report }}</li>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($import_status != 'success')
                    <div class='callout callout-danger'>
                        <h4> <i class="fa   fa-close"></i> {{trans('labels.import_data_failed')}}</h4>
                        <div style="max-height:240px; overflow-y: auto;">
                            @foreach ($reports as $report)
                                <li>{{ $report }}</li>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div><!-- /.box-body -->

            <div class="box-footer">
                <div class='pull-right'>
                    <a href='{{ CRUDBooster::mainpath() }}' class='btn btn-default'>{{trans('labels.finish')}}</a>
                    @if ($import_status != 'success')
                        @php
                            $action_path = CRUDBooster::mainpath();
                            $action = $action_path . '/import-data-form';
                        @endphp
                        <a href='{{ $action }}' class='btn btn-primary'>{{trans('labels.try_again')}}</a>
                    @endif
                </div>

            </div><!-- /.box-footer-->

        </div><!-- /.box -->

    @endif

    </div><!-- /.col -->


    </div><!-- /.row -->


    <script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>

    <script type="text/javascript">
        function onClickSubmitBtn(e) {
            var $status = confirm("{{trans('labels.are_you_confirm')}}");
            if ($status == 1) {
                if (document.getElementById("uploadFile").value != "") {
                    $("#submit-btn").addClass('disabled');
                    $("#submit-btn i").removeClass('fa-cloud-upload');
                    $("#submit-btn i").addClass('fa-spinner fa-spin');
                    $('.waiting-msg').removeClass('hidden');
                }
                return true;
            } else {
                e.preventDefault();
                return false;
            }
        }
    </script>
@endsection
