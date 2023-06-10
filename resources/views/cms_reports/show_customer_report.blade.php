@extends('crudbooster::admin_template')
@section('content')

    <div>

        @if (CRUDBooster::getCurrentMethod() != 'getProfile' && $button_cancel)
            @if (g('return_url'))
                <p><a title='Return' href='{{ g('return_url') }}'><i class='fa fa-chevron-circle-left '></i>
                        &nbsp; {{ cbLang('form_back_to_list', ['module' => CRUDBooster::getCurrentModule()->name]) }}</a>
                </p>
            @else
                <p><a title='Main Module' href='{{ CRUDBooster::mainpath() }}'><i class='fa fa-chevron-circle-left '></i>
                        &nbsp; {{ cbLang('form_back_to_list', ['module' => CRUDBooster::getCurrentModule()->name]) }}</a>
                </p>
            @endif
        @endif

        <div class="panel panel-default">
            <div class="panel-heading">
                <strong><i class='{{ CRUDBooster::getCurrentModule()->icon }}'></i> {!! $page_title !!}</strong>
            </div>

            <div class="panel-body" style="padding:20px 0px 0px 0px">
                <?php
                $action = @$row ? CRUDBooster::mainpath("edit-save/$row->id") : CRUDBooster::mainpath('add-save');
                $return_url = $return_url ?: g('return_url');
                ?>
                <form class='form-horizontal' method='post' id="form" enctype="multipart/form-data"
                    action='{{ $action }}'>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type='hidden' name='return_url' value='{{ @$return_url }}' />
                    <input type='hidden' name='ref_mainpath' value='{{ CRUDBooster::mainpath() }}' />
                    <input type='hidden' name='ref_parameter' value='{{ urldecode(http_build_query(@$_GET)) }}' />
                    @if ($hide_form)
                        <input type="hidden" name="hide_form" value='{!! serialize($hide_form) !!}'>
                    @endif
                    <div class="box-body" id="parent-form-area">

                        @if ($command == 'detail')
                            {{-- @include('crudbooster::default.form_detail') --}}
                            {{-- Start form detail --}}
                            <?php
                                $images = DB::table('model_images')->where([
                                    'model_type' => $table,
                                    'model_id' => $id
                                ])->get();
                                //Loading Assets
                                $asset_already = [];
                                foreach($forms as $form) {
                                $type = @$form['type'] ?: 'text';

                                if (in_array($type, $asset_already)) continue;

                                ?>
                            @if (file_exists(base_path('/vendor/voila_cms/crudbooster/src/views/default/type_components/' . $type . '/asset.blade.php')))
                                @include('crudbooster::default.type_components.' . $type . '.asset')
                            @elseif(file_exists(resource_path('views/vendor/crudbooster/type_components/' . $type . '/asset.blade.php')))
                                @include('vendor.crudbooster.type_components.' . $type . '.asset')
                            @endif
                            <?php
                                $asset_already[] = $type;
                                } //end forms
                                ?>

                            @push('head')
                                <style type="text/css">
                                    #table-detail tr td:first-child {
                                        font-weight: bold;
                                        width: 25%;
                                    }
                                </style>
                            @endpush

                            <div class='table-responsive'>
                                <table id='table-detail' class='table table-striped'>

                                    <?php
                                        foreach($forms as $index=>$form):

                                        $name = $form['name'];
                                        @$join = $form['join'];
                                        @$value = (isset($form['value'])) ? $form['value'] : '';
                                        @$value = (isset($row->{$name})) ? $row->{$name} : $value;
                                        @$showInDetail = (isset($form['showInDetail'])) ? $form['showInDetail'] : true;

                                        if ($showInDetail == FALSE) {
                                            continue;
                                        }

                                        if (isset($form['callback_php'])) {
                                            @eval("\$value = ".$form['callback_php'].";");
                                        }

                                        if (isset($form['callback'])) {
                                            $value = call_user_func($form['callback'], $row);
                                        }

                                        if (isset($form['default_value'])) {
                                            @$value = $form['default_value'];
                                        }

                                        if ($join && @$row) {
                                            $join_arr = explode(',', $join);
                                            array_walk($join_arr, 'trim');
                                            $join_table = $join_arr[0];
                                            $join_title = $join_arr[1];
                                            $join_table_pk = CB::pk($join_table);
                                            $join_fk = CB::getForeignKey($table, $join_table);
                                            $join_query[$join_table] = DB::table($join_table)->select($join_title)->where($join_table_pk, $row[$join_fk])->first();
                                            $value = @$join_query[$join_table][$join_title];
                                        }

                                        $type = @$form['type'] ?: 'text';
                                        $required = (@$form['required']) ? "required" : "";
                                        $readonly = (@$form['readonly']) ? "readonly" : "";
                                        $disabled = (@$form['disabled']) ? "disabled" : "";
                                        $jquery = @$form['jquery'];
                                        $placeholder = (@$form['placeholder']) ? "placeholder='".$form['placeholder']."'" : "";
                                        $file_location = base_path('vendor/voila_cms/crudbooster/src/views/default/type_components/'.$type.'/component_detail.blade.php');
                                        $user_location = resource_path('views/vendor/crudbooster/type_components/'.$type.'/component_detail.blade.php');
                                        ?>
                                    <tr>
                                        <td>{{ $form['label'] }}</td>
                                        <td>
                                            @if (@$value == '-1')
                                                unlimited
                                            @elseif (str_contains(@$form['name'], 'allowed_attachs_size'))
                                                {{ $value / 1024 . ' GB' }}
                                            @elseif (str_contains(@$form['name'], 'used_attachs_size'))
                                                {{ $value . ' GB' }}
                                            @else
                                                {{ $value }}
                                            @endif
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </table>
                            </div>

                            {{-- End form detail --}}
                        @else
                            @include('crudbooster::default.form_body')
                            @if (CRUDBooster::getCurrentModule()->has_images == 1)
                                @include('crudbooster::model_images')
                            @endif
                        @endif

                    </div><!-- /.box-body -->

                    <div class="box-footer" style="background: #F5F5F5">

                        <div class="form-group">
                            <label class="control-label col-sm-2"></label>
                            <div class="col-sm-10">
                                @if ($button_cancel && CRUDBooster::getCurrentMethod() != 'getDetail')
                                    @if (g('return_url'))
                                        <a href='{{ g('return_url') }}' class='btn btn-default'><i
                                                class='fa fa-chevron-circle-left'></i> {{ cbLang('button_back') }}</a>
                                    @else
                                        <a href='{{ CRUDBooster::mainpath('?' . http_build_query(@$_GET)) }}'
                                            class='btn btn-default'><i class='fa fa-chevron-circle-left'></i>
                                            {{ cbLang('button_back') }}</a>
                                    @endif
                                @endif
                                @if (CRUDBooster::isCreate() || CRUDBooster::isUpdate())
                                    @if (CRUDBooster::isCreate() && $button_addmore == true && $command == 'add')
                                        <input type="submit" name="submit" value='{{ cbLang('button_save_more') }}'
                                            class='btn btn-success'>
                                    @endif

                                    @if ($button_save && $command != 'detail')
                                        <input type="submit" name="submit" value='{{ cbLang('button_save') }}'
                                            class='btn btn-success'>
                                    @endif
                                @endif
                            </div>
                        </div>


                    </div><!-- /.box-footer-->

                </form>

            </div>
        </div>
    </div>
    <!--END AUTO MARGIN-->

@endsection
