<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Cloudsell Pos</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{asset('dashboard_img/MicrosoftTeams-image (4).png')}}" rel="icon">
  <link href="{{ asset('dashboard_img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('dashboard_vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('dashboard_vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('dashboard_vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('dashboard_vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('dashboard_vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{asset('dashboard_vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('dashboard_vendor/simple-datatables/style.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('dashboard_css/style.css')}}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="{{ asset('dashboard_img/MicrosoftTeams-image (4).png')}}" alt="cloudsell-pos-pic">
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->



    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="{{asset('dashboard_img/profile-img.jpg')}}" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">K. Anderson</span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>Kevin Anderson</h6>
              <span>Web Designer</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="index.html">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person"></i><span>Profile</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="components-alerts.html">
              <i class="bi bi-circle"></i><span>Change Email Address</span>
            </a>
          </li>
          <li>
            <a href="components-alerts.html">
              <i class="bi bi-circle"></i><span>Change Password</span>
            </a>
          </li>
          <li>
            <a href="components-alerts.html">
              <i class="bi bi-circle"></i><span>Change Profile Info</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->



    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">
        <!-- Left side columns -->
        <div class=""><!-- Customers Card -->
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

          </div><!-- End Customers Card -->
          <div class="row">
            <!-- Sales Card -->
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
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
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
            </div><!-- End Revenue Card -->
            <!-- Revenue Card -->
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
            </div><!-- End Revenue Card -->
            <!-- Revenue Card -->
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
            </div><!-- End Revenue Card -->
            <!-- Revenue Card -->
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
            </div><!-- End Revenue Card -->


          </div>
        </div><!-- End Left side columns -->
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      All Rights Reserved
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{asset('dashboard_vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('dashboard_vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('dashboard_vendor/chart.js/chart.umd.js')}}"></script>
  <script src="{{asset('dashboard_vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{asset('dashboard_vendor/quill/quill.min.js')}}"></script>
  <script src="{{asset('dashboard_vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('dashboard_vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('dashboard_vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('dashboard_js/main.js')}}"></script>

</body>

</html>