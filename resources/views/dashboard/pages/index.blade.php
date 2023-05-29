@extends('dashboard.layouts.master')
@section('content')



<div class="pagetitle">
  <h1>{{__('dashboard.Dashboard')}}</h1>
  <nav>
    <ol class="breadcrumb">
    </ol>
  </nav>
</div>

<section class="section dashboard">
  <div class="row">

    <div class="">
      <div class="col-md-8">

        <div class="card info-card host-card">

          <div class="card-body">

            <h5 class="card-title">{{auth()->user()->first_name}} {{auth()->user()->last_name}}<span> </span> </h5>

            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-link"></i>
              </div>
              <div class="">
                <a href="{{auth()->user()->host_link}}" target="_blank">
                  <h6>{{auth()->user()->host_link}} </h6>
                </a>
                @if(auth()->user()->is_free_trial)
                <span class="text-muted small pt-2 ps-1">Free Trail ends at {{auth()->user()->free_trial_end_date}}</span>
                @else
                <span class="text-muted small pt-2 ps-1">Subscription ends at {{auth()->user()->subscription_end_date}}</span>
                @endif
              </div>

            </div>


          </div>
          <div class="action-buttons">
            <a class="card-link" href="{{URL('pricing')}}">
              {{__('dashboard.Upgrade')}}
            </a>
            <a class="card-link">
              {{__('dashboard.Delete Account')}}
            </a>
          </div>
        </div>
      </div>


      <div class="row">
        <div class="col-md-3 col-md-4">
          <div class="card info-card customers-card">
            <div class="card-body">
              <h5 class="card-title">{{__('dashboard.Customers Count')}}<span></span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
                </div>
                <div class="box">
                  <p>{{auth()->user()->site_status->allowed_clients_count == -1 ? auth()->user()->site_status->used_clients_count ."/".__('dashboard.unlimited'): auth()->user()->site_status->used_clients_count ."/". auth()->user()->site_status->allowed_clients_count}}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-md-4">
          <div class="card info-card inventories-card">
            <div class="card-body">
              <h5 class="card-title">{{__('dashboard.Inventories Count')}} <span></span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-list-ol "></i>
                </div>
                <div class="box">
                  <p>{{auth()->user()->site_status->allowed_inventories_count == -1 ? auth()->user()->site_status->used_inventories_count ."/".__('dashboard.unlimited') : auth()->user()->site_status->used_inventories_count ."/". auth()->user()->site_status->allowed_inventories_count}}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-md-4">
          <div class="card info-card currencies-card">
            <div class="card-body">
              <h5 class="card-title">{{__('dashboard.Currencies Count')}} <span></span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-currency-exchange"></i>
                </div>
                <div class="box">
                  <p>{{auth()->user()->site_status->allowed_currencies_count == -1 ? auth()->user()->site_status->used_currencies_count ."/".__('dashboard.unlimited') : auth()->user()->site_status->used_currencies_count ."/". auth()->user()->site_status->allowed_currencies_count}}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-md-4">
          <div class="card info-card storage-card">
            <div class="card-body">
              <h5 class="card-title">{{__('dashboard.Attached Storage Usage')}} </h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-sd-card"></i>
                </div>
                <div class="box">
                  <p>{{auth()->user()->site_status->allowed_attachs_size == -1 ? auth()->user()->site_status->used_attachs_size ."MB/".__('dashboard.unlimited') : auth()->user()->site_status->used_attachs_size ."MB/". auth()->user()->site_status->allowed_attachs_size ."MB"}}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@stop