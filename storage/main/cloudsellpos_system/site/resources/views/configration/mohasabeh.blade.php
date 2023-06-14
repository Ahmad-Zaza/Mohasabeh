@extends('crudbooster::admin_template')
@section('content')
<div class="row">

    <div class="col-sm-8">

    <div class="box box-solid box-info">
        <div class="box-header with-border">
            <i class="fa fa-asterisk"></i>
            <h3 class="box-title"> {{trans('labels.mohasabeh')}} </h3>
        </div>

        <div class="box-body">
            {!! trans('labels.mohasabeh_message') !!}
        </div>

    </div>

    <div class="box box-solid box-success" id="subscribe_information">
            <div class="box-header with-border">
                <i class="fa fa-calendar"></i>
                <h3 class="box-title">  {{trans('labels.subscribe_information')}}  </h3>
            </div>

            <div class="box-body">
                <table class="table  table-striped table-hover">
                    <tbody>
                        <tr>
                            <th> {{trans('labels.free_trial_start_date')}}</th>
                            <td><span class="badge bg-blue">{{$data->free_trial_start_date}}</span></td>
                        </tr>
                        <tr>
                            <th> {{trans('labels.free_trial_end_date')}}</th>
                            <td><span class="badge bg-blue">{{$data->free_trial_end_date}}</span></td>
                        </tr>
                        <tr>
                            <th>   {{trans('labels.remaining_days_to_finish_free_trial')}} </th>
                            <td><span class="badge bg-blue">{{$data->free_trail_remaining_days}}</span></td>
                        </tr>
                        <tr>
                            <th> {{trans('labels.subscription_start_date')}}</th>
                            <td><span class="badge bg-red">{{$data->subscription_start_date}}</span></td>
                        </tr>
                        <tr>
                            <th> {{trans('labels.subscription_end_date')}}</th>
                            <td><span class="badge bg-red">{{$data->subscription_end_date}}</span></td>
                        </tr>
                        <tr>
                            <th> {{trans('labels.remaining_days_to_finish_subscription')}} </th>
                            <td><span class="badge bg-red">{{$data->subscription_remaining_days}}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

        <div class="box box-solid box-info" id="package_information">
            <div class="box-header with-border">
                <i class="fa fa-tags"></i>
                <h3 class="box-title"> {{trans('labels.package_information')}} </h3>
            </div>

            <div class="box-body">
                <table class="table table-striped table-hover text-center">
                    <tbody>
                        <tr>
                            <th></th>
                            <th> {{trans('labels.config_name')}} </th>
                            <th> {{trans('labels.total_num')}} </th>
                            <th> {{trans('labels.used')}} </th>
                            <th> {{trans('labels.unused')}} </th>
                        </tr>
                        <tr>
                            <td><i class="fa fa-users"></i></td>
                            <th > {{trans('labels.users_num')}}</th>
                            <td><span class="badge bg-red">{{$data->users_num}}</span></td>
                            <td><span class="badge bg-green">{{$data->current_users_num}}</span></td>
                            <td><span class="badge bg-blue">{{$data->avilable_users_num}}</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-building-o"></i></td>
                            <th > {{trans('labels.inventories_num')}}</th>
                            <td><span class="badge bg-red">{{$data->inventories_num}}</span></td>
                            <td><span class="badge bg-green">{{$data->current_inventories_num}}</span></td>
                            <td><span class="badge bg-blue">{{$data->avilable_inventories_num}}</span></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-money"></i></td>
                            <th > {{trans('labels.currencies_num')}}</th>
                            <td><span class="badge bg-red">{{$data->currencies_num}}</span></td>
                            <td><span class="badge bg-green">{{$data->current_currencies_num}}</span></td>
                            <td><span class="badge bg-blue">{{$data->avilable_currencies_num}}</span></td>
                        </tr>

                        {{-- <tr>
                            <td><i class="fa fa-user"></i></td>
                            <th > {{trans('labels.clients_num')}}</th>
                            <td><span class="badge bg-red">{{$data->clients_num}}</span></td>
                            <td><span class="badge bg-green">{{$data->current_clients_num}}</span></td>
                            <td><span class="badge bg-blue">{{$data->avilable_clients_num}}</span></td>
                        </tr> --}}

                        <tr>
                            <td><i class="fa fa-list-alt"></i></td>
                            <th > {{trans('labels.month_bills_num')}}</th>
                            <td><span class="badge bg-red">{{$data->month_bills_num}}</span></td>
                            <td><span class="badge bg-green">{{$data->current_month_bills_num}}</span></td>
                            <td><span class="badge bg-blue">{{$data->avilable_month_bills_num}}</span></td>
                        </tr>

                        <tr>
                            <td><i class="fa fa-database"></i></td>
                            <th > {{trans('labels.backups_size')}}</th>
                            <td><span class="badge bg-red">{{($data->backups_size!=trans('labels.unlimited'))?$data->backups_size.' M':$data->backups_size}}</span></td>
                            <td><span class="badge bg-green">{{($data->current_backups_size !=trans('labels.unlimited'))?$data->current_backups_size.' M':$data->current_backups_size}}</span></td>
                            <td><span class="badge bg-blue">{{($data->avilable_backups_size !=trans('labels.unlimited'))?$data->avilable_backups_size.' M':$data->avilable_backups_size}}</span></td>
                        </tr>

                        <tr>
                            <td><i class="fa fa-image"></i></td>
                            <th > {{trans('labels.attachs_size')}}</th>
                            <td><span class="badge bg-red">{{($data->attachs_size!=trans('labels.unlimited'))?$data->attachs_size.' M':$data->attachs_size}}</span></td>
                            <td><span class="badge bg-green">{{($data->current_attachs_size != trans('labels.unlimited'))?$data->current_attachs_size.' M':$data->current_attachs_size}}</span></td>
                            <td><span class="badge bg-blue">{{($data->avilable_attachs_size != trans('labels.unlimited'))?$data->avilable_attachs_size.' M':$data->avilable_attachs_size}}</span></td>
                        </tr>

                    </tbody>
                </table>
            </div>

        </div>
    </div> <!-- end col-sm-8 -->

        <!-- Mohasabeh Info -->
        <div class="col-md-4">
            <div class="box  box-solid box-primary" id="account_information">
                <div class="box-header with-border">
                    <i class="fa fa-user"></i>
                    <h3 class="box-title">{{trans('labels.account_information')}}</h3>
                </div>

                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="{{($mohasabeh_info->photo)?$mohasabeh_info->photo:asset('vendor/crudbooster/avatar.jpg')}}" alt="User profile picture">
                    <h3 class="profile-username text-center">{{$mohasabeh_info->first_name." ".$mohasabeh_info->last_name}}</h3>
                    <p class="text-muted text-center">{{$mohasabeh_info->email}}</p>
                    <ul class="list-group list-group-unbordered">

                        <li class="list-group-item">
                            <b>{{trans('labels.phone')}}</b> <a class="pull-left">{{$mohasabeh_info->phone}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{trans('labels.company')}}</b> <a class="pull-left">{{$mohasabeh_info->company}}</a>
                        </li>
                    </ul>

                </div>
            </div>


            <div class="box  box-solid box-primary" id="about_mohasabeh">
                <div class="box-header with-border">
                    <i class="fa fa-asterisk"></i>
                    <h3 class="box-title">{{trans('labels.about_mohasabeh')}}</h3>
                </div>

                <div class="box-body">
                    <strong><i class="fa fa-book margin-r-5"></i> {{trans('labels.description')}}</strong>
                    <p class="text-muted">{{trans('labels.mohasabeh_description')}}</p>
                    <hr>
                    <p><strong><i class="fa fa-phone margin-r-5"></i> للتواصل</strong></p>

                    <ul class="list-group list-group-unbordered">

                        <li class="list-group-item">
                            <b>{{trans('labels.phone')}}</b> <a class="pull-left">{{$mohasabeh_info->mohasabeh_phone}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{trans('modules.email')}}</b> <a class="pull-left">{{$mohasabeh_info->mohasabeh_email}}</a>
                        </li>
                    </ul>

                    <a href="https://cloudsellpos.com" target="_blank" class="btn btn-primary btn-block"><b>{{trans('labels.go_to_site')}}</b></a>
                </div>
            </div>

            <div class="box box-solid box-warning" id="contact_us">
                <div class="box-header">
                    <i class="fa fa-tty"></i>
                    <h3 class="box-title"> {{trans('labels.contact_us')}} </h3>
                </div>
                <div class="box-body">
                    <button  class="btn btn-default btn-block" data-toggle="modal" data-target="#DomainRequestModal" id="DomainRequestBtn">  {{trans('labels.domain_request')}} <i class="fa fa-send "></i> </button>
                    <button  class="btn btn-primary btn-block" data-toggle="modal" data-target="#MailMohasabehTeamModal" id="MailMohasabehTeamBtn"> {{trans('labels.mail_mohasabeh_team')}} <i class="fa fa-envelope "></i> </button>
                    <button  class="btn btn-info btn-block" data-toggle="modal" data-target="#RenewalRequestModal" id="RenewalRequestBtn"> {{trans('labels.renewal_request')}} <i class="fa fa-send "></i> </button>
                </div>
            </div>

        </div>
        <!-- end Mohasabeh Info -->

</div> <!-- end row -->


@include('configration.modals.domain_request')
@include('configration.modals.send_mail')
@include('configration.modals.renewal_request')
<script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<script src="{{asset('js/modules_js/configrations/configrations_script.js')}}"></script>
@endsection
