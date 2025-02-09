<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Icons -->
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('templateadmin/assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('templateadmin/assets/img/favicon.png') }}">

  <title>
    @yield('title', 'Dashboard') | Tenshibot - Dashboard
  </title>

  <!-- Fonts and Icons -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

  <!-- Nucleo Icons -->
  <link href="{{ asset('templateadmin/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('templateadmin/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <link id="pagestyle" href="{{ asset('templateadmin/assets/css/argon-dashboard.css?v=2.0.4') }}" rel="stylesheet" />

  <!-- Font Awesome CSS CDN -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-pzw1R0m4aFZV4Z5xHgFJxA2nTwJ7zNfZ3D8x+E57V8q8kU+F1RyV1Oj0E5eKx0J8aGmM3UX3NlZV5v7iHh3KGw=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  />
</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-300" style="background-color: #1C79BE; position: absolute; width: 100%;"></div>

  <!-- Sidebar -->
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="https://demos.creative-tim.com/argon-dashboard/pages/dashboard.html" target="_blank">
        <img src="{{ asset('templateadmin/assets/img/logo-ct-dark.png') }}" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">Tenshibot</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <!-- Dashboard Link -->
        <li class="nav-item">
          <a class="nav-link active" href="{{ route('dashboard') }}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <!-- Additional Links -->
        <!-- Tambahkan nav-item lainnya sesuai kebutuhan -->
      </ul>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="main-content position-relative border-radius-lg">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Dashboard User</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Dashboard</h6>
        </nav>
        <!-- Search and Nav Items -->
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group">
              <!-- Tambahkan elemen input jika diperlukan -->
            </div>
          </div>
          <ul class="navbar-nav justify-content-end">
            <!-- Sign In Link -->
            <li class="nav-item d-flex align-items-center">
              <a href="{{ route('login') }}" class="nav-link text-white font-weight-bold px-0">
                <i class="fas fa-user me-sm-1"></i>
                @yield('namauser')
              </a>
            </li>
            <!-- Sidenav Toggle (for mobile) -->
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                </div>
              </a>
            </li>
            <!-- Settings Icon -->
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0">
                <i class="fas fa-cog fixed-plugin-button-nav cursor-pointer"></i>
              </a>
            </li>
            <!-- Tambahkan nav-item lainnya sesuai kebutuhan -->
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container-fluid py-4">
      @yield('content')
    </div>
  </main>

  @yield('settings_panel')

  <!-- Core JS Files -->
  <script src="{{ asset('templateadmin/assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('templateadmin/assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('templateadmin/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('templateadmin/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{ asset('templateadmin/assets/js/plugins/chartjs.min.js') }}"></script>

  <!-- Custom Scripts -->
  <script>
    // Example Chart Initialization
    var ctx1 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');

    new Chart(ctx1, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Mobile apps",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 0,
          borderColor: "#5e72e4",
          backgroundColor: gradientStroke1,
          borderWidth: 3,
          fill: true,
          data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
          maxBarThickness: 6
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#fbfbfb',
              font: { size: 11, family: "Open Sans", style: 'normal', lineHeight: 2 },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#ccc',
              padding: 20,
              font: { size: 11, family: "Open Sans", style: 'normal', lineHeight: 2 },
            }
          },
        },
      },
    });
  </script>

  <script>
    // Initialize Scrollbar if on Windows
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = { damping: '0.5' }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>

  <!-- Github Buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>

  <!-- Argon Dashboard JS -->
  <script src="{{ asset('templateadmin/assets/js/argon-dashboard.min.js?v=2.0.4') }}"></script>
</body>

</html>
