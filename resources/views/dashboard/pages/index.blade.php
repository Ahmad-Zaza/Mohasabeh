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
      <div class="col-xxl-4 col-xl-8">

        <div class="card info-card customers-card">

          <div class="card-body">

            <h5 class="card-title">{{__('dashboard.User Name')}}<span> </span> </h5>
            <div class="action-buttons">
              <button class="button">
                {{__('dashboard.Upgrade')}}
              </button>
              <button class="button">
                {{__('dashboard.Login')}}
              </button>
              <button class="button">
                {{__('dashboard.Delete Account')}}
              </button>
            </div>
            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-people"></i>
              </div>
              <div class="box">
                <h6>{{__('dashboard.Domain')}}</h6>
                <span class="text-muted small pt-2 ps-1">subscription ends at 22-10-2022</span>

              </div>

            </div>


          </div>
        </div>

      </div>
      <div class="row">

        <div class="col-xxl-2 col-md-4">
          <div class="card info-card sales-card">

            <div class="card-body">
              <h5 class="card-title">{{__('dashboard.Customers Count')}}<span></span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-cart"></i>
                </div>
                <div class="box">
                  <h6>145</h6>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="col-xxl-2 col-md-4">
          <div class="card info-card revenue-card">


            <div class="card-body">
              <h5 class="card-title">{{__('dashboard.Inventories Count')}} <span></span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="box">
                  <h6>264</h6>

                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="col-xxl-2 col-md-4">
          <div class="card info-card revenue-card">


            <div class="card-body">
              <h5 class="card-title">{{__('dashboard.Currencies Count')}} <span></span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="box">
                  <h6>264</h6>

                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="col-xxl-2 col-md-4">
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
        </div>

        <div class="col-xxl-2 col-md-4">
          <div class="card info-card revenue-card">



            <div class="card-body">
              <h5 class="card-title">{{__('dashboard.Attached Storage Usage')}} </h5>

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
        </div>
      </div>
    </div>
  </div>
</section>
@stop