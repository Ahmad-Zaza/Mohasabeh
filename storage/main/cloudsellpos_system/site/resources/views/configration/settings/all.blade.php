@extends('crudbooster::admin_template')
@section('content')
    <div class="row">

        <div class="col-md-4 col-sm-6 col-xs-12">
            <a href="{{ url(CRUDBooster::mainpath() . '/temp_stop') }}" class="info-box-link">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-ban"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"> <strong> {{ trans('labels.temp_stop') }} </strong> </span>
                        <span class="setting-brief"> {{ trans('labels.temp_stop_brief') }} </span>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
            <a href="{{ url(CRUDBooster::mainpath() . '/images_settings') }}" class="info-box-link">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-image"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"> <strong> {{ trans('labels.images_setting') }} </strong> </span>
                        <span class="setting-brief"> {{ trans('labels.images_setting_brief') }} </span>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
            <a href="{{ url(CRUDBooster::mainpath() . '/bills_settings') }}" class="info-box-link">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa  fa-file-text-o"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"> <strong> {{ trans('labels.bills_setting') }} </strong> </span>
                        <span class="setting-brief"> {{ trans('labels.bills_setting_brief') }} </span>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
            <a href="{{ url(CRUDBooster::mainpath() . '/lock_url') }}" class="info-box-link">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-lock"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"> <strong> {{ trans('labels.lock_url') }} </strong> </span>
                        <span class="setting-brief"> {{ trans('labels.lock_url_brief') }} </span>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
            <a href="{{ url(CRUDBooster::mainpath() . '/https_setting') }}" class="info-box-link">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-shield"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"> <strong> {{ trans('labels.https_settings') }} </strong> </span>
                        <span class="setting-brief"> {{ trans('labels.https_settings_brief') }} </span>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
            <a href="{{ url(CRUDBooster::mainpath() . '/renew') }}" class="info-box-link">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-shield"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"> <strong> {{ trans('labels.renew') }} </strong> </span>
                        {{-- <span class="setting-brief"> {{ trans('labels.https_settings_brief') }} </span> --}}
                    </div>
                </div>
            </a>
        </div>

    </div> <!-- end row -->
@endsection
