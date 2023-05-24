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

        <div class="card info-card customers-card">

          <div class="card-body">

            <h5 class="card-title">{{auth()->user()->first_name}} {{auth()->user()->last_name}}<span> </span> </h5>

            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-people"></i>
              </div>
              <div class="box">
                <a href="{{auth()->user()->host_link}}">
                  <h6>{{auth()->user()->host_link}} </h6>
                </a>
                @if(auth()->user()->is_free_trial)
                <span class="text-muted small pt-2 ps-1">free trail ends at {{auth()->user()->free_trial_end_date}}</span>
                @else
                <span class="text-muted small pt-2 ps-1">subscription ends at {{auth()->user()->subscription_end_date}}</span>
                @endif
              </div>

            </div>


          </div>
          <div class="action-buttons">
            <a class="card-link">
              {{__('dashboard.Upgrade')}}
            </a>
            <a class="card-link">
              {{__('dashboard.Login')}}
            </a>
            <a class="card-link">
              {{__('dashboard.Delete Account')}}
            </a>
          </div>
        </div>

      </div>
      <div class="row">

        <div class="col-md-3 col-md-4">
          <div class="card info-card sales-card">

            <div class="card-body">
              <h5 class="card-title">{{__('dashboard.Customers Count')}}<span></span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-cart"></i>
                </div>
                <div class="box">
                  <h6>{{auth()->user()->site_status->allowed_clients_count == -1 ? auth()->user()->site_status->used_clients_count /unlimited : auth()->user()->site_status->used_clients_count / auth()->user()->site_status->allowed_clients_count}}</h6>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="col-md-3 col-md-4">
          <div class="card info-card revenue-card">


            <div class="card-body">
              <h5 class="card-title">{{__('dashboard.Inventories Count')}} <span></span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="box">
                  <h6>{{auth()->user()->site_status->allowed_inventories_count == -1 ? auth()->user()->site_status->used_inventories_count /unlimited : auth()->user()->site_status->used_inventories_count / auth()->user()->site_status->allowed_inventories_count}}</h6>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="col-md-3 col-md-4">
          <div class="card info-card revenue-card">


            <div class="card-body">
              <h5 class="card-title">{{__('dashboard.Currencies Count')}} <span></span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="box">
                  <h6>{{auth()->user()->site_status->allowed_currencies_count == -1 ? auth()->user()->site_status->used_currencies_count /unlimited : auth()->user()->site_status->used_currencies_count / auth()->user()->site_status->allowed_currencies_count}}</h6>

                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- <div class="col-md-3 col-md-4">
          <div class="card info-card revenue-card">
            <div class="card-body">
              <h5 class="card-title">{{__('dashboard.Backup Storage Usage')}} </h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="box">
                  <h6>264M</h6>

                </div>
              </div>
            </div>

          </div>
        </div> -->

        <div class="col-md-3 col-md-4">
          <div class="card info-card revenue-card">
            <div class="card-body">
              <h5 class="card-title">{{__('dashboard.Attached Storage Usage')}} </h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="box">
                  <h6>{{auth()->user()->site_status->allowed_attachs_size == -1 ? auth()->user()->site_status->used_attachs_size MB/unlimited : auth()->user()->site_status->used_attachs_size MB/ auth()->user()->site_status->allowed_attachs_size MB}}</h6>
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