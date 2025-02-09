<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Basic Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Tenshibot') }}</title>
    <link rel="icon" href="img/tenshibot/logo-tenshi.png" type="image/png" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
    <style>
        .flip-horizontal {
            transform: scaleX(-1);
            -webkit-transform: scaleX(-1);
            -moz-transform: scaleX(-1);
            -o-transform: scaleX(-1);
            -ms-transform: scaleX(-1);
            display: inline-block;
        }
    </style>
    
		<!-- Web Fonts  -->
		<link id="googleFonts" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800&display=swap" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/fontawesome-free/css/all.min.css">
		<link rel="stylesheet" href="vendor/animate/animate.compat.css">
		<link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.min.css">
		<link rel="stylesheet" href="vendor/owl.carousel/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="vendor/owl.carousel/assets/owl.theme.default.min.css">
		<link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.min.css">
		<link rel="stylesheet" href="vendor/bootstrap-star-rating/css/star-rating.min.css">
		<link rel="stylesheet" href="vendor/bootstrap-star-rating/themes/krajee-fas/theme.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
		<!-- Theme CSS -->
		<link rel="stylesheet" href="css/theme.css">
		<link rel="stylesheet" href="css/theme-elements.css">
		<link rel="stylesheet" href="css/theme-blog.css">
		<link rel="stylesheet" href="css/theme-shop.css">

		<!-- Demo CSS -->
		<link rel="stylesheet" href="css/demos/demo-auto-services.css">

		<!-- Skin CSS -->
		<link id="skinCSS" rel="stylesheet" href="css/skins/skin-auto-services.css">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="css/custom.css">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/tenshibot/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Web Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>
<body>
    <div class="body">
        <!-- Header -->
        <header id="header" class="bg-light py-3">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Logo -->
                    <a href="{{ url('/') }}" class="navbar-brand">
                        <img alt="Tenshibot" height="70" src="{{ asset('img/tenshibot/logo-tenshi.png') }}">
                    </a>

                    <!-- Navbar -->
                    <ul class="header-extra-info custom-left-border-1 d-none d-xl-block">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('cek-turnitin.index') }}" class="btn btn-primary custom-btn-border-radius custom-btn-arrow-effect-1 font-weight-bold text-3 px-4 btn-py-2 appear-animation me-3" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1300" style="border-radius: 20px; box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.229), 0 4px 8px rgba(0, 0, 0, 0.15);">
                                <!-- Ikon Panah di Kiri dengan Flip -->
                                <svg class="me-2 flip-horizontal" version="1.1" viewBox="0 0 15.698 8.706" width="14" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <polygon stroke="#FFF" stroke-width="0.1" fill="#FFF" points="11.354,0 10.646,0.706 13.786,3.853 0,3.853 0,4.853 13.786,4.853 10.646,8 11.354,8.706 15.698,4.353 "/>
                                </svg>
                                <!-- Teks -->
                                Kembali
                            </a>
                            
                            <a href="{{ route('login') }}" class="btn btn-white custom-btn-border-radius custom-btn-arrow-effect-1 font-weight-bold text-3 px-4 btn-py-2 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1300" style="border-radius: 20px; margin-left: 5px; border: 2px solid #1C79BE; color: #1C79BE; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);">
                                Masuk
                                <svg class="ms-2" version="1.1" viewBox="0 0 15.698 8.706" width="14" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <polygon stroke="#1C79BE" stroke-width="0.1" fill="#1C79BE" points="11.354,0 10.646,0.706 13.786,3.853 0,3.853 0,4.853 13.786,4.853 10.646,8 11.354,8.706 15.698,4.353 "/>
                                </svg>
                            </a>
                        </div>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="container mt-5">
            @yield('content')
        </div>

        <!-- Logout Form -->
        
    </div>

    <!-- Bootstrap 5 JS via CDN (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>
