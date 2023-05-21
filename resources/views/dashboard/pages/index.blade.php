@extends('dashboard.layouts.master')
@section('content')



<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </nav>
</div>

<section class="section dashboard">
  <div class="row">

    <div class="">
      <div class="col-xxl-4 col-xl-8">

        <div class="card info-card customers-card">

          <div class="card-body">

            <h5 class="card-title">User Name<span> </span> </h5>
            <div class="action-buttons">
              <button class="button">
                Upgrade
              </button>
              <button class="button">
                Login
              </button>
              <button class="button">
                Delete Account
              </button>
            </div>
            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-people"></i>
              </div>
              <div class="ps-3">
                <h6>Domain</h6>
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
              <h5 class="card-title">Customers Count <span></span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-cart"></i>
                </div>
                <div class="ps-3">
                  <h6>145</h6>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="col-xxl-2 col-md-4">
          <div class="card info-card revenue-card">


            <div class="card-body">
              <h5 class="card-title">Inventories Count <span></span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="ps-3">
                  <h6>264</h6>

                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="col-xxl-2 col-md-4">
          <div class="card info-card revenue-card">


            <div class="card-body">
              <h5 class="card-title">Currencies Count <span></span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="ps-3">
                  <h6>264</h6>

                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="col-xxl-2 col-md-4">
          <div class="card info-card revenue-card">



            <div class="card-body">
              <h5 class="card-title">Backup Storage Usage </h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="ps-3">
                  <h6>264M</h6>

                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="col-xxl-2 col-md-4">
          <div class="card info-card revenue-card">



            <div class="card-body">
              <h5 class="card-title">Attachs Storage Usage </h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="ps-3">
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