<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="/templateadmin/assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="{{ asset('img/tenshibot/logologin.png') }}">
  <title>Login - Tenshibot</title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link href="/templateadmin/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="/templateadmin/assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="/templateadmin/assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>
<body class="" style="background-image: url('{{ url('img/tenshibot/halamanlogin.png') }}'); background-size: cover;">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <!-- Navbar Placeholder -->
      </div>
    </div>
  </div>
  <main class="main-content mt-0">
    <section>
      <div class="page-header min-vh-100 d-flex align-items-center justify-content-center">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
              <!-- Form Login -->
              <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="card-wrapper p-3">
                  
                  <div class="card card-plain">
                    
                    <div class="card-header pb-0 text-center">
                      <div class="flex justify-center mt-4">
                        <a href="/">
                            <img src="{{ url('img/tenshibot/logologin.png') }}" alt="My Logo" class="w-30 h-30" />
                        </a>
                    </div>
                      <h4 class="font-weight-bolder">Sign In</h4>
                      <p class="mb-0">Masuk dengan akun anda</p>
                    </div>
                    <div class="card-body">
                      <div class="mb-3">
                        <input type="email" class="form-control form-control-lg" name="email" placeholder="Email" required autofocus autocomplete="username">
                      </div>
                      <div class="mb-3">
                        <input type="password" class="form-control form-control-lg" name="password" placeholder="Password" required autocomplete="current-password">
                      </div>
                      <div class="text-end">
                        <a href="{{ route('password.request') }}" class="text-sm text-[#1C79BE]" style="color: #1C79BE;">Lupa Password?</a>
                      </div>
                      <div class="text-center">
                        <button type="submit" class="btn btn-primary custom-btn-border-radius custom-btn-arrow-effect-1 font-weight-bold text-3 px-4 btn-py-2 appear-animation me-3 w-100 mt-4 mb-0" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1300" style="background-color: #1c79be; color: white; border-radius: 20px; box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.229), 0 4px 8px rgba(0, 0, 0, 0.15);">Sign in</button>
                      </div>
                    </div>
                    <div class="card-footer text-center pt-0 px-lg-2 px-1">
                      <p class="mb-4 text-sm mx-auto">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-primary text-gradient font-weight-bold">Daftar</a>
                      </p>
                    </div>
                  </div>
                </div>
              </form>
              <!-- End Form -->
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <script src="/templateadmin/assets/js/core/popper.min.js"></script>
  <script src="/templateadmin/assets/js/core/bootstrap.min.js"></script>
  <script src="/templateadmin/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="/templateadmin/assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>
</html>
