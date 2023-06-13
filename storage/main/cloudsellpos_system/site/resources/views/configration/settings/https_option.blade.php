@extends('crudbooster::admin_template')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-file-text-o"></i>
                    <h3 class="box-title">{{ trans('labels.https_settings') }}</h3>
                </div>

                <div class="box-body">
                    {!! trans('labels.https_settings_details') !!}
                    <hr />
                    <h4>{{ trans('labels.change_setting_value') }}</h4>

                    <form id="HttpsSettingForm" class="form" action="{{ CRUDBooster::mainPath('https_setting/edit') }}">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td width="40%"><label
                                            for="https_activity">{{ trans('labels.https_setting_status') }}</label></td>
                                    <td>
                                        <input type="radio" id="on" name="https_activity" value="on"
                                            @if ($https_value == 'on') checked @endif>
                                        <label for="html">{{ trans('labels.active') }}</label><br>
                                        <input type="radio" id="off" name="https_activity" value="off"
                                            @if ($https_value == 'off') checked @endif>
                                        <label for="css"> {{ trans('labels.not_active') }} </label><br>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td>
                                        @php $path = url(CRUDBooster::mainPath()); @endphp
                                        <a class="btn btn-sm btn-warning" href="javascript:void(0)"
                                            onclick="location.href = '{{ $path }}'"> {{ trans('labels.back') }}
                                            <i class="fa fa-chevron-circle-right"></i>
                                        </a>
                                        <button class="btn btn-sm btn-primary" type='submit'>
                                            {{ trans('crudbooster.button_save') }} <i class="fa fa-save"></i> </button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
            </div>
        </div>

    </div> <!-- end row -->
@endsection
