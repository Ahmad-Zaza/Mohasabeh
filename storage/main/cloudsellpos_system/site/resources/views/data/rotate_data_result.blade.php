@extends('crudbooster::admin_template')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-push-3">
        <div class="box box-solid box-success">
        <div class="box-header">
            <i class="fa fa-check-circle"></i>
            <h3 class="box-title"> {{trans('labels.rotate_data_success')}}</h3>
        </div>

        <div class="box-body">
            {!! trans('labels.rotate_data_success_issues') !!}
            <p class="text-center"><a class="btn btn-success btn-xs" href="{{url(config('crudbooster.ADMIN_PATH'))}}">{{trans('labels.dashboard')}}</a></p>
        </div>

    </div>
        </div>
    </div>
@endsection
